<?php

namespace Study\CategoryExternalCode\ViewModel;

use Magento\Catalog\Helper\Data;
use Magento\Framework\View\Element\Block\ArgumentInterface;

/**
 * View model transfer data to storefront category page
 */
class CategoryExternalCodeViewModel implements ArgumentInterface
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
     * Return external code for template
     *
     * @return string
     */
    public function getExternalCode(): string
    {
        $category = $this->dataHelper->getCategory();
        $externalCode = $category->getExtensionAttributes()->getCategoryExternalCode();
        $resultCode = '';
        if (isset($externalCode) && $externalCode !== '') {
            $resultCode =  '( ' . $externalCode . ')';
        }

        return $resultCode;
    }
}
