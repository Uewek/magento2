<?php
declare(strict_types=1);

namespace Study\Promotions\Controller\Adminhtml\Index;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\Action;
use Psr\Log\LoggerInterface;
use Study\Promotions\Model\PromotedProductsFactory;
use Study\Promotions\Model\PromotedProducts;
use Study\Promotions\Model\PromotedProductLinksRepository;
use Study\Promotions\Model\ResourceModel\PromotionsLinks\CollectionFactory;

/**
 * Add selected products to promotion without update promotion data
 */
class AddProductsToPromotion extends Action implements  HttpPostActionInterface
{
    /**
     * @var PromotedProductLinksRepository
     */
    private $productLinksRepository;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var PromotedProductsFactory
     */
    private $promotedProductsFactory;

    /**
     * @var CollectionFactory
     */
    private $promotionLinksCollectionFactory;

    /**
     * Constructor of add
     *
     * @param Context $context
     * @param PromotedProductLinksRepository $promotionProductLinksRepository
     * @param PromotedProductsFactory $promotedProductsFactory
     */
    public function __construct(
        Context                        $context,
        PromotedProductLinksRepository $productLinksRepository,
        CollectionFactory              $collectionFactory,
        LoggerInterface                $logger,
        PromotedProductsFactory        $promotedProductsFactory
    ) {
        $this->logger = $logger;
        $this->promotionLinksCollectionFactory = $collectionFactory;
        $this->productLinksRepository = $productLinksRepository;
        $this->promotedProductsFactory = $promotedProductsFactory;

        parent::__construct($context);
    }

    /**
     * Add selected product to current promotion
     *
     * @return void
     */
    public function execute(): void
    {
        $data = $this->getRequest()->getParams();
        $productIdsArray = $this->getLinkedProductsIds((int) $data['promotion']);
        $promotedProductIds = explode(' ', trim(preg_replace('@\W+@',
            ' ', $data['productJson'])));

        foreach ($promotedProductIds as $promotedProductId) {
            if (empty($productIdsArray) || !in_array($promotedProductId, $productIdsArray)) {
                $promotedProduct = $this->promotedProductsFactory->create()
                    ->setPromotedProduct((int)$promotedProductId)
                    ->setPromotion((int)$data['promotion']);
                try {
                    $this->productLinksRepository->save($promotedProduct);
                    $this->messageManager->addSuccessMessage(__('Products successfully assigned to promotion !'));
                } catch (\Exception $e) {
                    $this->messageManager->addErrorMessage(__('Something went wrong!'));
                    $this->logger->critical('Error during linking product to promotion', ['exception' => $e]);
                }
            }
        }
    }

    /**
     * Get id`s of products linked to promotion
     *
     * @param int $promotionId
     * @return array
     */
    private function getLinkedProductsIds(int $promotionId): array
    {
        $linkedProducts = $this->promotionLinksCollectionFactory->create()
            ->addFieldToFilter(PromotedProducts::PROMOTION_ID, $promotionId)
            ->addFieldToSelect(PromotedProducts::PRODUCT_ID)->getData();
        $productIdsArray = [];
        foreach ($linkedProducts as $productId) {
            $productIdsArray[] = $productId['product_id'];
        }

        return $productIdsArray;
    }
}
