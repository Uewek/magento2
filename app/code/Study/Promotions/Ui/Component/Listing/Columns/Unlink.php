<?php
declare(strict_types=1);

namespace Study\Promotions\Ui\Component\Listing\Columns;

use Magento\Framework\UrlInterface;
use Study\Promotions\Model\ResourceModel\PromotionsLinks\CollectionFactory;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;
use Magento\Catalog\Model\Session;
use Study\Promotions\Model\PromotedProducts;


/**
 * Class Edit need for contact edit ui form
 */
class Unlink extends Column
{
    /**
     * @var UrlInterface
     */
    protected $urlBuilder;

    protected $session;

    private $promotionLinksCollectionFactory;

    /**
     * Edit constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */
    public function __construct(
        ContextInterface   $context,
        Session            $session,
        CollectionFactory  $promotionLinksCollectionFactory,
        UiComponentFactory $uiComponentFactory,
        UrlInterface       $urlBuilder,
        array              $components = [],
        array              $data = []
    ) {
        $this->promotionLinksCollectionFactory = $promotionLinksCollectionFactory;
        $this->urlBuilder = $urlBuilder;
        $this->session = $session;

        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source for promotion edit ui form
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource): array
    {
        if (isset($dataSource['data']['items'])) {
            $promotionId = (string)  $this->getPromotionId();

            foreach ($dataSource['data']['items'] as &$item) {
                $assignedPromotions = $this->getPromotionsAssignedToCurrentProduct($item['entity_id']);
                $isAssigned =  $this->getProductAssignmentStatus($promotionId, $assignedPromotions);
                if ($isAssigned === 'Assigned') {
                    $item[$this->getData('name')]['unlink'] = [
                        'href' => $this->urlBuilder->getUrl(
                            'promotions/edit/unlink/',
                            ['promotion_id' => $promotionId,
                             'product_id' => $item['entity_id']]
                        ),
                        'label' => __('Unlink')
                    ];
                }
                $item['is_assigned'] = [
                    $isAssigned
                ];
            }
        }

        return $dataSource;
    }

    /**
     * Get id of edited promotion from session
     *
     * @return int
     */
    private function getPromotionId(): int
    {
        $promotionId = $this->session->getPromotionId();

        return (int) $promotionId;
    }

    /**
     * Get promotions assigned to current product
     *
     * @param string $productId
     * @return array
     */
    private function getPromotionsAssignedToCurrentProduct(string $productId): array
    {
        $result =  $this->promotionLinksCollectionFactory->create()
            ->addFieldToFilter(PromotedProducts::PRODUCT_ID, $productId)
            ->addFieldToSelect(PromotedProducts::PROMOTION_ID)
            ->getItems();

        return $result;

    }

    /**
     * Get assignment status of that product
     *
     * @param string $promotionId
     * @return string
     */
    private function getProductAssignmentStatus(string $promotionId, $promotions): string
    {
        $status = 'Unassigned';
        $promotionsArray = [];
        foreach ($promotions as $promotion) {
            $promotionsArray[] = $promotion->getData()['promotion_id'];
        }

        if (in_array($promotionId, $promotionsArray)) {
            $status = 'Assigned';
        }
        return $status;
    }
}
