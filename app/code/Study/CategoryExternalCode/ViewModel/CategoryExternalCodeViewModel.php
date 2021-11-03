<?php

namespace Study\CategoryExternalCode\ViewModel;

use Magento\Catalog\Helper\Data;
use Magento\Framework\View\Element\Block\ArgumentInterface;

class CategoryExternalCodeViewModel implements ArgumentInterface
{

    public function __construct(
        Data $dataHelper
    ) {
        $this->dataHelper = $dataHelper;

    }
    /**
     * Return external code for template

     */
    public function getExternalCode()
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
