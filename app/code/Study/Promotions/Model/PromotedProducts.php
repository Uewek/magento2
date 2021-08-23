<?php
declare(strict_types=1);

namespace Study\Promotions\Model;

use Study\Promotions\Api\PromotedProductsInterface;
use Magento\Framework\Model\AbstractModel;
use Study\Promotions\Model\ResourceModel\PromotionsLinkResource;

class PromotedProducts extends AbstractModel implements PromotedProductsInterface
{
    /**
     * Product promotion construct
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(PromotionsLinkResource::class);
    }

    /**
     * Set promoted product
     *
     * @param int $productId
     * @return PromotedProductsInterface
     */
    public function setPromotedProduct(int $productId): PromotedProductsInterface
    {
        $this->setData('product_id', $productId);

        return $this;
    }

    /**
     * Set promotion
     *
     * @param int $promotionId
     * @return PromotedProductsInterface
     */
    public function setPromotion(int $promotionId): PromotedProductsInterface
    {
        $this->setData('promotion_id', $promotionId);

        return $this;
    }

    /**
     * Get promoted product
     *
     * @return int
     */
    public function getPromotedProduct(): int
    {
        return $this->getData('product_id');
    }

    /**
     * Get promotion id
     *
     * @return int
     */
    public function getPromotion(): int
    {
        return $this->getData('promotion_id');
    }
}
