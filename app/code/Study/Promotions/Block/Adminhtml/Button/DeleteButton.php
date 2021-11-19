<?php
declare(strict_types=1);

namespace Study\Promotions\Block\Adminhtml\Button;

use Magento\Catalog\Block\Adminhtml\Product\Edit\Button\Generic;

/**
 * 'Empty' button
 */
class DeleteButton extends Generic
{
    /**
     * Prepare 'empty' button
     *
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Delete Promotion'),
            'class' => 'delete',
            'on_click' => '',
            'sort_order' => 10
        ];
    }

}
