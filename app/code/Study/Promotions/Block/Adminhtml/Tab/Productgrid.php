<?php

namespace Study\Promotions\Block\Adminhtml\Tab;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Grid\Column;
use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Helper\Data;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Model\ProductFactory;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Store\Api\Data\StoreInterface;
use Study\Promotions\Model\PromotedProducts;
use Study\Promotions\Model\ResourceModel\PromotionsLinks\CollectionFactory as LinksCollectionFactory;

use Magento\Framework\App\ObjectManager;
use Magento\Framework\Module\Manager;
use Magento\Framework\Registry;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;

class Productgrid extends Extended
{
    protected $linksCollection;
    /**
     * @var Registry
     */
    protected $coreRegistry = null;
    /**
     * @var ProductFactory
     */
    protected $productFactory;
    /**
     * @var CollectionFactory
     */
    protected $productCollFactory;

    /**
     * @param Context $context
     * @param Data $backendHelper
     * @param ProductFactory $productFactory
     * @param Registry $coreRegistry
     * @param Manager $moduleManager
     * @param StoreManagerInterface $storeManager
     * @param Visibility|null $visibility
     * @param array $data
     */
    public function __construct(
        Context                $context,
        Data                   $backendHelper,
        ProductFactory         $productFactory,
        CollectionFactory      $productCollFactory,
        Registry               $coreRegistry,
        Manager                $moduleManager,
        StoreManagerInterface  $storeManager,
        LinksCollectionFactory $linksCollection,
        Visibility             $visibility = null,
        array                  $data = []
    ) {
        $this->linksCollection = $linksCollection;
        $this->productFactory = $productFactory;
        $this->productCollFactory = $productCollFactory;
        $this->coreRegistry = $coreRegistry;
        $this->moduleManager = $moduleManager;
        $this->_storeManager = $storeManager;
        $this->visibility = $visibility ?: ObjectManager::getInstance()->get(Visibility::class);
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     *
     * @return void
     */
    protected function _construct(): void
    {
        parent::_construct();
        $this->setId('rh_grid_products');
        $this->setDefaultSort('entity_id');
        $this->setDefaultDir('ASC');
        $this->setUseAjax(true);
        if ($this->getRequest()->getParam('entity_id')) {
            $this->setDefaultFilter(['in_products' => 1]);
        } else {
            $this->setDefaultFilter(['in_products' => 0]);
        }
        $this->setSaveParametersInSession(true);
    }

    /**
     * Get store
     *
     * @return StoreInterface
     */
    protected function _getStore()
    {
        $storeId = (int)$this->getRequest()->getParam('store', 0);
        return $this->_storeManager->getStore($storeId);
    }

    /**
     * Get products collection and prepare grid
     *
     * @return Productgrid
     */
    protected function _prepareCollection()
    {
        $store = $this->_getStore();
        $collection = $this->productFactory->create()->getCollection()->addAttributeToSelect(
            'sku'
        )->addAttributeToSelect(
            'name'
        )->addAttributeToSelect(
            'attribute_set_id'
        )->addAttributeToSelect(
            'type_id'
        )->setStore(
            $store
        );
        if ($this->moduleManager->isEnabled('Magento_CatalogInventory')) {
            $collection->joinField(
                'qty',
                'cataloginventory_stock_item',
                'qty',
                'product_id=entity_id',
                '{{table}}.stock_id=1',
                'left'
            );
        }
        if ($store->getId()) {
            $collection->setStoreId($store->getId());
            $collection->addStoreFilter($store);
            $collection->joinAttribute(
                'name',
                'catalog_product/name',
                'entity_id',
                null,
                'inner',
                Store::DEFAULT_STORE_ID
            );
            $collection->joinAttribute(
                'status',
                'catalog_product/status',
                'entity_id',
                null,
                'inner',
                $store->getId()
            );
            $collection->joinAttribute(
                'visibility',
                'catalog_product/visibility',
                'entity_id',
                null,
                'inner',
                $store->getId()
            );
            $collection->joinAttribute('price', 'catalog_product/price', 'entity_id', null, 'left', $store->getId());
        } else {
            $collection->addAttributeToSelect('price');
            $collection->joinAttribute('status', 'catalog_product/status', 'entity_id', null, 'inner');
            $collection->joinAttribute('visibility', 'catalog_product/visibility', 'entity_id', null, 'inner');
        }
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Filter
     *
     * @param Column $column
     * @return Productgrid
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _addColumnFilterToCollection($column): ProductGrid
    {
        if ($column->getId() == 'in_products') {
            $productIds = $this->_getSelectedProducts();
            if (empty($productIds)) {
                $productIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('entity_id', ['in' => $productIds]);
            } else {
                if ($productIds) {
                    $this->getCollection()->addFieldToFilter('entity_id', ['nin' => $productIds]);
                }
            }
        } else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }

    /**
     * Prepare grid columns
     *
     * @return Extended
     */
    protected function _prepareColumns(): Extended
    {
        $this->addColumn(
            'in_products',
            [
                'type' => 'checkbox',
                'html_name' => 'products_id',
                'required' => true,
                'values' => $this->_getSelectedProducts(),
                'align' => 'center',
                'index' => 'entity_id',
            ]
        );
        $this->addColumn(
            'entity_id',
            [
                'header' => __('ID'),
                'width' => '50px',
                'index' => 'entity_id',
                'type' => 'number',
            ]
        );
        $this->addColumn(
            'name',
            [
                'header' => __('Name'),
                'index' => 'name',
                'header_css_class' => 'col-type',
                'column_css_class' => 'col-type',
            ]
        );
        $this->addColumn(
            'sku',
            [
                'header' => __('SKU'),
                'index' => 'sku',
                'header_css_class' => 'col-sku',
                'column_css_class' => 'col-sku',
            ]
        );
        $store = $this->_getStore();
        $this->addColumn(
            'price',
            [
                'header' => __('Price'),
                'type' => 'price',
                'currency_code' => $store->getBaseCurrency()->getCode(),
                'index' => 'price',
                'header_css_class' => 'col-price',
                'column_css_class' => 'col-price',
            ]
        );
        $this->addColumn(
            'position',
            [
                'header' => __('Position'),
                'name' => 'position',
                'width' => 60,
                'type' => 'number',
                'validate_class' => 'validate-number',
                'index' => 'position',
                'column_css_class' => 'no-display',
                'header_css_class' => 'no-display',
                'editable' => true,
                'edit_only' => true,
            ]
        );
        return parent::_prepareColumns();
    }

    /**
     * Get url of products grid controller
     *
     * @return string
     */
    public function getGridUrl(): string
    {
        return $this->getUrl('*/index/grids', ['_current' => true]);
    }

    /**
     * Get array of assigned products
     *
     * @return array
     */
    private function _getSelectedProducts()
    {
        $promotionId = $this->getRequest()->getParam('id');
        $products = $this->prepareAssignedProductIds((int)$promotionId);

        return $products;
    }

    /**
     * Prepare array with ids of products assigned to this promotion
     *
     * @param int $promotionId
     * @return array
     */
    private function prepareAssignedProductIds(int $promotionId): array
    {
        $arrayOfAssignedProductIds = [];
        $assignedProductsCollection = $this->linksCollection->create()
            ->addFieldToFilter(PromotedProducts::PROMOTION_ID, $promotionId)
            ->addFieldToSelect(PromotedProducts::PRODUCT_ID)
            ->getItems();

        foreach ($assignedProductsCollection as $item) {
            $arrayOfAssignedProductIds[] = $item->getData('product_id');
        }

        return $arrayOfAssignedProductIds;
    }
}
