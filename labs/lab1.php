<?php
    include '../include.php';
    printHeader("..","CSE 351 Lab 1");
?>


<a name="info"></a>
<div class="panel panel-default">
    <div class="panel-heading"><h2>Lab 1: Bits and Pointers in C</h2></div>
    <div class="panel-body">
        <div class="exam-listing">
            <div class="exam-name topic">Assigned</div>
            Tuesday, October 3, 2017
        </div>
        <div class="exam-listing">
            <div class="exam-name topic">Due Date</div>
            <em><u>Prelim</u>: Monday, October 9, 2017 at 11:59pm, &nbsp;
            <u>Final</u>: Friday, October 13, 2017 at 11:59pm</em>
        </div>
        <div class="exam-listing">
            <div class="exam-name topic">Video(s)</div>
            <a href="../../videos/tutorials/lab1-print_binary.mp4"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_vid.png"/> This video</button></a> <a href="https://www.youtube.com/watch?v=R0R4MDG3-mM"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_yt.png"/> (with captions)</button></a> shows how to use the optional helper function <code>print_binary()</code> as well as a few more bit tricks you might find helpful for this lab.
        </div>
    </div>
</div>


<a name="overview"></a>
<div class="panel panel-default">
    <div class="panel-heading"><h3>Overview</h3></div>
    <div class="panel-body">
        <b>Learning Objectives:</b>
        <ul>
            <li>Gain familiarity with data representations at the level of bits.</li>
            <li>Gain familiarity with pointers and pointer arithmetic.</li>
        </ul>
        You will solve a series of programming "puzzles."
        The first part is about using bit manipulations.
        Many of these may seem artificial, but bit manipulations are very useful in cryptography, data encoding, implementing file formats (e.g. MP3), and certain job interviews.
        The second part is about basic pointer manipulations and pointer arithmetic.
        Pointers are a critical part of C and necessary for understanding assembly code (Lab 2-3) and memory allocation (Lab 5).
    </div>
</div>


<a name="code"></a>
<div class="panel panel-default">
    <div class="panel-heading"><h3>Code for this lab</h3></div>
    <div class="panel-body">
        <div class="exam-listing">
            <div class="exam-name topic">Browser</div>
            <a href="lab1.tar.gz"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_zip.gif"/> Download here</button></a>
        </div>
        <div class="exam-listing">
            <div class="exam-name topic">Terminal</div>
            <code>wget https://courses.cs.washington.edu/courses/cse351/17au/labs/lab1.tar.gz</code>
        </div>
        <div class="exam-listing">
            <div class="exam-name topic">Unzip</div>
            Running <code>tar xf lab1.tar.gz</code> from the terminal will extract the lab files to a directory called <code>lab1</code>.
        </div>
    </div>
</div>


<a name="inst"></a>
<div class="panel panel-default">
    <div class="panel-heading"><h3>Lab 1 Instructions</h3></div>
    <div class="panel-body">


<p><code>bits.c</code> and <code>pointer.c</code> contain skeletons for the programming puzzles, along with a comment block that describes exactly what the function must do and what restrictions there are on its implementation.
Your assignment is to complete each function skeleton using:</p>

<ul>
  <li>only straightline code (i.e., no loops or conditionals);</li>
  <li>a limited number of C arithmetic and logical operators;</li>
  <li>no constants larger than 8 bits (i.e., 0 - 255 inclusive); and</li>
  <li>feel free to use "(", ")", and "=" as many as you need.</li>
</ul>

<p>The intent of the restrictions is to require you to think about the
data as bits - because of the restrictions, your solutions won't be
the most efficient way to accomplish the function's goal, but the
process of working out the solution should make the notion of data as
bits completely clear.</p>

<p>Similarly, you will start working with basic pointers and use them
to compute the size of different data items in memory and to modify
the contents of an array.</p>

<hr>

<h2>The Bit Puzzles</h2>

<p class="afterh">This section describes the puzzles that you will be solving in
<code>bits.c</code>. More complete (and definitive, should there be any
inconsistencies) documentation is found in the <code>bits.c</code> file
itself.</p>

<h3>Bit Manipulations</h3>

