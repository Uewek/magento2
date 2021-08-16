<?php
namespace Magenest\CookieDemo\Controller\Cookie;

use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\Action;
use Magento\Framework\Stdlib\CookieManagerInterface;

/**
 * Class GetCookie
 * @package Magenest\CookieDemo\Controller\Cookie
 */
class GetCookie extends Action
{
    /**
     * @var CookieManagerInterface
     */
    protected $cookieManager;

    /**
     * GetCookie constructor.
     * @param Context $context
     * @param CookieManagerInterface $cookieManager
     */
    public function __construct(
        Context $context,
        CookieManagerInterface $cookieManager
    )
    {
        $this->cookieManager = $cookieManager;
        parent::__construct($context);
    }

    public function execute()
    {
        $cookieValue = $this->cookieManager->getCookie(SetCookie::COOKIE_NAME);
        echo $cookieValue;
    }
}