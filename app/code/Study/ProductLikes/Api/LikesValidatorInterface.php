<?php
declare(strict_types=1);

namespace Study\ProductLikes\Api;

interface LikesValidatorInterface
{
    /**
     * Check is that product liked by current customer
     *
     * @param int $productId
     * @param int $customerId
     * @return bool
     */
    public function productLikedByThisCustomer(int $productId, int $customerId): bool;

    /**
     * Check is that product liked by current guest
     *
     * @param int $productId
     * @param string $guestCookieKey
     * @return bool
     */
    public function productLikedByThisGuest(int $productId, string $guestCookieKey): bool;
}
