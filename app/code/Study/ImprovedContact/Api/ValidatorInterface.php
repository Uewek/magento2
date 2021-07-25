<?php

declare(strict_types=1);

namespace Study\ImprovedContact\Api;

/**
 * Interface ValidatorInterface  for validator model
 */
interface ValidatorInterface
{

    /**
     * Check entering data
     *
     * @param array $data
     */
    public function validate(array $data): void;
}
