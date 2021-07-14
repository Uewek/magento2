<?php
declare(strict_types=1);

namespace Study\ImprovedContact\Model;

use Magento\Framework\Model\AbstractModel;
use Study\ImprovedContact\Api\Data\ContactInterface;
use Study\ImprovedContact\Model\ResourceModel\ContractorInfo;

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
     * @return array|mixed|string|null
     */
    public function getName()
    {
        return $this->getData(ContactInterface::NAME);
    }

    /**
     * Set new name
     *
     * @param string $name
     * @return $this|ContactorInfo
     */
    public function setName($name)
    {
        $this->setData(ContactInterface::NAME, $name);

        return $this;
    }

    /**
     * Set new telephone
     *
     * @param string $telephone
     * @return $this|ContactorInfo
     */
    public function setTelephone($telephone)
    {
        $this->setData(ContactInterface::TELEPHONE, $telephone);

        return $this;
    }

    /**
     * Get contact telephone
     *
     * @return array|mixed|string|null
     */
    public function getTelephone()
    {
        return $this->getData(ContactInterface::TELEPHONE);
    }

    /**
     * Get contact comment
     *
     * @return array|mixed|string|null
     */
    public function getComment()
    {
        return $this->getData(ContactInterface::COMMENT);
    }

    /**
     * Set new comment
     *
     * @param string $comment
     * @return $this|ContactorInfo
     */
    public function setComment($comment)
    {
        $this->setData(ContactInterface::COMMENT, $comment);

        return $this;
    }

    /**
     * Get contacts email
     *
     * @return array|mixed|string|null
     */
    public function getEmail()
    {
        return $this->getData(ContactInterface::EMAIL);
    }

    /**
     * Set new contacts email
     *
     * @param string $email
     * @return $this|mixed
     */
    public function setEmail(string $email)
    {
        $this->setData(ContactInterface::EMAIL, $email);

        return $this;
    }
}
