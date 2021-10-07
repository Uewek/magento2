<?php
declare(strict_types=1);

namespace Study\Promotions\Api;

interface PromotionsValidatorInterface
{
    /**
     * Promotion status values
     */
    public const PROMOTION_ENABLED = 1;

    public const PROMOTION_DISABLED = 0;

    /**
     * Check is time parameters is correct
     *
     * @param string $startTime
     * @param string $finishTime
     * @return bool
     */
    public function isTimeParametersIsCorrect(string $startTime, string $finishTime): bool;
}
