<?php
declare(strict_types=1);

namespace Study\InversedRelatedProducts\Model\ResourceModel\LinkedProducts;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Study\InversedRelatedProducts\Model\LinkedProducts;
use Study\InversedRelatedProducts\Model\ResourceModel\LinkedProducts as LinkedProductsResource;

/**
 * Class Collection init model and resourceModel
 */
class Collection extends AbstractCollection
{
    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(LinkedProducts::class, LinkedProductsResource::class);
    }
}
