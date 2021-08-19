<?php
declare(strict_types=1);

namespace Study\ProductLikes\Model;

use Study\ProductLikes\Api\LikesValidatorInterface;
use Study\ProductLikes\Model\ResourceModel\ProductLikes\CollectionFactory;


class LikesValidator implements LikesValidatorInterface
{
    private $collectionFactory;

    public function __construct
    (
        CollectionFactory $collectionFactory
    ) {
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * Check is that product liked by current customer
     *
     * @param int $productId
     * @param int $customerId
     * @return bool
     */
    public function productLikedByThisCustomer(int $productId, int $customerId): bool
    {
        $checkResult = false;
        $collection = $this->collectionFactory->create();
        $collection->addFilter('product_id', $productId)
            ->addFilter('customer_id', $customerId);

        if (!empty($collection->getItems())) {
            $checkResult = true;
        }

        return $checkResult;
    }

    /**
     * Check is that product liked by current guest
     *
     * @param int $productId
     * @param string $guestCookieKey
     * @return bool
     */
    public function productLikedByThisGuest(int $productId, string $guestCookieKey): bool
    {
        $checkResult = false;
        $collection = $this->collectionFactory->create();
        $collection->addFilter('product_id', $productId)
            ->addFilter('cookie_guest_key', $guestCookieKey);
        if (!empty($collection->getItems())) {
            $checkResult = true;
        }

        return $checkResult;

    }
}
