<?php
declare(strict_types=1);

namespace Study\Promotions\Service;

use Study\Promotions\Model\PromotionsRepository;
use Study\Promotions\Api\PromotionStatusInterface;

/**
 * Check promotion status
 */
class PromotionStatus implements PromotionStatusInterface
{
    /**
     * @var PromotionsRepository
     */
    private $promotionsRepository;

    public function __construct(
        PromotionsRepository $promotionsRepository
    ) {
        $this->promotionsRepository = $promotionsRepository;
    }

    /**
     * Check is that promotion is enabled
     *
     * @param int $promotionId
     * @return bool
     */
    public function isPromotionEnabled(int $promotionId): bool
    {
        if ($this->promotionsRepository->getById($promotionId)->getStatus() == self::PROMOTION_ENABLED) {

            return true;
        }

        return false;
    }

    /**
     * Check is that promotion active in current moment of time
     *
     * @param int $promotionId
     * @return bool
     */
    public function checkPromotionIsActiveNow(int $promotionId): bool
    {
        $promotion = $this->promotionsRepository->getById($promotionId);
        $start = strtotime($promotion->getStartTime());
        $finish = $promotion->getFinishTime();

        if ($promotion->getFinishTime()) {
            $finish = strtotime($promotion->getFinishTime());
        }

        if (!$finish && $start <= time()) {

            return true;
        }
        if ($start <= time() && time() <= $finish) {

            return true;
        }

        return false;
    }
}
