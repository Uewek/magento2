<?php
declare(strict_types=1);

namespace Study\ImprovedContact\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class AdvancedContactForm extends AbstractDb
{
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init('study_advancedcontacts', 'contact_id');
    }
}
