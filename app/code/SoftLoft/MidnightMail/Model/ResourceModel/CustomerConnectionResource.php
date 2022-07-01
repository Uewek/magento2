<?php
declare(strict_types=1);

namespace SoftLoft\MidnightMail\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Resource model for customer connection
 */
class CustomerConnectionResource extends AbstractDb
{
    /**
     * Table init
     */
    protected function _construct()
    {
        $this->_init('customer_connection_logs', 'log_id');
    }

}
