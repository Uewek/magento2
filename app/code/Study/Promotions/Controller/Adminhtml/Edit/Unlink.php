<?php
declare(strict_types=1);

namespace Study\Promotions\Controller\Adminhtml\Edit;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Study\Promotions\Api\PromotedProductsInterface;
use Study\Promotions\Model\PromotedProductLinksRepository;
use Study\Promotions\Model\ResourceModel\PromotionsLinks\CollectionFactory;

/**
 * Delete promotion link
 */
class Unlink extends Action implements HttpGetActionInterface
{
    /**
     * @var PromotedProductLinksRepository
     */
    private $productLinksRepository;

    /**
     * @var CollectionFactory
     */
    private $promotionLinksCollectionFactory;

    /**
     * Constructor
     *
     * @param Context $context
     * @param PromotedProductLinksRepository $productLinksRepository
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        Context                        $context,
        PromotedProductLinksRepository $productLinksRepository,
        CollectionFactory              $collectionFactory
    ) {
        $this->promotionLinksCollectionFactory = $collectionFactory;
        $this->productLinksRepository = $productLinksRepository;

        parent::__construct($context);
    }

    /**
     * Add selected product to current promotion
     *
     * @return void
     */
    public function execute(): ResultInterface
    {
        $data = $this->getRequest()->getParams();
        try {
            $deletedLink = $this->getLink((int)$data['product_id'], (int)$data['promotion_id']);
        } catch (\Exception $exception) {

        }

        $this->productLinksRepository->delete($deletedLink);

        return $this->returnToEditPage($data['promotion_id']);
    }


    /**
     * Get promotion link by given parameters
     *
     * @param int $productId
     * @param int $promotionId
     * @return
     */
    private function getLink(int $productId, int $promotionId): PromotedProductsInterface
    {
        $collection = $this->promotionLinksCollectionFactory->create();
        $collection->addFilter('product_id', $productId)->addFilter('promotion_id', $promotionId);

        foreach ($collection->getItems() as $item) {
            $link = $item;
        }

        return $link;
    }

    /**
     * Prepare and return redirect link
     *
     * @param string $promotionId
     * @return Redirect
     */
    private function returnToEditPage(string $promotionId): ResultInterface
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('promotions/edit/index/id/' . $promotionId . '/');

        return $resultRedirect;
    }
}
