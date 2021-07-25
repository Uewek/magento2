<?php
declare(strict_types=1);

namespace Study\ImprovedContact\Ui\DataProvider\Form;

use Study\ImprovedContact\Ui\DataProvider\Contact\DataProvider as ListingDataProvider;

/**
 * DataProvider for contact edit ui form
 */
class DataProvider extends ListingDataProvider
{
    /**
     * @var array
     */
    protected $loadedData;

    /**
     * Get data for edit form
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
