define([
    'Magento_Ui/js/form/form',
    'Magento_Checkout/js/model/step-navigator',
    'mage/translate',
    'underscore'
], function (Component,stepNavigator, $t,  _) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Barwenock_AdditionCheckout/contact',
            visible: true
        },
        initialize: function() {
             this._super();

             stepNavigator.registerStep(
              'contact',
              'contact',
              $t('Contact'),
              this.visible,
              _.bind(this.navigate, this),
              this.sortOrder
             );
        },

        initObservable: function () {
            this._super().observe(['visible']);

            return this;
        },

        navigate: function (step) {
            step && step.isVisible(true);
        },
        setContactInformation: function () {
            stepNavigator.next();
        },

        placeOrder: function (data, event) {
            var self = this;

            if (event) {
                event.preventDefault();
            }

            if (this.validate() &&
                additionalValidators.validate() &&
                this.isPlaceOrderActionAllowed() === true
            ) {
                this.isPlaceOrderActionAllowed(false);

                this.getPlaceOrderDeferredObject()
                    .done(
                        function () {
                            self.afterPlaceOrder();

                            if (self.redirectAfterPlaceOrder) {
                                redirectOnSuccessAction.execute();
                            }
                        }
                    ).always(
                    function () {
                        self.isPlaceOrderActionAllowed(true);
                    }
                );

                return true;
            }

            return false;
        },

    });
});
