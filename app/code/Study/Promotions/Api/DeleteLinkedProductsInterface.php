<?php
declare(strict_types=1);

namespace Study\Promotions\Api;

interface DeleteLinkedProductsInterface
{
    /**
     * Delete product link
     *
     * @param array $productLinks
     */
    public function deleteLinkedProducts(array $productLinks ): void;

    /**
     * Get promotion link by given parameters
     *
     * @param int $promotionId
     * @return
     */
    public function getLinks( int $promotionId): array;
}
