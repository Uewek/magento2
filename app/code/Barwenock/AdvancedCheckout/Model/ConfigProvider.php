<?php
declare(strict_types=1);

namespace Barwenock\AdvancedCheckout\Model;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Framework\View\LayoutInterface;
use Magento\Cms\Block\Widget\Block;
use Barwenock\AdvancedCheckout\Block\MyBlock;
use Magento\Checkout\Model\Session;

class ConfigProvider implements ConfigProviderInterface
{
    protected $cmsBlockWidget;

    public function __construct(
        MyBlock $block,
        Session $checkoutSession
    ) {
        $this->cmsBlockWidget = $block;
        $this->checkoutSession = $checkoutSession;
        $block->setData('block_id', 'checkout_cms_block');
        $block->setTemplate('Barwenock_AdvancedCheckout::myTemplate.phtml');
    }

    public function getConfig()
    {
        return [
            'cms_block' => $this->cmsBlockWidget->toHtml()
        ];
    }



}
