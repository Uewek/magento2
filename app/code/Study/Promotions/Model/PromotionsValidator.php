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
    private $requiredFields = [
        'start_time',
        'promotion_name',
        'promotion_enabled'
    ];

    /**
     * Check required fields
     *
     * @param array $data
     */
    public function checkIncomingData(array $data): void
    {
        foreach ($this->requiredFields as $requiredField) {
            $data[$requiredField] = strip_tags(trim($data[$requiredField]));
            if (!isset($data[$requiredField]) || $data[$requiredField] === '') {
                throw new \InvalidArgumentException('Required field missed or empty');
            }
        }
    }

    /**
     * Check is time parameters is correct
     *
     * @param string $startTime
     * @param string $finishTime
     * @return bool
     */
    public function isTimeParametersIsIncorrect(string $startTime, string $finishTime): bool
    {
        $result = false;

        if (((strtotime($finishTime) !== false) && strtotime($finishTime) < strtotime($startTime))) {
            throw new \InvalidArgumentException('Finish date can`t be earlier than start date');
        }

        return $result;
    }
}
