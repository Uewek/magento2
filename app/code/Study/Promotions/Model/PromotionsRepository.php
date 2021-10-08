<?php
declare(strict_types=1);

namespace Study\Promotions\Model;

use Psr\Log\LoggerInterface;
use Study\Promotions\Api\PromotionRepositoryInterface;
use Study\Promotions\Api\PromotionsInfoInterface;
use Study\Promotions\Model\ResourceModel\PromotionsInfoResource;

/**
 * That repository used to save promotions and promoted products
 */
class PromotionsRepository implements PromotionRepositoryInterface
{
    /**
     * @var PromotionsInfoFactory
     */
    private $promotionsInfoFactory;

    /**
     * @var PromotionsInfoResource
     */
    private $promotionsInfoResource;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * Repository constructor
     * @param PromotionsInfoResource $promotionsInfoResource
     * @param PromotionsInfoFactory $promotionsInfoFactory
     */
    public function __construct(
        PromotionsInfoResource    $promotionsInfoResource,
        LoggerInterface           $logger,
        PromotionsInfoFactory     $promotionsInfoFactory
    ) {
        $this->logger = $logger;
        $this->promotionsInfoFactory = $promotionsInfoFactory;
        $this->promotionsInfoResource = $promotionsInfoResource;
    }

    /**
     * Get promotion by id
     *
     * @param int $id
     * @return PromotionsInfoInterface
     */
    public function getById(int $id): PromotionsInfoInterface
    {
        $promotion = $this->promotionsInfoFactory->create();
        try {
            $this->promotionsInfoResource->load($promotion, $id);
        } catch (\Exception $e) {
            $this->logger->critical('Error during promotion loading', ['exception' => $e]);
            throw new \Exception('We can`t load promotion at this moment');
        }

        return $promotion;
    }

    /**
     * Save nev promotion
     *
     * @param PromotionsInfoInterface $promotion
     * @return
     */
    public function save(PromotionsInfoInterface $promotion): PromotionsInfoInterface
    {
        $this->promotionsInfoResource->save($promotion);

        return $promotion;
    }
}
