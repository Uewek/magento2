<?php
declare(strict_types=1);

namespace Study\ProductLikes\Api;

use Study\ProductLikes\Api\Data\LikesModelInterface;

interface LikesRepositoryInterface
{
    /**
     * Save like in the database
     *
     * @param LikesModelInterface $likesModel
     * @return LikesModelInterface
     */
    public function save(LikesModelInterface $likesModel): LikesModelInterface;

    /**
     * Get entity by id
     *
     * @param int $id
     * @return LikesModelInterface
     */
    public function getById(int $id): LikesModelInterface;

    /**
     * Delete like
     *
     * @param int $likeId
     * @throws \Exception
     */
    public function deleteById(int $likeId): void;

    /**
     * Delete like
     *
     * @param LikesModelInterface $likesModel
     */
    public function delete(LikesModelInterface $likesModel): void;

}
