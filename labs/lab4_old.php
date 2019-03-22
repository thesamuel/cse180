<?php
    include '../include.php';
    printHeader("..","CSE 351 Lab 4");
?>


<a name="info"></a>
<div class="panel panel-default">
    <div class="panel-heading"><h2>Lab 4: Cache Geometries</h2></div>
    <div class="panel-body">
        <div class="exam-listing">
            <div class="exam-name topic">Assigned</div>
            Wednesday, November 15, 2017
        </div>
        <div class="exam-listing">
            <div class="exam-name topic">Due Date</div>
            <em>Monday, November 27, 2017 at 11:59pm</em>
        </div>
        <div class="exam-listing">
            <div class="exam-name topic">Submit</div>
            Submit (1) a PDF containing your answers and (2) your modified <code>cache-test.skel.c</code> file to the <a href="../submit.php"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_canvas.png"/> assignments page</button></a>.
        </div>
    </div>
</div>


<a name="overview"></a>
<div class="panel panel-default">
    <div class="panel-heading"><h3>Overview</h3></div>
    <div class="panel-body">
        <b>Learning Objectives:</b>
        <ul>
            <li>Evaluate a claim made in the lecture slides that two seemingly equivalent ways of writing a program can have vastly different performance.</li>
            <li>Get a feel for the relative performance of Java and C.</li>
            <li>Get a feel for the effectiveness of turning on C compiler optimizations.</li>
            <li>Gain basic familiarity with cache geometries and how different associativities and line sizes present themselves.</li>
        </ul>
        <p>The first part of this lab involves running and timing some code using various programming languages (Java and C), code changes, and compiler optimizations.</p>
        <p>In the second part of this lab, Chip D. Signer, Ph.D., is trying to reverse engineer a competitor's microprocessors to discover their cache geometries and has recruited you to help.
        Instead of running programs on these processors and inferring the cache layout from timing results, you will approximate his work by using a simulator.</p>
    </div>
</div>


<a name="code"></a>
<div class="panel panel-default">
    <div class="panel-heading"><h3>Code for this lab</h3></div>
    <div class="panel-body">
        <div class="exam-listing">
            <div class="exam-name topic">Browser</div>
            <a href="lab4.tar.gz"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_zip.gif"/> Download here</button></a>
        </div>
        <div class="exam-listing">
            <div class="exam-name topic">Terminal</div>
            <code>wget https://courses.cs.washington.edu/courses/cse351/17au/labs/lab4.tar.gz</code>
        </div>
        <div class="exam-listing">
            <div class="exam-name topic">Unzip</div>
            Running <code>tar xzf lab4.tar.gz</code> from the terminal will extract the lab files to a directory called <code>lab4</code> with the following files:
            <ul>
                <li><code>cacheExperiment*</code> - [part 1] Source code files for timing experiments</li>
                <li><code>run.pl</code> - [part 1] Optional script for automating some of the timing experiments (see <a href="#automating">"Automating"</a>)</li>
                <li><code>cache_*.o</code> - [part 2] "Caches" with known parameters for testing your code</li>
                <li><code>mystery*.o</code> - [part 2] "Caches" with unknown parameters that you will need to discover</li>
                <li><code>mystery-cache.h</code> - [part 2] Defines the function interface that the object files export</li>
                <li><code>cache-test-skel.c</code> - [part 2] Skeleton code for determining cache parameters</li>
                <li><code>Makefile</code> - [part 2] For compiling and linking files for running cache test</li>
            </ul>
        </div>
    </div>
</div>



<a name="inst"></a>
<div class="panel panel-default">
    <div class="panel-heading"><h3>Instructions</h3></div>
    <div class="panel-body">

<h2>Part I: An Experiment in C and Java</h2>

<h3>Overview</h3>
<p> Let's test the claim that understanding the memory hierarchy can be
  useful in writing efficient programs.  An example in the first-day
  lecture slides said that interchanging two loops has no effect on the
  correctness of the results, but can give a <em>21x</em> difference
  in performance.  Let's see about that.
</p>
<p> Here's the important part of the code.  It computes exactly the same
  thing no matter which of the two loops is outermost.
</p>
<pre><code>int rep;
int i, j;

// ...

    for (i = 0; i &lt; 2048; i++) {
        for (j = 0; j &lt; 2048; j++) {
            // src[i][j] = i * rep;
            dst[i][j] = src[i][j];
        }
    }</code></pre>

