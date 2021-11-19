define([
    'mage/adminhtml/grid'
], function () {
    'use strict';
    require(['jquery', 'mage/url'], function ($, url) {
        "use strict";
        $(document).on('click', '.delete', function () {
            var promotionStatus = $("input[name=promotion_enabled]").val();
            var promotion = $("input[name=promotion_id]").val();

            if (promotionStatus === '1') {
                var warningMessage = 'To delete promotion, please disable it first!';
                alert(warningMessage);

            }
            if (promotionStatus === '0') {
                jQuery.ajax({
                    url: '/admin/promotions/edit/deletepromotion',
                    type: "POST",
                    data: {
                        promotion: promotion
                    },
                    success: function (data) {
                        window.location.replace(data.redirectUrl);
                    }

                });
            }
        });
    });
});
