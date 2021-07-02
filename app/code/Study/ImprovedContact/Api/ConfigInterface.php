<?php
declare(strict_types=1);

namespace Study\ImprovedContact\Api;

/**
 * Interface ConfigInterface
 */
interface ConfigInterface
{
    const XML_IMPRIVEDCONTACTS_ENABLED = 'reports/options/advanced_contacts_enabled';

    /**
     * Return config enabled/disabled
     *
     * @return mixed
     */
    public function isEnabled();
}
