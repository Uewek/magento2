<?php
declare(strict_types=1);

namespace Study\ImprovedContact\Api;

use Study\ImprovedContact\Api\Data\ContactInterface;

interface ContactRepositoryInterface
{
    /**
     * Save contact after update
     */
    public function saveContact(ContactInterface $contact);

    /**
     * Get entity by id
     *
     * @param $id
     * @return mixed
     */
    public function getById($id);

}
