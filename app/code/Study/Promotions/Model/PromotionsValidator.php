<?php
declare(strict_types=1);

namespace Study\Promotions\Model;

use Study\Promotions\Api\PromotionsValidatorInterface;
use Study\Promotions\Model\PromotionsRepository;

/**
 * Validate promotion parameters
 */
class PromotionsValidator implements PromotionsValidatorInterface
{
    /**
     * Check is time parameters is correct
     *
     * @param string $startTime
     * @param string $finishTime
     * @return bool
     */
    public function isTimeParametersIsCorrect(string $startTime, string $finishTime): bool
    {
        $result = false;

        if ($startTime !== '' && $finishTime == '') {
            $result = true;
        }

        if ($startTime !== '' && (strtotime($finishTime) > strtotime($startTime))) {
            $result = true;
        }

        return $result;
    }

}
