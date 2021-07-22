<?php
declare(strict_types=1);

namespace Study\ImprovedContact\Controller\Adminhtml\Edit;

use Magento\Backend\App\Action;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;

/**
 * Class Index - controller of contact edit ui form
 */
class Index extends Action implements HttpGetActionInterface
{
    /**
     * Main method
     *
     * @return Page
     */
    public function execute()
    {
        return  $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
