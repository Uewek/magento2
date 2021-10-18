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
                            'promotions/edit/unlink',
                            ['id' => $promotionId]
                        ),
                        'label' => __('Unlink')
                    ];
                }
                $item['is_assigned'] = [
                    $isAssigned
                ];
            }
//            $this->clearSession();
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
     * Clear temporary data from session
     */
    private function clearSession(): void
    {
        $this->session->unsPromotionId();
    }

    /**
     * Get promotions assigned to current product
     *
     */
    private function getPromotionsAssignedToCurrentProduct(string $productId): array
    {
        return  $this->promotionLinksCollectionFactory->create()
            ->addFieldToFilter(PromotedProducts::PRODUCT_ID, $productId)
            ->addFieldToSelect(PromotedProducts::PROMOTION_ID)
            ->getItems();

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
        if(isset($promotions[0])) {
            if(in_array($promotionId, $promotions[0]->getData())) {
                $status = 'Assigned';
            }
        }
        return $status;
    }
}
