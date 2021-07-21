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
    /**
     * Prepare data for saving
     *
     * @param array $enteringData
     * @return array
     */
    public function prepareData(array $enteringData): array
    {
        $result = [];
        $result['contact_id']=$enteringData['contact_id'];
        $result['name']=$enteringData['name'];
        $result['telephone']=$enteringData['telephone'];
        $result['comment']=$enteringData['comment'];
        $result['email']=$enteringData['email'];

        return $result;
    }

    /**
     * Check incoming data array
     *
     * @param array $data
     * @return $this
     * @throws LocalizedException
     */
    public function validateData(array $data)
    {
        $errorMessage = "Required parameter ' %1 ' missed or absent. Please try again";
        foreach ($this::REQUIRED_FIELDS as $requiredField) {
            if (!isset($data[$requiredField]) || trim($data[$requiredField])=='') {
                throw new LocalizedException(__($errorMessage, $requiredField));
            }
        }
        return $this;
    }
}