<p> You will download a set of three tiny programs&mdash;one in C and
  two in Java&mdash;that contain those loops.  You'll compile them
  and time how long it takes them to run.  For the C program, you'll
  compile both with and without compiler optimizations enabled, so in
  total you will have four programs to compare at a time (two Java
  programs + one C program compiled two ways).
</p>

<p>You will do this several times, making small modifications to see
  what differences they make&mdash;how the choice of language affects
  performance and how effective the compiler can be at optimizing your
  code when you:</p>

<ul>
  <li>interchange the order of the <code>i</code> and <code>j</code> loops</li>
  <li>uncomment the commented line</li>
  <li>change the size of the array being copied from 2048 x 2048 to
  4096 x 4096 (change both the array size and the bounds of the loop
  that copies the arrays)</li>
</ul>

<p>You'll run each version of the code and measure how long it takes
  to complete. With all the permutations (4 executables x 2 loop
  orderings x 2 commented/uncommented line versions x 2 array sizes),
  that's 32 versions. (It will be easy&mdash;just read all the way
  through these instructions first.)</p>

<p>You'll then turn in a short document, described below, in which you
  summarize your test results and answer a few questions.</p>

<h3>Details</h3>

<h4>Compiling</h4>

<p>To compile the C program without optimizations, <code>cd</code> to
  the <code>lab4</code> directory and type:

  <pre><code>gcc -Wall cacheExperiment.c</code></pre>

  That produces an executable named <code>a.out</code>. To compile the
  program with optimizations, type:

  <pre><code>gcc -Wall -O2 cacheExperiment.c</code></pre>

  (that is the capital letter o, not the number zero), which also
  produces an executable called <code>a.out</code> (overwriting the
  previous one).
</p>

<p>To run <code>a.out</code>, you would
type <code>./a.out</code>. (<strong>Note:</strong> You don't actually
want to do this. See the next heading about obtaining timings.)
</p>

<p>To compile <code>cacheExperiment.java</code> type:

  <pre><code>javac -Xlint cacheExperiment.java</code></pre>

  which produces <code>cacheExperiment.class</code>. Do the same thing
  for the other Java programs.
  <br>To run it, type: 

  <pre><code>java -Xmx640M -cp . cacheExperiment</code></pre>

  (Again, this is a command you need to time, so read on.)
</p>

<h4>Timing</h4>

<!--
<p><b>Note: On the CSE VM, the command <code>/usr/bin/time</code> was
    not installed by default.</b>  Typing "time" at the bash command
    line will instead run bash's built in time command (which is
    different).  To use <code>/usr/bin/time</code> on the VM you will
  need to install it by typing this at the command line:</p> 

<pre><code>sudo yum -y install time.</code></pre> </p>
-->
<p>On Linux, you can measure the CPU time consumed by any execution
    using the <code>time</code> program.  For example:</p>

<pre>
$ /usr/bin/time ./a.out
0.12user 0.03system 0:00.16elapsed 95%CPU (0avgtext+0avgdata 66704maxresident)k
0inputs+0outputs (0major+8287minor)pagefaults 0swaps
</pre>

<p>This executes the command (<code>./a.out</code>) and then prints
  information about the resources it consumed.  (Type <code>man
  time</code> to obtain more information about the time program and
  ways to format its output.)
</p>

<p>The only information we'll use is the user time ('0.12user',
  meaning 0.12 seconds of CPU time consumed while not in the operating
  system) and the system time ('0.03system', meaning 0.03 CPU seconds
  spent by the operating system doing things for this
  application). <em>The measured time we want is the sum of those
  two.</em> For this example, the measured time would be 0.15
  seconds.
</p>

<p>Measured times are likely to vary quite a bit from one run to the
  next, even without changing anything. (This course will explain
  some of the reasons why.) Note that all the programs wrap the two
  array-copying loops with another loop that causes the copy to be
  performed 10 times. One goal of that is to reduce the amount of
  variability in the measurements.
</p>

<h4 id="automating">Automating</h4>

<p>The distribution includes an optional script, <code>run.pl</code>,
  that automates some of the chore of running the four executables and
  gathering measurements.  To run it, type <code>./run.pl</code>.  It
  compiles each of the source files
  (and <code>cacheExperiment.c</code> twice; with and without
  optimizations), runs each with the <code>time</code> command, and
  reports the sum of the user and system times.
</p>

