<?php
declare(strict_types=1);

namespace Study\Promotions\Controller\Adminhtml\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\Action;
use Study\Promotions\Model\PromotedProductsFactory;
use Study\Promotions\Model\PromotionsRepository;


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
     * Constructor of add
     *
     * @param Context $context
     * @param PromotionsRepository $promotionsRepository
     * @param PromotedProductsFactory $promotedProductsFactory
     */
    public function __construct (
        Context $context,
        PromotionsRepository $promotionsRepository,
        PromotedProductsFactory $promotedProductsFactory
    ) {
        $this->promotionsRepository = $promotionsRepository;
        $this->promotedProductsFactory = $promotedProductsFactory;

        parent::__construct($context);
    }

    /**
     * Add selected product to current promotion
     *
     * @return void
     */
    public function execute(): void
    {
        $data = $this->getRequest()->getParams();
        $promotedProductIds=explode(' ',trim(preg_replace('@\W+@',' ',$data['productJson'])));
        foreach ($promotedProductIds as $promotedProductId) {
            $promotedProduct = $this->promotedProductsFactory->create()
                ->setPromotedProduct((int)$promotedProductId)
                ->setPromotion((int) $data['promotion']);
                $this->promotionsRepository->savePromotedProduct($promotedProduct);
        }

    }


}
