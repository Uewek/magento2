<?php
declare(strict_types=1);

namespace Study\CategoryExternalCode\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Study\CategoryExternalCode\Model\CategoryExternalCodeFactory;
use Study\CategoryExternalCode\Model\CategoryExternalCodeRepository;
use Study\CategoryExternalCode\Api\Data\CategoryExternalCodeInterface;

/**
 * This observer saving external attribute value from category form
 */
class SaveExternalCodeObserver implements ObserverInterface
{
    /**
     * @var CategoryExternalCodeFactory
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
     * @param CategoryExternalCodeFactory $attributeDataFactory
     */
    public function __construct(
        CategoryExternalCodeRepository $categoryAttributeRepository,
        CategoryExternalCodeFactory   $attributeDataFactory
    ) {
        $this->attributeDataFactory = $attributeDataFactory;
        $this->categoryAttributeRepository = $categoryAttributeRepository;
    }

    /**
     * Save category external code
     *
     * @param Observer $observer
     * @return void
     */
    public function execute(Observer $observer): void
    {
        $category = $observer->getData('entity');
        $categoryId = $category->getData(CategoryExternalCodeInterface::ENTITY_ID);
        $externalAttributeValue = $category
            ->getData(CategoryExternalCodeInterface::EXTERNAL_CODE);
        $attribute = $this->attributeDataFactory->create();
        $attribute->setData(CategoryExternalCodeInterface::CATEGORY_ID, $categoryId)
            ->setData(CategoryExternalCodeInterface::EXTERNAL_CODE, $externalAttributeValue);
        $this->categoryAttributeRepository->save($attribute);
    }
}
