<?php
declare(strict_types=1);

namespace Study\ProductLikes\Ui\DataProvider;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Study\ProductLikes\Model\ResourceModel\ProductLikes\Collection;
use Study\ProductLikes\Model\ResourceModel\ProductLikes\CollectionFactory;
use Magento\Customer\Model\SessionFactory;

/**
 * This class prepare data for admin grid
 */
class StorefrontProductLikeListingDataProvider extends AbstractDataProvider
{
    /**
     * @var SessionFactory
     */
    private $customerSessionFactory;
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
     * @param SessionFactory $customerSessionFactory
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        SessionFactory $customerSessionFactory,
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
        $this->customerSessionFactory = $customerSessionFactory;
        $customerId = $customerSessionFactory->create()->getCustomerId();
        $this->collection = $collectionFactory->create()->addFilter('customer_id', $customerId);
    }
}
