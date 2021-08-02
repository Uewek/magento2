<?php
declare(strict_types=1);

namespace Study\ProductLikes\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\View\Result\Page;
use Magento\Customer\Model\SessionFactory;
use Magento\Framework\Controller\Result\Redirect;

/**
 * Customer likesgrid page controller
 */
class Index extends Action implements HttpGetActionInterface
{
    /**
     * @var SessionFactory
     */
    private $customerSessionFactory;

    /**
     * Index constructor.
     * @param Context $context
     * @param SessionFactory $customerSessionFactory
     */
    public function __construct(
        Context $context,
        SessionFactory $customerSessionFactory
    ) {
        $this->customerSessionFactory = $customerSessionFactory;
        parent::__construct($context);
    }
    /**
     * Return page or redirect to login page
     *
     * @return Page|Redirect
     */
    public function execute(): Page|Redirect
    {
        $isLogged = $this->customerSessionFactory->create()->isLoggedIn();
        if(!$isLogged){
            $redirect = $this->resultRedirectFactory->create()->setPath('customer/account/login');
            $this->messageManager->addWarningMessage(__('Please login!'));

            return $redirect;
        }
        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}