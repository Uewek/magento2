<?php
declare(strict_types=1);

namespace Study\ImprovedContact\Ui\DataProvider\Form;

use Study\ImprovedContact\Ui\DataProvider\Contact\DataProvider as ListingDataProvider;

class DataProvider extends ListingDataProvider
{
    /**
     * @var
     */
    protected $loadedData;
    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $contact) {
            $this->loadedData[$contact->getId()] = $contact->getData();
        }
        return $this->loadedData;
    }
}
