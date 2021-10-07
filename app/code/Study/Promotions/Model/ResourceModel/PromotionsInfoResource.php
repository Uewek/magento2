<?php
declare(strict_types=1);

namespace Study\Promotions\Model\ResourceModel;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Study\Promotions\Model\ResourceModel\PromotionsLinks\CollectionFactory;
use Study\Promotions\Model\PromotedProductsFactory;
use Study\Promotions\Model\PromotedProductLinksRepository;

/**
 * Promotions resource model
 */
class PromotionsInfoResource extends AbstractDb
{
    /**
     * @var PromotedProductLinksRepository
     */
    private $productLinksRepository;

    /**
     * @var PromotedProductsFactory
     */
    private $promotedProductsFactory;

    /**
     * @var CollectionFactory
     */
    private $promotionsLinksCollectionFactory;

    /**
     *
     * @param Context $context
     * @param PromotedProductsFactory $promotedProductsFactory
     * @param PromotedProductLinksRepository $productLinksRepository
     * @param CollectionFactory $promotionsLinksCollectionFactory
     */
    public function __construct(
        Context                        $context,
        PromotedProductsFactory        $promotedProductsFactory,
        PromotedProductLinksRepository $productLinksRepository,
        CollectionFactory              $promotionsLinksCollectionFactory
    ) {
        $this->promotedProductsFactory = $promotedProductsFactory;
        $this->promotionsLinksCollectionFactory = $promotionsLinksCollectionFactory;
        $this->productLinksRepository = $productLinksRepository;

        parent::__construct($context);
    }

    /**
     * Table init
     *
     * @inheirtDoc
     */
    protected function _construct()
    {
        $this->_init('promotions_info', 'promotion_id');
    }

    /**
     * Link products to promotion after promotion create/update
     *
     * @param AbstractModel $object
     * @return void
     */
    protected function _afterSave(AbstractModel $object): void
    {
        $promotedProducts = $object->getData('promoted_products');
        $promotionId = (int)$object->getId();
        $linkedProductsArray = $this->promotionsLinksCollectionFactory->create()
            ->addFieldToFilter('promotion_id', $promotionId)->addFieldToSelect('product_id')->getData();
        $productIdsArray = [];
        foreach ($linkedProductsArray as $productId) {
            $productIdsArray[] = $productId['product_id'];
        }
        $promotedProductIds = explode(' ', trim(preg_replace('@\W+@', ' ', $promotedProducts)));
        foreach ($promotedProductIds as $promotedProductId) {
            if (empty($productIdsArray) || in_array($promotedProductId, $productIdsArray) !== true) {
                $promotedProduct = $this->promotedProductsFactory->create()
                    ->setPromotedProduct((int)$promotedProductId)
                    ->setPromotion($promotionId);
                $this->productLinksRepository->savePromotedProduct($promotedProduct);
            }
        }
    }
}
