<?php
declare(strict_types=1);

namespace Study\CategoryExternalCode\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use Study\CategoryExternalCode\Api\Data\CategoryAttributeDataInterface;
use Study\CategoryExternalCode\Api\Data\CategoryExternalSearchResultInterface;

/**
 * Interface of external attribute repository
 */
interface CategoryExternalCodeRepositoryInterface
{
    /**
     * Constants of table columns
     */
    public const ENTITY_ID = 'entity_id';

    public const CATEGORY_ID = 'category_id';

    public const CATEGORY_NAME = '';

    public const EXTERNAL_CODE = 'category_external_code';

    /**
     * Save category attribute
     *
     * @param CategoryAttributeDataInterface $categoryAttribute
     */
    public function save(CategoryAttributeDataInterface $categoryAttribute): void;

    /**
     * Get list of External attributes
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return CategoryExternalSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria): CategoryExternalSearchResultInterface;


}
