<?php
declare(strict_types=1);

namespace Study\InversedRelatedProducts\Model;

/**
 * Interface ConfigInterface
 */
interface ConfigInterface
{
    const XML_PATH_ENABLED = 'catalog/frontend/enable_inversed_relations';

    /**
     * Return config enabled/disabled
     *
     * @return mixed
     */
    public function isEnabled();
}
