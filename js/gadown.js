var GA = {
    addListener: function(element, type, callback) { 
        if (element.addEventListener) {
            element.addEventListener(type, callback);
        }
        else if (element.attachEvent) {
            element.attachEvent('on' + type, callback);
        }
    },
    logAnalytics: function(doc, type) {
        var downloads = doc.getElementsByClassName(type);
        for (var i = 0; i < downloads.length; i++) {
            (function() {
                var download = downloads[i].href.split("/").splice(3, 10);
                var item = download.splice(-1, 1)[0].split(".")[0];
                var category = download.join("/");

                GA.addListener(downloads[i], 'click', function() {
                    ga('send', 'event', {
                        'eventCategory': category,
                        'eventAction': 'click',
                        'eventLabel': item,
                    });
                });
            })();
        }
    },
    logAll: function(doc) {
        GA.logAnalytics(doc, "pdf");
        GA.logAnalytics(doc, "java");
        GA.logAnalytics(doc, "zip");
        GA.logAnalytics(doc, "txt");
        GA.logAnalytics(doc, "programming-specification");
    }
};

if (typeof(jQuery) !== 'undefined') {
    jQuery(document).ready(function() {
        GA.logAll(document);
    });
}
else {
    GA.logAll(document);
}
