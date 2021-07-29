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
     * @return void
     */
    public function save(LikesModelInterface $likesModel): void;

    /**
     * Get entity by id
     *
     * @param int $id
     * @return LikesModelInterface
     */
    public function getById(int $id): LikesModelInterface;
}
