<?php
namespace  Study\InversedRelatedProducts\Model\ResourceModel;

class LinkedProducts extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{


    protected function _construct()
    {
        $this->_init('catalog_product_link', 'link_id');
    }
}
