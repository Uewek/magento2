<?php

declare(strict_types=1);

namespace Study\Promotions\Service;

use Study\Promotions\Model\PromotedProductLinksRepository;
use Study\Promotions\Model\ResourceModel\PromotionsLinks\CollectionFactory;

/**
 * Service class to delete promotions links
 */
class DeleteLinkedProductsService
{
    /**
     * @var CollectionFactory
     */
    private $promotionsLinksCollectionFactory;

    /**
     * @var PromotedProductLinksRepository
     */
    private $productLinksRepository;

    /**
     * Class constructor
     *
     * @param CollectionFactory $promotionsLinksCollectionFactory
     * @param PromotedProductLinksRepository $productLinksRepository
     */
    public function __construct
    (
        CollectionFactory $promotionsLinksCollectionFactory,
        PromotedProductLinksRepository $productLinksRepository
    ) {
        $this->promotionsLinksCollectionFactory = $promotionsLinksCollectionFactory;
        $this->productLinksRepository = $productLinksRepository;
    }

    /**
     * Get promotion link by given parameters
     *
     * @param int $promotionId
     * @return
     */
    public function getLinks( int $promotionId): array
    {
        $collection = $this->promotionsLinksCollectionFactory->create();
        $collection->addFilter('promotion_id', $promotionId);

        return $collection->getItems();
    }

    /**
     * Delete product link
     *
     * @param array $productLinks
     */
    public function deleteLinkedProducts(array $productLinks ): void
    {
        foreach ($productLinks as $link) {
            try {
                $this->productLinksRepository->delete($link);
            } catch (\Exception $exception) {

            }
        }
    }
}
