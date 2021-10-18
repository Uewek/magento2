<?php
declare(strict_types=1);

namespace Study\ProductLikes\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Class LikesResource
 */
class LikesResource extends AbstractDb
{
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        $this->_init('study_product_likes', 'like_id');
    }
}
