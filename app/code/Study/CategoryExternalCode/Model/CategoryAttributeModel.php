<?php
declare(strict_types=1);

namespace Study\CategoryExternalCode\Model;

use Study\CategoryExternalCode\Api\CategoryAttributeModelInterface;
use Magento\Framework\Model\AbstractModel;
use Study\CategoryExternalCode\Model\ResourceModel\CategoryAttributeResource;

/**
 * Model of category attributes
 */
class CategoryAttributeModel extends AbstractModel implements CategoryAttributeModelInterface
{
    /**
     * Init resource model
     */
    protected function _construct(): void
    {
        $this->_init(CategoryAttributeResource::class);
    }
}
