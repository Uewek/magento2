<?php
declare(strict_types=1);

namespace Study\Promotions\Model\ResourceModel\PromotionsInfo;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Study\Promotions\Model\PromotionsInfo;
use Study\Promotions\Model\ResourceModel\PromotionsInfoResource;


class Collection extends AbstractCollection
{
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(
            PromotionsInfo::class,
            PromotionsInfoResource::class
        );
    }
}

