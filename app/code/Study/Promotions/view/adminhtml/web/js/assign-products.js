define([
    'mage/adminhtml/grid',
], function () {
    'use strict';
    require(['jquery', 'mage/url','uiRegistry'], function ($, url, reg) {
        "use strict";
        $(document).on('change', '.data-grid th input[type=checkbox]', function (){
            // var targetInputValue = $("input[name=promoted_products]").val();
            var a =  jQuery(".data-grid td input[type=checkbox]");
            var len = a.length;
            for(var i = 0; i < len; i++) {
                var targetInputValue = $("input[name=promoted_products]").val();
                if (a.is(':checked')) {
                    var rowId = targetInputValue+'\"'+a[i].value+'\"'+' ';
                    reg.get('index  = promoted_products').value(rowId);
                    // console.log(reg.get('index  = promoted_products').value());
                    // all good?
                }

            }
            // console.log(a.length);
        });
        $(document).on('change', '.data-grid td input[type=checkbox]', function () {
        // $(window).load(function(){
        // $(document).ready(function() {
            // debugger;
            // $("td input[type=checkbox]").on("click", function() {
            // $("td input[type=checkbox]").change(function() {
            // $("input[data-action='select-row']").change(function() {

                var targetInputValue = $("input[name=promoted_products]").val();

                if ($(this).is(':checked')) {
                    alert('yes');
                    var rowId = targetInputValue+'\"'+$(this).val()+'\"'+' ';
                    reg.get('index  = promoted_products').value(rowId);
                }
                if ($(this).is(':not(:checked')) {
                    alert('no');
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
        // $(document).on('click', '.admin__control-checkbox', function () {
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
// });
