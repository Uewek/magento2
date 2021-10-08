define([
    'mage/adminhtml/grid'
], function () {
    'use strict';
    require(['jquery', 'mage/url','uiRegistry'], function ($, url, reg) {
        "use strict";
        $(document).ready(function() {
            $('td input[type=checkbox]').change(function() {
                var targetInputValue = $("input[name=promoted_products]").val();

                if ($(this).is(':checked')) {
                    var rowId = targetInputValue+'\"'+$(this).val()+'\"'+' ';
                    reg.get('index  = promoted_products').value(rowId);
                }

                if ($(this).is(':not(:checked')) {
                    var arrayOfIds = targetInputValue.split(' ');
                    var uniqArray = arrayOfIds.reduce(function(a,b){
                        if (a.indexOf(b) < 0 ) a.push(b);
                        return a;},[]);
                    var deletedElement = uniqArray.indexOf('\"'+$(this).val()+'\"');
                    uniqArray.splice(deletedElement,1);
                    var result = uniqArray.join(' ');
                    reg.get('index  = promoted_products').value(result);
                }
            });
        });
        $(document).on('click', '.promote_products', function () {
            var productsJson = $("input[name=promoted_products]").val();
            var promotion = $("input[name=promotion_id]").val();
            document.getElementsByClassName("checkbox admin__control-checkbox").checked = false
            jQuery.ajax({
                url: '/admin/promotions/index/addproductstopromotion',
                type: "POST",
                data: {
                    productJson: productsJson,
                    promotion: promotion
                }
            });
        });
    });
});
