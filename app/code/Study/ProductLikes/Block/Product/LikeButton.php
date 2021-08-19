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
     * Block constructor
     *
     * @param Context $context
     * @param Data $catalogData
     * @param LikesRepository $likesRepository
     * @param SessionFactory $customerSessionFactory
     */
    public function __construct
    (
        Context                $context,
        Data                   $catalogData,
        CookieManagerInterface $cookieManager,
        LikesRepository        $likesRepository,
        SessionFactory         $customerSessionFactory
    ) {
        $this->cookieManager = $cookieManager;
        $this->likesrepository = $likesRepository;
        $this->dataHelper = $catalogData;
        $this->customerSession = $customerSessionFactory->create();

        parent::__construct($context);
    }

    /**
     * Get product id on product page
     *
     * @return int
     */
    public function getProductId(): int
    {
        return (int)$this->dataHelper->getProduct()->getId();
    }

    /**
     * Get customer id on product page
     *
     * @return int|null
     */
    public function getCustomerId(): int
    {
        return (int)$this->customerSession->getCustomer()->getId();
    }

    /**
     * Check is customer logged
     *
     * @return bool
     */
    public function isLogged(): bool
    {
        return $this->customerSession->isLoggedIn();
    }

    /**
     * Check is this product liked
     *
     * @return bool
     */
    public function isThisProductLikedByCustomer(): bool
    {
        $customerId = $this->getCustomerId();
        $productId = $this->getProductId();
        $result = $this->likesrepository->checkIsProductLikedByThisCustomer($productId, (int)$customerId);

        return $result;
    }

    /**
     * Check is that product is liked by current guest
     *
     * @return bool
     */
    public function isThisProductLikedByThisGuest(): bool
    {
        if (!$this->customerSession->isLoggedIn()) {
            $productId = $this->getProductId();
            $cookieGuestKey = $this->cookieManager->getCookie('cookie_guest_key');
            if($cookieGuestKey == null){

                return false;
            }
            $result = $this->likesrepository->checkIsProductLikedByThisGuest($productId, $cookieGuestKey);

            return $result;
        }

        return false;
    }
}
