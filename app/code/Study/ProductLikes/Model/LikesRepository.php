<?php
declare(strict_types=1);

namespace Study\ProductLikes\Model;

use Magento\Framework\DataObject;
use Magento\Framework\Exception\AlreadyExistsException;
use Study\ProductLikes\Model\ResourceModel\ProductLikes\CollectionFactory;
use Study\ProductLikes\Model\ResourceModel\LikesResource;
use Study\ProductLikes\Api\Data\LikesModelInterface;
use Study\ProductLikes\Api\LikesRepositoryInterface;

/**
 * This repository managing likes
 */
class LikesRepository implements LikesRepositoryInterface
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var LikesModelFactory
     */
    private $likesModelFactory;

    /**
     * @var LikesResource
     */
    private $likesResource;

    /**
     * LikesRepository constructor.
     * @param CollectionFactory $collectionFactory
     * @param LikesResource $likesResource
     * @param LikesModelFactory $likesModelFactory
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        LikesResource $likesResource,
        LikesModelFactory $likesModelFactory

    ) {
        $this->collectionFactory = $collectionFactory;
        $this->likesModelFactory = $likesModelFactory;
        $this->likesResource = $likesResource;
    }

    /**
     * Get like by id
     *
     * @param int $id
     * @return LikesModel
     */
    public function getById(int $id): LikesModelInterface
    {
        $like= $this->likesModelFactory->create();
        $this->likesResource->load($like, $id);

        return $like;
    }

    /**
     * Save new like
     *
     * @param LikesModelInterface $like
     * @throws AlreadyExistsException
     */
    public function save(LikesModelInterface $like): void
    {
        $this->likesResource->save($like);
    }

    /**
     * Check is this product liked by this customer
     *
     * @param $productId
     * @param $customerId
     * @return DataObject[]
     */
    public function checkIsProductLikedByThisCustomer(int $productId, int $customerId): array
    {
        $collection = $this->collectionFactory->create();
        $collection->addFilter('product_id',$productId)->addFilter('customer_id', $customerId);
        $result = $collection->getItems();
        return $result;
    }

    public function checkIsProductLikedByThisGuest(int $productId, int $guestCookieKey): array
    {
        $collection = $this->collectionFactory->create();
        $collection->addFilter('product_id',$productId)->addFilter('cookie_guest_key', $guestCookieKey);
        $result = $collection->getItems();
        return $result;
    }

    /**
     * Delete like
     *
     * @param int $likeId
     * @throws \Exception
     */
    public function deleteLikeById(int $likeId): void
    {
        $this->likesResource->delete($this->getById($likeId));
    }
}
