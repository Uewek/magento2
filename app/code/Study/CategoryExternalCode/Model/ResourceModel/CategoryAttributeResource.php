<?php
declare(strict_types=1);

namespace Study\CategoryExternalCode\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
use Magento\Framework\Model\ResourceModel\Db\Context;

/**
 * Category attribute resource model
 */
class CategoryAttributeResource extends AbstractDb
{
    /**
     * Disable autoincrement
     *
     * @var bool
     */
    protected $_isPkAutoIncrement = false;

    /**
     * Table init
     */
    protected function _construct()
    {
        $this->_init('category_external_code_attribute', 'category_id');
    }
}

