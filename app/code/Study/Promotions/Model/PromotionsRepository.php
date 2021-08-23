<?php
declare(strict_types=1);

namespace Study\Promotions\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use Study\Promotions\Api\PromotionRepositoryInterface;
use Study\Promotions\Api\PromotedProductsInterface;
use Study\Promotions\Api\PromotionsInfoInterface;
use Study\Promotions\Model\ResourceModel\PromotionsInfoResource;
use Study\Promotions\Model\ResourceModel\PromotionsLinkResource;
use Study\Promotions\Model\ResourceModel\PromotionsInfo\CollectionFactory as PromotionsInfoCollection;
use Study\Promotions\Model\ResourceModel\PromotionsLinks\CollectionFactory as PromotionsLinksCollection;


class PromotionsRepository implements PromotionRepositoryInterface
{
    private $promotionsInfoCollectionFactory;

    private $promotionsLinksCollectionFactory;

    private $promotionsInfoFactory;

    private $promotedProductsFactory;

    private $promotionsInfoResource;

    private $promotionsLinkResource;

    public function __construct(
        PromotionsInfoResource $promotionsInfoResource,
        PromotionsLinkResource $promotionsLinkResource,
        PromotionsInfoCollection $promotionsInfoCollectionFactory,
        PromotionsLinksCollection $promotionsLinksCollectionFactory,
        PromotionsInfoFactory $promotionsInfoFactory,
        PromotedProductsFactory $promotedProductsFactory
    ) {
        $this->promotedProductsFactory = $promotedProductsFactory;
        $this->promotionsInfoFactory = $promotionsInfoFactory;
        $this->promotionsInfoCollectionFactory = $promotionsInfoCollectionFactory;
        $this->promotionsLinksCollectionFactory = $promotionsLinksCollectionFactory;
        $this->promotionsInfoResource = $promotionsInfoResource;
        $this->promotionsLinkResource = $promotionsLinkResource;
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
            echo "No like with that id!";
        }

        return $promotion;
    }

    /**
     * Save nev promotion
     *
     * @param PromotionsInfoInterface $promotion
     * @return PromotionsInfoInterface
     */
    public function save(PromotionsInfoInterface $promotion): PromotionsInfoInterface
    {
        $this->promotionsInfoResource->save($promotion);

        return $promotion;
    }

}
