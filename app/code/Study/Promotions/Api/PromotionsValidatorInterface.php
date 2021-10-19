<?php
declare(strict_types=1);

namespace Study\Promotions\Api;

interface PromotionsValidatorInterface
{
    /**
     * Check required fields
     *
     * @param array $data
     */
    public function checkIncomingData(array $data): void;

    /**
     * Check is time parameters is correct
     *
     * @param string $startTime
     * @param string $finishTime
     * @return bool
     */
    public function isTimeParametersIsIncorrect(string $startTime, string $finishTime): bool;
}
