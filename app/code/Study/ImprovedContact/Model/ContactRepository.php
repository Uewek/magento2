<?php

namespace Study\ImprovedContact\Model;

use Study\ImprovedContact\Api\Data\ContactInterface;
use Study\ImprovedContact\Model\ResourceModel\ContractorInfo as ModelResource;
use Study\ImprovedContact\Api\ContactRepositoryInterface;

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
     * ContactRepository constructor.
     * @param ModelResource $modelResource
     * @param \Study\ImprovedContact\Model\ContactorInfoFactory $contactorInfoFactory
     */
    public function __construct(
        ModelResource $modelResource,
        ContactorInfoFactory $contactorInfoFactory
    ) {
        $this->modelRecource = $modelResource;
        $this->contactorInfoFactory = $contactorInfoFactory;
    }

    /**
     * Get contact by id
     *
     * @param int $id
     * @return mixed|ContactorInfo
     */
    public function getById(int $id)
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
    public function save(ContactInterface $contact)
    {
        $this->modelRecource->save($contact);
    }
}
