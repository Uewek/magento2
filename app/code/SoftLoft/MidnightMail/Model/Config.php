<?php
declare(strict_types=1);

namespace SoftLoft\MidnightMail\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use SoftLoft\MidnightMail\Api\ConfigInterface;

/**
 * Configuration model for track connections
 */
class Config implements ConfigInterface
{
    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @inerhitDoc
     *
     * @return bool
     */
    public function trackConnectionIsEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_TRACK_CUSTOMERS_ENABLED, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @inerhitDoc
     *
     * @return bool
     */
    public function mailTrackedIsEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_MAIL_TRACKED, ScopeInterface::SCOPE_STORE);
    }

    /**
     * @inerhitDoc
     *
     * @return string
     */
    public function getMailRecepientEmail(): string
    {
        return $this->scopeConfig->getValue(self::XML_MAIL_TARGET_ADDRESS, ScopeInterface::SCOPE_STORE);
    }
}
