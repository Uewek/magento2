<?php
declare(strict_types=1);

namespace Study\Promotions\Model\ResourceModel;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Study\Promotions\Model\ResourceModel\PromotionsLinks\CollectionFactory;
use Study\Promotions\Model\PromotedProductsFactory;
use Study\Promotions\Model\PromotedProductLinksRepository;
use Study\Promotions\Service\DeleteLinkedProductsService;
use Psr\Log\LoggerInterface;

/**
 * Promotions resource model
 */
class PromotionsInfoResource extends AbstractDb
{
    /**
     * @var LoggerInterface
     */
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
     * @var DeleteLinkedProductsService
     */
    private $deleteLinkedProductsService;

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
        DeleteLinkedProductsService  $deleteLinkedProductsService
    ) {
        $this->logger = $logger;
        $this->promotedProductsFactory = $promotedProductsFactory;
        $this->productLinksRepository = $productLinksRepository;
        $this->deleteLinkedProductsService = $deleteLinkedProductsService;

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
        if (null !== $promotedProducts && $promotedProducts !== '{}') {
            $promotionId = (int)$object->getId();
            $links = $this->deleteLinkedProductsService->getLinks($promotionId);
            $this->deleteLinkedProductsService->deleteLinkedProducts($links);
            $promotedProductIds = explode(' ', trim(preg_replace('@\W+@', ' ', $promotedProducts)));
            foreach ($promotedProductIds as $promotedProductId) {
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
}
