<?php
declare(strict_types=1);

namespace Study\ProductLikes\Block\Product;

use Magento\Customer\Model\Session;
use Magento\Customer\Model\SessionFactory;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Catalog\Helper\Data;




/**
 * Class LikeButton contain 'like' button logic
 */
class LikeButton extends Template
{
    public const TITLE_ENABLED = "Like this";
    public const TITLE_Disabled = "Already liked";

    /**
     * @var Data
     */
    private $dataHelper;

    /**
     * @var Session
     */
    private $customerSession;

    private $customerSessionFactory;

    public function __construct(
        Context $context,
        Session $customerSession,
        Data $catalogData,
        SessionFactory $customerSessionFactory

    ) {
        $this->dataHelper = $catalogData;
        $this->customerSession = $customerSessionFactory->create();
        $this->customerSessionFactory = $customerSessionFactory;

        parent::__construct($context);
    }

    public function getConst(){
        return $this::TITLE_ENABLED;
    }

    /**
     * Get product id on product page
     *
     *
     */
    public function getProductId()
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

}
