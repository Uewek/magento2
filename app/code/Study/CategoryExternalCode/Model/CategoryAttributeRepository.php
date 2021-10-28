<?php
declare(strict_types=1);

namespace Study\CategoryExternalCode\Model;

use Study\CategoryExternalCode\Api\CategoryAttributeModelInterface;
use Study\CategoryExternalCode\Api\CategoryAttributeRepositoryInterface;
use Study\CategoryExternalCode\Model\ResourceModel\CategoryAttributeResource;

class CategoryAttributeRepository implements CategoryAttributeRepositoryInterface
{
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
        CategoryAttributeResource $categoryAttributeResource
    ) {
        $this->categoryAttributeResource = $categoryAttributeResource;
    }

    /**
     * Save category attribute
     *
     * @param CategoryAttributeModelInterface $categoryAttribute
     */
    public function save(CategoryAttributeModelInterface $categoryAttribute): void
    {
        try {
            $this->categoryAttributeResource->save($categoryAttribute);
        } catch (\Exception $e) {

        }
    }

    /**
     * Delete category attribute
     *
     * @param CategoryAttributeModelInterface $categoryAttribute
     */
    public function delete(CategoryAttributeModelInterface $categoryAttribute): void
    {
        try {
            $this->categoryAttributeResource->delete($categoryAttribute);
        } catch (\Exception $e) {

        }
    }
}
