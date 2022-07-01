<?php
declare(strict_types=1);

namespace SoftLoft\MidnightMail\Model\ResourceModel\ConnectionCollection;

use SoftLoft\MidnightMail\Model\CustomerConnection;
use SoftLoft\MidnightMail\Model\ResourceModel\CustomerConnectionResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

/**
 * Customer connection log collection
 */
class Collection extends AbstractCollection
{
    /**
     * Define entity model and resource model
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(CustomerConnection::class, CustomerConnectionResource::class);
    }
}
