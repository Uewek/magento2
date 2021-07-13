<?php

namespace Study\ImprovedContact\Model;

use Study\ImprovedContact\Api\Data\ContactInterface;
use Study\ImprovedContact\Model\ResourceModel\ContractorInfo as ModelResource;
use Study\ImprovedContact\Api\ContactRepositoryInterface;
use Magento\Framework\Model\AbstractModel;


class ContactRepository extends AbstractModel implements ContactRepositoryInterface
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
     * ContactRepository constructor.
     * @param ModelResource $modelResource
     * @param \Study\ImprovedContact\Model\ContactorInfoFactory $contactorInfoFactory
     */
    public function __construct
    (
        ModelResource $modelResource,
        ContactorInfoFactory $contactorInfoFactory
    )
    {
        $this->modelRecource = $modelResource;
        $this->contactorInfoFactory = $contactorInfoFactory;
    }

    /**
     * @param $id
     * @return mixed|ContactorInfo
     */
    public function getById($id)
    {
        $contact= $this->contactorInfoFactory->create();
        $this->modelRecource->load($contact,$id);
        return $contact;
    }

    /**
     * @param ContactInterface $contact
     * @throws \Magento\Framework\Exception\AlreadyExistsException
     */
    public function saveContact(ContactInterface $contact){
        $this->modelRecource->save($contact);
    }
}
