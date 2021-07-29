<?php
declare(strict_types=1);

namespace Study\ProductLikes\Model\ResourceModel\ProductLikes;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Study\ProductLikes\Model\ResourceModel\LikesResource;
use Study\ProductLikes\Model\LikesModel;

/**
 * Class Collection - main collection of this class
 */
class Collection extends AbstractCollection
{
    /**
     * Collection constructor
     */
    protected function _construct()
    {
        $this->_init(
            LikesModel::class,
            LikesResource::class
        );
    }
}
