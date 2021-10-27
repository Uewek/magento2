<?php
declare(strict_types=1);

namespace Study\CategoryExternalCode\Service;

use Study\CategoryExternalCode\Model\ResourceModel\CategoryExternalAttribute\CollectionFactory;

class ExternalAttributeService
{
    private $externalAttributeCollectionFactory;

    public function __construct(
        CollectionFactory $collectionFactory
    ) {
        $this->externalAttributeCollectionFactory = $collectionFactory;
    }

    public function getExternalAttributeValue($categoryId): ?string
    {
        $collection = $this->externalAttributeCollectionFactory->create();
        $collection->addFieldToFilter('category_id',$categoryId)
            ->addFieldToSelect('category_external_code');
        $result = null;
        foreach ($collection as $item) {
            $result = $item->getData()['category_external_code'];
        }
        return $result;
    }
}
