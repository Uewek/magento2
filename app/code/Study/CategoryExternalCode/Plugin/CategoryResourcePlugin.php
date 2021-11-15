<?php
declare(strict_types=1);

namespace Study\CategoryExternalCode\Plugin;

use Magento\Catalog\Model\ResourceModel\Category;
use Magento\Catalog\Model\Category as CategoryModel;
use Study\CategoryExternalCode\Service\ExternalAttributeService;

/**
 * Add extension attribute to category
 */
class CategoryResourcePlugin
{
    /**
     * @var ExternalAttributeService
     */
    private $externalAttributeService;

    /**
     * Class constructor
     *
     * @param ExternalAttributeService $externalAttributeService
     */
    public function __construct(
        ExternalAttributeService $externalAttributeService
    ) {
        $this->externalAttributeService = $externalAttributeService;
    }

    /**
     * Add external code to category during load
     *
     * @param Category $subject
     * @param CategoryModel $object
     * @param int $entityId
     * @return void
     */
    public function beforeLoad(Category $subject, CategoryModel $object, int $entityId): void
    {
        $externalAttribute = $object->getExtensionAttributes()->getCategoryExternalCode();

        if (!$externalAttribute) {
            $externalAttributeCode = $this->externalAttributeService->getExternalAttributeValue($entityId);
            $object->getExtensionAttributes()->setCategoryExternalCode($externalAttributeCode);
        }
    }
}
