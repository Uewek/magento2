<?php
declare(strict_types=1);

namespace Study\InversedRelatedProducts\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Resource model LinkedProducts
 */
class LinkedProducts extends AbstractDb
{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init('catalog_product_link', 'link_id');
    }
}
