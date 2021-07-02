<?php
declare(strict_types=1);

namespace Study\ImprovedContact\Model;

use Magento\Framework\Model\AbstractModel;
use Study\ImprovedContact\Model\ResourceModel\ContractorInfo;

class ContactorInfo extends AbstractModel
{

    /**
     * Form constructor
     */
    protected function _construct()
    {
        $this->_init(ContractorInfo::class);
    }
}
