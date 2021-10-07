<?php
declare(strict_types=1);

namespace Study\Promotions\Model;

use Study\Promotions\Api\PromotionsValidatorInterface;
use Study\Promotions\Model\PromotionsRepository;

/**
 * Validate promotion parameters
 */
class PromotionsValidator implements PromotionsValidatorInterface
{
    private $promotionsRepository;

    public function __construct(
        PromotionsRepository $promotionsRepository
    ) {
        $this->promotionsRepository = $promotionsRepository;
    }
    /**
     * Check is time parameters is correct
     *
     * @param string $startTime
     * @param string $finishTime
     * @return bool
     */
    public function isTimeParametersIsCorrect(string $startTime, string $finishTime): bool
    {
        $result = false;

        if ($startTime !== '' && $finishTime == '') {
            $result = true;
        }

        if ($startTime !== '' && (strtotime($finishTime) > strtotime($startTime))) {
            $result = true;
        }

        return $result;
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
