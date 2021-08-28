<?php
declare(strict_types=1);

namespace Study\Promotions\Ui\DataProvider;

use Study\Promotions\Ui\DataProvider\PromotionsGridDataProvider;


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
        $contact = array_shift($items)->getData();
        $this->loadedData[$contact[$this->primaryFieldName]] = $contact;

        return $this->loadedData;
    }
}
