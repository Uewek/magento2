<?php
declare(strict_types=1);

namespace Study\ProductLikes\Controller\Index;

use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\Request\Http;
use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Action\Action;
use Study\ProductLikes\Model\LikesModelFactory;
use Study\ProductLikes\Model\LikesRepository;

/**
 * Class LikeProduct - in this controller creating new like
 */
class LikeProduct extends Action implements HttpPostActionInterface
{
    /**
     * @var LikesModelFactory
     */
    private $likesModelFactory;

    /**
     * @var Http
     */
    private $request;

    /**
     * @var LikesRepository
     */
    private $likesRepository;

    /**
     * LikeProduct constructor.
     * @param Context $context
     * @param Http $request
     * @param LikesModelFactory $likesModelFactory
     * @param LikesRepository $likesRepository
     */
    public function __construct(
        Context $context,
        Http $request,
        LikesModelFactory $likesModelFactory,
        LikesRepository $likesRepository
    ) {
        $this->request = $request;
        $this->likesModelFactory = $likesModelFactory;
        $this->likesRepository = $likesRepository;
        parent::__construct($context);
    }

    /**
     * Create new product like
     *
     * @return void
     */
    public function execute(): void
    {
        $data = $this->request->getParams();
        $isLiked = $this->likesRepository->checkIsProductLikedByThisCustomer((int)$data['productId'],(int)$data['customerId']);
        if($data){
            if(empty($isLiked)){
                $newLike = $this->likesModelFactory->create()
                    ->setProduct((int)$data['productId'])
                    ->setCustomer((int)$data['customerId']);
                $this->likesRepository->save($newLike);
                $this->messageManager->addSuccessMessage(__('Product liked!'));
            } else {
                $this->messageManager->addWarningMessage(__('You already liked this product!'));
            }
        }
    }
}
