<?php
declare(strict_types=1);

namespace Study\CategoryExternalCode\Service;

use Study\CategoryExternalCode\Api\Data\CategoryExternalCodeInterface;
use Study\CategoryExternalCode\Model\ResourceModel\CategoryExternalAttribute\CollectionFactory;

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
        $collection->addFieldToFilter(CategoryExternalCodeInterface::CATEGORY_ID, $categoryId)
            ->addFieldToSelect(CategoryExternalCodeInterface::EXTERNAL_CODE);

        return  $collection->getFirstItem()->getData(CategoryExternalCodeInterface::EXTERNAL_CODE);
    }
}
