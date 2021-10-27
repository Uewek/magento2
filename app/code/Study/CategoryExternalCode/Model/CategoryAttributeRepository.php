<?php
declare(strict_types=1);

namespace Study\CategoryExternalCode\Model;

use Study\CategoryExternalCode\Api\CategoryAttributeModelInterface;
use Study\CategoryExternalCode\Api\CategoryAttributeRepositoryInterface;
use Psr\Log\LoggerInterface;
use Study\CategoryExternalCode\Model\CategoryAttributeModelFactory;
use Study\CategoryExternalCode\Model\ResourceModel\CategoryAttributeResource;
use Study\CategoryExternalCode\Model\ResourceModel\CategoryExternalAttribute\CollectionFactory;

class CategoryAttributeRepository implements CategoryAttributeRepositoryInterface
{
    /**
     * @var CategoryAttributeModelFactory
     */
    private $categoryAttributeFactory;

    /**
     * @var CategoryAttributeResource
     */
    private $categoryAttributeResource;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        CategoryAttributeResource $categoryAttributeResource,
        CollectionFactory $collectionFactory,
        LoggerInterface $logger,
        CategoryAttributeModelFactory $categoryAttributeModelFactory
    ) {
        $this->categoryAttributeModelFactory = $categoryAttributeModelFactory;
        $this->collectionFactory = $collectionFactory;
        $this->logger = $logger;
        $this->categoryAttributeResource = $categoryAttributeResource;
    }

    /**
     * Get external category attribute
     *
     * @param int $id
     * @return CategoryAttributeModelInterface
     * @throws \Exception
     */
    public function getCategoryAttribute(int $id): CategoryAttributeModelInterface
    {
        $categoryExternalAttribute = $this->categoryAttributeFactory->create();
        try {
            $this->categoryAttributeResource->load($categoryExternalAttribute,$id);
        } catch (\Exception $e) {
            $this->logger->critical('Error during attribute loading', ['exception' => $e]);
            throw new \Exception('We can`t load promotion at this moment');
        }
        return $categoryExternalAttribute;
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
