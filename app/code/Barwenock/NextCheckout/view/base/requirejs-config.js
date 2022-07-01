var config = {
    'config': {
        'mixins': {
            'Magento_Checkout/js/view/shipping': {
                'Barwenock_NextCheckout/js/view/shipping-payment-mixin': true
            },
            'Magento_Checkout/js/view/payment': {
                'Barwenock_NextCheckout/js/view/shipping-payment-mixin': true
            }
        }
    }
}
