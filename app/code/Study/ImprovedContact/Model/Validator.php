<?php
declare(strict_types=1);

namespace Study\ImprovedContact\Model;

use Magento\Framework\Exception\LocalizedException;
use Study\ImprovedContact\Api\ValidatorInterface;

/**
 * Class Validator used for check and prepare data during edit contact
 */
class Validator implements ValidatorInterface
{
    private const REQUIRED_FIELDS = ['contact_id', 'name', 'email', 'telephone', 'comment'];

    /**
     * Check incoming data array
     *
     * @param array $data
     * @throws LocalizedException
     */
    public function validate(array $data): void
    {
        $errorMessage = "Required parameter '%1' missed or absent. Please try again";
        foreach ($this::REQUIRED_FIELDS as $requiredField) {
            if (!isset($data[$requiredField]) || trim($data[$requiredField]) == '') {
                throw new LocalizedException(__($errorMessage, $requiredField));
            }
        }
    }
}
