<?php
declare(strict_types=1);

namespace Study\ProductLikes\Ui\Component\Frontend\Column;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Prepare columns for storefront grid
 */
class StorefrontDeleteLikeColumn extends Column
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * Product name/link constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface           $context,
        UiComponentFactory         $uiComponentFactory,
        array                      $components = [],
        array                      $data = []
    ) {
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source for unlike column
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$like) {
                $id = $like['like_id'];

                $like[$this->getData('name')] = [
                    'delete' => [
                        'href' => "\likes\index\deleteproductlike?like_id=$id",
                        'label' => __('Unlike')
                    ]
                ];
            }
        }

        return $dataSource;
    }
}


