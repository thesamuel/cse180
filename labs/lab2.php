<?php
    include '../include.php';
    printHeader("..","CSE 351 Lab 2");
?>


<a name="info"></a>
<div class="panel panel-default">
    <div class="panel-heading"><h2>Lab 2: Disassembling and Defusing a Binary Bomb</h2></div>
    <div class="panel-body">
        <div class="exam-listing">
            <div class="exam-name topic">Assigned</div>
            Tuesday, October 17, 2017
        </div>
        <div class="exam-listing">
            <div class="exam-name topic">Due Date</div>
            <em>Friday, October 27, 2017 at 11:59pm</em>
        </div>
        <div class="exam-listing">
            <div class="exam-name topic">Video(s)</div>
            You may find <a href="../../videos/tutorials/gdb.mp4"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_vid.png"/> this video</button></a> <a href="https://www.youtube.com/watch?v=0f8VZBaMj0I"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_yt.png"/> (with captions)</button></a> helpful for getting started with the lab.
        </div>
    </div>
</div>


<a name="overview"></a>
<div class="panel panel-default">
    <div class="panel-heading"><h3>Overview</h3></div>
    <div class="panel-body">
        <b>Learning Objectives:</b>
        <ul>
            <li>Gain basic familiarity with x86-64 assembly instructions and how they are used to implement comparison, loops, switch statements, recursion, pointers, and arrays.</li>
            <li>Gain experience using the <code>gdb</code> debugger to step through assembly code and other tools such as <code>objdump</code>.</li>
        </ul>
        <p>
        The nefarious <a href="https://upload.wikimedia.org/wikipedia/en/1/16/Drevil_million_dollars.jpg">Dr. Evil</a> has planted a slew of "binary bombs" on our machines.
        A binary bomb is a program that consists of a sequence of phases.
        Each phase expects you to type a particular string on <code>stdin</code> (standard input).
        If you type the correct string, then the phase is defused and the bomb proceeds to the next phase.
        Otherwise, the bomb explodes by printing "<code>BOOM!!!</code>" and then terminating.
        The bomb is defused when every phase has been defused.</p>

        <p>There are too many bombs for us to deal with, so we are giving everyone a bomb to defuse.
        Your mission, which you have no choice but to accept, is to defuse your bomb before the due date.
        Good luck, and welcome to the bomb squad!</p>
    </div>
</div>


<a name="code"></a>
<div class="panel panel-default">
    <div class="panel-heading"><h3>Code for this lab</h3></div>
    <div class="panel-body">
        <p style="color:red; font-style:italic;">Everyone gets a different bomb to diffuse!<br>
        Substitute <code>&lt;username&gt;</code> in the URL below with your UWNetID in order to find yours.</p>
        <div class="exam-listing">
            <div class="exam-name topic">Terminal</div>
            <b>NOT SUPPORTED, 'wget' command will NOT work</b>
        </div>
	<div class="exam-listing">
            <div class="exam-name topic">Direct Download</div>
            Go to <code>https://courses.cs.washington.edu/courses/cse351/17au/uwnetid/&lt;username&gt;/lab2-bomb.tar</code> in a web browser and <code>lab2-bomb.tar</code> will be downloaded
        </div>
	<div class="exam-listing">
            <div class="exam-name topic">Attu Users</div>
            Download the tar file onto your local machine and the use scp to move the file to attu (use the scp command on terminal for Mac and Linux users and Windows with bash users; for a user interface use WinSCP on Windows and Cyberduck on Mac). <br/> For help on scp, visit <code>https://courses.cs.washington.edu/courses/cse391/16au/handouts/MovingAndEditingFiles_12sp.pdf</code>
	</div>
        <div class="exam-listing">
            <div class="exam-name topic">Unzip</div>
            Running <code>tar xvf lab2-bomb.tar</code> from the terminal in the directory where <code>lab2-bomb.tar</code> is located will extract the lab files to a directory called <code>bomb$NUM</code> (where $NUM is the ID of your bomb) with the following files:
            <ul>
                <li><code>bomb</code> - The executable binary bomb</li>
                <li><code>bomb.c</code> - Source file with the bomb's main routine</li>
                <li><code>defuser.txt</code> - File in which you write your defusing solution</li>
                <li><code>lab2reflect.txt</code> - File for your Reflection answers</li>
            </ul>
        </div>
    </div>
</div>



<a name="inst"></a>
<div class="panel panel-default">
    <div class="panel-heading"><h3>Lab 2 Instructions</h3></div>
    <div class="panel-body">
    
