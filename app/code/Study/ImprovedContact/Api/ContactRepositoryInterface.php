<?php
declare(strict_types=1);

namespace Study\ImprovedContact\Api;

use Study\ImprovedContact\Api\Data\ContactInterface;
use Study\ImprovedContact\Api\Data\ContactSearchResultInterface;
use Study\ImprovedContact\Model\ContactorInfo;
use Magento\Framework\Api\SearchCriteriaInterface;

/**
 * Interface ContactRepositoryInterface interface for contacts repository
 */
interface ContactRepositoryInterface
{
    /**
     * Save contact after update
     *
     * @param ContactInterface $contact
     * @return void
     */
    public function save(ContactInterface $contact): void;

    /**
     * Get entity by id
     *
     * @param int $id
     */
    public function getById(int $id): ContactInterface;

    /**
     * Get contact list
     *
     * @param SearchCriteriaInterface $searchCriteria
     */
    public function getList(SearchCriteriaInterface $searchCriteria): ContactSearchResultInterface;
}
