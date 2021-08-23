<?php
declare(strict_types=1);

namespace Study\Promotions\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class PromotionsInfoResource extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('promotions_info', 'promotion_id');
    }
}
