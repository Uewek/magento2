<?php
declare(strict_types=1);

namespace Study\ProductLikes\Controller\Index;

use Magento\Customer\Model\Session;
use Magento\Customer\Model\SessionFactory;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\Http;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\Action;
use Study\ProductLikes\Model\LikesModelFactory;
use Study\ProductLikes\Model\LikesRepository;
use Study\ProductLikes\Logger\Logger;

/**
 * Class LikeProduct - in this controller creating new like
 */
class LikeProduct extends Action implements HttpPostActionInterface
{
    /**
     * @var LikesModelFactory
     */
    private $likesModelFactory;

    /**
     * @var Http
     */
    private $request;

    /**
     * @var LikesRepository
     */
    private $likesRepository;

    /**
     * @var Session
     */
    private $customerSession;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * LikeProduct constructor.
     * @param Context $context
     * @param Http $request
     * @param LikesModelFactory $likesModelFactory
     * @param LikesRepository $likesRepository
     */
    public function __construct
    (
        Context           $context,
        Http              $request,
        LikesModelFactory $likesModelFactory,
        SessionFactory    $customerSessionFactory,
        Logger            $logger,
        LikesRepository   $likesRepository
    ) {
        $this->customerSession = $customerSessionFactory->create();
        $this->request = $request;
        $this->likesModelFactory = $likesModelFactory;
        $this->likesRepository = $likesRepository;

        parent::__construct($context);

        $this->logger = $logger;
    }

    /**
     * Create new product like
     *
     * @return void
     */
    public function execute(): void
    {
        $customerLogged = $this->customerSession->isLoggedIn();
        $productId = $this->request->getParam('productId');
        $guestKey = $this->request->getParam('cookie_guest_key');

        if (!$customerLogged) {
            $this->addGuestLike((int)$productId, $guestKey);
        }

        if ($customerLogged) {
            $this->addCustomerLike((int)$productId);
        }
    }

    /**
     * Add like for unsigned customer
     *
     * @param int $productId
     * @param string $cookieKey
     * @return void
     */
    private function addGuestLike(int $productId, string $cookieKey): void
    {
        $isLiked = $this->likesRepository->
        isProductLikedByGuest($productId, $cookieKey);

        if ($isLiked) {
            $this->logger->emergency("Guest with guestKey $cookieKey try hack site!!!");
        }

        if (!$isLiked) {
            $newLike = $this->likesModelFactory->create()
                ->setProductId($productId)
                ->setCookieGuestKey($cookieKey);
            $this->likesRepository->save($newLike);
            $this->messageManager->addSuccessMessage(__('Product liked!'));
        }
    }

    /**
     * Add like for registred and signed customer
     *
     * @param array $data
     */
    private function addCustomerLike(int $productId): void
    {
        $customerId = $this->customerSession->getCustomerId();
        $isLiked = $this->likesRepository->
        isProductLikedByCustomer($productId, (int)$customerId);

        if ($isLiked) {
            $this->logger->emergency("Customer with customerId $customerId try hack site!!!");
        }


        if (!$isLiked) {
            $newLike = $this->likesModelFactory->create()
                ->setProductId($productId)
                ->setCustomerId((int)$customerId);
            $this->likesRepository->save($newLike);
            $this->messageManager->addSuccessMessage(__('Product liked!'));
        }
    }
}
