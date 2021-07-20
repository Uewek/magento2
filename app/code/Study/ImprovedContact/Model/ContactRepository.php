<?php
declare(strict_types=1);

namespace Study\ImprovedContact\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\LocalizedException;
use Study\ImprovedContact\Api\Data\ContactInterface;
use Study\ImprovedContact\Model\ResourceModel\ContractorInfo as ModelResource;
use Study\ImprovedContact\Api\ContactRepositoryInterface;
use Study\ImprovedContact\Model\ResourceModel\AdvancedContactForm\CollectionFactory;
use Study\ImprovedContact\Api\Data\ContactSearchResultInterface;
use Study\ImprovedContact\Api\Data\ContactSearchResultInterfaceFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessor;

/**
 * Class ContactRepository contain logic needed to work with cew contacts
 */
class ContactRepository implements ContactRepositoryInterface
{
    /**
     * @var ContactorInfoFactory
     */
    private $contactorInfoFactory;

    /**
     * @var ModelResource
     */
    private $modelRecource;

    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var CollectionProcessor
     */
    private $collectionProcessor;

    /**
     * @var ContactSearchResultInterfaceFactory
     */
    private $searchResultFactory;

    /**
     * ContactRepository constructor.
     * @param ModelResource $modelResource
     * @param ContactorInfoFactory $contactorInfoFactory
     * @param CollectionFactory $collectionFactory
     * @param CollectionProcessor $collectionProcessor
     * @param ContactSearchResultInterfaceFactory $searchResultFactory
     */
    public function __construct(
        ModelResource $modelResource,
        ContactorInfoFactory $contactorInfoFactory,
        CollectionFactory $collectionFactory,
        CollectionProcessor $collectionProcessor,
        ContactSearchResultInterfaceFactory $searchResultFactory
    ) {
        $this->collectionProcessor = $collectionProcessor;
        $this->collectionFactory = $collectionFactory;
        $this->modelRecource = $modelResource;
        $this->contactorInfoFactory = $contactorInfoFactory;
        $this->searchResultFactory = $searchResultFactory;
    }

    /**
     * Get contact by id
     *
     * @param int $id
     * @return mixed|ContactorInfo
     */
    public function getById(int $id): ContactorInfo
    {
        $contact= $this->contactorInfoFactory->create();
        $this->modelRecource->load($contact, $id);

        return $contact;
    }

    /**
     * Save contact after edition
     *
     * @param ContactInterface $contact
     * @return void
     */
    public function save(ContactInterface $contact): void
    {
        $this->modelRecource->save($contact);
    }

    /**
     * Get list of contacts
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @return ContactSearchResultInterface
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);

        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                $condition=$filter->getConditionType();
                $collection->addFieldToFilter($filter->getField(), [$condition=>$filter->getValue()]);
            }
        }
        $searchResult = $this->searchResultFactory->create();
        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());

        return $searchResult;
    }

    /**
     * Validate data from fields
     *
     * @param array $data
     *
     * @throws LocalizedException
     */
    public function validateData(array $data)
    {
        $errorMessage="Required parameter ' %1 ' missed or absent. Please try again";

        $contact=$this->contactorInfoFactory->create();
        if (!$data[$contact::EMAIL] || $data[$contact::EMAIL]=='') {
            throw new LocalizedException(__($errorMessage, $contact::EMAIL));
        }
        if (!$data[$contact::COMMENT] || $data[$contact::COMMENT]=='') {
            throw new LocalizedException(__($errorMessage, $contact::COMMENT));
        }
        if (!$data[$contact::NAME] || $data[$contact::NAME]=='') {
            throw new LocalizedException(__($errorMessage, $contact::NAME));
        }
        if (!$data[$contact::TELEPHONE] || $data[$contact::TELEPHONE]=='') {
            throw new LocalizedException(__($errorMessage, $contact::TELEPHONE));
        }
    }
}
