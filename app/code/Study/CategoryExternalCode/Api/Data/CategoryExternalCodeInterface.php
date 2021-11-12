<?php
declare(strict_types=1);

namespace Study\CategoryExternalCode\Api\Data;

interface CategoryExternalCodeInterface
{
    /**
     * Constants of table columns
     */
    public const ENTITY_ID = 'entity_id';

    public const CATEGORY_ID = 'category_id';

    public const EXTERNAL_CODE = 'category_external_code';

    /**
     * Get attribute code string
     *
     * @return string
     */
    public function getAttributeCode(): ?string;
}
