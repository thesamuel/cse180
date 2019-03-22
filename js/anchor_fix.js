/** Fixes Anchor Links on Chrome
 *  @author Parker DeWilde
 *  https://stackoverflow.com/questions/38588346/anchor-a-tags-not-working-in-chrome-when-using
 */


$(document).ready(function () {
        var isChrome = /Chrome/.test(navigator.userAgent) && /Google Inc/.test(navigator.vendor);
        if (window.location.hash && isChrome) {
            setTimeout(function () {
                var hash = window.location.hash;
                window.location.hash = "";
                window.location.hash = hash;
            }, 300);
        }
    });