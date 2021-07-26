<?php
declare(strict_types=1);

namespace Study\ImprovedContact\Model\ResourceModel\AdvancedContactForm;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Study\ImprovedContact\Model\ContactorInfo;
use Study\ImprovedContact\Model\ResourceModel\ContractorInfo as ContactorInfoResource;

/**
 * Class Collection - main collection of this class
 */
class Collection extends AbstractCollection
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            ContactorInfo::class,
            ContactorInfoResource::class
        );
    }
}
