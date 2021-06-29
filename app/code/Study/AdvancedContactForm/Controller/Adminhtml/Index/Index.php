<?php
declare(strict_types=1);

namespace Study\AdvancedContactForm\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\Page;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action
{


    public function __construct(
        Context $context
    )
    {
        parent::__construct($context);
    }

    /**
     * @return Page
     */
    public function execute()
    {
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
