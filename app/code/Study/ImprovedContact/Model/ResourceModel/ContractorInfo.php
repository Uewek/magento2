<?php
declare(strict_types=1);

namespace Study\ImprovedContact\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class ContractorInfo resource model
 */
class ContractorInfo extends AbstractDb
{
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init('study_contactors_info', 'contact_id');
    }
}
