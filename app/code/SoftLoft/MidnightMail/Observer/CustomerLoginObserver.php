<?php
declare(strict_types=1);

namespace SoftLoft\MidnightMail\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress;
use SoftLoft\MidnightMail\Api\ConfigInterface;
use SoftLoft\MidnightMail\Api\CustomerConnectionInterfaceFactory;
use SoftLoft\MidnightMail\Api\CustomerConnectionRepositoryInterface;

/**
 * Log customer connection observer
 */
class CustomerLoginObserver implements ObserverInterface
{
    /**
     * @var RemoteAddress
     */
    private $remoteAddress;

    /**
     * @var ConfigInterface
     */
    private $config;

    /**
     * @var CustomerConnectionRepositoryInterface
     */
    private $connectionRepository;

    /**
     * @var CustomerConnectionInterfaceFactory
     */
    private  $customerConnectionFactory;


    public function __construct(
        RemoteAddress                         $remoteAddress,
        CustomerConnectionRepositoryInterface $connectionRepository,
        ConfigInterface                       $config,
        CustomerConnectionInterfaceFactory    $customerConnectionFactory
    ) {
        $this->remoteAddress = $remoteAddress;
        $this->config = $config;
        $this->customerConnectionFactory = $customerConnectionFactory;
        $this->connectionRepository = $connectionRepository;
    }

    /**
     * Log customer connection
     *
     * @param Observer $observer
     * @return void
     * @throws CouldNotSaveException
     */
    public function execute(Observer $observer)
    {
        if ($this->config->trackConnectionIsEnabled()) {
            $customerId = $observer->getEvent()->getCustomer()->getId();
            $customerIp = $this->remoteAddress->getRemoteAddress();
            $logEntity = $this->customerConnectionFactory->create();
            $logEntity->setData('customer_id', $customerId);
            $logEntity->setData('customer_ip', $customerIp);
            $this->connectionRepository->save($logEntity);
        }
    }
}
