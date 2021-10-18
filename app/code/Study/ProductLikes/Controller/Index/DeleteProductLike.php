<?php
declare(strict_types=1);

namespace Study\ProductLikes\Controller\Index;

use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\Action;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Customer\Model\SessionFactory;
use Magento\Framework\Controller\Result\Redirect;
use Study\ProductLikes\Api\LikesRepositoryInterface;

/**
 * Delete like controller
 */
class DeleteProductLike extends Action implements HttpGetActionInterface
{
    /**
     * @var Session
     */
    private $customerSession;

    /**
     * @var LikesRepositoryInterface
     */
    private $likesRepository;

    /**
     * @var SessionFactory
     */
    private $customerSessionFactory;

    /**
     * Constructor
     *
     * @param Context $context
     * @param LikesRepositoryInterface $likesRepository
     * @param SessionFactory $customerSessionFactory
     */
    public function __construct
    (
        Context                  $context,
        LikesRepositoryInterface $likesRepository,
        SessionFactory           $customerSessionFactory
    ) {
        $this->customerSessionFactory = $customerSessionFactory;
        $this->likesRepository = $likesRepository;
        $this->customerSession = $customerSessionFactory->create();

        parent::__construct($context);
    }

    /**
     * Delete like return redirect
     *
     * @return Redirect
     */
    public function execute(): Redirect
    {
        $isLogged = $this->customerSession->isLoggedIn();

        if (!$isLogged) {
            $redirect = $this->resultRedirectFactory->create()->setPath('customer/account/login');
            $this->messageManager->addWarningMessage(__('Please login!'));

            return $redirect;
        }

        $likeId = (int)$this->getRequest()->getParam('like_id');
        $redirect = $this->resultRedirectFactory->create()->setPath('likes');

        if (null !== $likeId) {
            try {
                $this->likesRepository->deleteById($likeId);
                $this->messageManager->addSuccessMessage(__('Like deleted successfully'));
            } catch (NoSuchEntityException $entityException) {
                $this->errorRedirect();
            }
        }

        return $redirect;
    }

    /**
     * Redirect to previous page when error happened
     *
     * @return Redirect
     */
    private function errorRedirect(): Redirect
    {
        $redirect = $this->resultRedirectFactory->create()->setPath('likes');
        $this->messageManager->addErrorMessage(__("Something went wrong!!"));

        return $redirect;
    }
}
