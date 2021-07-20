<?php
declare(strict_types=1);

namespace Study\ImprovedContact\Api;

/**
 * Interface ConfigInterface interface for config model
 */
interface ConfigInterface
{
    const XML_IMPROVEDCONTACTS_ENABLED = 'reports/options/advanced_contacts_enabled';

    /**
     * Return config enabled/disabled
     *
     * @return bool
     */
    public function isEnabled();
}