<p class="afterh">The table below describes a set of functions that manipulate and
test sets of bits. The Rating column gives the difficulty rating (the
number of points) for each puzzle and the Description column states
the desired output for each puzzle along with the constraints. See the
comments in <code>bits.c</code> for more details on the desired behavior of the
functions. You may also refer to the test functions in tests.c. These
are used as reference functions to express the correct behavior of
your functions, although they don't satisfy the coding rules for your
functions.</p>

<table border=1>
  <tr style="background:#DDDDDD;">
    <th style="text-align:center" width=60>Rating</th>
    <th style="text-align:center" width=120>Function Name</th>
    <th>Description</th>
  </tr>

  <tr>
    <td style="text-align:center">1</td>
    <td style="text-align:center">bitAnd</td>
    <td>Compute x &amp; y using only ~ and |. &nbsp;<b>Hint:</b> DeMorgan's Law.</td>
  </tr>

  <tr>
    <td style="text-align:center">1</td>
    <td style="text-align:center">bitXor</td>
    <td>Compute x ^ y using only ~ and &amp;. &nbsp;<b>Hint:</b> DeMorgan's Law.</td>
  </tr>

  <tr>
    <td style="text-align:center">1</td>
    <td style="text-align:center">thirdBits</td>
    <td>Return an int with every third bit (starting from the least significant bit) set to 1 (i.e. 0100 1001 0010 0100 1001 0010 0100 1001<sub>2</sub>). &nbsp;<b>Hint:</b> Remember the restrictions on integer constants.</td>
  </tr>

  <tr>
    <td style="text-align:center">2</td>
    <td style="text-align:center">getByte</td>
    <td>Extract the n<sup>th</sup> byte from int x. &nbsp;<b>Hint:</b> Bytes are 8 bits.</td>
  </tr>

  <tr>
    <td style="text-align:center">3</td>
    <td style="text-align:center">logicalShift</td>
    <td>Shift x to the right by n bits, using a <i>logical</i> shift. &nbsp;You only have access to <i>arithmetic</i> shifts in this function.</td>
  </tr>

  <tr>
    <td style="text-align:center">3</td>
    <td style="text-align:center">invert</td>
    <td>Invert (0&lt;-&gt;1) n bits from position p to position p+n-1. &nbsp;<b>Hint:</b> Use a bitmask.</td>
  </tr>

  <tr>
    <td style="text-align:center">4</td>
    <td style="text-align:center">bang</td>
    <td>Compute !x without using the ! operator. &nbsp;<b>Hint:</b> Recall that 0 is false and anything else is true.</td>
  </tr>

</table>

<h3>Two's Complement Arithmetic</h3>

<p class="afterh">The following table describes a set of functions that make use of
the two's complement representation of integers. Again, refer to the
comments in <code>bits.c</code> and the reference versions in tests.c for more
information.</p>

<table border=1 width=100%>
  <tr style="background:#DDDDDD;">
    <th style="text-align:center" width=60>Rating</th>
    <th style="text-align:center" width=120>Function Name</th>
    <th>Description</th>
  </tr>

  <tr>
    <td style="text-align:center">2</td>
    <td style="text-align:center">sign</td>
    <td>Return 1 if positive, 0 if zero, and -1 if negative. &nbsp;<b>Hint:</b> Shifting is the key.</td>
  </tr>

  <tr>
    <td style="text-align:center">3</td>
    <td style="text-align:center">fitsBits</td>
    <td>Return 1 if x can be represented as an n-bit, two's complement integer. &nbsp;<b>Hint:</b> -1 = ~0.</td>
  </tr>

  <tr>
    <td style="text-align:center">3</td>
    <td style="text-align:center">addOK</td>
    <td>Return 1 if x+y can be computed <i>without</i> overflow. &nbsp;<b>Hint:</b> Think about what happens to sign bits during addition.</td>
  </tr>

  <tr>
    <td colspan=3>&nbsp; <em>Extra Credit:</em></td>
  </tr>

  <tr>
    <td style="text-align:center">4</td>
    <td style="text-align:center">isPower2</td>
    <td>returns 1 if x is a power of 2, and 0 otherwise</td>
  </tr>
</table>

<hr>

<h2>Checking Your Work (bits.c)</h2>

<p class="afterh">We have included the following tools to help you check the correctness of your work:</p>

