<?php
declare(strict_types=1);

namespace Study\Promotions\Controller\Adminhtml\Edit;

use Psr\Log\LoggerInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultInterface;
use Study\Promotions\Model\PromotionsRepository;
use Magento\Framework\Controller\Result\JsonFactory;
use Study\Promotions\Service\DeleteLinkedProductsService;

/**
 * Delete promotion controller
 */
class DeletePromotion extends Action implements HttpPostActionInterface
{
    /**
     * @var DeleteLinkedProductsService
     */
    private $deleteLinkedProductsService;
    /**
     * @var JsonFactory
     */
    private $jsonFactory;
    /**
     * @var PromotionsRepository
     */
    private $promotionsRepository;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param Context $context
     * @param LoggerInterface $logger
     * @param JsonFactory $jsonFactory
     * @param DeleteLinkedProductsService $deleteLinkedProductsService
     * @param PromotionsRepository $promotionsRepository
     */
    public function __construct(
        Context              $context,
        LoggerInterface      $logger,
        JsonFactory          $jsonFactory,
        DeleteLinkedProductsService $deleteLinkedProductsService,
        PromotionsRepository $promotionsRepository
    ) {
        $this->deleteLinkedProductsService = $deleteLinkedProductsService;
        $this->logger = $logger;
        $this->jsonFactory = $jsonFactory;
        $this->promotionsRepository = $promotionsRepository;
        parent::__construct($context);
    }

    /**
     * Delete assigned product links and promotion, return response
     *
     * @return ResultInterface
     * @throws \Exception
     */
    public function execute(): ResultInterface
    {
        $promotionId = (int) $this->getRequest()->getParams()['promotion'];
        $response['redirectUrl'] = $this->_url->getUrl('promotions/index/index');
        $resultJson = $this->jsonFactory->create();
        $resultJson->setData($response);

        if (isset($promotionId)) {
            $promotion = $this->promotionsRepository->getById($promotionId);

            try {
                $links = $this->deleteLinkedProductsService->getLinks($promotionId);
                $this->deleteLinkedProductsService->deleteLinkedProducts($links);
                $this->promotionsRepository->delete($promotion);
                $this->messageManager->addSuccessMessage(__('Promotion deleted successfully !'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Something went wrong!'));
                $this->logger->critical('Error during deleting promotion', ['exception' => $e]);
            }
        }

        return $resultJson;
    }
}
