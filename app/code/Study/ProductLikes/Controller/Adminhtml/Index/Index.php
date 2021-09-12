<?php
declare(strict_types=1);

namespace Study\ProductLikes\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface as ResponseInterfaceAlias;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page as Page;

/**
 * Class Index - controller of ui listing page
 */
class Index extends Action implements HttpGetActionInterface
{
    /**
     * Main method
     *
     * @return Page
     */
    public function execute(): Page
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}