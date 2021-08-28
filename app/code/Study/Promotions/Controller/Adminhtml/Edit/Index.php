<?php
declare(strict_types=1);

namespace Study\Promotions\Controller\Adminhtml\Edit;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;

/**
 * Class Index - controller of contact edit ui form
 */
class Index extends Action implements HttpGetActionInterface
{


    public function execute()
    {
        return  $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
