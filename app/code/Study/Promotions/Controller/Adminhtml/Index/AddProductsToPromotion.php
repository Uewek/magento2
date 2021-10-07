<?php
declare(strict_types=1);

namespace Study\Promotions\Controller\Adminhtml\Index;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\Action;
use Psr\Log\LoggerInterface;
use Study\Promotions\Model\PromotedProductsFactory;
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
        $linkedProductsArray = $this->promotionLinksCollectionFactory->create()
            ->addFieldToFilter('promotion_id', $data['promotion'])->addFieldToSelect('product_id')->getData();
        $productIdsArray = [];

        foreach ($linkedProductsArray as $productId) {
            $productIdsArray[] = $productId['product_id'];
        }
        $promotedProductIds = explode(' ', trim(preg_replace('@\W+@',
            ' ', $data['productJson'])));

        foreach ($promotedProductIds as $promotedProductId) {
            if (empty($productIdsArray) || in_array($promotedProductId, $productIdsArray) !== true) {
                $promotedProduct = $this->promotedProductsFactory->create()
                    ->setPromotedProduct((int)$promotedProductId)
                    ->setPromotion((int)$data['promotion']);
                try {
                    $this->productLinksRepository->savePromotedProduct($promotedProduct);
                } catch (\Exception $e) {
                    $this->messageManager->addErrorMessage(__('Something went wrong!'));
                    $this->logger->critical('Error during linking product to promotion', ['exception' => $e]);
                }
            }
        }
        $this->messageManager->addSuccessMessage(__('Products successfully assigned to promotion !'));
    }
}
