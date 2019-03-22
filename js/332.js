/** 332-Specific Plug-ins for Course Website 
 *  @author Adam Blank
 */

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
                    return '';//<a class="external" href="https://gitlab.cs.washington.edu/cse332-' + qtr() + '/' + number + '/tree/master">See <samp>gitlab</samp></a>.'
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

            $('.checkpoint[notready]').css({'pointer-events': 'none',  'cursor': 'default'});
            $('.checkpoint[notready] a').css({'color': '#ddd'});
        }
    });
})();


var CSE332 =  {};
CSE332.ckpt = function(id, url) {
    document.write(
    '<div class="modal fade" id="' + id + '-modal" tabindex="-100000" role="dialog" aria-labelledby="ckpt-label">' +
    '  <div class="modal-dialog" role="document">' +
    '    <div class="modal-content" style="max-width: 904px">' +
    '      <div class="modal-header">' +
    '        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>' +
    '        <h4 class="modal-title" id="ckpt-label">' +
    '            Checkpoint Schedule (Updates Every Five Minutes)' +
    '            <h5>' +
    '                <center>' +
    '                    <a target="_blank" href="https://grinch.cs.washington.edu/cse332/ckpt">Click Here To Sign Up For A Checkpoint Time</a>' +
    '                </center>' +
    '            </h5>' +
    '            <div style="margin-top: -10px"></div>' +
    '        </h4>' +
    '      </div>' +
    '      <div class="modal-body" style="max-height: 636px">' +
    '        <iframe frameborder=0 style="width: 100%; height: 100%" src="https://docs.google.com/spreadsheets/d/' + url +
    '/pubhtml?gid=0&gridlines=false&single=true&widget=false&chrome=false&headers=false&footers=false"></iframe>' +
    '      </div>' +
    '    </div>' +
    '  </div>' +
    '</div>');
}

