<?php
declare(strict_types=1);

namespace Study\Promotions\Controller\Adminhtml\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\Action;
use Study\Promotions\Model\PromotedProductsFactory;
use Study\Promotions\Model\PromotionsRepository;
use Study\Promotions\Model\ResourceModel\PromotionsLinks\CollectionFactory;


class AddProductsToPromotion extends Action implements HttpGetActionInterface,HttpPostActionInterface
{
    /**
     * @var PromotionsRepository
     */
    private $promotionsRepository;

    /**
     * @var PromotedProductsFactory
     */
    private $promotedProductsFactory;

    /**
     * @var CollectionFactory
     */
    private $promotionLinksCollectionFactory;

    /**
     * Constructor of add
     *
     * @param Context $context
     * @param PromotionsRepository $promotionsRepository
     * @param PromotedProductsFactory $promotedProductsFactory
     */
    public function __construct (
        Context $context,
        PromotionsRepository $promotionsRepository,
        CollectionFactory $collectionFactory,
        PromotedProductsFactory $promotedProductsFactory
    ) {
        $this->promotionLinksCollectionFactory = $collectionFactory;
        $this->promotionsRepository = $promotionsRepository;
        $this->promotedProductsFactory = $promotedProductsFactory;

        parent::__construct($context);
    }

    /**
     * Add selected product to current promotion
     *

     */
    public function execute()
    {
        $data = $this->getRequest()->getParams();
        $linkedProductsArray = $this->promotionLinksCollectionFactory->create()
            ->addFieldToFilter('promotion_id',$data['promotion'])->addFieldToSelect('product_id')->getData();
        $productIdsArray = [];
        foreach ($linkedProductsArray as $productId) {
            $productIdsArray[] =$productId['product_id'];
        }
        $promotedProductIds=explode(' ',trim(preg_replace('@\W+@',' ',$data['productJson'])));
        foreach ($promotedProductIds as $promotedProductId) {
            if (empty($productIdsArray) || in_array($promotedProductId,$productIdsArray) !==true) {
                $promotedProduct = $this->promotedProductsFactory->create()
                    ->setPromotedProduct((int)$promotedProductId)
                    ->setPromotion((int) $data['promotion']);
                $this->promotionsRepository->savePromotedProduct($promotedProduct);
            }

        }
        $this->messageManager->addSuccessMessage(__('Products successfully assigned to promotion !'));

        if (isset($data['saveUpdate'])) {
            $resultRedirect = $this->resultRedirectFactory->create();
            $resultRedirect->setPath('promotions/');

            return $resultRedirect;
        }

    }


}
