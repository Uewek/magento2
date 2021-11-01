<?php
declare(strict_types=1);

namespace Study\CategoryExternalCode\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Study\CategoryExternalCode\Api\Data\CategoryAttributeDataInterface;
use Study\CategoryExternalCode\Api\CategoryExternalCodeRepositoryInterface;
use Study\CategoryExternalCode\Model\ResourceModel\CategoryAttributeResource;
use Magento\Framework\Api\SearchCriteria\CollectionProcessor;
use Study\CategoryExternalCode\Model\ResourceModel\CategoryExternalAttribute\CollectionFactory;


/**
 * Repository of external attributes
 */
class CategoryExternalCodeRepository implements CategoryExternalCodeRepositoryInterface
{
    private $collectionFactory;

    private $collectionProcessor;

    /**
     * @var CategoryAttributeResource
     */
    private $categoryAttributeResource;

    /**
     * Class constructor
     *
     * @param CategoryAttributeResource $categoryAttributeResource
     */
    public function __construct(
        CategoryAttributeResource $categoryAttributeResource,
        CollectionProcessor $collectionProcessor,
        CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->categoryAttributeResource = $categoryAttributeResource;
    }

    /**
     * Save category attribute
     *
     * @param CategoryAttributeDataInterface $categoryAttribute
     */
    public function save(CategoryAttributeDataInterface $categoryAttribute): void
    {
        try {
            $this->categoryAttributeResource->save($categoryAttribute);
        } catch (\Exception $e) {

        }
    }

    /**
     * Delete category attribute
     *
     * @param CategoryAttributeDataInterface $categoryAttribute
     */
    public function delete(CategoryAttributeDataInterface $categoryAttribute): void
    {
        try {
            $this->categoryAttributeResource->delete($categoryAttribute);
        } catch (\Exception $e) {

        }
    }

    public function getList(SearchCriteriaInterface $searchCriteria): CategoryExternalSearchResultInterface
    {
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);

        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition=$filter->getConditionType();
                $collection->addFieldToFilter($filter->getField(), [$condition=>$filter->getValue()]);
            }
        }
        $searchResult = $this->searchResultFactory->create();
        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());

        return $searchResult;
    }
}
