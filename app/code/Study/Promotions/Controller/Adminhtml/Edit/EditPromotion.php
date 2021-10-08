<?php
declare(strict_types=1);

namespace Study\Promotions\Controller\Adminhtml\Edit;

use Psr\Log\LoggerInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Study\Promotions\Model\PromotionsRepository;
use Study\Promotions\Model\PromotionsInfoFactory;
use Study\Promotions\Model\PromotionsValidator;

/**
 * Update promotion controller
 */
class EditPromotion extends Action implements HttpPostActionInterface
{
    /**
     * @var PromotionsRepository
     */
    private $promotionsRepository;

    /**
     * @var PromotionsInfoFactory
     */
    private $promotionsInfoFactory;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var PromotionsValidator
     */
    private $promotionValidator;

    /**
     * Class constructor
     *
     * @param Context $context
     * @param PromotionsRepository $promotionsRepository
     * @param PromotionsInfoFactory $promotionsInfoFactory
     */
    public function __construct(
        Context               $context,
        PromotionsRepository  $promotionsRepository,
        LoggerInterface       $logger,
        PromotionsValidator   $promotionValidator,
        PromotionsInfoFactory $promotionsInfoFactory
    ) {
        $this->promotionValidator = $promotionValidator;
        $this->logger = $logger;
        $this->promotionsRepository = $promotionsRepository;
        $this->promotionsInfoFactory = $promotionsInfoFactory;

        parent::__construct($context);
    }

    /**
     * Update promotion
     *
     * @return ResultInterface
     */
    public function execute(): ResultInterface
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('promotions/');
        $data = $this->getRequest()->getParams();

        if (!$this->promotionValidator->isTimeParametersIsCorrect($data['start_time'], $data['finish_time'])) {
            $this->messageManager->addErrorMessage(__('Finish date cannot be less than start date !'));

            return $resultRedirect;
        }

        if (!isset($data['promotion_id'])) {
            $promotion = $this->promotionsInfoFactory->create();
            $promotion->setData('promoted_products', $data['promoted_products']);
            $message = 'Promotion created successfully !';
        }

        if (isset($data['promotion_id'])) {
            $promotion = $this->promotionsRepository->getById((int)$data['promotion_id']);
            $promotion->setData('promoted_products', $data['promoted_products']);
            $message = 'Promotion data updated successfully !';
        }

        $promotion->setDescription($data['promotion_description'])
            ->setName($data['promotion_name'])
            ->setStatus((int)$data['promotion_enabled'])
            ->setStartTime($data['start_time'])
            ->setFinishTime($data['finish_time']);

        try {
            $this->promotionsRepository->save($promotion);
            $this->messageManager->addSuccessMessage(__($message));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('Something went wrong!'));
            $this->logger->critical('Error during save promotion', ['exception' => $e]);
        }

        return $resultRedirect;
    }
}
