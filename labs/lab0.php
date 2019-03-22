<?php
    include '../include.php';
    printHeader("..","CSE 351 Lab 0");
?>


<a name="info"></a>
<div class="panel panel-default">
    <div class="panel-heading"><h2>Lab 0: C Warm-Up & Preview</h2></div>
    <div class="panel-body">
        <div class="exam-listing">
            <div class="exam-name topic">Assigned</div>
            Wednesday, September 27, 2017
        </div>
        <div class="exam-listing">
            <div class="exam-name topic">Due Date</div>
            <em>Monday, October 2, 2017 at 11:59pm</em>
        </div>
    </div>
</div>


<a name="overview"></a>
<div class="panel panel-default">
    <div class="panel-heading"><h3>Overview</h3></div>
    <div class="panel-body">
        <b>Learning Objectives:</b>
        <ul>
            <li>Set up your computing environment for the rest of the quarter.</li>
            <li>Compile and run C code on a Linux environment.</li>
            <li>Observe C programming behaviors that will preview the topics covered in the later labs.</li>
        </ul>
        Be sure to read the <a href="../linux/"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_txt.png"/> Linux tips</button></a> page to set up your environment and pick a text editor before starting this lab.<br>
        Instructions on what to do are in the Canvas quiz along with comments in the starter code.
    </div>
</div>


<a name="code"></a>
<div class="panel panel-default">
    <div class="panel-heading"><h3>Code for this lab</h3></div>
    <div class="panel-body">
        <div class="exam-listing">
            <div class="exam-name topic">Browser</div>
            <a href="lab0.c"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_c.gif"/> Download here</button></a>
        </div>
        <div class="exam-listing">
            <div class="exam-name topic">Terminal</div>
            <code>wget https://courses.cs.washington.edu/courses/cse351/17au/labs/lab0.c</code>
        </div>
    </div>
</div>


<a name="inst"></a>
<div class="panel panel-default">
    <div class="panel-heading"><h3>Instructions</h3></div>
    <div class="panel-body">

<div class="unspacesection"></div>
<section id="edit"><br>
<h3>Editing Code</h3>
<p class="afterh">
After acquiring the source file, you will need to open <code>lab0.c</code> in your <a class="external" href="../linux/#edit">text editor</a> of choice.
See the tutorials if you are unsure how to make edits.
</p>
<p>The <code>lab0.c</code> file contains a number of comments explaining some basics of C (and their differences from Java).
There are five different parts to this lab and you will need to modify or write some lines of code for each one. 
We recommend keeping a fresh copy of <code>lab0.c</code> around for reference (as you may lose track of all the changes you end up making).
</p>
</section>

<hr>

<div class="unspacesection"></div>

<section id="compile"><br>
<h3>Compiling Code</h3>
<p class="afterh">
The source file <code>lab0.c</code> won't do anything by itself;
you need a compiler (specifically the GNU C compiler) to generate to an executable from it.
The GNU C compiler is available on the <a class="external" href="https://www.cs.washington.edu/lab/vms">CSE VM</a>, attu, the instructional Linux machines in the lab, and most popular variants of Linux, such as Ubuntu and Fedora.
You are free to use whichever machine you like, although we will only provide support for the CSE home VM, attu, and the instructional Linux machines in the lab.
</p>

<p>Using any one of these machines, open a terminal and execute <code>gcc -v</code>.
On attu, we see:</p>

<pre>
$ gcc -v
<span style="font-weight:bold;">Using built-in specs.
COLLECT_GCC=gcc
COLLECT_LTO_WRAPPER=/opt/rh/devtoolset-4/root/usr/libexec/gcc/x86_64-redhat-linux/5.3.1/lto-wrapper
Target: x86_64-redhat-linux
Configured with: ../configure --enable-bootstrap --enable-languages=c,c++,fortran,lto --prefix=/opt/rh/devtoolset-4/root/usr --mandir=/opt/rh/devtoolset-4/root/usr/share/man --infodir=/opt/rh/devtoolset-4/root/usr/share/info --with-bugurl=http://bugzilla.redhat.com/bugzilla --enable-shared --enable-threads=posix --enable-checking=release --enable-multilib --with-system-zlib --enable-__cxa_atexit --disable-libunwind-exceptions --enable-gnu-unique-object --enable-linker-build-id --enable-plugin --with-linker-hash-style=gnu --enable-initfini-array --disable-libgcj --with-default-libstdcxx-abi=gcc4-compatible --with-isl=/builddir/build/BUILD/gcc-5.3.1-20160406/obj-x86_64-redhat-linux/isl-install --enable-libmpx --enable-gnu-indirect-function --with-tune=generic --with-arch_32=i686 --build=x86_64-redhat-linux
Thread model: posix
gcc version 5.3.1 20160406 (Red Hat 5.3.1-6) (GCC)</span>
</pre>

