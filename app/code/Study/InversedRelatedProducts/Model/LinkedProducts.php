<?php
namespace  Study\InversedRelatedProducts\Model;

class LinkedProducts extends \Magento\Framework\Model\AbstractModel implements \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'catalog_product_link';

    protected function _construct()
    {
        $this->_init('Study\InversedRelatedProducts\Model\ResourceModel\LinkedProducts');
    }
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_'. $this->getId()];
    }

}
