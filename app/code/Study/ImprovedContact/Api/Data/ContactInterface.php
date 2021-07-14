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
     * Get name of contact
     *
     * @return string
     */
    public function getName();

    /**
     * Set new name of contact
     *
     * @param string $name
     * @return $this
     */
    public function setName($name);

    /**
     * Get telephone of contact
     *
     * @return string
     */
    public function getTelephone();

    /**
     * Set new telephone
     *
     * @param string $telephone
     * @return $this
     */
    public function setTelephone($telephone);

    /**
     * Get comment of the contact
     *
     * @return string
     */
    public function getComment();

    /**
     * Set new comment
     *
     * @param string $comment
     * @return $this
     */
    public function setComment($comment);

    /**
     * Get email of contact
     *
     * @return string
     */
    public function getEmail();

    /**
     * Set contact email
     *
     * @param string $email
     * @return mixed
     */
    public function setEmail(string $email);
}
