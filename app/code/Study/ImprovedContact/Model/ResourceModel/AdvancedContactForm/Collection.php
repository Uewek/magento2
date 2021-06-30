<?php
declare(strict_types=1);

namespace Study\ImprovedContact\Model\ResourceModel\AdvancedContactForm;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Study\ImprovedContact\Model\AdvancedContactForm;
use Study\ImprovedContact\Model\ResourceModel\AdvancedContactForm as AdvancedContactFormResource;

class Collection extends AbstractCollection
{

    /**
     * @var string
     */
    protected $_idFieldName = 'contact_id';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            AdvancedContactForm::class,
            AdvancedContactFormResource::class
        );
    }
}
