<?php
declare(strict_types=1);

namespace Study\InversedRelatedProducts\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractModel;
use Study\InversedRelatedProducts\Model\ResourceModel\LinkedProducts as LinkedProductsResource;

/**
 * Class LinkedProducts need to get ids
 */
class LinkedProducts extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'catalog_product_link';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(LinkedProductsResource::class);
    }

    /**
     * @inheritdoc
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
