/** 332-Specific Plug-ins for Course Website 
 *  @author Adam Blank
 */

if (jQuery.when.all===undefined) {
    jQuery.when.all = function(deferreds) {
        var deferred = new jQuery.Deferred();
        $.when.apply(jQuery, deferreds).then(
            function() {
                deferred.resolve(Array.prototype.slice.call(arguments));
            },
            function() {
                deferred.fail(Array.prototype.slice.call(arguments));
            });

        return deferred;
    }
}

(function() {
    $(document).ready(function() {
        Course.programmingHWTitle = function(name, title) {
            return name.toUpperCase() + ": " + title;
        }

        Course.installPopovers = function() {
            Course.popover(
                'a.programming-files', 
                function(number, title) { return title; },
                function(number) { return "homework/" + number + "/files.html"; },
                "This homework is not uploaded yet.  Check back later!",
                function(late) {
                    return late === "default" ? "2" : parseInt(late);
                },
                function(number, diff) {
                    return '<a class="external" href="https://gitlab.cs.washington.edu/cse332-' + qtr() + '/' + number + '/tree/master">See <samp>gitlab</samp></a>.'
                }
            );

            Course.popover(
                'a.section-homework', 
                function(number, _, due) { 
                    var today = moment().startOf('day');
                    return "Section " + number + " Warm-Up" +
                    (today.diff(due) > 0 ? " Solutions" : ""); },
                function(number, due) {
                    var today = moment().startOf('day');
                    if (today.diff(due) > 0) {
                        return "sections/" + number + ".solutions";
                    }
                    else {
                        return "sections/" + number + ".section";
                    }
                },
                "This is not uploaded yet.  Check back later!"
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
