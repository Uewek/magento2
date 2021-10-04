<?php
declare(strict_types=1);

namespace Study\Promotions\Api;

interface PromotedProductsInterface
{
    /**
     * Set promoted product by id
     *
     * @param int $productId
     */
    public function setPromotedProduct(int $productId);

    /**
     * Set promotion by id
     *
     * @param int $promotionId
     */
    public function setPromotion(int $promotionId);

    /**
     * Get id of promoted product
     *
     * @return int
     */
    public function getPromotedProductId(): int;

    /**
     * Get id of promotion
     *
     * @return int
     */
    public function getPromotionId(): int;
}
