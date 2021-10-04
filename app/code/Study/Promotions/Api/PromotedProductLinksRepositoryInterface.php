<?php
declare(strict_types=1);

namespace Study\Promotions\Api;

interface PromotedProductLinksRepositoryInterface
{
    /**
     * Save promoted product
     *
     * @param PromotedProductsInterface $product
     * @return PromotedProductLinksRepositoryInterface
     */
    public function savePromotedProduct(PromotedProductsInterface $product);
}
