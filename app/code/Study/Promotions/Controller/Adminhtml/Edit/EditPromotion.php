<?php
declare(strict_types=1);

namespace Study\Promotions\Controller\Adminhtml\Edit;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\Action;
use Study\Promotions\Model\PromotionsRepository;
use Study\Promotions\Model\PromotionsInfoFactory;


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

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('promotions/');
        $data = $this->getRequest()->getParams();
        if (!$data['finish_time']) {
            $data['finish_time'] = null;
        }
        if (isset ($data['finish_time']) && (strtotime($data['start_time']) > strtotime($data['finish_time']))) {
            $this->messageManager->addErrorMessage(__('Finish date cannot be less than start date !'));

            return $resultRedirect;
        }
        $promotion = $this->promotionsRepository->getPromotionById((int)$data['promotion_id'])
            ->setDescription($data['promotion_description'])
            ->setName($data['promotion_name'])
            ->setStatus($this->strToBool($data['promotion_enabled']))
            ->setStartTime($data['start_time'])
            ->setFinishTime($data['finish_time']);
        $this->promotionsRepository->savePromotion($promotion);
        $this->messageManager->addSuccessMessage(__('Promotion data updated successfully !'));
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
