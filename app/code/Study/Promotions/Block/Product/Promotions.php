<?php
declare(strict_types=1);

namespace Study\Promotions\Block\Product;

use Study\Promotions\Model\ResourceModel\PromotionsLinks\CollectionFactory;
use Study\Promotions\Model\PromotedProducts;
use Study\Promotions\Model\PromotionsRepository;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Catalog\Helper\Data;
use Study\Promotions\Model\PromotionsValidator;

/**
 * Prepare promotions block on product page
 */
class Promotions extends Template
{
    /**
     * @var CollectionFactory
     */
    private $promotionLinksCollectionFactory;

    /**
     * @var PromotionsValidator
     */
    private $promotionsValidator;

    /**
     * @var Data
     */
    private $dataHelper;

    /**
     * @var PromotedProducts
     */
    private $promotedProductsModel;

    /**
     * @var PromotionsRepository
     */
    private $promotionsRepository;

    /**
     * Promotions block constructor
     *
     * @param Context $context
     * @param Data $datahelper
     * @param PromotionsRepository $promotionsRepository
     * @param PromotionsValidator $promotionsValidator
     * @param CollectionFactory $promotionLinksCollectionFactory
     */
    public function __construct(
        Context              $context,
        Data                 $datahelper,
        PromotionsRepository $promotionsRepository,
        PromotionsValidator  $promotionsValidator,
        CollectionFactory    $promotionLinksCollectionFactory
    ) {
        $this->promotionsValidator = $promotionsValidator;
        $this->promotionsRepository = $promotionsRepository;
        $this->dataHelper = $datahelper;
        $this->promotionLinksCollectionFactory = $promotionLinksCollectionFactory;

        parent::__construct($context);
    }

    /**
     * Get product id on product page
     *
     * @return int
     */
    private function getProductId(): int
    {
        return (int)$this->dataHelper->getProduct()->getId();
    }

    /**
     * Get promotions assigned to current product
     *
     * @return array
     */
    public function getPromotionsAssignedToCurrentProduct(): array
    {
        return $this->promotionLinksCollectionFactory->create()
            ->addFieldToFilter(PromotedProducts::PRODUCT_ID, $this->getProductId())
            ->addFieldToSelect(PromotedProducts::PROMOTION_ID)
            ->getItems();
    }

    /**
     * Check is that promotion is enabled
     *
     * @param int $promotionId
     * @return bool
     */
    public function isPromotionEnabled(int $promotionId): bool
    {
        return $this->promotionsValidator->isPromotionEnabled($promotionId);
    }

    /**
     * Get name of current promotion
     *
     * @param int $promotionId
     * @return string
     */
    public function getPromotionName(int $promotionId): string
    {
        return $this->promotionsRepository->getById($promotionId)->getName();

    }

    /**
     * Check is that promotion active in current moment of time
     *
     * @param int $promotionId
     * @return bool
     */
    public function checkPromotionIsActiveNow(int $promotionId): bool
    {
        return $this->promotionsValidator->checkPromotionIsActiveNow($promotionId);
    }
}
