<?php
declare(strict_types=1);

namespace Barwenock\AdditionCheckout\Block;

use Magento\Checkout\Block\Checkout\AttributeMerger;
use Magento\Checkout\Block\Checkout\LayoutProcessorInterface;
use Magento\Customer\Model\AttributeMetadataDataProvider;
use Magento\Ui\Component\Form\AttributeMapper;

class LayoutProcessor implements LayoutProcessorInterface
{
    /**
     * @var AttributeMerger
     */
    private $merger;

    /**
     * @var AttributeMetadataDataProvider
     */
    private $attributeMetaDataProvider;

    /**
     * @var AttributeMapper
     */
    private $attributeMapper;

    /**
     * @param AttributeMetadataDataProvider $attributeMetadataDataProvider
     * @param AttributeMapper $attributeMapper
     * @param AttributeMerger $attributeMerger
     */
    public function __construct(
        AttributeMetadataDataProvider $attributeMetadataDataProvider,
        AttributeMapper $attributeMapper,
        AttributeMerger $attributeMerger
    ) {
        $this->merger = $attributeMerger;
        $this->attributeMetaDataProvider = $attributeMetadataDataProvider;
        $this->attributeMapper = $attributeMapper;
    }


    public function process($jsLayout)
    {
        $elements = $this->getAddressAttributes();
        $fields = &$jsLayout['components']['checkout']['children']['steps']['children']['contact-step']
        ['children']['contact']['children']['contact-fieldset']['children'];
        $fieldCodes = array_keys($fields);
        $elements = array_filter($elements, function ($key) use ($fieldCodes) {
            return in_array($key, $fieldCodes);
        }, ARRAY_FILTER_USE_KEY);
        $fields = $this->merger->merge(
            $elements,
            'checkoutProvider',
            'contact',
            $fields
        );
        return $jsLayout;
    }

    private function getAddressAttributes(): array
    {
        $attributes = $this->attributeMetaDataProvider->loadAttributesCollection(
            'customer_address',
            'customer_register_address'
        );
        $elements = [];
        foreach ($attributes as $attribute) {
            $code = $attribute->getAttributeCode();
            $elements[$code] = $this->attributeMapper->map($attribute);

            if (isset($elements[$code]['label'])) {
                $label = $elements[$code]['label'];
            $elements[$code]['label'] = __($label);
            }
        }

        return $elements;
    }
}
