<?php
namespace Study\ImprovedContact\Ui\Component\Listing;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class Edit extends Column
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }
    public function prepareDataSource(array $dataSource) {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$contact) {
                $contact[$this->getData('name')]['edit'] = [
                    'href' => $this->urlBuilder->getUrl(
                        'improvedcontact/edit/index',
                        ['id' => $contact['contact_id']]
                    ),
                    'label' => __('Edit'),
                    'hidden' => false,
                ];
            }
        }
        return $dataSource;
    }

}
