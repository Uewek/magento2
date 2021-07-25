<?php
declare(strict_types=1);

namespace Study\ImprovedContact\Model;

use Magento\Framework\Model\AbstractModel;
use Study\ImprovedContact\Api\Data\ContactInterface;
use Study\ImprovedContact\Model\ResourceModel\ContractorInfo;

/**
 * Class ContactorInfo this is main model of this module
 */
class ContactorInfo extends AbstractModel implements ContactInterface
{
    /**
     * Form constructor
     */
    protected function _construct()
    {
        $this->_init(ContractorInfo::class);
    }

    /**
     * Get contacts name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->getData(ContactInterface::NAME);
    }

    /**
     * Set new name
     *
     * @param string $name
     * @return $this
     */
    public function setName(string $name): ContactInterface
    {
        $this->setData(ContactInterface::NAME, $name);

        return $this;
    }

    /**
     * Set new telephone
     *
     * @param string $telephone
     * @return $this
     */
    public function setTelephone(string $telephone): ContactInterface
    {
        $this->setData(ContactInterface::TELEPHONE, $telephone);

        return $this;
    }

    /**
     * Get contact telephone
     *
     * @return string
     */
    public function getTelephone(): string
    {
        return $this->getData(ContactInterface::TELEPHONE);
    }

    /**
     * Get contact comment
     *
     * @return string
     */
    public function getComment(): string
    {
        return $this->getData(ContactInterface::COMMENT);
    }

    /**
     * Set new comment
     *
     * @param string $comment
     * @return $this
     */
    public function setComment(string $comment): ContactInterface
    {
        $this->setData(ContactInterface::COMMENT, $comment);

        return $this;
    }

    /**
     * Get contacts email
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->getData(ContactInterface::EMAIL);
    }

    /**
     * Set new contacts email
     *
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email): ContactInterface
    {
        $this->setData(ContactInterface::EMAIL, $email);

        return $this;
    }
}
