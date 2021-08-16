<?php
declare(strict_types=1);

namespace Study\ProductLikes\Block\Product;

use Magento\Customer\Model\SessionFactory;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Catalog\Helper\Data;
use Study\ProductLikes\Model\LikesRepository;
use Magento\Framework\Stdlib\CookieManagerInterface;


/**
 * Class LikeButton contain 'like' button logic
 */
class LikeButton extends Template
{
    public const TITLE_ENABLED = "I like this product";
    public const TITLE_DISABLED = "Already liked";

    /**
     * @var CookieManagerInterface
     */
    private $cookieManager;

    /**
     * @var Data
     */
    private $dataHelper;

    /**
     * @var LikesRepository
     */
    private $likesrepository;

    /**
     * @var SessionFactory
     */
    private $customerSessionFactory;


    /**
     * Block constructor
     *
     * @param Context $context
     * @param Data $catalogData
     * @param LikesRepository $likesRepository
     * @param SessionFactory $customerSessionFactory
     */
    public function __construct(
        Context $context,
        Data $catalogData,
        CookieManagerInterface $cookieManager,
        LikesRepository $likesRepository,
        SessionFactory $customerSessionFactory
    ) {
        $this->cookieManager = $cookieManager;
        $this->likesrepository = $likesRepository;
        $this->dataHelper = $catalogData;
        $this->customerSession = $customerSessionFactory->create();
        $this->customerSessionFactory = $customerSessionFactory;

        parent::__construct($context);
    }

    /**
     * Get product id on product page
     *
     * @return int
     */
    public function getProductId(): int
    {
      return (int) $this->dataHelper->getProduct()->getId();
    }

    /**
     * Get customer id on product page
     *
     * @return int|null
     */
    public function getCustomerId()
    {
        $customerSession = $this->customerSessionFactory->create();
        $customerId = $customerSession->getCustomer()->getId();

        return $customerId;
    }

    /**
     * Check is customer logged
     *
     * @return bool
     */
    public function isLogged(): bool
    {
        $customerSession = $this->customerSessionFactory->create();

        return $customerSession->isLoggedIn();
    }

    /**
     * Check is this product liked
     *
     * @return bool
     */
    public function isThisProductLikedByCustomer(): bool
    {
        $customerId = $this->getCustomerId();
        $productId= $this->getProductId();
        $result = true;
        $likes = $this->likesrepository->checkIsProductLikedByThisCustomer($productId, (int)$customerId);
        if(empty($likes)){
            $result = false;
        }
        return $result;
    }

    /**
     * Check is that product is liked by current guest
     *
     * @param $productId
     * @return bool
     */
    public function isThisProductLikedByThisGuest(): bool
    {
        $productId = $this->getProductId();
        $cookieGuestKey = $this->cookieManager->getCookie('cookie_guest_key');
        $result = true;
        $likes = $this->likesrepository->checkIsProductLikedByThisGuest($productId, $cookieGuestKey);
        if(empty($likes)){
            $result = false;
        }
        return $result;
    }
}
