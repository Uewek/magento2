<?php
declare(strict_types=1);

namespace Study\CategoryExternalCode\Api;

/**
 * Interface of external attribute repository
 */
interface CategoryAttributeRepositoryInterface
{
    /**
     * Constants of table columns
     */
    public const CATEGORY_NAME = 'category_name';

    public const CATEGORY_ID = 'category_id';

    public const EXTERNAL_CODE = 'category_external_code';

    /**
     * Save category attribute
     *
     * @param CategoryAttributeModelInterface $categoryAttribute
     */
    public function save(CategoryAttributeModelInterface $categoryAttribute): void;

    /**
     * Delete category attribute
     *
     * @param CategoryAttributeModelInterface $categoryAttribute
     */
    public function delete(CategoryAttributeModelInterface $categoryAttribute): void;
}
