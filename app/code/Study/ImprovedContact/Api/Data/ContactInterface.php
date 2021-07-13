<?php
declare(strict_types=1);

namespace Study\ImprovedContact\Api\Data;

interface ContactInterface
{
    const ID = 'contact_id';
    const NAME = 'name';
    const EMAIL = 'email';
    const TELEPHONE = 'telephone';
    const COMMENT = 'comment';
    const CREATED = 'created_at';

    /**
     * @return string
     */
    public function getName();

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name);

    /**
     * @return string
     */
    public function getTelephone();

    /**
     * @param string $telephone
     * @return $this
     */
    public function setTelephone($telephone);

    /**
     * @return string
     */
    public function getComment();

    /**
     * @param string $comment
     * @return $this
     */
    public function setComment($comment);

    /**
     * @return string
     */
    public function getEmail();

    /**
     * @param $email
     * @return mixed
     */
    public function setEmail($email);




}
