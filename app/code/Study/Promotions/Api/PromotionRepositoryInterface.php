<?php
declare(strict_types=1);

namespace Study\Promotions\Api;

interface PromotionRepositoryInterface
{

    /**
     * Get promotion by id
     *
     * @param int $id
     * @return PromotionsInfoInterface
     */
    public function getPromotionById(int $id): PromotionsInfoInterface;

    /**
     * Save nev promotion
     *
     * @param PromotionsInfoInterface $promotion
     * @return
     */
    public function savePromotion(PromotionsInfoInterface $promotion): PromotionRepositoryInterface;
}
