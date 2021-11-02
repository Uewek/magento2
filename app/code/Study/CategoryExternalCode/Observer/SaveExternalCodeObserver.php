<?php
declare(strict_types=1);

namespace Study\CategoryExternalCode\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Study\CategoryExternalCode\Model\CategoryAttributeDataFactory;
use Study\CategoryExternalCode\Model\CategoryExternalCodeRepository;

/**
 * This observer saving external attribute value from category form
 */
class SaveExternalCodeObserver implements ObserverInterface
{
    /**
     * @var CategoryAttributeDataFactory
     */
    private $attributeDataFactory;

    /**
     * @var CategoryExternalCodeRepository
     */
    private $categoryAttributeRepository;

    /**
     * Class constructor
     *
     * @param CategoryExternalCodeRepository $categoryAttributeRepository
     * @param CategoryAttributeDataFactory $attributeDataFactory
     */
    public function __construct(
        CategoryExternalCodeRepository $categoryAttributeRepository,
        CategoryAttributeDataFactory   $attributeDataFactory
    ) {
        $this->attributeDataFactory = $attributeDataFactory;
        $this->categoryAttributeRepository = $categoryAttributeRepository;
    }

    /**
     * Save category external code
     *
     * @param Observer $observer
     */
    public function execute(Observer $observer): void
    {
        $category = $observer->getData('entity');
        $categoryId = $category->getData(CategoryExternalCodeRepository::ENTITY_ID);
        $externalAttributeValue = $category
            ->getData(CategoryExternalCodeRepository::EXTERNAL_CODE);
        $attribute = $this->attributeDataFactory->create();
        $attribute->setData(CategoryExternalCodeRepository::CATEGORY_ID, $categoryId)
            ->setData(CategoryExternalCodeRepository::EXTERNAL_CODE, $externalAttributeValue);
        try {
            $this->categoryAttributeRepository->save($attribute);
        } catch (\Exception $e) {

        }
    }
}
