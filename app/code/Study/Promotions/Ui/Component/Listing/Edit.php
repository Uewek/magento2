<?php
declare(strict_types=1);

namespace Study\Ptomotions\Ui\Component\Listing;

use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class Edit need for contact edit ui form
 */
class Edit extends Column
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * Edit constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
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

    /**
     * Prepare Data Source for contact edit ui form
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$contact) {
                $contact[$this->getData('name')]['edit'] = [
                    'href' => $this->urlBuilder->getUrl(
                        'promotions/edit/index',
                        ['id' => $contact['contact_id']]
                    ),
                    'label' => __('Edit promotion'),
                    'hidden' => false,
                ];
            }
        }
        return $dataSource;
    }
}