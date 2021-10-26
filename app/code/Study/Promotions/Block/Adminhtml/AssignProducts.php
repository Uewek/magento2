<?php
declare(strict_types=1);

namespace Study\Promotions\Block\Adminhtml;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Template\Context;
use Magento\Catalog\Block\Adminhtml\Category\Tab\Product;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Study\Promotions\Model\PromotedProducts;
use Study\Promotions\Model\ResourceModel\PromotionsLinks\CollectionFactory as LinksCollectionFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Json\EncoderInterface;
use Magento\Framework\View\Element\BlockInterface;

/**
 * Support block to assign products grid
 */
class AssignProducts extends Template
{
    /**
     * @var LinksCollectionFactory
     */
    protected $linksCollection;

    /**
     * Block template
     *
     * @var string
     */
    protected $_template = 'products/assign_products.phtml';

    /**
     * @var Product
     */
    protected $blockGrid;

    /**
     * @var EncoderInterface
     */
    protected $jsonEncoder;

    /**
     * @var CollectionFactory
     */
    protected $productFactory;

    /**
     * @param Context $context
     * @param LinksCollectionFactory $linksCollectionFactory
     * @param EncoderInterface $jsonEncoder
     * @param CollectionFactory $productFactory
     * @param array $data
     */
    public function __construct(
        Context                $context,
        LinksCollectionFactory $linksCollectionFactory,
        EncoderInterface       $jsonEncoder,
        CollectionFactory      $productFactory,
        array                  $data = []
    ) {
        $this->linksCollection = $linksCollectionFactory;
        $this->jsonEncoder = $jsonEncoder;
        $this->productFactory = $productFactory;

        parent::__construct($context, $data);
    }

    /**
     * Retrieve instance of grid block
     *
     * @return BlockInterface
     * @throws LocalizedException
     */
    public function getBlockGrid(): BlockInterface
    {
        if (null === $this->blockGrid) {
            $this->blockGrid = $this->getLayout()->createBlock(
                'Study\Promotions\Block\Adminhtml\Tab\Productgrid',
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

    /**
     * Get json with ids of products linked to this promotion (need to saving )
     *
     * @return string
     */
    public function getProductsJson(): string
    {
        $promotionId = $this->getRequest()->getParam('id');
        $result = [];
        $assignedProductsCollection = $this->linksCollection->create()
            ->addFieldToFilter(PromotedProducts::PROMOTION_ID, $promotionId)
            ->addFieldToSelect(PromotedProducts::PRODUCT_ID)
            ->getItems();

        if (!empty($assignedProductsCollection)) {

            foreach ($assignedProductsCollection as $item) {
                $result[$item->getData('product_id')] = "";
            }

            return $this->jsonEncoder->encode($result);
        }

        return '{}';
    }
}
