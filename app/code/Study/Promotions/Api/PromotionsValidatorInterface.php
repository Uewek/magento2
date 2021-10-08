<?php
declare(strict_types=1);

namespace Study\Promotions\Api;

interface PromotionsValidatorInterface
{
    /**
     * Check is time parameters is correct
     *
     * @param string $startTime
     * @param string $finishTime
     * @return bool
     */
    public function isTimeParametersIsCorrect(string $startTime, string $finishTime): bool;
}
