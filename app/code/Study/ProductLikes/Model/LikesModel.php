<?php
declare(strict_types=1);

namespace Study\ProductLikes\Model;

use Magento\Framework\Model\AbstractModel;
use Study\ProductLikes\Api\Data\LikesModelInterface;
use Study\ProductLikes\Model\ResourceModel\LikesResource;

class LikesModel extends AbstractModel implements LikesModelInterface
{
    /**
     * Constructor
     */
    protected function _construct()
    {
        $this->_init(LikesResource::class);
    }

    /**
     * Set liked product
     *
     * @param int $productId
     */
    public function setProduct(int $productId): LikesModelInterface
    {
        $this->setData('product_id', $productId);

        return $this;
    }

    /**
     * Set customer who make like
     *
     * @param int $customerId
     */
    public function setCustomer(int $customerId): LikesModelInterface
    {
        $this->setData('customer_id', $customerId);

        return $this;
    }

    /**
     * Set cookie_guest_key for guest customers
     *
     * @param string $cookieGuestKey
     */
    public function setCookieGuestKey(string $cookieGuestKey): LikesModelInterface
    {
        $this->setData('cookie_guest_key', $cookieGuestKey);

        return $this;
    }
}
