<?php
declare(strict_types=1);

namespace Study\Promotions\Block\Adminhtml\Edit\Tab;

use Magento\Backend\Block\Template\Context;
use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Helper\Data;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Api\Data\ProductInterfaceFactory;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\CatalogInventory\Api\Data\StockStatusInterface;
use Magento\Framework\App\ObjectManager;
use Magento\Framework\Module\Manager;
use Magento\Framework\Registry;
use Magento\Store\Api\Data\StoreInterface;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Reduced version of app/code/Magento/Catalog/Block/Adminhtml/Category/Tab/Product.php
 */
class ProductGrid extends Extended
{
    /**
     * @var Registry
     */
    protected $coreRegistry = null;

    /**
     * @var ProductInterfaceFactory
     */
    protected $productFactory;

    /**
     * @var CollectionFactory
     */
    protected $productCollFactory;

    /**
     * @var ProductInterface
     */
    private $productInterface;

    /**
     * @param Context $context
     * @param Data $backendHelper
     * @param ProductInterfaceFactory $productFactory
     * @param Registry $coreRegistry
     * @param Manager $moduleManager
     * @param StoreManagerInterface $storeManager
     * @param Visibility|null $visibility
     * @param array $data
     */
    public function __construct(
        Context                 $context,
        Data                    $backendHelper,
        ProductInterfaceFactory $productFactory,
        CollectionFactory       $productCollFactory,
        Registry                $coreRegistry,
        Manager                 $moduleManager,
        ProductInterface        $productInterface,
        StoreManagerInterface   $storeManager,
        Visibility              $visibility = null,
        array                   $data = []
    ) {
        $this->productInterface = $productInterface;
        $this->productFactory = $productFactory;
        $this->productCollFactory = $productCollFactory;
        $this->coreRegistry = $coreRegistry;
        $this->moduleManager = $moduleManager;
        $this->_storeManager = $storeManager;
        $this->visibility = $visibility ?: ObjectManager::getInstance()->get(Visibility::class);
        parent::__construct($context, $backendHelper, $data);
    }

    /**
     * @inheirtDoc
     */
    protected function _construct()
    {
        parent::_construct();
        $this->setId('promotions_grid_products');
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
    protected function _getStore(): StoreInterface
    {
        $storeId = (int)$this->getRequest()->getParam('store', 0);
        return $this->_storeManager->getStore($storeId);
    }

    /**
     * @inheirtDoc
     *
     * @return ProductGrid
     */
    protected function _prepareCollection(): ProductGrid
    {
        $store = $this->_getStore();
        $collection = $this->productFactory->create()->getCollection()->addAttributeToSelect(
            $this->productInterface::SKU
        )->addAttributeToSelect(
            $this->productInterface::NAME
        )->addAttributeToSelect(
            $this->productInterface::ATTRIBUTE_SET_ID
        )->addAttributeToSelect(
            $this->productInterface::TYPE_ID
        )->setStore(
            $store
        );

        if ($this->moduleManager->isEnabled('Magento_CatalogInventory')) {
            $collection->joinField(
                'qty',
                'cataloginventory_stock_item',
                'qty',
                'product_id=entity_id',
                '{{table}}.stock_id=' . StockStatusInterface::STATUS_IN_STOCK,
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
     * @inheirtDoc
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
        return parent::_prepareColumns();
    }


    /**
     * @inheirtDoc
     *
     * @return array
     */
    protected function _getSelectedProducts(): array
    {
        return [];
    }
}
