<?php

namespace Study\InversedRelatedProducts\Block\Product\View;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Helper\Data;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Study\InversedRelatedProducts\Model\Config;
use Study\InversedRelatedProducts\Model\LinkedProductsFactory;

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
     * @var LinkedProductsFactory
     */
    private $_linkedProductsFactory;
    /**
     * @var Data
     */
    private $dataHelper;

    private $productRepository;

    /**
     * Extra constructor.
     * @param Context $context
     * @param Config $config
     * @param LinkedProductsFactory $linkedProductsFactory
     * @param Data $catalogData
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        Context $context,
        Config $config,
        LinkedProductsFactory $linkedProductsFactory,
        Data $catalogData,
        ProductRepositoryInterface $productRepository
    ) {
        $this->_linkedProductsFactory = $linkedProductsFactory;
        $this->config = $config;
        $this->dataHelper = $catalogData;
        $this->productRepository = $productRepository;
        parent::__construct($context);
    }

    /**
     * Get product by id
     *
     * @param int $id
     * @return \Magento\Catalog\Api\Data\ProductInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getProductById(int $id)
    {
        $product = $this->productRepository->getById($id);
        return $product;
    }

    /**
     * Prepare array with ids products that have inversed relations with current
     *
     * @param int $count
     * @return array
     */
    private function getInversedRelations(int $count = 3): array
    {
        $relations = $this->_linkedProductsFactory->create();
        $relationItems = $relations->getCollection()->getItems();
        $arr = [];
        foreach ($relationItems as $item) {
            if ($item->toArray()['linked_product_id'] == $this->getCurrentProductId() && count($arr) < $count) {
                $arr[] = $item->toArray()['product_id'];
            }
        }
        return $arr;
    }

    /**
     *  Get products that have inversed relations with current
     *
     * @return array
     */
    public function getInversedRelatedProducts(): array
    {
        $products = [];
        foreach ($this->getInversedRelations() as $inversedRelationId) {
            $products[] = $this->getProductById($inversedRelationId);
        }
        return $products;
    }

    /**
     * Check enabled/disabled status
     *
     * @return bool
     */
    public function canShowInversedProducts(): bool
    {
        $result = $this->config->isEnabled();
        return $result;
    }

    /**
     * Get id of current product
     *
     * @return int
     */
    public function getCurrentProductId(): int
    {
        return $this->dataHelper->getProduct()->getId();
    }
}
