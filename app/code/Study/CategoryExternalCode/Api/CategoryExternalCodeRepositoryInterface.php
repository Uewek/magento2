<?php
declare(strict_types=1);

namespace Study\CategoryExternalCode\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Study\CategoryExternalCode\Api\Data\CategoryExternalCodeInterface;
use Study\CategoryExternalCode\Api\Data\CategoryExternalCodeSearchResultInterface;

/**
 * Interface of external attribute repository
 */
interface CategoryExternalCodeRepositoryInterface
{
    /**
     * Save category attribute
     *
     * @param CategoryExternalCodeInterface $categoryAttribute
     */
    public function save(CategoryExternalCodeInterface $categoryAttribute): void;

    /**
     * Get list of External attributes
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return CategoryExternalCodeSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): CategoryExternalCodeSearchResultInterface;


}
