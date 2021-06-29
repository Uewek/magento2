<?php
declare(strict_types=1);

namespace Study\AdvancedContactForm\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context as Context;

class AdvancedContactForm extends AbstractDb
{
    /**
     * AdvancedContactForm constructor.
     * @param Context $context
     */
    public function __construct( Context $context)
    {
        parent::__construct($context);
    }
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init('study_advancedcontacts', 'contact_id');
    }
}
