<?php
declare(strict_types=1);

namespace Study\Promotions\Ui\DataProvider;

use Study\Promotions\Ui\DataProvider\PromotionsGridDataProvider;

/**
 * Prepare data for promotion form
 */
class PromotionsFormDataProvider extends PromotionsGridDataProvider
{
    /**
     * @var array
     */
    protected $loadedData;

    /**
     * Get data for promotion edit form
     *
     * @return array
     */
    public function getData(): array
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        $promotion = array_shift($items)->getData();
        $this->loadedData[$promotion[$this->primaryFieldName]] = $promotion;

        return $this->loadedData;
    }
}
