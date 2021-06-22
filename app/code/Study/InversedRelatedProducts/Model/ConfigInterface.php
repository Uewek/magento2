<?php
namespace Study\InversedRelatedProducts\Model;

interface ConfigInterface
{
    const XML_PATH_ENABLED = 'catalog/frontend/enable';

    public function isEnabled();
}
