
define([
    'mage/adminhtml/grid'
], function () {
    'use strict';
    require(["jquery", 'mage/url'], function ($, url) {
        "use strict";
        $(document).on('click', '.promote_products', function () {
            var productsJson = document.querySelector('input[name=rh_products]').value
            var promotion = document.querySelector(' input[name=promotion_id]').value;
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

    // $(document).on('click', '#save', function () {
    //     alert('fuhghfrdg');
    //     var productsJson = document.querySelector('input[name=rh_products]').value
    //     jQuery.ajax({
    //         url: 'admin/promotions/index/createnewpromotion',
    //         type: "POST",
    //         data: {
    //             productJson: productsJson,
    //         }
    //     });
    //
    // });
    return function (config) {
        var selectedProducts = config.selectedProducts,
            categoryProducts = $H(selectedProducts),
            gridJsObject = window[config.gridJsObjectName],
            tabIndex = 1000;
        /**
         * Show selected product when edit form in associated product grid
         */
        $('rh_products').value = Object.toJSON(categoryProducts);
        /**
         * Register Category Product
         *
         * @param {Object} grid
         * @param {Object} element
         * @param {Boolean} checked
         */
        function registerCategoryProduct(grid, element, checked) {
            if (checked) {
                if (element.positionElement) {
                    element.positionElement.disabled = false;
                    categoryProducts.set(element.value, element.positionElement.value);
                }
            } else {
                if (element.positionElement) {
                    element.positionElement.disabled = true;
                }
                categoryProducts.unset(element.value);
            }
            $('rh_products').value = Object.toJSON(categoryProducts);
            grid.reloadParams = {
                'selected_products[]': categoryProducts.keys()
            };
        }

        /**
         * Click on product row
         *
         * @param {Object} grid
         * @param {String} event
         */
        function categoryProductRowClick(grid, event) {
            var trElement = Event.findElement(event, 'tr'),
                isInput = Event.element(event).tagName === 'INPUT',
                checked = false,
                checkbox = null;

            if (trElement) {
                checkbox = Element.getElementsBySelector(trElement, 'input');

                if (checkbox[0]) {
                    checked = isInput ? checkbox[0].checked : !checkbox[0].checked;
                    gridJsObject.setCheckboxChecked(checkbox[0], checked);
                }
            }
        }

        /**
         * Change product position
         *
         * @param {String} event
         */
        function positionChange(event) {
            var element = Event.element(event);

            if (element && element.checkboxElement && element.checkboxElement.checked) {
                categoryProducts.set(element.checkboxElement.value, element.value);
                $('rh_products').value = Object.toJSON(categoryProducts);
            }
        }

        /**
         * Initialize category product row
         *
         * @param {Object} grid
         * @param {String} row
         */
        function categoryProductRowInit(grid, row) {
            var checkbox = $(row).getElementsByClassName('checkbox')[0],
                position = $(row).getElementsByClassName('input-text')[0];

            if (checkbox && position) {
                checkbox.positionElement = position;
                position.checkboxElement = checkbox;
                position.disabled = !checkbox.checked;
                position.tabIndex = tabIndex++;
                Event.observe(position, 'keyup', positionChange);
            }
        }

        gridJsObject.rowClickCallback = categoryProductRowClick;
        gridJsObject.initRowCallback = categoryProductRowInit;
        gridJsObject.checkboxCheckCallback = registerCategoryProduct;

        if (gridJsObject.rows) {
            gridJsObject.rows.each(function (row) {
                categoryProductRowInit(gridJsObject, row);
            });
        }
    };
});