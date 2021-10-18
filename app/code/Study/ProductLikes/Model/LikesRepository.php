<?php
declare(strict_types=1);

namespace Study\ProductLikes\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use Study\ProductLikes\Model\ResourceModel\LikesResource;
use Study\ProductLikes\Api\Data\LikesModelInterface;
use Study\ProductLikes\Api\LikesRepositoryInterface;
use Study\ProductLikes\Api\LikesValidatorInterface;

/**
 * This repository managing likes
 */
class LikesRepository implements LikesRepositoryInterface
{
    /**
     * @var LikesValidatorInterface
     */
    private $likesValidator;


    /**
     * @var LikesModelFactory
     */
    private $likesModelFactory;

    /**
     * @var LikesResource
     */
    private $likesResource;

    /**
     * LikesRepository constructor.
     * @param LikesResource $likesResource
     * @param LikesModelFactory $likesModelFactory
     * @param LikesValidator $likesValidator
     */
    public function __construct(
        LikesResource $likesResource,
        LikesValidatorInterface $likesValidator,
        LikesModelFactory $likesModelFactory
    ) {
        $this->likesValidator = $likesValidator;
        $this->likesModelFactory = $likesModelFactory;
        $this->likesResource = $likesResource;
    }

    /**
     * Get like by id
     *
     * @param int $id
     * @return LikesModel
     */
    public function getById(int $id): LikesModelInterface
    {
        $like= $this->likesModelFactory->create();
        $this->likesResource->load($like, $id);

        if(null === $like->getId()) {
            throw new NoSuchEntityException(__('Like with id %1 absent', $id));
        }

        return $like;
    }

    /**
     * Save new like
     *
     * @param LikesModelInterface $like
     * @return LikesModelInterface
     */
    public function save(LikesModelInterface $like): LikesModelInterface
    {
        $this->likesResource->save($like);

        return $like;
    }

    /**
     * Check is this product liked by this customer
     *
     * @param $productId
     * @param $customerId
     * @return bool
     */
    public function isProductLikedByCustomer(int $productId, int $customerId): bool
    {
        return $this->likesValidator->productLikedByThisCustomer($productId, $customerId);
    }

    /**
     * Check is that product liked by current guest
     *
     * @param int $productId
     * @param string $guestCookieKey
     * @return bool
     */
    public function isProductLikedByGuest(int $productId, string $guestCookieKey): bool
    {
        return $this->likesValidator->productLikedByThisGuest($productId, $guestCookieKey);
    }

    /**
     * Delete like
     *
     * @param int $likeId
     * @return void
     */
    public function deleteById(int $likeId): void
    {
        $this->likesResource->delete($this->getById($likeId));
    }

    /**
     * Delete like
     *
     * @param LikesModelInterface $likesModel
     * @return void
     */
    public function delete(LikesModelInterface $likesModel): void
    {
        $this->likesResource->delete($likesModel);
    }
}
