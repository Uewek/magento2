<?php
declare(strict_types=1);

namespace Study\CategoryExternalCode\Service;

use Study\CategoryExternalCode\Api\Data\CategoryExternalCodeInterface;
use Study\CategoryExternalCode\Api\CategoryExternalCodeRepositoryInterface;

/**
 * Class need to get value of external attribute assigned to category
 */
class ExternalAttributeService
{
    /**
     * Class constructor
     *
     * @var CategoryExternalCodeRepositoryInterface
     */
    private $categoryExternalCodeRepository;

    public function __construct(
        CategoryExternalCodeRepositoryInterface $categoryExternalCodeRepository
    ) {
        $this->categoryExternalCodeRepository = $categoryExternalCodeRepository;
    }

    /**
     * Get external attribute value by category id
     *
     * @param $categoryId
     * @return string|null
     */
    public function getExternalAttributeValue(int $categoryId): ?string
    {
        $externalCode = $this->categoryExternalCodeRepository->getExternalCodeEntity((int) $categoryId);
        $codeValue = $externalCode->getData(CategoryExternalCodeInterface::EXTERNAL_CODE);

        return $codeValue;
    }
}
