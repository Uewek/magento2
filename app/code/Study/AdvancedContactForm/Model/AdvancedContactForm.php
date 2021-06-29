<?php
declare(strict_types=1);

namespace Study\AdvancedContactForm\Model;

use Magento\Framework\Model\AbstractModel;
use Study\AdvancedContactForm\Model\ResourceModel\AdvancedContactForm as Resource;

class AdvancedContactForm extends AbstractModel
{
    const CACHE_TAG = 'study_advancedcontacts';

    protected function _construct()
    {
        $this->_init(Resource::class);
    }
}
