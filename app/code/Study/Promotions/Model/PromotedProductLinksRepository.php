<?php
declare(strict_types=1);

namespace Study\Promotions\Model;

use Study\Promotions\Api\PromotedProductLinksRepositoryInterface;
use Study\Promotions\Api\PromotedProductsInterface;
use Study\Promotions\Model\ResourceModel\PromotionsLinkResource;

/**
 * That repository used to link products to promotion
 */
class PromotedProductLinksRepository implements PromotedProductLinksRepositoryInterface
{
    /**
     * @var PromotionsLinkResource
     */
    private $promotionsLinkResource;

    /**
     * Class constructor
     *
     * @param PromotionsLinkResource $promotionsLinkResource
     */
    public function __construct(
        PromotionsLinkResource $promotionsLinkResource
    ) {
        $this->promotionsLinkResource = $promotionsLinkResource;
    }

    /**
     * Save promoted product
     *
     * @param PromotedProductsInterface $product
     * @return PromotedProductsInterface
     */
    public function savePromotedProduct(PromotedProductsInterface $product): PromotedProductsInterface
    {
        $this->promotionsLinkResource->save($product);

        return $product;
    }
}
