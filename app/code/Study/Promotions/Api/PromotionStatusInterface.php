<?php
declare(strict_types=1);

namespace Study\Promotions\Api;

interface PromotionStatusInterface
{
    /**
     * Promotion status values
     */
    public const PROMOTION_ENABLED = 1;

    public const PROMOTION_DISABLED = 0;
}
