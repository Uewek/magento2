<?php
declare(strict_types=1);

namespace Study\ProductLikes\Ui\Component\Listing\Column;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\ProductRepository;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

/**
 * Class Edit need for contact edit ui form
 */
class ProductColumn extends Column
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    private $productRepository;

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
        ProductRepository $productRepository,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->productRepository = $productRepository;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source for products column
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items']) && !isset($dataSource['data']['items']['0']['numberOfLikes'])){
            $dataSource['data']['items'] =$this->linkLikesToProduct($dataSource)['data']['items'];
        }
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as &$like) {
                $like['productName'] = $this->getProductById((int)$like['product_id'])->getName();
            }
        }
        return $dataSource;
    }

    /**
     * Get product entity by id
     *
     * @param int $id
     * @return ProductInterface|null
     * @throws NoSuchEntityException
     */
    private function getProductById(int $id): ProductInterface
    {
        $product = $this->productRepository->getById($id);

        return $product;
    }

    /**
     * Remove product doubles from data source
     *
     * @param array $array
     * @return array
     */
    protected function removeProductDoubles(array $array): array
    {
        $temporaryArray = [];
            foreach ($array as $likedProduct){
                $flag = true;
                foreach ($temporaryArray as $tempArrayElement){
                    if($tempArrayElement['product_id']==$likedProduct['product_id']){
                        $flag = false;
                    }
                }
                if($flag){
                    $temporaryArray[] = $likedProduct;
                }
            }
            return $temporaryArray;
    }

    /**
     * Count likes and link it to products
     *
     * @param array $dataSource
     * @return array
     */
    private function linkLikesToProduct(array $dataSource): array
    {
        $productArray = $this->removeProductDoubles($dataSource['data']['items']);
        foreach ($productArray as &$element){
            $element['numberOfLikes'] = 0;
        }
        foreach ($dataSource['data']['items'] as $like){
            foreach ($productArray as &$product){
                if($like['product_id'] == $product['product_id']){
                    $product['numberOfLikes']++;
                }
            }
        }
        $dataSource['data']['items'] = $productArray;
        return $dataSource;
    }
}
