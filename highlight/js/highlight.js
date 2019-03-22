/* Display Code Automatically Highlighted 
 * @author Adam Blank
 */
(function() {
    /* Small Polyfill, because safari is stupid... */
    if (!String.prototype.endsWith) {
      String.prototype.endsWith = function(searchString, position) {
          var subjectString = this.toString();
          if (position === undefined || position > subjectString.length) {
            position = subjectString.length;
          }
          position -= searchString.length;
          var lastIndex = subjectString.indexOf(searchString, position);
          return lastIndex !== -1 && lastIndex === position;
      };
    }

    var $code = $("#code");
    $code.next().remove();
    
    var $iframe = $("#iframe");
    
    function loadLecture(lecture, file) {
        var $slides = $("#slides-list");
        $slides.html('<div class="loader">Loading...</div>');
        $.get( "../lectures/" + lecture, function(files) {
            $slides.attr("lecture", lecture);
            $slides.html(files);
            Course.updateSlides("#slides-list .slides ul", "../");
            Course.forceExternal();
        });
        var $codelist = $("#code-list");
        $codelist.html('<div class="loader">Loading...</div>');
        $.get( "../lectures/" + lecture + "/code", function(files) {
            var $code = $("#code-list");
            $code.attr("lecture", lecture);
            $code.html(files);
            var $codesl = $($code.children()[0]);
            $codesl.attr("class", $codesl.attr("class") + " slides");
            Course.updateCode("#code-list .code ul", "../");
            $codesl.children("ul").children(".code-space").remove();
            //Course.forceExternal();
           
            $(document).ready(function() {
                $("#code-list .code ul li a").each(function(_, x) {
                    if ($(x).text() === file) {
                        $(x).attr("style", "font-weight: 800; pointer-events: none");
                    }
                }); 
            });
            Course.replaceCodeDownloadLinks('.code-download', '../');
        });
    }


    function loadDay(type, num, file) {
        var $slides = $("#slides-list");
        $slides.html('<div class="loader">Loading...</div>');
        $.get( "../" + type + "s/" + num, function(files) {
            $slides.attr(type, num);
            $slides.html(files);
            Course.updateSlides("#slides-list .slides ul", "../");
            Course.forceExternal();
        });
        var $codelist = $("#code-list");
        $codelist.html('<div class="loader">Loading...</div>');
        $.get( "../" + type + "s/" + num + "/code", function(files) {
            var $code = $("#code-list");
            $code.attr(type, num);
            $code.html(files);
            var $codesl = $($code.children()[0]);
            $codesl.attr("class", $codesl.attr("class") + " slides");
            Course.updateCode("#code-list .code ul", "../");
            $codesl.children("ul").children(".code-space").remove();
            //Course.forceExternal();
           
            $(document).ready(function() {
                $("#code-list .code ul li a").each(function(_, x) {
                    if ($(x).text() === file) {
                        $(x).attr("style", "font-weight: 800; pointer-events: none");
                    }
                }); 
            });
            Course.replaceCodeDownloadLinks('.code-download', '../');
        });
    }

    function loadCode(type, num, file) {
        $("title").text("CSE351: " + file + " (" + type + " " + num + ")"); 
        $("#day-type").text(type.substr(0,1).toUpperCase() + type.substr(1));
        $("#type-num").text(num);
        if (file.endsWith(".zip") || file.endsWith(".pdf")) {
            $code.parent().hide();
            $iframe.hide();
            window.open("../" + type + "s/" + num + "/code/" + file, '_blank');
        }
        else if (file.endsWith(".html")) {
            $code.parent().hide();
            $iframe.show();
            $iframe.html('<iframe frameborder=0 width="100%" height="100%" src="' + '../' + type + 's/' + num + '/code/' + file + '"></iframe>');
            $(document).ready(function() {
                $('#iframe iframe').on('load', function(){
                    this.style.height=this.contentDocument.body.scrollHeight +'px';
                });
            });
        }
        else {
            $code.parent().show();
            $iframe.hide();
            $.get("../" + type + "s/" + num + "/code/" + file, function(source) {
                $("#dl-btn").remove();
                $code.text(source);
                Prism.highlightElement($code[0]);
                $code.parent().prepend('<button id="dl-btn" class="btn btn-default"></button>');
                $("#dl-btn").attr("style", "position: absolute; top: 0px; right: 0px; z-index: 1000");
                $("#dl-btn").html('<span class="glyphicon glyphicon-download" aria-hidden="true"></span>&nbsp;<span>Download (' + file + ')</span>');
                $("#dl-btn").click(function() {
                    window.location.href = "../" + type + "s/" + num + "/code/" + file;
                });
        
                Course.replaceCodeDownloadLinks('.code-download', '../');
            }).fail(function() {
                window.location.href = "../" + type + "s/" + num + "/code/" + file;
            });
        }
    }

    Course.onHash = function() {
        var hash = location.href.substr(location.href.indexOf('#')+1);
        var pieces = hash.split("/");
        var type, num, file;
        for (var i = 0; i < pieces.length; i++) {
            if (pieces[i] === "lectures" || pieces[i] === "sections") {
                type = pieces[i];
                type = type.substring(0, type.length-1);
                num = pieces[i+1];
            }
            else if (pieces[i] === "code") {
                file = pieces[i+1];
            }
        }
 
        var $code = $("#code");
        $code.children().detach().remove();
        $code.html('<div class="loader">Loading...</div>');
        $(document).ready(function() {
            loadCode(type, num, file);
            //loadLecture(lecture, file); 
            loadDay(type, num, file); 
            /*
            $(".code-download").each(function(_, x) {
                $(x).attr("target", "_self");
            });
            */
            Course.replaceCodeDownloadLinks('.code-download', '../');
        });
    }

    $(window).bind('hashchange', Course.onHash);
})();
