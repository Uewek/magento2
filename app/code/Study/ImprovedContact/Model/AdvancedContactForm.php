<?php
declare(strict_types=1);

namespace Study\ImprovedContact\Model;

use Magento\Framework\Model\AbstractModel;
use Study\ImprovedContact\Model\ResourceModel\AdvancedContactForm as Resource;

class AdvancedContactForm extends AbstractModel
{

    const CACHE_TAG = 'study_advancedcontacts';

    /**
     * Form constructor
     */
    protected function _construct()
    {
        $this->_init(Resource::class);
    }
}
