<?php
declare(strict_types=1);

namespace Study\ProductLikes\Observer;

use Magento\Customer\Model\SessionFactory;
use Magento\Framework\Data\Form\FormKey;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Study\ProductLikes\Block\Product\LikeButton;
use Study\ProductLikes\Model\ResourceModel\ProductLikes\CollectionFactory;

class LoginObserver implements ObserverInterface
{
    private $sessionFactory;
    private $formKey;
    private $collectionFactory;
    private $block;
    public function __construct(
        SessionFactory $sessionFactory,
        FormKey $formKey,
        SessionFactory $customerSessionFactory,
        CollectionFactory $collectionFactory,
        LikeButton $block

    ) {
       $this->block = $block;
       $this->sessionFactory = $sessionFactory;
       $this->formKey = $formKey;
       $this->customerSessionFactory = $sessionFactory;
       $this->collectionFactory = $collectionFactory;
    }
    public function execute(Observer $observer)
    {
        $blockFormKey = $this->block->getFormKey();
        $currentFormKey = $this->formKey->getFormKey();
        $sessionId = $this->sessionFactory->create()->getSessionId();
        $customerId = $this->customerSessionFactory->create()->getCustomerId();
        $collectionByFormKey = $this->collectionFactory->create()->
        addFilter('cookie_form_key', $currentFormKey)
        ->getItems();

    }
}
