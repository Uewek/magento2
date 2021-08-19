    require(["jquery", 'mage/url'], function ($, url) {
        "use strict";
        $(document).on('click', '.like', function () {
            var presistentCookie = getCookieGuestKey();
            var productId = document.querySelector('input[name=product]').value
            jQuery.ajax({
                url: '/likes/index/likeproduct',
                type: "POST",
                data: {
                    productId: productId,
                    cookie_guest_key: presistentCookie
                }
            });
            document.getElementById("like").disabled = true;
            document.getElementById("like").innerHTML = "Already liked";
        });
    });

    /**
     * Get value of cookie
     *
     * @param name
     * @returns {string}
     */
    function getCookie(name) {
        let value = `; ${document.cookie}`;
        let parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
    }

    /**
     * Make string for personal cookie guest key
     *
     * @param length
     * @returns {string}
     */
    function makePresistentCookie(length) {
        let result = '';
        let characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        let charactersLength = characters.length;
        for (var i = 0; i < length; i++) {
            result += characters.charAt(Math.floor(Math.random() *
                charactersLength));
        }
        return result;
    }

    /**
     * Get cookie guest key or set and get key if not existing
     *
     * @returns {string}
     */
    function getCookieGuestKey() {
        let presistentCookie = getCookie('cookie_guest_key');
        if (presistentCookie === undefined) {
            presistentCookie = makePresistentCookie(16);
            document.cookie = "cookie_guest_key = " + presistentCookie + "; path = /; max-age=86400";
        }
        return presistentCookie;
    }
