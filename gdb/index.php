<?php
    include '../include.php';
    printHeader("..","CSE 351 GDB");
?>


    <h2>GDB (Gnu DeBugger)</h2>


    <p class="afterh">GDB is an immensely useful tool to help you debug your C and assembly programs.</p>
    <ul class="afterh">
        <li>It lets you insert <i>breakpoints</i> into your programs so that you can stop execution and examine the contents of memory and registers.</li>
        <li>It supports single-stepping your program one line of source code at a time.</li>
        <li>It leads to much more productive debugging than just using print statements (e.g. <code>printf</code>).</li>
    </ul>
    <p>The time you spend getting familiar with GDB will be an excellent investment.</p>


    <div class="unspace"></div>

    <section id="resources"><br>
    <div class="panel panel-default">
        <div class="panel-heading"><h3>Resources</h3></div>
        <div class="panel-body">

            <ul>
                <li><a class="external" href="gdbnotes-x86-64.pdf"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_pdf.gif"/> GDB cheat sheet</button></a>
                <ul>
                    <li>A handy dandy guide to the most commonly used GDB commands.
                        Useful to have open while using GDB (and going through the other resources here).</li>
                </ul></li>
                <li class="afterh"><a href="../../videos/tutorials/gdb.mp4"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_vid.png"/> Intro to GDB</button></a>
                <ul>
                    <li>This very useful video shows you how to get started with GDB.</li>
                </ul></li>
                <li class="afterh"><a class="external" href="http://heather.cs.ucdavis.edu/~matloff/UnixAndC/CLanguage/Debug.html"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_html.gif"/> Extensive tutorial</button></a>
                <ul>
                    <li>Looking for more details?
                        Find them here thanks to Norman Matloff at UC Davis.</li>
                </ul></li>
            </ul>
        </div>
    </div>
    </section>


    <div class="unspacepanel"></div>

    <section id="examples"><br>
    <div class="panel panel-default">
        <div class="panel-heading"><h3>Examples</h3></div>
        <div class="panel-body">

            <p>Here are some code samples for playing with GDB along with some example commands you can try:</p>

            <ul class="afterh">
                <li><a class="external" href="gdb_example.c"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_c.gif"/> Array example</button></a>
                    and typical GDB <a class="external" href="gdb_commands_example.txt"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_txt.gif"/> commands</button></a>
                </li>
                <li class="afterh"><a class="external" href="tiny_linked_list.c"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_c.gif"/> Linked list example</button></a>
                    and typical GDB <a class="external" href="gdb_linked_list.txt"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_txt.gif"/> commands</button></a>
                </li>
            </ul>

        </div>
    </div>
    </section>


    <div class="unspacepanel"></div>

    <section id="tui"><br>
    <div class="panel panel-default">
        <div class="panel-heading"><h3>Text User Interface</h3></div>
        <div class="panel-body">

            <p>Text User Interface (TUI) mode of GDB can nicely show your code and the value of registers as you debug!
               <br><em>Its use is entirely optional for 351</em>, but we wanted you to be aware of it as it may help some of you.</p>

            <ul>
                <li><a class="external" href="https://sourceware.org/gdb/onlinedocs/gdb/TUI-Commands.html"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_html.gif"/> TUI Commands</button></a></li>
            </ul>

            <h4>Opening TUI Mode</h4>
            <p class="afterh">Most TUI commands will automatically start TUI mode, but you can also explicitly open GDB in TUI mode using:</p>
<pre>[attu]$ gdb -tui &lt;filename&gt;</pre>

            <h4>Layout Views</h4>
            <p class="afterh">Of particular interest, you can bring up the disassembly and registers view using:</p>
<pre>(gdb) layout asm
(gdb) layout regs</pre>
            <p>Note that you want to do them <em>in that order</em> so that the registers window is on top.
               Then as you execute instructions (<code>stepi</code> or <code>si</code> for assembly instructions), the assembly view will highlight the <em>next</em> instruction (not executed yet) and the registers view will highlight any changed registers.</p>

            <h4>Formatting Issues</h4>
            <p class="afterh">Unfortunately, there are some annoying formatting issues that sometimes pop up while using TUI mode.
               If things start to look weird, run the following command to set things straight:</p>
<pre>(gdb) refresh</pre>

        </div>
    </div>
    </section>


<?php printFooter(".."); ?>
