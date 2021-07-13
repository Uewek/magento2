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
     * @return array|mixed|string|null
     */
    public function getName()
    {
        return $this->getData(ContactInterface::NAME);
    }

    /**
     * @param string $name
     * @return $this|ContactorInfo
     */
    public function setName($name)
    {
        $this->setData(ContactInterface::NAME,$name);
        return $this;
    }

    /**
     * @param string $telephone
     * @return $this|ContactorInfo
     */
    public function setTelephone($telephone)
    {
        $this->setData(ContactInterface::TELEPHONE,$telephone);
        return $this;
    }

    /**
     * @return array|mixed|string|null
     */
    public function getTelephone()
    {
        return $this->getData(ContactInterface::TELEPHONE);
    }

    /**
     * @return array|mixed|string|null
     */
    public function getComment()
    {
        return $this->getData(ContactInterface::COMMENT);

    }

    /**
     * @param string $comment
     * @return $this|ContactorInfo
     */
    public function setComment($comment)
    {
        $this->setData(ContactInterface::COMMENT, $comment);
        return $this;
    }

    /**
     * @return array|mixed|string|null
     */
    public function getEmail()
    {
        return $this->getData(ContactInterface::EMAIL);
    }

    /**
     * @param $email
     * @return mixed|void
     */
    public function setEmail($email)
    {
        $this->setData(ContactInterface::EMAIL, $email);
        return $this;
    }
}
