<?php
declare(strict_types=1);

namespace Study\ProductLikes\Observer;

use Magento\Customer\Model\SessionFactory;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Stdlib\Cookie\CookieMetadataFactory;
use Magento\Framework\Stdlib\CookieManagerInterface;
use Study\ProductLikes\Model\ResourceModel\ProductLikes\CollectionFactory;
use Study\ProductLikes\Model\LikesModelFactory;
use Study\ProductLikes\Model\LikesRepository;

/**
 * Observer used for set customer likes instead guest likes
 */
class LoginObserver implements ObserverInterface
{
    /**
     * @var CookieManagerInterface
     */
    private $cookieManager;

    /**
     * @var SessionFactory
     */
    private $sessionFactory;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var CookieMetadataFactory
     */
    private $cookieMetadataFactory;

    /**
     * @var LikesModelFactory
     */
    private $likesModelFactory;

    /**
     * @var LikesRepository
     */
    private $likesRepository;

    /**
     * Login observer constructor
     *
     * @param SessionFactory $sessionFactory
     * @param LikesRepository $likesRepository
     * @param LikesModelFactory $likesModelFactory
     * @param CookieMetadataFactory $cookieMetadataFactory
     * @param CollectionFactory $collectionFactory
     * @param CookieManagerInterface $cookieManager
     */
    public function __construct(
        SessionFactory $sessionFactory,
        LikesRepository $likesRepository,
        LikesModelFactory $likesModelFactory,
        CookieMetadataFactory $cookieMetadataFactory,
        CollectionFactory $collectionFactory,
        CookieManagerInterface $cookieManager
    ) {
       $this->cookieMetadataFactory = $cookieMetadataFactory;
       $this->likesRepository = $likesRepository;
       $this->likesModelFactory = $likesModelFactory;
       $this->cookieManager = $cookieManager;
       $this->sessionFactory = $sessionFactory;
       $this->collectionFactory = $collectionFactory;
    }

    /**
     * Set customer likes and deleting guest likes of signing in/creating new customer
     *
     * @param Observer $observer
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function execute(Observer $observer): void
    {
        $cookieGuestKey = $this->cookieManager->getCookie('cookie_guest_key');
        $customerId = $this->sessionFactory->create()->getCustomerId();
        $collectionByFormKey = $this->collectionFactory->create()->
        addFilter('cookie_guest_key', $cookieGuestKey)
        ->getItems();
        if(!empty($collectionByFormKey)){
            foreach ($collectionByFormKey as $like){
                $newLike = $this->likesModelFactory->create()
                    ->setProduct((int) $like['product_id'])
                    ->setCustomer((int) $customerId);
                $this->likesRepository->save($newLike);
                $this->likesRepository->deleteLikeById((int) $like['like_id']);
            }
        }
        $metadata = $this->cookieMetadataFactory->createPublicCookieMetadata()->setPath('/');
        $this->cookieManager->deleteCookie('cookie_guest_key', $metadata);
    }
}