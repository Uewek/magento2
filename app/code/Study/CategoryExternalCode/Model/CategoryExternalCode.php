<?php
declare(strict_types=1);

namespace Study\CategoryExternalCode\Model;

use Study\CategoryExternalCode\Api\Data\CategoryExternalCodeInterface;
use Magento\Framework\Model\AbstractModel;
use Study\CategoryExternalCode\Model\ResourceModel\CategoryAttributeResource;

/**
 * Model of category attributes
 */
class CategoryExternalCode extends AbstractModel implements CategoryExternalCodeInterface
{
    /**
     * Init resource model
     */
    protected function _construct(): void
    {
        $this->_init(CategoryAttributeResource::class);
    }

}
