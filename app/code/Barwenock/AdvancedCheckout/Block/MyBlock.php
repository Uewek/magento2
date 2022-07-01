<?php
declare(strict_types=1);

namespace Barwenock\AdvancedCheckout\Block;
use Magento\Cms\Block\Widget\Block;
use Magento\Cms\Model\BlockFactory;
use Magento\Cms\Model\Template\FilterProvider;
use Magento\Framework\View\Element\Template\Context;
use Magento\Checkout\Model\Session;

class MyBlock extends Block
{
    /**
     * @var Session
     */
    private $session;

    public function __construct(
        Context $context,
        FilterProvider $filterProvider,
        BlockFactory $blockFactory,
        Session $session,
        array $data = []
    ) {

        $this->session = $session;
        parent::__construct($context, $filterProvider, $blockFactory, $data);
    }

    public function getPaymentString():string
    {
        $quote = $this->session->getQuote();
        $payment = $quote->getPayment()->getMethod();
        $items = $quote->getItems();
        $shipping = $quote->getShippingAddress();
        return $payment;
    }


}
