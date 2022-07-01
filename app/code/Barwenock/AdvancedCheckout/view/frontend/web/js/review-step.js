define(
    [
        'jquery',
        'ko',
        'uiComponent',
        'underscore',
        'Magento_Checkout/js/model/step-navigator',
        'mage/translate'
    ],
    function (
        $,
        ko,
        Component,
        _,
        stepNavigator,
        $t
    ) {
        'use strict';
        return Component.extend({
            defaults: {
                template: 'Barwenock_AdvancedCheckout/reviewInfo'
            },

            //add here your logic to display step,
            isVisible: ko.observable(false),
            //isCustomerLoggedIn: customer.isLoggedIn,
            //totals: quote.getTotals(),
            /**
             *
             * @returns {*}
             */
            initialize: function () {
                this._super();
                // register your step

                stepNavigator.registerStep(
                    'review_info', //step_code will be used as component template html file <li> id
                    null,
                    $t('Review & Place Order'),
                    //observable property with logic when display step or hide step
                    this.isVisible,
                    //navigate function call from below
                    _.bind(this.navigate, this),
                    /**
                     * sort order value
                     * 'sort order value' < 10: step displays before shipping step (first step);
                     * 10 < 'sort order value' < 20 : step displays between shipping and payment step
                     * 'sort order value' > 20 : step displays after payment step at the end.(last step)
                     */
                    30
                );
                $('#checkout').addClass('customer-step');
                return this;
            },

            /**
             * The navigate() method is responsible for navigation between checkout step
             * during checkout. You can add custom logic, for example some conditions
             * for switching to your custom step
             *
             * when directly refresh page with #review_info code below function call
             */
            navigate: function () {
                var self = this;
                self.isVisible(true);
                //window.location = window.checkoutConfig.checkoutUrl + "#payment";
            },

            /**
             * @returns void
             */
            navigateToNextStep: function () {
                stepNavigator.next();
            },

            placeorder: function(){
                console.log('revieworder');
                $('.payment-method._active .primary button.checkout').trigger('click');
            },

            back: function() {
                stepNavigator.navigateTo('shipping');
            },
            backbilling: function() {
                $('.payment-method._active .primary button.checkout').removeClass("disabled");
                stepNavigator.navigateTo('payment');
            },
        });
    }
);
