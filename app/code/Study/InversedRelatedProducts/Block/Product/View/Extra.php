<?php

namespace Study\InversedRelatedProducts\Block\Product\View;
use Magento\Catalog\Api\ProductRepositoryInterface;

class Extra extends \Magento\Framework\View\Element\Template
{

    private $config;

    private $_linkedProductsFactory;

    private $dataHelper;

    private $productRepository;


    public function __construct(\Magento\Framework\View\Element\Template\Context
                                $context, \Study\InversedRelatedProducts\Model\Config $config,
                                \Study\InversedRelatedProducts\Model\LinkedProductsFactory $linkedProductsFactory,
                                \Magento\Catalog\Helper\Data $catalogData,
                                ProductRepositoryInterface $productRepository
                                )
    {
        $this->_linkedProductsFactory = $linkedProductsFactory;
        $this->config = $config;
        $this->dataHelper = $catalogData;
        $this->productRepository = $productRepository;
        parent::__construct($context);
    }

    public function getProductById( int $id)
    {
        $product = $this->productRepository->getById($id);
        return $product;

    }

    private function getInversedRelations(int $count=3):array
    {
        $relations = $this->_linkedProductsFactory->create();
        $relationItems=$relations->getCollection()->getItems();
        $arr=[];
        foreach ($relationItems as $item){
           if($item->toArray()['linked_product_id']==$this->getCurrentProductId()&&count($arr)<$count){
               $arr[]= $item->toArray()['product_id'];
           }
        }
        return $arr;

    }

    public function getInversedRelatedProducts():array
    {
        $products=[];
        foreach($this->getInversedRelations() as $inversedRelationId){
            $products[]=$this->getProductById($inversedRelationId);
        }
        return $products;
    }


    public function canShowInversedProducts():bool
    {
        $result = $this->config->isEnabled();
        return $result;

    }

    public function getCurrentProductId()
    {
        return $this->dataHelper->getProduct()->getId();
    }



}