<ul>
    <li>We have included a <code>print_binary</code> function, which takes an integer and outputs its binary representation.
        This can be useful in debugging your code, but its use is optional and all calls to the function should be commented out in your final submission.
        See the video link at the top of this page for usage examples.<br>&nbsp;
    </li>

    <li><p><code>btest</code> is a program that <em><b>checks the functional correctness of the code</b></em> in <code>bits.c</code>.
        To build and use it, type the following two commands:</p>
        <pre><code>$ make
$ ./btest</code></pre>
        <p>Notice that you must rebuild <code>btest</code> each time you modify your <code>bits.c</code> file.
        (You rebuild it by typing <code>make</code>.)
        You'll find it helpful to work through the functions one at a time, testing each one as you go.
        You can use the <code>-f</code> flag to instruct <code>btest</code> to test only a single function:</p>
        <pre><code>$ ./btest -f bitXor</code></pre>
        <p>You can feed it specific function arguments using the option flags <code>-1</code>, <code>-2</code>, and <code>-3</code>:</p>
        <pre><code>$ ./btest -f bitXor -1 7 -2 0xf</code></pre>
        <p>Check the file README for documentation on running the <code>btest</code> program.</p>
        <p style="font-style:italic;color:red;">We may test your solution on inputs that btest does not check by default and we will check to see that your solutions follow the coding rules.</p>
    </li>

    <li><p><code>dlc</code> is a modified version of an ANSI C compiler from the MIT CILK group that you can <em><b>use to check for compliance with the coding rules</b></em> for each puzzle.
        The typical usage is:</p>
        <pre><code>$ ./dlc <code>bits.c</code></code></pre>
        <p><b>Note: dlc will always output the following warning, which can be ignored:</b></p> 
        <pre><code>/usr/include/stdc-predef.h:1: Warning: Non-includable file &ltcommand-line&gt included from includable file /usr/include/stdc-predef.h.</pre></code>
        <p>The program runs silently unless it detects a problem, such as an illegal operator, too many operators, or non-straightline code in the integer puzzles. Running with the -e switch:</p>
        <pre><code>$ ./dlc -e <code>bits.c</code></code></pre>
        <p>causes <code>dlc</code> to print counts of the number of operators used by each function.
        Type <code>./dlc -help</code> for a list of command line options.<br>&nbsp;</p>
    </li>

</ul>


<hr>


<h2>Advice</h2>

<ul class="afterh">
    <li><strong>Start early on <code>bits.c</code>!</strong></li>
    <li class="afterh">Puzzle over the problems yourself, it is much more rewarding to find the solution yourself than stumble upon someone else's solution.</li>
    <li class="afterh">If you get stuck on a problem, move on. You may find you suddenly realize the solution the next day.</li>
    <li class="afterh">There is partial credit if you do not quite meet the operator limit, but often times working with a suboptimal solution will allow you to see how to improve it.</li>

    <li class="afterh">Do NOT include the <code>&lt;stdio.h&gt;</code> header file in <code>bits.c</code>, as it confuses <code>dlc</code> and results in some non-intuitive error messages.
        You will still be able to use <code>printf</code> for debugging without including the <code>&lt;stdio.h&gt;</code> header, although <code>gcc</code> will print a warning that you can ignore.</li>

    <li class="afterh">You can use <code>gdb</code> (GNU debugger) on your code.
        See <a href="lab1-gdb.html">this transcript</a> for an example.</li>

    <li class="afterh"><p>The <code>dlc</code> program enforces a stricter form of C declarations than is the case for C++ or that is enforced by <code>gcc</code>.
        In particular, in a block (what you enclose in curly braces) all your variable declarations must appear before any statement that is not a declaration.
        For example, <code>dlc</code> will complain about the following code:</p>

<pre><code>int foo(int x)
{
    int a = x;
    a *= 3;     /* Statement that is not a declaration */
    int b = a;  /* ERROR: Declaration not allowed here */
}</code></pre>

<p>Instead, you must declare all your variables first, like this:</p>

<pre><code>int foo(int x)
{
    int a = x;
    int b;
    a *= 3;
    b = a;
}</code></pre>
    </li>
</ul>

<hr style="border-top: 3px double #8c8b8b; border-bottom: 3px double #8c8b8b;">


<h2>Using Pointers</h2>

<p class="afterh">This section describes the functions you will be completing in <code>pointer.c</code> that is also in the lab1 folder you downloaded.  Refer to the file <code>pointer.c</code> itself for more complete details. <b><em>You are permitted to use casts for these functions.</em></b></p>

