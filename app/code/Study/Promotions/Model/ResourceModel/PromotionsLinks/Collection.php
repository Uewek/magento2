<?php
declare(strict_types=1);

namespace Study\Promotions\Model\ResourceModel\PromotionsLinks;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Study\Promotions\Model\PromotedProducts;
use Study\Promotions\Model\ResourceModel\PromotionsLinkResource;


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
            PromotedProducts::class,
            PromotionsLinkResource::class
        );
    }
}
