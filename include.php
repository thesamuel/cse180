<?php
// Print the correct page header from different contexts
// Example usage:  printHeader(".","Test");
function printHeader($dir,$title) {

    echo "<head>\n";
    echo "    <title>" . $title . "</title>\n";
    echo "    <meta name=\"viewport\" content=\"width=device-width, user-scalable=no\" />\n";
	
	// Begin Dependencies
    echo "    <link rel='stylesheet' href='//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css'>\n";
    echo "    <link href='//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.2.0/fullcalendar.css' rel='stylesheet' />\n";
    echo "    <link href='//cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.2.0/fullcalendar.print.css' rel='stylesheet' media='print' />\n";
    echo "    <link rel='stylesheet' type='text/css' href='" . $dir . "/css/prism.css' />\n";
    echo "    <link rel='stylesheet' type='text/css' href='" . $dir . "/css/style.css?v2' />\n";
    echo "    <link rel='stylesheet' type='text/css' href='" . $dir . "/css/color.css' />\n";
    echo "    <script src='//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js'></script>\n";
    echo "    <script src='//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.7.0/underscore-min.js'></script>\n";
	
	// Syntax Highlighting
	echo "    <link rel='stylesheet' href='//cdnjs.cloudflare.com/ajax/libs/highlight.js/9.12.0/styles/default.min.css'>\n";
	echo "    <script src='" . $dir . "/js/highlight.pack.js'></script>\n";
	echo "    <script>hljs.initHighlightingOnLoad();</script>\n";
	// End Syntax Highlighting
	
    echo "    <script src='" . $dir . "/js/prism.js'></script>\n";
    echo "    <script src='" . $dir . "/js/polyfill.js'></script>\n";
    echo "    <script src='" . $dir . "/js/351.js'></script>\n";
    echo "    <script src='" . $dir . "/js/moment.min.js'></script>\n";
    echo "    <script src='" . $dir . "/js/main.js?v4'></script>\n";
    echo "    <script src='" . $dir . "/js/staff.js'></script>\n";
    echo "    <script src='" . $dir . "/js/quarter.js?v4'></script>\n";
    echo "    <script src='" . $dir . "/js/exams.js'></script>\n";
    echo "    <script src='" . $dir . "/js/anchor_fix.js'></script>\n";
	// End Dependencies
    if ( strpos($_SERVER['REQUEST_URI'], 'hw') !== false || strpos($_SERVER['REQUEST_URI'], 'videos') !== false )
        echo "    <style> ol > li { margin-top: 0.8em; } </style>\n";
    echo "</head>\n";

    echo "<body>\n";
    echo "<nav class='navbar navbar-default navbar-fixed-top device-fixed-height' role='navigation'>\n";
    echo "<div class='header container'>\n";
    echo "    <div id='header'>\n";
    echo "        <div class='header-left'>\n";
    echo "            <h1 class='course'>\n";
    echo "                <a href='http://cs.washington.edu' class='cse-logo'></a>\n";
    echo "                <a href='" . $dir . "#'>CSE 351: The Hardware/Software Interface</a>\n";
    echo "            </h1>\n";
    echo "        </div>\n";
    echo "        <div class='header-right'>\n";
    echo "            <ul id='navbar'>\n";
    echo "                <li class='nav'><a href='" . $dir . "'>Home</a></li>\n";
    echo "                <li class='nav'><a href='" . $dir . "#events'>Events</a></li>\n";
    echo "                <li class='nav'><a href='" . $dir . "#contact'>Contact</a></li>\n";
    echo "                <li class='nav'><a href='" . $dir . "#staff'>Staff</a></li>\n";
    echo "                <li class='nav'><a href='" . $dir . "#schedule'>Schedule</a></li>\n";
    echo "            </ul>\n";
    echo "        </div>\n";
    echo "    </div>\n";
    echo "</div>\n";
    echo "</nav>\n\n";

    echo "<div class='content container'>\n";
    echo "    <div class='subheader'>\n";
    echo "        <script type='text/javascript'>document.write(quarter());</script>\n";
    echo "    </div>\n";
    echo "    <br>\n";
}

function printFooter($dir) {
    echo "</div>\n\n";

    echo "<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js'></script>\n";
    echo "<script src='" . $dir . "/js/gadown.js'></script>\n\n";

    echo "</body>\n";
}

?>
