/** 143-Specific Plug-ins for Course Website 
 *  @author Adam Blank
 */

(function() {
    $(document).ready(function() {
        $('.practice-it').each(function(_, qc) {
            var $qc = $(qc);
            var category = $qc.attr("category");
            var problem = $qc.attr("problem");
            var title = $qc.attr("title");
            var hide = $qc.attr("hide");
            if (hide !== undefined) {
                $qc.attr("style", "display: none");
            }

            var link = $("<a>", {
                href: "http://practiceit.cs.washington.edu/problem.jsp?category=" + category + "&" +
                                                                      "problem=" + problem,
                class: "external",
                html: "<samp>" + title + "</samp>"
            });

            $qc.append(link);
        });

        $('div.videos').each(function(_, video) {
            var $video = $(video);
            var lectureNumber = $video.parent().attr("lecture");
            $video.children('a').each(function(num, vid) {
                var $vid = $(vid);
                if (num !== 0) {
                    $vid.before('<div style="margin-left: -3px; padding-right: 4px; display: inline-block">, </div>');
                }
                var vidid = $vid.attr("videoid");
                $vid.addClass("external");
                $vid.attr("href", "http://media.pearsoncmg.com/aw/aw_reges_bjp_2/videoPlayer.php?id=" + vidid);
            });
        }); 

        Course.programmingHWTitle = function(name, title) {
            return "HW" + name + ": " + title;
        }

        Course.programmingTurnin = function(name) {
            var id = "a" + name;
            if (id === "aEC") { id = "a9"; }
            return "<a href='" +
                        make_url("https://gradeit.cs.washington.edu/uwcse/turnin/code/turnin_page_view.php?" +
                                  "course=143&assignment=" + id + "&quarter=") +
                        "' target='_blank' " + 
                    "class='btn btn-xs btn-default programming-turnin' number='" + name + "'>" +
                        "<span class='glyphicon glyphicon-upload'></span> TurnIn" +
                    "</a>";
        }

        Course.installPopovers = function() {
            Course.popover(
                'a.programming-files', 
                function(number, title) { return title; },
                function(number) { return "homework/" + number + "/files.html"; },
                "This homework is not uploaded yet.  Check back later!",
                function(late) {
                    return late === "default" ? "3" : parseInt(late);
                },
                function(number, diff) {
                    var any = diff;
                    return (any ? ('<li class="list-group-item">' +
                           '<h4>Check Your Output</h4>' +
                           '<ul class="homework-files">' + (diff ? 
                           '<li class="diff-tool"><a target="_blank" href="diff#' + number + 
                           '"><span class="glyphicon glyphicon-tasks"></span> Output Comparison Tool</a></li>' : "") +
                           '</ul></li>') : "") + '</ul></div>'
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
