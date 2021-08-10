<?php
declare(strict_types=1);

namespace Study\ProductLikes\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\View\Result\Page;
use Magento\Customer\Model\SessionFactory;
use Magento\Framework\Controller\Result\Redirect;
use Study\ProductLikes\Model\LikesRepository;

/**
 * Delete like controller
 */
class DeleteProductLike extends Action implements HttpGetActionInterface
{
    /**
     * @var SessionFactory
     */
    private $customerSessionFactory;

    /**
     * @var LikesRepository
     */
    private $likesRepository;

    /**
     * Constructor
     *
     * @param Context $context
     * @param LikesRepository $likesRepository
     * @param SessionFactory $customerSessionFactory
     */
    public function __construct(
        Context $context,
        LikesRepository $likesRepository,
        SessionFactory $customerSessionFactory
    ) {
        $this->customerSessionFactory = $customerSessionFactory;
        $this->likesRepository = $likesRepository;

        parent::__construct($context);
    }
    /**
     * Delete like return redirect
     *
     * @return Redirect
     */
    public function execute(): Redirect
    {
        $isLogged = $this->customerSessionFactory->create()->isLoggedIn();
        if(!$isLogged){
            $redirect = $this->resultRedirectFactory->create()->setPath('customer/account/login');
            $this->messageManager->addWarningMessage(__('Please login!'));

            return $redirect;
        }
        $getData = (int) $this->getRequest()->getParams()['like_id'];
        $this->likesRepository->deleteLikeById($getData);
        $redirect = $this->resultRedirectFactory->create()->setPath('likes');
        $this->messageManager->addWarningMessage(__("Like with id $getData delete successfully"));

        return $redirect;
    }
}
