<?php
declare(strict_types=1);

namespace Study\ProductLikes\Ui\DataProvider;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Study\ProductLikes\Model\ResourceModel\ProductLikes\Collection;
use Study\ProductLikes\Model\ResourceModel\ProductLikes\CollectionFactory;

class ProductLikeListingDataProvider extends AbstractDataProvider
{
    /**
     * @var Collection
     */
    protected $collection;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $meta,
            $data
        );
        $this->collection = $collectionFactory->create();
    }
}
