<?php
declare(strict_types=1);

namespace Study\CategoryExternalCode\Block;

use Magento\Catalog\Helper\Data;
use Magento\Framework\Phrase;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Study\CategoryExternalCode\Service\ExternalAttributeService;

class CategoryExternal extends Template
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
        Context $context,
        Data $dataHelper,
        ExternalAttributeService $externalAttributeService
    ) {
        $this->dataHelper = $dataHelper;
        $this->externalAttributeService = $externalAttributeService;

        parent::__construct($context);
    }

    /**
     * Return external code for template
     *
     * @return Phrase
     */
    public function getExternalCode(): Phrase
    {
        $categoryId = $this->dataHelper->getCategory()->getId();
        $externalCode = $this->externalAttributeService->getExternalAttributeValue($categoryId);
        $resultCode = '';
        if (isset($externalCode) && $externalCode !== '') {
            $resultCode = '( ' . $externalCode . ')';
        }

        return __($resultCode);
    }


}
