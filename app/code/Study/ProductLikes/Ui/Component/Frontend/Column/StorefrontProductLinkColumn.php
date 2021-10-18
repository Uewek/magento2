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
class StorefrontProductLinkColumn extends Column
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

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
        UrlInterface               $urlBuilder,
        ProductRepositoryInterface $productRepository,
        array                      $components = [],
        array                      $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->productRepository = $productRepository;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source for product link column
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$like) {
                $like['product_sku'] = $this->productRepository->getById((int)$like['product_id'])->getSku();
                $url = $this->productRepository->getById((int)$like['product_id'])->getProductUrl();
                $productName = $this->productRepository->getById((int)$like['product_id'])->getName();
                $like[$this->getData('name')] = [
                    'link' => [
                        'href' => $url,
                        'label' => $productName
                    ]
                ];
            }
        }

        return $dataSource;
    }
}