<h3>Pointer Arithmetic</h3>

<p class="afterh">The first three functions in <code>pointer.c</code> ask you to compute the size (in bytes) of various data elements (ints, doubles, and pointers).  You will accomplish this by noting that arrays of these data elements allocate contiguous space in memory so that one element follows the next.</p>

<h3>Manipulating Data Using Pointers</h3>

<p class="afterh">The <code>changeValue</code> function in <code>pointer.c</code> asks you to change the value of an element of an array using only the starting address of the array.  You will add the appropriate value to the pointer to create a new pointer to the data element to be modified.<strong><em>You are not permitted to use [] syntax to access or change elements in the array anywhere in the <code>pointer.c</code> file.</em></strong></p>

<h3>Pointers and Address Ranges</h3>

<p class="afterh">The last two functions in <code>pointer.c</code> ask you to determine whether pointers fall within certain address ranges, defined by aligned memory blocks or arrays.</p>


<hr>


<h2>Checking Your Work (pointer.c)</h2>

<p class="afterh">We have included the following tools to help you check the correctness of your work:</p>

<ul>
    <li><code>ptest.c</code> is a test harness for <code>pointer.c</code>. You can test your solutions like this:</p>
        <pre><code>$ make ptest
$ ./ptest</code></pre>
        <p>This only checks if your solutions return the expected result. <em>We may test your solution on inputs that ptest does not check by default and we will review your solutions to ensure they meet the restrictions of the assignment.</em></p>
    </li>

    <li><p><code>dlc.py</code> is a Python script that will check for compliance with the coding rules 
        <b>(note that <code>dlc</code> does not work with <code>pointer.c</code>)</b>.
        The usage is:</p>
        <pre><code>$ python dlc.py</code></pre>
    </li>
</ul>

</div></div>


<a name="reflect"></a>
<div class="panel panel-default">
    <div class="panel-heading"><h3>Lab 1 Reflection</h3></div>
    <div class="panel-body">
        <p style="color:red;">Make sure your answers to these questions are included in the file <code>lab1reflect.txt</code>!</p>
        <p>Assuming that <code>x = 351</code>, as in the original code of <code>lab0.c</code>:</p>

        <ol>
            <li>Find a <em>positive</em> value of <code>y &lt; x</code> such that <code>x &amp; y = 0</code>. Answer in hex. &nbsp;[1 pt]</li>
            <li class="afterh">Find a <em>negative</em> value of <code>y</code> such that <code>x ^ y = -1</code>. Answer in decimal. &nbsp;[1 pt]</li>
            <li class="afterh">Consider the following two statements:
                <ul>
                    <li><code>y = -1;</code></li>
                    <li><code>y = 0xFFFFFFFF;</code></li>
                </ul>
                Is there a difference between using these two statements in your code? Explain.
                If there is a difference, make sure to provide an example. &nbsp;[1 pt]</li>
        </ol>

    </div>
</div>


<a name="submit"></a>
<div class="panel panel-default">
    <div class="panel-heading"><h3>Submission</h3></div>
    <div class="panel-body">
        <p>You will submit your completed files to the <a href="../submit.php"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_canvas.png"/> assignments page</button></a> in the following stages:</p>

        <p><em><u>Prelim</u>:</em> &nbsp;
        By the preliminary deadline, we expect you to have 3 functions of your choice in <code>bits.c</code> completed and passing all tests (including using the proper number of operations).
        The purpose of this deadline is help you get started early on the assignment and it will be worth a small-ish number of points (no more than 10% of the total points for lab 1).
        Files submitted that contain at least 3 functions passing the spec will receive full credit for this stage.
        We will ignore all non-functioning/incomplete functions in the file, although please do ensure that the file will compile and run before submitting.
        <i>We strongly encourage you to have more of the assignment done &mdash; 3 functions is just the minimum.</i>
        </p>

        <p><em><u>Final</u>:</em> &nbsp;
        Please submit your completed <code>bits.c</code>, <code>pointer.c</code>, and <code>lab1reflect.txt</code> files (*three* separate files).
        This will be a complete re-grade of the entire <code>bits.c</code> file &mdash; you are welcome to change anything you submitted for the preliminary submission.
        </p>
    </div>
</div>


<?php printFooter(".."); ?>
