<?php
declare(strict_types=1);

namespace Study\ImprovedContact\Api;

use Study\ImprovedContact\Api\Data\ContactInterface;

interface ContactRepositoryInterface
{
    /**
     * Save contact after update
     *
     * @param ContactInterface $contact
     * @return void
     */
    public function save(ContactInterface $contact);

    /**
     * Get entity by id
     *
     * @param int $id
     * @return mixed
     */
    public function getById(int $id);
}