<p>You should do this assignment on a 64-bit CSE Linux VM or a CSE lab Linux machine or on attu.
<span style="color: red;">Be sure to test your solution on one of those platforms before submitting it, to make sure it works when we grade it!</span>
In fact, there is a rumor that Dr. Evil has ensured the bomb
will always blow up if run elsewhere.
There are several other tamper-proofing devices built into the
bomb as well, or so they say.</p>


<p>Your job is to find to correct strings to defuse the bomb. Look at the <a href="#tools">Tools</a> section for ideas and tools to use. Two of the best ways are to (a) use a debugger to step through the disassembled binary and (b) print out the disassembled code and step through it by hand.</p>

<p>The bomb has 5 regular phases. The 6th phase is extra credit,
and rumor has it that a secret 7th phase exists.
If it does and you can find and defuse it, you will receive additional
extra credit points.
The phases get progressively harder to defuse, but the expertise you
gain as you move from phase to phase should offset this difficulty.
Nonetheless, the latter phases are not easy, so <span style="color:red;">please don't wait
until the last minute to start!</span>
(If you're stumped, check the <a href="#hints">Hints</a> section at the end of this document.)</p>

<p>The bomb ignores blank input lines. If you run your bomb with a command line argument, for example,</p>

<pre>
./bomb defuser.txt
</pre>

<p>then it will read the input lines from <code>defuser.txt</code>
until it reaches EOF (end of file), and then switch over to stdin
(standard input from the terminal).
In a moment of weakness, Dr. Evil added this feature so you don't
have to keep retyping the solutions to phases you have already
defused, instead you can put them in <code>defuser.txt</code>.</p>

<p>To avoid accidentally detonating the bomb, you will need to learn
how to single-step through the assembly code in <code>gdb</code> and
how to set breakpoints.
You will also need to learn how to inspect both the registers and
the memory states.
One of the nice side-effects of doing the lab is that you will get
very good at using a debugger.
This is a crucial skill that will pay big dividends the rest of your
career.</p>

<hr>
<div class="unspacesection"></div>
<section id="Resources"><br>
<h3>Resources</h3>

<p class="afterh">There are many online resources that will help you
understand any assembly instructions you may encounter. In particular, the instruction references for x86-64 processors
distributed by Intel and AMD are exceptionally valuable. They both
describe the same ISA, but sometimes one may be easier to understand
than the other.</p>

<h4>Useful for this Lab</h4>

<p class="afterh"><b>Important Note:</b> The instruction format used in these manuals is known as &ldquo;Intel format&rdquo;.
This format is <b>very different</b> than the format used in our text,
in lecture slides, and in what is produced by <code>gcc</code>,
<code>objdump</code> and other tools (which is known as &ldquo;AT&amp;T
format&rdquo;.
You can read more about these differences in our textbook (p.177) or on
<a href="https://en.wikipedia.org/wiki/X86_assembly_language#Syntax">Wikipedia</a>.
<b>The biggest difference is that the order of operands is SWITCHED.</b>
This also serves as a warning that you may see both formats come up in
web searches.</p>

<ul>
    <li><a href="http://download.intel.com/products/processor/manual/325383.pdf" target="_blank">Intel Instruction Reference</a></li>
    <li><a href="http://developer.amd.com/wordpress/media/2008/10/24594_APM_v3.pdf" target="_blank">AMD Instruction Reference</a></li>
</ul>

<h4>Not Directly Useful, but Good Brainfood Nonetheless</h4>

<ul class="afterh">
    <li><a href="http://download.intel.com/products/processor/manual/253665.pdf" target="_blank">Intel 64 and IA-32 Architectures Software Developer's Manual
Volume 1: Basic Architecture</a></li>
    <li><a href="http://download.intel.com/products/processor/manual/325384.pdf" target="_blank">Intel 64 and IA-32 Architectures Software Developer's Manual
Combined Volumes 3A and 3B: System Programming Guide, Parts 1 and 2</a></li>
    <li><a href="http://developer.amd.com/wordpress/media/2012/10/24592_APM_v11.pdf" target="_blank">AMD64 Architecture Programmer&#39;s Manual Volume 1: Application Programming</a></li>
    <li><a href="http://developer.amd.com/wordpress/media/2012/10/24593_APM_v21.pdf" target="_blank">AMD64 Architecture Programmer&#39;s Manual Volume 2: System Programming</a></li>
    <li><a href="http://developer.amd.com/wordpress/media/2012/10/26568_APM_v41.pdf" target="_blank">AMD64 Architecture Programmer&#39;s Manual Volume 4: 128-bit and 256 bit media instructions</a></li>
    <li><a href="http://developer.amd.com/wordpress/media/2012/10/26569_APM_v51.pdf" target="_blank">AMD64 Architecture Programmer&#39;s Manual Volume 5: 64-Bit Media and x87 Floating-Point Instructions</a></li>
</ul>

<h4>x86-64 Calling Conventions</h4>

<p class="afterh">The x86-64 ISA passes the first six arguments to a function in
registers. Registers are used in the following
order: <code>rdi</code>, <code>rsi</code>, <code>rdx</code>, <code>rcx</code>, <code>r8</code>, <code>r9</code>. The
return value for functions is passed in <code>rax</code>.</p>

<h4>Using sscanf</h4>

<p class="afterh"> It will be helpful to first familiarize yourself with <code>scanf</code> ("scan format"), which reads in data
from stdin (the keyboard) stores it according to the parameter format into the 
locations pointed to by the additional arguments:
<code><pre>int i;
printf("Enter a number: ");
scanf("%d", &amp;i);</pre></code>
<ul><li> The <code>printf</code> prints a prompt, once the user enters in a number and hits enter
    <code>scanf</code> will store the input from stdin into <code>i</code> with the format of an integer. Notice
    how <code>scanf</code> uses the address of <code>i</code> as the argument.</li></ul>
Lab 2 uses <code>sscanf</code> ("string scan format"), which is similiar to <code>scanf</code> but rather than read in data
from stdin it parses a string that is provided as an argument:
<pre><code>char *mystring = "123, 456"
int a, b;
sscanf(mystring, "%d, %d", &amp;a, &amp;b);
</pre></code><ul><li>The first argument, <code>mystring</code>, is parsed according to the format string, <code>"%d, %d"</code>.</li>
<li>After this code is run, <code>a = 123</code> and <code>b = 456</code>.</li></ul>

<h4>Documentation for sscanf, scanf, and printf</h4>

<ul class="afterh">
    <li><a href="http://www.cplusplus.com/reference/cstdio/sscanf/">sscanf</a></li>
    <li><a href="http://www.cplusplus.com/reference/cstdio/scanf/">scanf</a></li>
    <li><a href="http://www.cplusplus.com/reference/cstdio/printf/">printf</a></li>
</ul>
</section>
<hr>

<div class="unspacesection"></div>

<section id="tools"><br>
<h3>Tools (Read This!!)</h3>

<p class="afterh">There are many ways of defusing your bomb. You can print out the
assembly and examine it in great detail without ever running the
program, and figure out exactly what it does. This is a useful
technique, but it not always easy to do. You can also run it under a
debugger, watch what it does step by step, and use this information to
defuse it. Both are useful skills to develop.</p>

<p>We do make one request, please do not use brute force! You could
write a program that will try every possible key to find the right
one, but the number of possibilities is so large that you won't be
able to try them all in time.</p>

<p>There are many tools which are designed to help you figure out both
how programs work, and what is wrong when they don't work. Here is a
list of some of the tools you may find useful in analyzing your bomb,
and hints on how to use them.</p>

<ul>
  <li><code>gdb</code>: The GNU debugger is a command line debugger
  tool available on virtually every platform. You can trace through a
  program line by line, examine memory and registers, look at both the
  source code and assembly code (we are not giving you the source code
  for most of your bomb), set breakpoints, set memory watch points,
  and write scripts. Here are some tips for using <code>gdb</code>.
    <ul>
      <li>To keep the bomb from blowing up every time you type in a
      wrong input, you'll want to learn how to set breakpoints.</li>
      <li>The CS:APP Student Site has a very handy <a href="http://csapp.cs.cmu.edu/public/docs/gdbnotes-x86-64.pdf"single-page <code>gdb</code> summary</a> (there is also a <a href="http://heather.cs.ucdavis.edu/~matloff/UnixAndC/CLanguage/Debug.html">more extensive tutorial</a>).</li>
      <li>For other documentation, type <code>help</code> at
      the <code>gdb</code> command prompt, or type <code>man
      gdb</code>, or <code>info gdb</code>; at a Unix prompt. Some people
      also like to run <code>gdb</code> under gdb-mode in emacs</li>
      </ul></li>

  <li><code>objdump -t bomb > bomb_symtab</code>: This will print out the bomb's
symbol table into a file called <code>bomb_symtab</code>. The symbol table includes the names of all functions
  and global variables in the bomb, the names of all the functions the
  bomb calls, and their addresses. You may learn something by looking
  at the function names!</li>

  <li><code>objdump -d bomb > bomb_disas</code>: Use this to disassemble all of the
    code in the bomb into a file called <code>bomb_disas</code>. You can also just look at individual
  functions. If you would like to print out the assembly you can use this command from a linux machine in the CSE lab (or attu) to print to the printer in 002 in two column, two-sided format:
<pre>
enscript -h -2r -Pps002 -DDuplex:true bomb_disas
</pre>
Reading the assembly code can tell you how the bomb
  works. Although <code>objdump -d</code> gives you a lot of
  information, it doesn't tell you the whole story. Calls to
  system-level functions may look cryptic. For example, a call
  to <code>sscanf</code> might appear as: <code>8048c36: e8 99 fc ff
  ff call 80488d4 &lt;_init+0x1a0&gt;</code> To determine that the
  call was to <code>sscanf</code>, you would need to disassemble
  within <code>gdb</code>.</li>

  <li><code>strings -t x bomb > bomb_strings</code>: This utility will print the
  printable strings in your bomb and their offset within the
    bomb into into a file called <code>bomb_strings</code>.</li>
</ul>

<p>Looking for a particular tool? How about documentation? Don't
forget, the commands <code>apropos</code> and <code>man</code> are
your friends. In particular, <code>man ascii</code> is more useful
than you'd think. If you get stumped, use the course's discussion
board.</p>

</section>

<hr>

<div class="unspacesection"></div>

<section id="hints"><br>
<h3>Hints</h3>

<p class="afterh">If you're still having trouble figuring out what your bomb is
doing, here are some hints for what to think about at each stage: (1)
comparison, (2) loops, (3) switch statements, (4) recursion, (5)
pointers and arrays, (6) sorting linked lists.</p>

</div></div>


<a name="reflect"></a>
<div class="panel panel-default">
    <div class="panel-heading"><h3>Lab 2 Reflection</h3></div>
    <div class="panel-body">
        <p style="color:red;">REMINDER: You will need to be on the CSE VM or attu in order to get addresses that are consistent with our solutions.</p>
        <p>Start with a <em>fresh</em> copy of <code>lab0.c</code> and examine <code>part2()</code> using the following commands:</p>
        <pre><code>$ wget https://courses.cs.washington.edu/courses/cse351/17au/labs/lab0.c
$ gcc -g -std=c99 -o lab0 lab0.c
$ gdb lab0
(gdb) layout split
(gdb) break fillArray
(gdb) break part2
(gdb) run 2</code></pre>
        <p>Now answer the following questions:</p>
        <ol>
            <li>What address is the variable <code>value</code> stored at in memory? &nbsp;[0.5 pt]</li>
            <li class="afterh">What is the <em>relative</em> address (i.e. how many bytes forwards or backwards) of the variable <code>array</code> compared to the variable <code>value</code>? &nbsp;[0.5 pt]</li>
            <li class="afterh">Give an equivalent assembly instruction to the <code>lea</code> at address 0x400842. &nbsp;[1 pt]</li>
            <li class="afterh">Give the lowest and highest addresses of the instruction<b>s</b> that perform the <code>i * 3 + 2</code> calculation within the loop (not the assert). &nbsp;[1 pt]</li>
        </ol>
        <p>You will find the following GDB commands useful:  <code>nexti</code>, <code>finish</code>, <code>print</code>, and <code>refresh</code>.</p>
    </div>
</div>


<a name="submit"></a>
<div class="panel panel-default">
    <div class="panel-heading"><h3>Submission</h3></div>
    <div class="panel-body">
        <p>Submit <code>defuser.txt</code> and <code>lab2reflect.txt</code> to the <a href="../submit.php"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_canvas.png"/> assignments page</button></a>.</p>
        <p>It is important to make sure that <code>defuser.txt</code> obeys the folowing formatting rules, otherwise our grading script is likely to conclude you defused zero bombs:</p>
        <ul class="afterh">
            <li>Put your answer for each phase in one line.
            Your answer for phase 1 should be in the first line, answer for phase 2 on the second line, and so on.</li>
            <li>Do <b><i>not</i></b> put your name or other information at the top of the file.
            Again, you want the first line in the file to be your answer for phase 1.</li>
            <li>Do <b><i>not</i></b> add numbering or other &ldquo;comments&rdquo; for your answers (e.g. <code>1. This is my answer for phase 1</code>).</li>
            <li>Make sure all your answers, <i>including the last one</i>, have a newline character afterwards, so even your last-phase answer is a complete line <i>with</i> a newline.
            This last newline is important for our grading script even though you will not notice the difference in your own testing.</li>
        </ul>
    </div>
</div>


<?php printFooter(".."); ?>
