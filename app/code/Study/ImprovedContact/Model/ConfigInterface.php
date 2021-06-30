<?php
declare(strict_types=1);

namespace Study\ImprovedContact\Model;

/**
 * Interface ConfigInterface
 */
interface ConfigInterface
{
    const XML_PATH_ENABLED = 'reports/options/advanced_contacts_enabled';

    /**
     * Return config enabled/disabled
     *
     * @return mixed
     */
    public function isEnabled();
}
