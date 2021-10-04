<?php
declare(strict_types=1);

namespace Study\Promotions\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use Study\Promotions\Api\PromotionRepositoryInterface;
use Study\Promotions\Api\PromotedProductsInterface;
use Study\Promotions\Api\PromotionsInfoInterface;
use Study\Promotions\Model\ResourceModel\PromotionsInfoResource;
use Study\Promotions\Model\ResourceModel\PromotionsLinkResource;

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
     * Repository constructor
     * @param PromotionsInfoResource $promotionsInfoResource
     * @param PromotionsInfoFactory $promotionsInfoFactory
     */
    public function __construct(
        PromotionsInfoResource    $promotionsInfoResource,
        PromotionsInfoFactory     $promotionsInfoFactory
    ) {
        $this->promotionsInfoFactory = $promotionsInfoFactory;
        $this->promotionsInfoResource = $promotionsInfoResource;
    }

    /**
     * Get promotion by id
     *
     * @param int $id
     * @return PromotionsInfoInterface
     */
    public function getPromotionById(int $id): PromotionsInfoInterface
    {
        $promotion = $this->promotionsInfoFactory->create();
        try {
            $this->promotionsInfoResource->load($promotion, $id);
        } catch (NoSuchEntityException $noSuchEntityException) {
            throw new \InvalidArgumentException(
                'No promotion with that id!"' . $noSuchEntityException->getMessage()
            );
        }

        return $promotion;
    }

    /**
     * Save nev promotion
     *
     * @param PromotionsInfoInterface $promotion
     * @return
     */
    public function savePromotion(PromotionsInfoInterface $promotion): PromotionRepositoryInterface
    {
        $this->promotionsInfoResource->save($promotion);

        return $this;
    }
}
