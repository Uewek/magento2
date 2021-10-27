<?php
declare(strict_types=1);

namespace Study\CategoryExternalCode\Ui\DataProvider\Modifier;

use Magento\Catalog\Helper\Data;
use Magento\Ui\DataProvider\Modifier\ModifierInterface;
use Study\CategoryExternalCode\Service\ExternalAttributeService;

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

    public function __construct(
        Data $dataHelper,
        ExternalAttributeService $externalAttributeService
    ) {
        $this->dataHelper = $dataHelper;
        $this->externalAttributeService = $externalAttributeService;
    }

    public function modifyMeta(array $meta)
    {
        $categoryId = $this->getCurrentCategoryId();
        $existingCode = $this->externalAttributeService->getExternalAttributeValue($categoryId);
        if (isset($existingCode) && $existingCode !== '') {
            $meta['general'] = [
                'arguments' => [
                    'data' => [
                        'config' => [
                            'label' => __('Label For Fieldset'),
                            'sortOrder' => 50,
                            'collapsible' => true
                        ]
                    ]
                ],
                'children' => [
                    'category_external_code' => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'formElement' => 'text',
                                    'componentType' => 'field',
                                    'value' => $existingCode,
                                    'visible' => 1,
                                    'required' => 1,
                                    'label' => __('Label For Element')
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
     * {@inheritdoc}
     */
    public function modifyData(array $data)
    {
        return $data;
    }

    /**
     * Get id of current category
     *
     * @return string
     */
    private function getCurrentCategoryId(): string
    {
        $category = $this->dataHelper->getCategory();
        return  $category->getId();
    }


}
