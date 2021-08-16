<?php
declare(strict_types=1);

namespace Study\ProductLikes\Ui\DataProvider;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Study\ProductLikes\Model\ResourceModel\ProductLikes\Collection;
use Study\ProductLikes\Model\ResourceModel\ProductLikes\CollectionFactory;

/**
 * This class prepare data on the admin grid
 */
class ProductLikeListingDataProvider extends AbstractDataProvider
{
    /**
     * @var Collection
     */
    protected $collection;

    /**
     * Constructor
     *
     * @param $name
     * @param $primaryFieldName
     * @param $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        string $name,
        string $primaryFieldName,
        string $requestFieldName,
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
