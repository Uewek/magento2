<?php

declare(strict_types=1);

namespace Study\ImprovedContact\Api;

/**
 * Interface ValidatorInterface  for validator model
 */
interface ValidatorInterface
{
    const REQUIRED_FIELDS = ['contact_id', 'name', 'email', 'telephone', 'comment'];
}
