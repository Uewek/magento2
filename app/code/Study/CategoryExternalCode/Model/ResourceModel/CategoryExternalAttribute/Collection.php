<?php
declare(strict_types=1);

namespace Study\CategoryExternalCode\Model\ResourceModel\CategoryExternalAttribute;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Study\CategoryExternalCode\Model\CategoryAttributeModel;
use Study\CategoryExternalCode\Model\ResourceModel\CategoryAttributeResource;

/**
 * Collection of external attributes
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
        $this->_init(CategoryAttributeModel::class,
            CategoryAttributeResource::class);
    }
}
