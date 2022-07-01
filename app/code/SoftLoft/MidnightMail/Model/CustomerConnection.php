<?php
declare(strict_types=1);

namespace SoftLoft\MidnightMail\Model;

use SoftLoft\MidnightMail\Model\ResourceModel\CustomerConnectionResource;
use Magento\Framework\Model\AbstractModel;
use SoftLoft\MidnightMail\Api\CustomerConnectionInterface;

/**
 * Entity model of customer connection log
 */
class CustomerConnection extends AbstractModel implements CustomerConnectionInterface
{
    /**
     * Init resource model
     */
    protected function _construct(): void
    {
        $this->_init(CustomerConnectionResource::class);
    }

    /**
     * Set mail send status
     *
     * @return CustomerConnectionInterface
     */
    public function setMailSend(): CustomerConnectionInterface
    {
        $this->setData('mail_send', 1);

        return $this;
    }
}
