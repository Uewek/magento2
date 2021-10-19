define([
    'mage/adminhtml/grid',
], function () {
    'use strict';
    require(['jquery', 'mage/url','uiRegistry'], function ($, url, reg) {
        "use strict";
        $(document).on('change', '.data-grid th input[type=checkbox]', function (){
            var a =  jQuery(".data-grid td input[type=checkbox]");
            var len = a.length;
            for(var i = 0; i <= len; i++) {
                var targetInputValue = $("input[name=promoted_products]").val();
                if ($(this).is(':checked')) {
                    var rowId = targetInputValue+'\"'+a[i].value+'\"'+' ';
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
            }
        });
        $(document).on('change', '.data-grid td input[type=checkbox]', function () {
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
        $(document).on('click', '.promote_products', function () {

            var productsJson = jQuery("input[name=promoted_products]").val();
            // alert(productsJson);
            var promotion = jQuery("input[name=promotion_id]").val();
            jQuery.ajax({
                url: '/admin/promotions/index/addproductstopromotion',
                type: "POST",
                data: {
                    productJson: productsJson,
                    promotion: promotion
                }
            });
            location.reload();
        });
        });

    });
