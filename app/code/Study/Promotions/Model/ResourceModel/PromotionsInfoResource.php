<?php
declare(strict_types=1);

namespace Study\Promotions\Model\ResourceModel;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Study\Promotions\Model\ResourceModel\PromotionsLinks\CollectionFactory;
use Study\Promotions\Model\PromotedProductsFactory;
use Study\Promotions\Model\PromotedProductLinksRepository;
use Study\Promotions\Api\PromotedProductsInterface;
use Psr\Log\LoggerInterface;


/**
 * Promotions resource model
 */
class PromotionsInfoResource extends AbstractDb
{
    protected $logger;
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
        LoggerInterface                $logger,
        PromotedProductsFactory        $promotedProductsFactory,
        PromotedProductLinksRepository $productLinksRepository,
        CollectionFactory              $promotionsLinksCollectionFactory
    ) {
        $this->logger = $logger;
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
        $productIdsArray = $this->getAlreadyLinkedProductIds($promotionId);
        $promotedProductIds = explode(' ', trim(preg_replace('@\W+@', ' ', $promotedProducts)));
        foreach ($promotedProductIds as $promotedProductId) {
            if (empty($productIdsArray) || !in_array($promotedProductId, $productIdsArray)) {
                $promotedProduct = $this->promotedProductsFactory->create()
                    ->setPromotedProduct((int)$promotedProductId)
                    ->setPromotion($promotionId);
                try {
                    $this->productLinksRepository->save($promotedProduct);
                } catch (\Exception $e) {
                    $this->logger->critical('Error during linking product to promotion', ['exception' => $e]);
                    throw new \Exception('Error during product linking');
                }
            }
        }
    }

    /**
     * Get array of id`s already linked to current promotion products
     *
     * @param int $promotionId
     * @return array
     */
    protected function getAlreadyLinkedProductIds(int $promotionId): array
    {
        $linkedProductsArray = $this->promotionsLinksCollectionFactory->create()
            ->addFieldToFilter(PromotedProductsInterface::PROMOTION_ID, $promotionId)
            ->addFieldToSelect(PromotedProductsInterface::PRODUCT_ID)->getData();

        $productIdsArray = [];
        foreach ($linkedProductsArray as $productId) {
            $productIdsArray[] = $productId['product_id'];
        }

        return $productIdsArray;
    }
}
