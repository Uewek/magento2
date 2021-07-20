<?php
declare(strict_types=1);

namespace Study\ImprovedContact\Ui\DataProvider\Contact;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Study\ImprovedContact\Model\ResourceModel\AdvancedContactForm\Collection;
use Study\ImprovedContact\Model\ResourceModel\AdvancedContactForm\CollectionFactory;

/**
 * Class DataProvider for ui listing
 */
class DataProvider extends AbstractDataProvider
{

    /**
     * @var Collection
     */
    protected $collection;

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     * @SuppressWarnings(PHPMD.ExcessiveParameterList)
     */
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
