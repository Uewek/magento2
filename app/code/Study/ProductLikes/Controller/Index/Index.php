<?php
declare(strict_types=1);

namespace Study\ProductLikes\Controller\Index;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\View\Result\Page;

class Index extends Action implements HttpPostActionInterface
{
    /**
     * Return page
     *
     * @return Page
     */
    public function execute()
    {
        $page = $this->resultFactory->create(ResultFactory::TYPE_PAGE);

        return $page;
    }
}
