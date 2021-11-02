<?php
declare(strict_types=1);

namespace Study\CategoryExternalCode\Service;

use Study\CategoryExternalCode\Model\ResourceModel\CategoryExternalAttribute\CollectionFactory;
use Study\CategoryExternalCode\Api\CategoryExternalCodeRepositoryInterface;

/**
 * Class need to get value of external attribute assigned to category
 */
class ExternalAttributeService
{
    /**
     * @var CollectionFactory
     */
    private $externalAttributeCollectionFactory;

    /**
     * Class constructor
     *
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        CollectionFactory $collectionFactory
    ) {
        $this->externalAttributeCollectionFactory = $collectionFactory;
    }

    /**
     * Get value of external category attribute
     *
     * @param $categoryId
     * @return string|null
     */
    public function getExternalAttributeValue($categoryId): ?string
    {
        $collection = $this->externalAttributeCollectionFactory->create();
        $collection->addFieldToFilter(CategoryExternalCodeRepositoryInterface::CATEGORY_ID, $categoryId)
            ->addFieldToSelect(CategoryExternalCodeRepositoryInterface::EXTERNAL_CODE);

        return  $collection->getFirstItem()->getData(CategoryExternalCodeRepositoryInterface::EXTERNAL_CODE);
    }
}
