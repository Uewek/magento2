<?php
declare(strict_types=1);

namespace Study\Promotions\Block\Adminhtml\Edit;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Catalog\Block\Adminhtml\Category\Tab\Product;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\View\Element\BlockInterface;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;

class AssignProducts extends Template
{
    /**
     * Block template
     *
     * @var string
     */
    protected $_template = 'products/assign_products.phtml';

    /**
     * @var Product
     */
    private $blockGrid;


    /**
     * Retrieve instance of grid block
     *
     * @return BlockInterface
     * @throws LocalizedException
     */
    public function getBlockGrid()
    {
        if (null === $this->blockGrid) {
            $this->blockGrid = $this->getLayout()->createBlock(
                'Study\Promotions\Block\Adminhtml\Edit\Tab\ProductGrid',
                'category.product.grid'
            );
        }
        return $this->blockGrid;
    }

    /**
     * Return HTML of grid block
     *
     * @return string
     */
    public function getGridHtml(): string
    {
        return $this->getBlockGrid()->toHtml();
    }
}
