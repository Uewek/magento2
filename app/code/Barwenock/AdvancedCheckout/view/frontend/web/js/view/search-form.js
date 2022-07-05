define([
    'jquery',
    'uiComponent',
    'Magento_Customer/js/customer-data',
    'mage/storage',
    'ko'
], function (
    $,
    uiComponent,
    customerData,
    storage,
    ko
) {
    'use_strict';

    return uiComponent.extend({
        //свойства класа
        defaults: {
            template: 'Barwenock_AdvancedCheckout/searchForm'
        },
        cart:customerData.get('cart'),


        //функция класа
        initialize: function () {
            this._super();

            console.log(this.cart().items);
            console.log('cart-data');
            return this;
        },

        /** Your function for ajax call */
        productSearch: function(dataToPass) {

            fullScreenLoader.startLoader();
            storage.post(
                'url/of/mycontroller',
                JSON.stringify(dataToPass),
                true
            ).done(
                function (response) {
                    /** Do your code here */
                    alert('Success');
                    fullScreenLoader.stopLoader();
                }
            ).fail(
                function (response) {
                    fullScreenLoader.stopLoader();
                }
            );
        }
    });
});