<p><code>run.pl</code> should work in most environments (including the
  CSE virtual machine). It should work for you, but it is an optional
  (and unsupported) tool.
</p>

<h4>So, to summarize:</h4>
<ol>
  <li>Compile and measure each of the Java implementations as they
	come in the distribution.  Compile and measure the C program with
	and without optimizations.</li>
  <li>Edit each source file to uncomment the assignment to
  array <code>src</code>.  Re-compile and re-measure.</li>
  <li>Edit to switch the order of the <code>i</code>
  and <code>j</code> loops.  Recompile and re-measure.</li>
  <li>Edit to re-comment out the statement assigning to
  array <code>src</code> (with the <code>i</code> and
	<code>j</code> loops still reversed). Re-compile and
	re-measure.</li>
  <li>Edit to put the loops back in the original order. (At this point
	the code is the same as it was when you first fetched it.)
	Change the code to copy an array of size 4096 x 4096 (change
	both the size of the arrays and the loop bounds).  Then repeat
	steps 1&ndash;4 above.</li>
</ol>

<h3>Test Results</h3>

<p>Collect your results in a short PDF document with the following
sections:</p>

<ol>
  <li><strong>The Test System</strong>
	<ul>
	  <li>A short string describing the system you ran on (e.g., &#8220;my Mac laptop&#8221; or &#8220;the CSE home VM on my
		Windows laptop&#8221; or &#8220;lab Linux workstation&#8221;).</li>
	  <li>What the CPU is on that system. You can obtain that on any
		Linux system by issuing the command <code>cat
		/proc/cpuinfo</code>. Give us the model name, as
		listed.</li>
	</ul>
  </li>
  <li><strong>Test Results</strong> Four tables of numbers giving the
	measured CPU time consumed when executing each of the four
	executables under the different configurations.  Each table
	should look like this.  (It doesn't have to be exactly this,
	to every detail of formatting, but please keep your
	information in the same order; it makes reading 100 copies of
	these tables easier if they're all laid out the same way.)

	<table>
	  <tr>
		<th>Array Size</th>
		<th>Performing<br>
		  <code>src</code> assignment?</th>
		<th>App</th>
		<th>Time with <code>i</code> then <code>j</code></th>
		<th>Time with <code>j</code> then <code>i</code></th>
		</tr>
	  <tr>
		<td rowspan="5">2048</td>
		<td rowspan="5">No</td>
		<td>Java</td>
		<td></td>
		<td></td>
	  </tr>
	  <tr>
		<td>JavaInteger</td>
		<td></td>
		<td></td>
		</tr>
	  <tr>
		<td>C</td>
		<td></td>

	<td></td>
		</tr>
	  <tr>
		<td>Optimized C</td>
		<td></td>
		<td></td>
	  </tr>
	</table>
  </li>

  <li><strong>Q&amp;A</strong> <br>
	Answer these questions:
	<ol>
	  <li>What are the source code differences among the two Java
	  implementations?</li>
	  <li>Pick a single pair of results that most surprised you.  What
	  is it about the results that surprised you?
	    <em>(That is, from the 32 measurements you collected,
	      pick one pair of measurements whose relationship is
	      least like what you would have guessed.)</em></li>
	  <li><em>[Optional extra credit]</em> None of these
		programs appear to actually do anything, so one is tempted to
		optimize them by simply eliminating all code (resulting in an
		empty <code>main()</code>). Is that a correct optimization?
		Related to that, try compiling this C program, with and without optimization, and then time running it:
		<pre>
<code>#include &lt;stdio.h&gt;

#define SIZE 1000000

int main() {
    int i, j, k;
    int sum = 1;

    for (i = 0; i &lt; SIZE; i++) {
        for (j = 0; j &lt; SIZE; j++) {
            for (k = 0; k &lt; SIZE; k++) {
                sum = -sum;
            }
        }
    }

    printf(&quot;hello, world\n&quot;);

    return 0;
}</code>
</pre>
		<p> Now replace the <code>printf</code> line with</p>
    <pre><code>printf(&quot;Sum is %d\n&quot;, sum);</code></pre>
    <p>and compile/run unoptimized and optimized.</p>
    <p>It may also be interesting to explore what happens to this code using the <a href="http://gcc.godbolt.org">Compiler Explorer</a> tool we told you about earlier. Try changing <code>sum = -sum</code> to some other operation, such as <code>sum++</code> and tell us what happens.
  </li>
	</ol>
  </li>
</li>
</ol>

<h2>Part II: Inferring Mystery Cache Geometries</h2>

<p><em>This lab should be done on a 64-bit machine. Use the CSE
VM, attu, or your own personal 64-bit computer.</em></p>

<h3>Instructions</h3>
<p>Each of the &ldquo;processors&rdquo; is provided as an object
file (.o file) against which you will link your code. The file
<code>mystery-cache.h</code> defines the function interface
that these object files export. It includes a typedef for a type <code>addr_t</code> (an unsigned 8-byte integer) which is what these (pretend) caches use for "addresses", or you can use any convenient integer type.

<pre>
typedef unsigned long long addr_t;
typedef unsigned char bool_t;
#define TRUE 1
#define FALSE 0

/** Lookup an address in the cache. Returns TRUE if the access hits,
    FALSE if it misses. */
bool_t access_cache(addr_t address);

/** Clears all words in the cache (and the victim buffer, if
    present). Useful for helping you reason about the cache
    transitions, by starting from a known state. */
void flush_cache(void);
</pre>
</p>
<p>
Your job is to fill in the function stubs in
<code>cache-test-skel.c</code> which, when linked with one of these
cache object files, will determine and then output the cache size,
associativity, and block size. You will use the functions above to perform cache accesses and use your observations of which ones hit and miss to determine the parameters of the caches.
</p><p>
Some of the provided object files are
named with this information (e.g. <code>cache_65536c_2a_16b.o</code>
is a 65536 <b>Byte</b> capacity, 2-way set-associative cache with
16 <b>Byte</b> blocks) to help you check your work. There are also 4
mystery cache object files, whose parameters you must discover on your
own.
</p>

<p>You can assume that the mystery caches have sizes that are powers of 2 and use
a least recently used replacement policy. You cannot assume anything else about
the cache parameters except what you can infer from the cache size. Finally, the
mystery caches are all pretty realistic in their geometries, so use this fact to
sanity check your results.</p>

<p>You will need to complete this assignment on a Linux machine with
the C standard libraries (e.g. the CSE VM, attu).  All the files you need are
in <a href="labs/lab4/lab4.tar.gz">lab4.tar.gz</a>. To extract the files
from this archive, simply use the command
<code>tar xzf lab4.tar.gz</code> to extract the files into a new
subdirectory of the current directory named <em>lab4</em>.  However,
you presumably already did this for Part I and you do not need to do it
again.

The provided <code>Makefile</code> includes a
target <code>cache-test</code>.  To use it, set <code>TEST_CACHE</code>
to the object file to link against on the command line.  That is, from within the
lab4 directory run the command:</p>
<pre><code>make cache-test TEST_CACHE=cache_65536c_2a_16b.o</code></pre>

<p>This will create an executable <code>cache-test</code> that will run
your cache-inference code against the supplied cache object.  Run this
executable like so:</p>
<pre><code>./cache-test</code></pre>
<p>and it will print the results to the screen.</p>

<p>You may find this <a href="labs/lab4/testCache.sh">script</a> that
  makes and runs <code>cache-test</code> with all the object files
  useful. But you are not required to use it and it is provided
  without support.</p>



<h3>Your Tasks</h3>
<p>Complete the 3 functions in <code>cache-test-skel.c</code> which have
<code>/* YOUR CODE GOES HERE */</code> comments in them.
</p>

<p>Additionally, determine the geometry of each of the four mystery caches and
list these in a comment, along with your name, at the top of your modified
<code>cache-test-skel.c</code>.</p>

<!--
<p>Note: You should NOT be calling any functions other than
  <code>flush_cache</code> and <code>access_cache</code> inside of
  your functions.  For example, you may not
  call <code>get_block_size()</code> say inside
  of <code>get_cache_assoc</code>.</p>
-->

    </div>
</div>


<a name="submit"></a>
<div class="panel panel-default">
    <div class="panel-heading"><h3>Submission</h3></div>
    <div class="panel-body">
        <p><b>Part I:</b> Submit a PDF file containing your answers to Part I to the <a href="../submit.php"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_canvas.png"/> assignments page</button></a>.</p>
        <p><b>Part II:</b> Submit your modified version of <code>cache-test-skel.c</code> to the <a href="../submit.php"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_canvas.png"/> assignments page</button></a>.</p>
    </div>
</div>


<?php printFooter(".."); ?>
