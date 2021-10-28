<?php
declare(strict_types=1);

namespace Study\CategoryExternalCode\Service;

use Study\CategoryExternalCode\Model\ResourceModel\CategoryExternalAttribute\CollectionFactory;
use Study\CategoryExternalCode\Api\CategoryAttributeRepositoryInterface;

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
        $collection->addFieldToFilter(CategoryAttributeRepositoryInterface::CATEGORY_ID,$categoryId)
            ->addFieldToSelect(CategoryAttributeRepositoryInterface::EXTERNAL_CODE);
        $result = null;
        foreach ($collection as $item) {
            $result = $item->getData()[CategoryAttributeRepositoryInterface::EXTERNAL_CODE];
        }
        return $result;
    }
}
