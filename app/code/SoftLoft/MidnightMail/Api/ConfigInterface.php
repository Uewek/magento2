<?php

namespace SoftLoft\MidnightMail\Api;

interface ConfigInterface
{
    /**
     * Path to track connection 'is enabled' value
     */
    public const XML_TRACK_CUSTOMERS_ENABLED = 'customer/track_module/track_connections';

    /**
     * Path to mail connections at 00:00 config
     */
    public const XML_MAIL_TRACKED = 'customer/track_module/track_vebsite_visit';

    /**
     * Path to mail connections at 00:00 config
     */
    public const XML_MAIL_TARGET_ADDRESS = 'customer/track_module/target_email';

    /**
     * Return config track customer connection enabled/disabled
     *
     * @return bool
     */
    public function trackConnectionIsEnabled(): bool;

    /**
     * Return config mail tracked enabled/disabled
     *
     * @return bool
     */
    public function mailTrackedIsEnabled(): bool;

    /**
     * Return recepient email
     *
     * @return string
     */
    public function getMailRecepientEmail(): string;
}
