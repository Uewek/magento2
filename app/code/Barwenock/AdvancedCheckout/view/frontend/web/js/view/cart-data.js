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
            template: 'Barwenock_AdvancedCheckout/cartData'
        },
        cart:customerData.get('cart'),
        // cartItems:this.cart().items,

        // getCartDetails: this.getCartDetails,

        //функция класа
        initialize: function () {
            this._super();

            // this.cart.getItems()

            // customerData.reload(['customer']);
            // console.log(this.cart());
            console.log(this.cart().items);
            console.log('cart-data');
            // var target = $('#target');

            // this.customer.subscribe( function(a) {
            // console.log(a);
            // target.text(a['fullname']);
            // });


            return this;
        },

        /** Your function for ajax call */
        myAjaxCall: function(dataToPass) {

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
