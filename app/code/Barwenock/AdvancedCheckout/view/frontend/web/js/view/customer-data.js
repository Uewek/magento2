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
            template: 'Barwenock_AdvancedCheckout/customerData'
        },
        customer:customerData.get('customer'),
        cart:customerData.get('cart'),

        //функция класа
        initialize: function () {
            this._super();

            // customerData.reload(['customer']);
            // console.log(customer());
            // var target = $('#target');

            // this.customer.subscribe( function(a) {
                // console.log(a);
                // target.text(a['fullname']);
            // });


            return this;
        }
    });
});
