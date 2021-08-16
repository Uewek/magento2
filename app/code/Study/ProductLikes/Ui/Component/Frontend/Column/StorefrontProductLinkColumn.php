<?php
declare(strict_types=1);

namespace Study\ProductLikes\Ui\Component\Frontend\Column;

use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Exception\NoSuchEntityException;
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
     * @var ProductRepository
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
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        ProductRepository $productRepository,
        array $components = [],
        array $data = []
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
        if (isset($dataSource['data']['items']) ){
            foreach ($dataSource['data']['items'] as &$like){
                $like['product_sku'] = $this->productRepository->getById((int) $like['product_id'])->getSku();
                $id = $like['like_id'];
                $baseUrl = $this->urlBuilder->getBaseUrl();
                $url = $this->prepareProductLink((int) $like['product_id']);
                $productName = $this->prepareProductName((int) $like['product_id']);
                $like['storefront_url'] = html_entity_decode('<a href="'.$url.'">'.$productName.'</a>');
                $like['delete'] = "<a href=\"$baseUrl.\likes\index\deleteproductlike?like_id=$id\">
                                   <button >Unlike</button></a>";
            }
        }
        return $dataSource;
    }

    /**
     * Create storefront product url by product id
     *
     * @param $productId
     * @return string
     * @throws NoSuchEntityException
     */
    private function prepareProductLink(int $productId): string
    {
        $productSku = $this->productRepository->getById($productId)->getSku();
        $productUrl = $this->productRepository->get($productSku)->getProductUrl();

        return $productUrl;
    }

    /**
     * Get product name by id
     *
     * @param $productId
     * @return string
     * @throws NoSuchEntityException
     */
    private function prepareProductName(int $productId): string
    {
        $productSku = $this->productRepository->getById($productId)->getSku();
        $productName = $this->productRepository->get($productSku)->getName();

        return $productName;
    }
}
