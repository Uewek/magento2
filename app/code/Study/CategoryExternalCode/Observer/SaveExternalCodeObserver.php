<?php
declare(strict_types=1);

namespace Study\CategoryExternalCode\Observer;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Study\CategoryExternalCode\Model\CategoryAttributeDataFactory;
use Study\CategoryExternalCode\Model\CategoryExternalCodeRepository;
use Magento\Framework\Message\ManagerInterface;
use Study\CategoryExternalCode\Service\ExternalAttributeService;
use Study\CategoryExternalCode\Model\ResourceModel\CategoryExternalAttribute\CollectionFactory;

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
     * @param RequestInterface $request
     * @param ManagerInterface $messageManager
     * @param CollectionFactory $attributeCollectionFactory
     * @param ExternalAttributeService $externalAttributeService
     * @param CategoryExternalCodeRepository $categoryAttributeRepository
     * @param CategoryAttributeDataFactory $attributeDataFactory
     */
    public function __construct(
        CollectionFactory              $attributeCollectionFactory,
        ExternalAttributeService       $externalAttributeService,
        CategoryExternalCodeRepository $categoryAttributeRepository,
        CategoryAttributeDataFactory   $attributeDataFactory
    ) {
        $this->attributeCollectionFactory = $attributeCollectionFactory;
        $this->externalAttributeService = $externalAttributeService;
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
        $categoryId = $observer->getData('entity')->getData(CategoryExternalCodeRepository::ENTITY_ID);
        $externalAttributeValue = $observer->getData('entity')
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
