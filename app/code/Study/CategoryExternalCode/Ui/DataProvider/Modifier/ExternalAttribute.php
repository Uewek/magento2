<?php
declare(strict_types=1);

namespace Study\CategoryExternalCode\Ui\DataProvider\Modifier;

use Magento\Catalog\Helper\Data;
use Magento\Ui\DataProvider\Modifier\ModifierInterface;
use Study\CategoryExternalCode\Service\ExternalAttributeService;

/**
 * Modify data when category form loading
 */
class ExternalAttribute implements ModifierInterface
{
    /**
     * @var Data
     */
    private $dataHelper;

    /**
     * @var ExternalAttributeService
     */
    private $externalAttributeService;

    /**
     * Class constructor
     *
     * @param Data $dataHelper
     * @param ExternalAttributeService $externalAttributeService
     */
    public function __construct(
        Data                     $dataHelper,
        ExternalAttributeService $externalAttributeService
    )
    {
        $this->dataHelper = $dataHelper;
        $this->externalAttributeService = $externalAttributeService;
    }

    /**
     * Add value in the 'Category external code field'
     *
     * @param array $meta
     * @return array
     */
    public function modifyMeta(array $meta)
    {
        $categoryId = $this->dataHelper->getCategory()->getId();
        $existingCode = $this->externalAttributeService->getExternalAttributeValue($categoryId);
        if (isset($existingCode) && $existingCode !== '') {
            $meta['general'] = [
                'children' => [
                    'category_external_code' => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'value' => $existingCode
                                ]
                            ]
                        ]
                    ]
                ]
            ];
        }

        return $meta;
    }

    /**
     * This method must be implemented
     *
     * @param array $data
     * @return array
     */
    public function modifyData(array $data)
    {
        return $data;
    }
}
