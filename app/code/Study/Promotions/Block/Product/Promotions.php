<?php
declare(strict_types=1);

namespace Study\Promotions\Block\Product;

use Magento\Eav\Model\Entity\Attribute\Backend\Datetime;
use Study\Promotions\Model\PromotionsRepository;
use Study\Promotions\Model\ResourceModel\PromotionsLinks\CollectionFactory;
use Study\Promotions\Model\ResourceModel\PromotionsInfo\Collection as PromotionCollection;
use Study\Promotions\Model\ResourceModel\PromotionsInfo\CollectionFactory as PromotionCollectionFactory;
use Study\Promotions\Api\PromotionsInfoInterface;
use Magento\Framework\View\Element\Template;

use Magento\Framework\View\Element\Template\Context;
use Magento\Catalog\Helper\Data;

class Promotions extends Template
{
    /**
     * @var PromotionsRepository
     */
    private $promotionsRepository;

    /**
     * @var CollectionFactory
     */
    private $promotionLinksCollectionFactory;

    /**
     * @var PromotionCollectionFactory
     */
    private $promotionCollectionFactory;

    /**
     * @var Data
     */
    private $dataHelper;

    /**
     * @var PromotionsInfoInterface
     */
    private $promotionsModel;

    /**
     * Promotions block constructor
     *
     * @param Context $context
     * @param PromotionsRepository $promotionsRepository
     * @param Data $datahelper
     * @param PromotionsInfoInterface $promotionsModel
     * @param PromotionCollectionFactory $promotionCollectionFactory
     * @param CollectionFactory $promotionLinksCollectionFactory
     */
    public function __construct(
        Context $context,
        PromotionsRepository $promotionsRepository,
        Data $datahelper,
        PromotionsInfoInterface $promotionsModel,
        PromotionCollectionFactory $promotionCollectionFactory,
        CollectionFactory $promotionLinksCollectionFactory

    ) {
        $this->promotionsModel = $promotionsModel;
        $this->promotionCollectionFactory = $promotionCollectionFactory;
        $this->dataHelper = $datahelper;
        $this->promotionLinksCollectionFactory = $promotionLinksCollectionFactory;
        $this->promotionsRepository = $promotionsRepository;

        parent::__construct($context);
    }

    /**
     * Get product id on product page
     *
     * @return int
     */
    public function getProductId(): int
    {
        return (int) $this->dataHelper->getProduct()->getId();
    }

    /**
     * Get promotions assigned to current product
     *
     * @return array
     */
    public function getPromotionsAssignedToCurrentProduct(): array
    {
        $collection = $this->promotionLinksCollectionFactory->create()
            ->addFieldToFilter('product_id', $this->getProductId())
            ->addFieldToSelect('promotion_id')
            ->getItems();


        return $collection;
    }

    /**
     * Check is that promotion is enabled
     *
     * @param int $promotionId
     * @return bool
     */
    public function promotionIsEnabled(int $promotionId): bool
    {
       $promotion = $this->promotionCollectionFactory->create()
           ->addFieldToFilter('promotion_id', $promotionId)
           ->addFieldToSelect('promotion_enabled',)
           ->getItems();
       foreach ($promotion as $item){
           if ($item->getData('promotion_enabled') == 1) {
               return true;
           }
       }
        return false;
    }

    /**
     * Get name of current promotion
     *
     * @param int $promotionId
     * @return string
     */
    public function getPromotionName(int $promotionId): string
    {
        $nameInCollection = $this->promotionCollectionFactory->create()
            ->addFieldToFilter('promotion_id', $promotionId)
            ->addFieldToSelect('promotion_name')
            ->getItems();
        $nameString = '';
        foreach ($nameInCollection as $item) {
            $nameString = $item->getData('promotion_name');
        }

        return $nameString;
    }

    /**
     * Check is that promotion active in current moment of time
     *
     * @param int $promotionId
     * @return bool
     */
    public function checkPromotionIsActiveNow(int $promotionId): bool
    {
        $timeCollection = $this->promotionCollectionFactory->create()
            ->addFieldToFilter('promotion_id', $promotionId)
            ->addFieldToSelect('start_time')
            ->addFieldToSelect('finish_time')
            ->getItems();
        foreach ($timeCollection as $item) {
            $startData = $item->getData('start_time');
            $finishData = $item->getData('finish_time');
            $start = strtotime($startData);
            if ($finishData) {
                $finish = strtotime($finishData);
            }
            if (! $finishData) {
                $finish = null;
            }
        }
        if ($start <= time() && !$finish) {
            return true;
        }
        if ($start <= time() && time() <= $finish) {
            return true;
        }

        return false;
    }

}
