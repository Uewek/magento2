<?php
declare(strict_types=1);

namespace Study\Promotions\Controller\Adminhtml\Edit;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\Result\Redirect;
use Study\Promotions\Model\PromotionsRepository;
use Study\Promotions\Model\PromotionsInfoFactory;

/**
 * Update promotion controller
 */
class EditPromotion extends Action implements HttpGetActionInterface, HttpPostActionInterface
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
     * Class constructor
     *
     * @param Context $context
     * @param PromotionsRepository $promotionsRepository
     * @param PromotionsInfoFactory $promotionsInfoFactory
     */
    public function __construct(
        Context               $context,
        PromotionsRepository  $promotionsRepository,
        PromotionsInfoFactory $promotionsInfoFactory
    ) {
        $this->promotionsRepository = $promotionsRepository;
        $this->promotionsInfoFactory = $promotionsInfoFactory;

        parent::__construct($context);
    }

    /**
     * Update promotion
     *
     * @return Redirect
     */
    public function execute(): Redirect
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('promotions/');
        $data = $this->getRequest()->getParams();

        if (!$data['finish_time']) {
            $data['finish_time'] =null;
        }

        if (isset($data['finish_time']) && (strtotime($data['start_time']) > strtotime($data['finish_time']))) {
            $this->messageManager->addErrorMessage(__('Finish date cannot be less than start date !'));

            return $resultRedirect;
        }

        if (!isset($data['promotion_id'])) {
            $promotion = $this->promotionsInfoFactory->create();
            $message = 'Promotion created successfully !';
        }

        if (isset($data['promotion_id'])) {
            $promotion = $this->promotionsRepository->getPromotionById((int)$data['promotion_id']);
            $message = 'Promotion data updated successfully !';
        }
            $promotion->setDescription($data['promotion_description'])
            ->setName($data['promotion_name'])
            ->setStatus($this->strToBool($data['promotion_enabled']))
            ->setStartTime($data['start_time'])
            ->setFinishTime($data['finish_time']);

        $this->promotionsRepository->savePromotion($promotion);
        $this->messageManager->addSuccessMessage(__($message));
        return $resultRedirect;
    }

    /**
     * Convert string to boolean
     *
     * @param string $str
     * @return bool
     */
    private function strToBool(string $str): bool
    {
        $result = true;
        if ($str === "false") {
            $result = false;
        }
        return $result;
    }
}
