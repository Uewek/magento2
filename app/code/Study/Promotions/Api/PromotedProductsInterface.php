<?php
declare(strict_types=1);

namespace Study\Promotions\Api;

interface PromotedProductsInterface
{
    public const PROMOTION_ID = 'promotion_id';

    public const PRODUCT_ID = 'product_id';

    /**
     * Set promoted product by id
     *
     * @param int $productId
     * @return PromotedProductsInterface
     */
    public function setPromotedProduct(int $productId): PromotedProductsInterface;

    /**
     * Set promotion by id
     *
     * @param int $promotionId
     * @return PromotedProductsInterface
     */
    public function setPromotion(int $promotionId): PromotedProductsInterface;

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
