<?php
declare(strict_types=1);

namespace Study\InversedRelatedProducts\Block\Product\View;

use Magento\Catalog\Helper\Data;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Study\InversedRelatedProducts\Model\Config;
use Magento\Catalog\Model\ResourceModel\Product\Link;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;

/**
 * Class Extra
 * block class related to template
 */
class Extra extends Template
{
    /**
     * @var Config
     */
    private $config;

    /**
     * @var Data
     */
    private $dataHelper;

    /**
     * @var Link
     */
    private $link;

    /**
     * @var CollectionFactory
     */
    private $productCollectionFactory;

    /**
     * Extra constructor.
     * @param Context $context
     * @param Config $config
     * @param Data $catalogData
     * @param Link $link
     * @param CollectionFactory $productCollectionFactory
     */
    public function __construct(
        Context $context,
        Config $config,
        Data $catalogData,
        Link $link,
        CollectionFactory $productCollectionFactory
    ) {
        $this->productCollectionFactory = $productCollectionFactory;
        $this->link = $link;
        $this->config = $config;
        $this->dataHelper = $catalogData;

        parent::__construct($context);
    }

    /**
     * Check enabled/disabled status
     *
     * @return bool
     */
    public function canShowInversedProducts(): bool
    {

        return $this->config->isEnabled();
    }

    /**
     * Get limited collection of "base" products
     *
     * @return Collection
     */
    public function getInveresedRealtedProductsColection(): Collection
    {
        $inveresedRealtedProductsColection = $this->productCollectionFactory->create();
        $inveresedRealtedProductsColection->addAttributeToSelect('name');
        $inveresedRealtedProductsColection->addAttributeToSelect('productUrl');
        $inveresedRealtedProductsColection->addAttributeToFilter('entity_id', ['in' => $this->getLinkedParents()]);
        $inveresedRealtedProductsColection->getSelect()->limit(3);

        return $inveresedRealtedProductsColection;
    }

    /**
     * Return array of the "base" product ids
     *
     * @return array
     */
    private function getLinkedParents(): array
    {
        return $this->link->getParentIdsByChild($this->getCurrentProductId(),1);
    }

    /**
     * Get id of current product
     *
     */
    private function getCurrentProductId()
    {
        return  $this->dataHelper->getProduct()->getId();
    }
}
