<?php
declare(strict_types=1);

namespace Study\CategoryExternalCode\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Study\CategoryExternalCode\Api\Data\CategoryAttributeDataInterface;
use Study\CategoryExternalCode\Api\Data\CategoryExternalSearchResultInterfaceFactory;
use Study\CategoryExternalCode\Api\Data\CategoryExternalSearchResultInterface;
use Study\CategoryExternalCode\Api\CategoryExternalCodeRepositoryInterface;
use Study\CategoryExternalCode\Model\ResourceModel\CategoryAttributeResource;
use Magento\Framework\Api\SearchCriteria\CollectionProcessor;
use Study\CategoryExternalCode\Model\ResourceModel\CategoryExternalAttribute\CollectionFactory;

/**
 * Repository of external attributes
 */
class CategoryExternalCodeRepository implements CategoryExternalCodeRepositoryInterface
{
    /**
     * @var CategoryExternalSearchResultInterfaceFactory
     */
    private $searchResultFactory;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var CollectionProcessor
     */
    private $collectionProcessor;

    /**
     * @var CategoryAttributeResource
     */
    private $categoryAttributeResource;

    /**
     * Class constructor
     *
     * @param CategoryAttributeResource $categoryAttributeResource
     * @param CollectionProcessor $collectionProcessor
     * @param CategoryExternalSearchResultInterfaceFactory $searchResultFactory
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        CategoryAttributeResource $categoryAttributeResource,
        CollectionProcessor $collectionProcessor,
        CategoryExternalSearchResultInterfaceFactory $searchResultFactory,
        CollectionFactory $collectionFactory
    ) {
        $this->searchResultFactory = $searchResultFactory;
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
     * Get list of External attributes
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return CategoryExternalSearchResultInterface
     */
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
