/** 351-Specific Plug-ins for Course Website 
 *  @author Adam Blank
 *  @author Justin Hsia
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
 
(function() {
    $(document).ready(function() { console.log("1");
        Course.programmingHWTitle = function(name, title) {
            return title;
        }

        Course.installPopovers = function() {
            Course.popover(
                'a.programming-files', 
                function(number, title) {return title; },
                function(number) { return "homework/" + number + "/files.html"; },
                "This homework is not uploaded yet.  Check back later!",
                function(late) {
                    return late === "default" ? "2" : parseInt(late);
                },
                function(number, diff) {
                    return '';//<a class="external" href="https://gitlab.cs.washington.edu/cse332-' + qtr() + '/' + number + '/tree/master">See <samp>gitlab</samp></a>.'
                }
            );

            $('html').click(function(e) {
                if ($(e.toElement).parents(".popover").length == 0) {
                    $('a.section-homework').popover('hide');
                    $('a.programming-files').popover('hide');
                }
            });
        }
    });
})();


$(document).ready(function() {
    Course.$('div.practice-exam')});

