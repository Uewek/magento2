<?php
declare(strict_types=1);

namespace Study\ProductLikes\Api\Data;

interface LikesModelInterface
{
    /**
     * Set product in like
     *
     * @param int $productId
     */
    public function setProduct(int $productId): LikesModelInterface;

    /**
     * Set customer in like
     *
     * @param int $customerId
     */
    public function setCustomer(int $customerId): LikesModelInterface;
}
