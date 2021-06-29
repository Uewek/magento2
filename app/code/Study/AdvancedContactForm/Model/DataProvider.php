<?php
 declare(strict_types=1);

 namespace Study\AdvancedContactForm\Model;

 use Magento\Ui\DataProvider\AbstractDataProvider;


 class DataProvider extends AbstractDataProvider
 {
     /**
      * @param string $name
      * @param string $primaryFieldName
      * @param string $requestFieldName
//      * @param CollectionFactory $advancedContactFormCollectionFactory
      * @param array $meta
      * @param array $data
      */
     public function __construct(
         $name,
         $primaryFieldName,
         $requestFieldName,
//         CollectionFactory $advancedContactFormCollectionFactory,
         array $meta = [],
         array $data = []
     ) {
//         $this->collection = $advancedContactFormCollectionFactory->create();
         parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
     }

     /**
      * Get data
      *
      * @return array
      */
     public function getData()
     {
         return [];
     }
 }

