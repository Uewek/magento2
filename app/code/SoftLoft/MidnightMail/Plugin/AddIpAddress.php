<?php
declare(strict_types=1);

namespace SoftLoft\MidnightMail\Plugin;

use SoftLoft\MidnightMail\Model\ResourceModel\ConnectionCollection\CollectionFactory;
use SoftLoft\MidnightMail\Api\CustomerConnectionRepositoryInterface;

/**
 * Add customer IP address value in customer admin form data
 */
class AddIpAddress
{
    /**
     * @var CollectionFactory
     */
    private CollectionFactory $collectionFactory;

    /**
     * @var CustomerConnectionRepositoryInterface
     */
    private CustomerConnectionRepositoryInterface $customerConnectionRepository;


    public function __construct(
        CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Add customer IP address value to customer form data
     *
     * @param $subject
     * @param $result
     * @return array
     */
    public function afterGetData($subject, $result): array
    {
        if (!empty($result[1]['customer_id'])) {
            $result[1]['customer']['customer_ip'] = $this->getCustomerIp($result[1]['customer_id']);
        }

        return $result;
    }

    /**
     * Get customer IP address value
     *
     * @param $customerId
     * @return string
     */
    private function getCustomerIp($customerId): string
    {
        $collection = $this->collectionFactory->create()
            ->addFieldToFilter('customer_id', $customerId)
            ->setOrder('log_id', 'ASC')
            ->setPageSize(1);

        return $collection->getFirstItem()->getData('customer_ip');
    }
}
