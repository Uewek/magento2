<?php
declare(strict_types=1);

namespace Study\CategoryExternalCode\Plugin;

use Magento\Catalog\Api\CategoryRepositoryInterface as CategoryRepository;
use Magento\Catalog\Api\Data\CategoryInterface;
use Study\CategoryExternalCode\Service\ExternalAttributeService;
use Study\CategoryExternalCode\Model\ResourceModel\CategoryExternalAttribute\CollectionFactory as ExternalCodeCollectionFactory;
use Magento\Catalog\Model\ResourceModel\Category\CollectionFactory;

class CategoryRepositoryInterface
{
    private $collectionFactory;

    private $externalCodeCollectionFactory;


    /**
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        ExternalCodeCollectionFactory $externalCodeCollectionFactory

    ) {
        $this->collectionFactory = $collectionFactory;
        $this->externalCodeCollectionFactory = $externalCodeCollectionFactory;
    }

    public function afterGet(CategoryRepository $subject, CategoryInterface $category)
    {
        if($category->getExtensionAttributes() && $category->getExtensionAttributes()->getCategoryExternalCode()) {
            return $category;
        }

        $categoryExternalCode = $this->getCategoryExternalCode($category->getId());
        $extensionAttributes = $category->getExtensionAttributes()->setCategoryExternalCode($categoryExternalCode);
        $category->setExtensionAttributes($extensionAttributes);

        return $category;

    }

    public function getCategoryExternalCode($categoryId)
    {
        return $this->externalCodeCollectionFactory->create()
            ->addFieldToFilter('category_id', ['eq' => $categoryId])
            ->getFirstItem()->getData('category_external_code');
    }
}
