<?php
declare(strict_types=1);

namespace Study\CategoryExternalCode\Block;

use Magento\Catalog\Helper\Data;
use Magento\Framework\Phrase;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Study\CategoryExternalCode\Service\ExternalAttributeService;

/**
 * This block adding category code to category name on storefront category page
 */
class CategoryExternal extends Template
{
    /**
     * @var Data
     */
    private $dataHelper;

    /**
     * Class constructor
     *
     * @param Context $context
     * @param Data $dataHelper
     */
    public function __construct(
        Context $context,
        Data $dataHelper
    ) {
        $this->dataHelper = $dataHelper;

        parent::__construct($context);
    }

    /**
     * Return external code for template
     *
     * @return Phrase
     */
    public function getExternalCode(): Phrase
    {
        $category = $this->dataHelper->getCategory();
        $externalCode = $category->getExtensionAttributes()->getCategoryExternalCode();
        $resultCode = '';
        if (isset($externalCode) && $externalCode !== '') {
            $resultCode = '( ' . $externalCode . ')';
        }

        return __($resultCode);
    }
}
