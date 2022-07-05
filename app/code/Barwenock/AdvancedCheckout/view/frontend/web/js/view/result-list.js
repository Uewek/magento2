define([
    'jquery',
    'uiComponent',
    'Magento_Customer/js/customer-data',
    'ko'
], function (
    $,
    uiComponent,
    customerData,
    ko
) {
    'use_strict';

    return uiComponent.extend({
        //свойства класа
        defaults: {
            template: 'Barwenock_AdvancedCheckout/searchForm'
        },
        customer:customerData.get('customer'),
        cart:customerData.get('cart'),

        //функция класа
        initialize: function () {
            this._super();

            return this;
        }
    });
});