<p>The output tells me a bunch of the configuration options for the my installation of GCC as well as the version number, which is 5.3.1.
Assuming that you have saved <code>lab0.c</code> somewhere on your machine, navigate to that directory, and then use GCC to compile it with the following command:</p>

<pre>
$ gcc -g -Wall -std=gnu99 -o lab0 lab0.c
</pre>

<p>It's not that important right now for you to know what all of these options do, but
<code>-g</code> tells the compiler to include debugging symbols,
<code>-Wall</code> says to print warnings for all types of potential problems,
<code>-std=gnu99</code> says to use the C99 standard (now only 18 years old!),
<code>-o lab0</code> instructs the compiler to output the executable code to a file called <code>lab0</code>, and
<code>lab0.c</code> is the source file being compiled.</p>

<p>During execution of that command, you should see a warning about the variable 'bigArray', which you can safely ignore.
This warning would not be shown if you removed <code>-Wall</code> from the <code>gcc</code> command, but you will want <code>-Wall</code> to catch potential errors when you write code yourself.</p>

<p>Having executed the <code>gcc</code> command, you should be able to see a file named <code>lab0</code> in the same directory:</p>

<pre>
$ ls
<span style="font-weight:bold;">lab0  lab0.c</span>
</pre>
</section>

<hr>

<div class="unspacesection"></div>

<section id="run"><br>
<h3>Running Executables</h3>
<p class="afterh">
The <code>lab0</code> file is an <em>executable file</em>, which you can run using the command <code>./lab0</code>.
You should see:</p>

<pre>
$ ./lab0
<span style="font-weight:bold;">Usage: ./lab0 &lt;num&gt;</span>
</pre>

<p>In this case, the executable <code>lab0</code> is expecting a <em>command-line argument</em>, which is text that is provided to the executable from the command-line when the program is run.
In particular, <code>lab0</code> wants a number from 1 to 5, corresponding to which part of the lab code you want to run.
See <code>main()</code> in <code>lab0.c</code> for more details.
For example:</p>

<pre>
$ ./lab0 1
<span style="font-weight:bold;">*** LAB 0 PART 1 ***
x = 351
y = 410
x &amp; x = 351</span>
</pre>
</section>

<hr>

<div class="unspacesection"></div>

<section id="check"><br>
<h3>Checking Your Work</h3>
<p class="afterh">
With that, you should have everything you need to complete the assignment.
Follow the instructions found on the associated Canvas quiz; you will want to work on the different parts of the lab in order (from 1 to 5).
Each question can be answered and/or verified by appropriate edits to the source code. 
Note that every time you want to test a code modification, you will need to use the <code>gcc -g -Wall -std=gnu99 -o lab0 lab0.c</code> command to produce an updated <code>lab0</code> executable file

(<span style="color:red;"><b>Tip:</b> Use the up and down keys to scroll through previous commands you've executed</span>).
</p>

<p>You can submit the Lab 0 quiz once you have answered <em>all</em> of the questions.
Canvas will indicate which questions were answered correctly and which were answered incorrectly.
You have a maximum of 20 submissions.</p>

<p>Some of the code behaviors will seem inexplicable at this point, but our goal is that you will be able to explain to someone else what is going on by the end of this course! =)</p>
</section>


</div></div>



<a name="submit"></a>
<div class="panel panel-default">
    <div class="panel-heading"><h3>Submission</h3></div>
    <div class="panel-body">
        You will not be submitting files for this lab.
        Submit your answers to the Lab 0 Canvas quiz on the <a href="../submit.php"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_canvas.png"/> assignments page</button></a>.
    </div>
</div>


<?php printFooter(".."); ?>
