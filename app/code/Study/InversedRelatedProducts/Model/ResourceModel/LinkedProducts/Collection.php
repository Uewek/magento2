<?php

namespace Study\InversedRelatedProducts\Model\ResourceModel\LinkedProducts;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{


    protected function _construct()
    {
        $this->_init('Study\InversedRelatedProducts\Model\LinkedProducts',
            'Study\InversedRelatedProducts\Model\ResourceModel\LinkedProducts');
    }

}
