<?php
declare(strict_types=1);

namespace Study\ImprovedContact\Api\Data;

/**
 * Interface ContactInterface  for contact model
 */
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
    public function getName(): string;

    /**
     * Set new name of contact
     *
     * @param string $name
     * @return $this
     */
    public function setName(string $name): ContactInterface;

    /**
     * Get telephone of contact
     *
     * @return string
     */
    public function getTelephone(): string;

    /**
     * Set new telephone
     *
     * @param string $telephone
     * @return $this
     */
    public function setTelephone(string $telephone): ContactInterface;

    /**
     * Get comment of the contact
     *
     * @return string
     */
    public function getComment(): string;

    /**
     * Set new comment
     *
     * @param string $comment
     * @return $this
     */
    public function setComment(string $comment): ContactInterface;

    /**
     * Get email of contact
     *
     * @return string
     */
    public function getEmail(): string;

    /**
     * Set contact email
     *
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email): ContactInterface;
}
