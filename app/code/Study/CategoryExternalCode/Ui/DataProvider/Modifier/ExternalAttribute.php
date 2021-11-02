<?php
declare(strict_types=1);

namespace Study\CategoryExternalCode\Ui\DataProvider\Modifier;

use Magento\Catalog\Helper\Data;
use Magento\Ui\DataProvider\Modifier\ModifierInterface;

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
     * Class constructor
     *
     * @param Data $dataHelper
     */
    public function __construct(
        Data $dataHelper
    ) {
        $this->dataHelper = $dataHelper;
    }

    /**
     * Add value in the 'Category external code field'
     *
     * @param array $meta
     * @return array
     */
    public function modifyMeta(array $meta)
    {
        $category = $this->dataHelper->getCategory();
        $categoryExternalCode = $category->getExtensionAttributes()->getCategoryExternalCode();
        if (isset($categoryExternalCode) && $categoryExternalCode !== '') {
            $meta['general'] = [
                'children' => [
                    'category_external_code' => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'value' => $categoryExternalCode
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
