<?php
declare(strict_types=1);

namespace SoftLoft\MidnightMail\Model;

use SoftLoft\MidnightMail\Api\CustomerConnectionRepositoryInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use SoftLoft\MidnightMail\Api\CustomerConnectionInterface;
use SoftLoft\MidnightMail\Api\CustomerConnectionInterfaceFactory;
use SoftLoft\MidnightMail\Model\ResourceModel\CustomerConnectionResource;

/**
 * Repository of customer connections
 */
class CustomerConnectionRepository implements CustomerConnectionRepositoryInterface
{
    /**
     * @var CustomerConnectionInterfaceFactory
     */
    private CustomerConnectionInterfaceFactory $customerConnectionFactory;

    /**
     * @var CustomerConnectionResource
     */
    private CustomerConnectionResource $customerConnectionResource;

    public function __construct(
        CustomerConnectionInterfaceFactory $customerConnectionFactory,
        CustomerConnectionResource  $customerConnectionResource
    ) {
        $this->customerConnectionFactory = $customerConnectionFactory;
        $this->customerConnectionResource = $customerConnectionResource;
    }

    /**
     * @inerhitDoc
     *
     * @param CustomerConnectionInterface $categoryAttribute
     */
    public function save(CustomerConnectionInterface $categoryAttribute): void
    {
        try {
            $this->customerConnectionResource->save($categoryAttribute);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(
                __(
                    'Could not save entity',
                    $categoryAttribute->getId()
                ),
                $e
            );
        }
    }

    /**
     * @inerhitDoc
     *
     * @param int $logId
     * @return CustomerConnectionInterface
     */
    public function getCustomerLogEntity(int $logId): CustomerConnectionInterface
    {
        $logEntity = $this->customerConnectionFactory->create();
        $this->customerConnectionResource->load($logEntity, $logId);

        return $logEntity;
    }
}
