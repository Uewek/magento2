<?php

namespace SoftLoft\MidnightMail\Api;

interface CustomerConnectionRepositoryInterface
{
    /**
     * Save category attribute
     *
     * @param CustomerConnectionInterface $categoryAttribute
     */
    public function save(CustomerConnectionInterface $categoryAttribute): void;

    /**
     * Get customer log entity by id
     *
     * @param int $logId
     * @return CustomerConnectionInterface
     */
    public function getCustomerLogEntity(int $logId): CustomerConnectionInterface;
}
