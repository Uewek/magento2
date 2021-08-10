<?php
declare(strict_types=1);

namespace Study\ProductLikes\Block\Product;

use Magento\Customer\Model\SessionFactory;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Catalog\Helper\Data;
use Study\ProductLikes\Model\LikesRepository;
use Study\ProductLikes\Model\CookieModel;
use Study\ProductLikes\Model\Cookie;
use Magento\Framework\Data\Form\FormKey;
use Magento\Framework\App\ObjectManager;


/**
 * Class LikeButton contain 'like' button logic
 */
class LikeButton extends Template
{
    public const TITLE_ENABLED = "I like this product";
    public const TITLE_DISABLED = "Already liked";

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

    private $formKey;

    /**
     * @param Context $context
     * @param Data $catalogData
     * @param LikesRepository $likesRepository
     * @param SessionFactory $customerSessionFactory
     */
    public function __construct(
        Context $context,
        Data $catalogData,
        LikesRepository $likesRepository,
        SessionFactory $customerSessionFactory,
        FormKey $formKey
    ) {
        $this->formKey = $formKey;
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
        $a = (int) $this->dataHelper->getProduct()->getId();
        return  $a;
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
    public function isLogged()
    {
        $customerSession = $this->customerSessionFactory->create();
        return $customerSession->isLoggedIn();
    }

    /**
     * Check is this product liked
     *
     * @param $productId
     * @param $customerId
     * @return bool
     */
    public function isThisProductLiked($productId, $customerId)
    {
        $result = true;
        $likes = $this->likesrepository->checkIsProductLikedByThisCustomer((int)$productId, (int)$customerId);
        if(empty($likes)){
            $result = false;
        }
        return $result;
    }


    /**
     * Get form key
     *
     * @return string
     */
    public function getFormKey()
    {
        return $this->formKey->getFormKey();
    }

}
