<?php
declare(strict_types=1);

namespace Study\Promotions\Ui\DataProvider;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Study\Promotions\Model\ResourceModel\PromotionsInfo\CollectionFactory;
use Study\Promotions\Model\ResourceModel\PromotionsInfo\Collection;
use Magento\Catalog\Model\Session;

/**
 * Prepare data for promotions grid
 */
class PromotionsGridDataProvider extends AbstractDataProvider
{
    /**
     * @var Session
     */
    protected $session;
    /**
     * @var Collection
     */
    protected $collection;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        string            $name,
        string            $primaryFieldName,
        string            $requestFieldName,
        CollectionFactory $collectionFactory,
        Session           $session,
        array             $meta = [],
        array             $data = []
    )
    {
        parent::__construct(
            $name,
            $primaryFieldName,
            $requestFieldName,
            $meta,
            $data
        );
        $this->collection = $collectionFactory->create();
        $this->session = $session;
    }
}
