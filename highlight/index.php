<?php
    include '../include.php';
    printHeader("..","CSE 351 -- FILE");
?>


    <div class="level-one" style="margin-bottom: -15px; margin-top: -15px;">
        <h2><span id="day-type"></span> <span id="type-num"></span></h2><br>
            Files: &nbsp; <div style="display: inline" id="slides-list"></div><br>
        Code:&nbsp; <div style="display:inline" id="code-list"></div>
        </ul>
    </div>
    <div class="level-one">
        <div class="row">
            <div class="col-md-12">
                <div id="iframe"></div>
                <pre class="line-numbers"><code id="code" class='language-java'></code><pre>
            </div>
        </div>
    </div>
    
    <script src="js/highlight.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script src="../js/gadown.js"></script>


<?php printFooter(".."); ?>
