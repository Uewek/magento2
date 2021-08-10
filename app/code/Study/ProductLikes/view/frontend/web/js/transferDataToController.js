// debugger;
let presistentCookie = getCookie('cookie_guest_key');
console.log(presistentCookie);
if(presistentCookie === undefined){
     presistentCookie = makePresistentCookie(16);
    document.cookie = "cookie_guest_key = "+presistentCookie+"; path = /; max-age=86400";
}
var productId = document.querySelector('input[name=product]').value


require(["jquery",'mage/url'], function($, url){
    "use strict";
    $(document).on('click','.like',function(){
        alert("button working");
        // debugger;
        jQuery.ajax({
            url: '/likes/index/likeproduct',
            type: "POST",
            data: {
                productId:productId ,
                cookie_guest_key: presistentCookie
    }
    });
    });
});

function getCookie(name) {
    const value = `; ${document.cookie}`;
    const parts = value.split(`; ${name}=`);
    if (parts.length === 2) return parts.pop().split(';').shift();
}

function makePresistentCookie(length) {
    var result           = '';
    var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    var charactersLength = characters.length;
    for ( var i = 0; i < length; i++ ) {
        result += characters.charAt(Math.floor(Math.random() *
            charactersLength));
    }
    return result;
}
