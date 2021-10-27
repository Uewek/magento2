<?php
declare(strict_types=1);

namespace Study\CategoryExternalCode\Observer;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Study\CategoryExternalCode\Model\CategoryAttributeModelFactory;
use Study\CategoryExternalCode\Model\CategoryAttributeRepository;
use Magento\Framework\Message\ManagerInterface;
use Study\CategoryExternalCode\Service\ExternalAttributeService;
use Study\CategoryExternalCode\Model\ResourceModel\CategoryExternalAttribute\CollectionFactory;


class SaveExternalCodeObserver implements ObserverInterface
{
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var ExternalAttributeService
     */
    private $externalAttributeService;

    /**
     * @var CategoryAttributeModelFactory
     */
    private $attributeModelFactory;

    /**
     * @var CategoryAttributeRepository
     */
    private $categoryAttributeRepository;

    /**
     * @var ManagerInterface
     */
    private $messageManager;

    /**
     * @var CollectionFactory
     */
    private $attributeCollectionFactory;

    /**
     * @param RequestInterface $request
     * @param ManagerInterface $messageManager
     * @param CollectionFactory $attributeCollectionFactory
     * @param ExternalAttributeService $externalAttributeService
     * @param CategoryAttributeRepository $categoryAttributeRepository
     * @param CategoryAttributeModelFactory $attributeModelFactory
     */
    public function __construct(
        RequestInterface $request,
        ManagerInterface $messageManager,
        CollectionFactory $attributeCollectionFactory,
        ExternalAttributeService $externalAttributeService,
        CategoryAttributeRepository $categoryAttributeRepository,
        CategoryAttributeModelFactory $attributeModelFactory
    ) {
        $this->request = $request;
        $this->attributeCollectionFactory = $attributeCollectionFactory;
        $this->externalAttributeService = $externalAttributeService;
        $this->messageManager = $messageManager;
        $this->attributeModelFactory = $attributeModelFactory;
        $this->categoryAttributeRepository = $categoryAttributeRepository;
    }

    /**
     * Save category external code
     *
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        $data = $this->request->getParams();
        $categoryId = $data['entity_id'];
        $externalAttributeValue = $data['category_external_code'];
        $existingCode = $this->externalAttributeService->getExternalAttributeValue($categoryId);
        $isOverride = $this->checkAttributeOverride($externalAttributeValue ,$existingCode);
        $this->deleteOldAttribute($categoryId);
        if ($isOverride) {
            $attribute = $this->attributeModelFactory->create();
            $attribute->setData('category_id', $categoryId)
                ->setData('category_external_code', $externalAttributeValue);
            try {
                $this->categoryAttributeRepository->save($attribute);
                $this->messageManager->addSuccessMessage(__('External code added successfully'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Something went wrong!'));
            }
        }
    }

    /**
     * Check is external attribute is changed
     *
     * @param string|null $newAttributeValue
     * @param string|null $existingAttributeValue
     * @return bool
     */
    private function checkAttributeOverride(string $newAttributeValue, ?string $existingAttributeValue): bool
    {
        $result = true;
        if ($newAttributeValue === $existingAttributeValue) {
            $result = false;
        }

        return $result;
    }

    /**
     * Delete old external attribute
     *
     * @param string $categoryId
     */
    private function deleteOldAttribute(string $categoryId): void
    {
        $oldAttribute = $this->attributeCollectionFactory->create();
        $oldAttribute->addFieldToFilter('category_id',$categoryId);

        foreach ($oldAttribute as $item){
            $this->categoryAttributeRepository->delete($item);
        }
    }
}
