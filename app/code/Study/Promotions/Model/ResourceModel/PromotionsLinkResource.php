<?php
declare(strict_types=1);

namespace Study\Promotions\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Promoted products resource model
 */
class PromotionsLinkResource extends AbstractDb
{
    /**
     * Define table
     */
    protected function _construct()
    {
        $this->_init('promoted_products', 'promotion_link_id');
    }
}
