<?php
    include '../include.php';
    printHeader("..","CSE 351 Lab 4");
?>


<a name="info"></a>
<div class="panel panel-default">
    <div class="panel-heading"><h2>Lab 4: Caches and Cache Performance</h2></div>
    <div class="panel-body">
        <div class="exam-listing">
            <div class="exam-name topic">Assigned</div>
            Wednesday, November 15, 2017
        </div>
        <div class="exam-listing">
            <div class="exam-name topic">Due Date</div>
            <em>Monday, November 27, 2017 at 11:59pm</em>
        </div>
    </div>
</div>


<a name="overview"></a>
<div class="panel panel-default">
    <div class="panel-heading"><h3>Overview</h3></div>
    <div class="panel-body">
        <b>Learning Objectives:</b>
        <ul>
            <li>Gain basic familiarity with cache geometries and how different associativities and line sizes present themselves.</li>
            <li>Evaluate a claim made in the lecture slides that two seemingly equivalent ways of writing a program can have vastly different performance.</li>
            <li>Gain experience in designing cache-friendly code.</li>
        </ul>
        <p>In the first part of this lab, Chip D. Signer, Ph.D., is trying to reverse engineer a competitor's microprocessors to discover their cache geometries and has recruited you to help.
        Instead of running programs on these processors and inferring the cache layout from timing results, you will approximate his work by using a simulator.</p>
        <p>The second part of this lab involves trying to design a Matrix Transpose function that has as few cache misses as possible.</p>
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
                <li><code>cache_*.o</code> - [part I] "Caches" with known parameters for testing your code</li>
                <li><code>mystery*.o</code> - [part I] "Caches" with unknown parameters that you will need to discover</li>
                <li><code>mystery-cache.h</code> - [part I] Defines the function interface that the object files export</li>
                <li><code>cache-test-skel.c</code> - [part I] Skeleton code for determining cache parameters</li>
                <li><code>Makefile</code> - [part I &amp II] For compiling and linking file</li>
                <li><code>trans.c</code> - [part II] Place for your transpose functions</li>
                <li><code>test-trans.c</code> - [part II] code to test efficiency of your functions in <code>trans.c</code></li>
                <li><code>driver.py</code> - [part II] Script to run all part II tests and calculate score</li>
                <li><code>tracegen.c</code> - [part II] used by <code>test-trans.c</code> to generate memory traces</code></li>
                <li><code>csim-ref</code> - [part II] Cache Simulator used by <code>test-trans</code></li>
                <li><code>cachelab.*</code> - [part II] Helper code used by other programs in part II</li>
                <li><code>lab4reflect.txt</code> - For your Reflection responses</li>
            </ul>
        </div>
    </div>
</div>



<a name="inst-1"></a>
<div class="panel panel-default">
    <div class="panel-heading"><h3>Lab 4 Instructions (Part I)</h3></div>
    <div class="panel-body">

<div class="unspacesection"></div>
<section id="part1"> <br>
<h3>Inferring Mystery Cache Geometries &nbsp;[27 points]</h3>

<p class="afterh"><em>This lab should be done on a 64-bit machine. Use the CSE
VM, attu, or your own personal 64-bit computer.</em></p>

<p>Each of the &ldquo;processors&rdquo; is provided as an object
file (.o file) against which you will link your code. The file
<code>mystery-cache.h</code> defines the function interface
that these object files export. It includes a typedef for a type <code>addr_t</code> (an unsigned 8-byte integer) which is what these (pretend) caches use for "addresses", or you can use any convenient integer type.

<pre><code>typedef unsigned long long addr_t;
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
</code></pre>
</p>
<p>
Your job is to fill in the function stubs in
<code>cache-test-skel.c</code> which, when linked with one of these
cache object files, will determine and then output the cache size,
associativity, and block size. You will use the functions above to perform cache accesses and use your observations of which ones hit and miss to determine the parameters of the caches.
</p><p>
Some of the provided object files are
named with this information (e.g. <code>cache_65536c_2e_16k.o</code>
is a 65536 <b>Byte</b> <span style="color:red;">c</span>apacity, 2-way set-associativ<span style="color:red;">e</span> cache with
16 <b>Byte</b> bloc<span style="color:red;">k</span>s) to help you check your work. There are also 4
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
in <a href="lab4.tar.gz">lab4.tar.gz</a>. To extract the files
from this archive, simply use the command
<code>tar xzf lab4.tar.gz</code> to extract the files into a new
subdirectory of the current directory named <em>lab4</em>.

The provided <code>Makefile</code> includes a
target <code>cache-test</code>.  To use it, set <code>TEST_CACHE</code>
to the object file to link against on the command line.  That is, from within the
lab4 directory run the command:</p>
<pre><code class="nohighlight">make cache-test TEST_CACHE=cache_65536c_2e_16k.o</code></pre>

<p>This will create an executable <code>cache-test</code> that will run
your cache-inference code against the supplied cache object.  Run this
executable like so:</p>
<pre><code class="nohighlight">./cache-test</code></pre>
<p>and it will print the results to the screen.</p>

<p>You may find this <a href="testCache.sh">script</a> that
  makes and runs <code>cache-test</code> with all the object files
  useful. But you are not required to use it and it is provided
  without support. Run this shell script like so:</p>
<pre><code class="nohighlight">bash testCache.sh</code></pre>


<h3>Your Tasks</h3>
<p class="afterh">Complete the 3 functions in <code>cache-test-skel.c</code> that have
<code>/* YOUR CODE GOES HERE */</code> comments in them.
</p>

<p>Additionally, determine the geometry of each of the four mystery caches and
list these in a comment, along with your name, at the top of your modified
<code>cache-test-skel.c</code>.</p>

<p><b>Note:</b> You should NOT be calling any functions other than
  <code>flush_cache</code> and <code>access_cache</code> inside of
  your functions.  For example, you may not
  call <code>get_block_size()</code> say inside
  of <code>get_cache_assoc</code>.</p>
</section>

</div></div>



<a name="inst-2"></a>
<div class="panel panel-default">
    <div class="panel-heading"><h3>Lab 4 Instructions (Part II)</h3></div>
    <div class="panel-body">

<div class="unspacesection"></div>
<section id="part2"> <br>
<h3>Optimizing Matrix Transpose &nbsp;[15 points]</h3>

<p class="afterh">In Part II you will write a transpose function in <code>trans.c</code> that causes as few cache misses as possible.</p>

<p>Let <em>A</em> denote a matrix, and <em>A<sub>ij</sub></em> denote the component in the ith row and jth column. The transpose of <em>A</em>,
denotated <em>A<sup>T</sub></em> is a matrix such that <em>A<sub>ij</sub> = A<sup>T</sup><sub>ji</sub></em></p>

<p>To help you get started, we have given you an example transpose function in <code>trans.c</code> that computes the transpose of M x N
matrix A and stores the results in N x M matrix B:</p>

<pre><code>char trans_desc[] = "Simple row-wise scan transpose";
void trans(int M, int N, int A[M][N], int B[M][N])</code></pre>

<p>The example transpose function is correct, but it is inefficient because the access pattern results in relatively many cache misses.</p>
<p>Your job in Part II is to write a similar function, called <code>transpose_submit</code>, that minimizes the number of cache misses across
different sized matrices on a simulated cache with parameters <code>s=5, E=1, b=5</code>:</p>

<pre><code>char trans_desc[] = "Transpose submission";
void transpose_submit(int M, int N, int A[M][N], int B[M][N])</code></pre>

<p>Do <span style="color:red;">not</span> change the description string <code>"Transpose submission"</code> for your <code>transpose_submit</code> function.
The autograder searrches for this string to determine which transpose function to evaluate for credit.</p>

<h4>Trace Files</h4>
<p class="afterh">The Linux program <code>valgrind</code> can generate traces of memory accesses of programs. For example, typing</p>
<pre><code>linux> valgrind --log-fd=1 --tool=lackey -v --trace-mem=yes ls -l</code></pre>
<p>on the command line runs <code>ls -l</code>, captures the memory accesses in order, and prints them to <code>stdout</code>.</p>
<p><code>valgrind</code> memory accesses have the following form:</p>
<pre>I 0400d7d4,8
M 0421c7f0,4
L 04f6b868,8
S 7ff0005c8,8</pre>
<p>Each line denotes one or two memory accesses. The format of each line is:</p>
<pre>[space]operation address,size</pre>
<p>The <em>operation</em> field denotes the type of memory access: "I" denotes an instruction load, "L" a data load, "S" a
data store and "M" a data modify (i.e., a data load followed by a data store). There is never a space before each "I". There is
always a space before each "M", "L", and "S". The <em>address</em> field specifies a 64-bit hexadecimal memory address. The <em>size</em> field
specifies the number of bytes accessed by the operation.</p>

<p>Tools in this lab use <code>valgrind</code> traces of your code running on a cache simulator to evaluate the efficieny of your transpsoe
function. See the <a href="#hints">Hints</a> section for more information.</p>

<h4>Programming Rules for Part II</h4>
<ul class="afterh">
  <li>Include your name and NetID in the header comment for <code>trans.c</code></li>
  <li>Your code in <code>trans.c</code> must compile without warnings to receive credit.</li>
  <li>You are allowed to define at most 12 local variables of type <code>int</code> per transpose function.
  The reason for this restriction is that our testing code is not able to count references to the stack. We want you to limit
  your references to the stack and foucus on the access patterns of the source and destination arrays.</li>
  <li>Arrays DO count towards your 12 local ints. For example, if you had 4 ints, you could declare an array of ints up to size 8.</li>
  <li>You are not allowed to side-step the previous rule by using any variables of type <code>long</code> or by using any 
  bit tricks to store more than one value to a single variable.</li>
  <li>Your transpose function may not use recursion.</li>
  <li>If you choose to use helper functions, you may not have more than 12 local variables on the stack at a time
  between your helper functions and your top level transpose function. For example, if your transpose declares 8
  variables, and then you call a function which uses 4 variables, which calls another function which uses 2, you will have 14
  variables on the stack, and you will be in violation of the rule.</li>
  <li>Your transpose function may not modify array A. You may, however, do whatever you want with the contents of array B.</li>
  <li>You are <span style="color:red;">NOT</span> allowed to use any variant of <code>malloc</code></li>
</ul>

<h4>Performance</h4>
<p class="afterh">For Part II, we will evaluate the correctness and performance of your <code>transpose_submit</code> function on 3 different-sized input
matrices:</p>

<ul>
    <li>32 x 32 (M=32, N=32)</li>
    <li>64 x 64 (M=64, N=64)</li>
    <li>67 x 61 (M=67, N=61)</li>
</ul>
<p>For each matrix size, the performance of your <code>transpose_submit</code> function is evaluated by using
<code>valgrind</code> to extract the address trace for your function, and then using the reference simulator to replay
this trace on a cache with parameters <code>s = 5, E = 1, b=5 </code>.</p>

<p>Your performance score for each matrix size scales linearly with the number of misses, <em>m</em>, up to some
threshold:</p>
<ul>
    <li><b>32 x 32:</b> 5 points if <em>m</em> &le; 330, 0 points if <em>m</em> &gt; 600</li>
    <li><b>64 x 64:</b> 5 points if <em>m</em> &le; 1,800, 0 points if <em>m</em> &gt; 2,400</li>
    <li><b>67 x 61:</b> 5 points if <em>m</em> &le; 2,100, 0 points if <em>m</em> &gt; 3,000</li>
</ul>

<p>Your code must be correct to receive any performance points for a particular size. <span style="color:red;">Your code only needs to
be correct for these three cases and you can optimize it specifically for these three cases.</span> In particular, it is
perfectly OK for your function to explicitly check for the input sizes and implement separate code optimized
for each case.</p>

<p>We have provided you with a driver program, called <code>./driver.py</code>, that performs a complete evaluation
of your transpose code. This is the same program your instructor uses to evaluate your
handin. The driver uses test-trans to evaluate your submitted transpose function on the three matrix sizes.
Then it prints a summary of your results and the points you have earned. To run the driver, type:
<pre><code>linux> python driver.py</code></pre>

<h4>Extra Credit</h4>
<p class="afterh">
Extra credit will be awarded for code that results in significantly fewer misses than the full score "baselines."
</p>
<p>
For reference, there exist solutions with <em>m</em> as low as 300 (32 x 32), 1200 (64 x 64), and 1920 (67 x 61).
</p>
<hr>
<div class="unspacesection"></div>
<section id="resources">
<br>
<h3>Resources</h3>
<ul class="afterh">
    <li><a href="https://software.intel.com/en-us/articles/how-to-use-loop-blocking-to-optimize-memory-use-on-32-bit-intel-architecture">This intel post</a>
    is a good place to start if you are stuck.</li>
    <li><a href="../images/lab_4_32_32_visualization.png">This image</a> shows the last 2 bytes
    of the address of each cache blocks as they align to the 32x32 matricies. Red squares notate the 
    start of a section that would fit in cache. Green lines divide individual integers, and black lines 
    divide cache blocks.
</ul>

</section>
<hr>
<div class="unspacesection"></div>
<section id="tools">
<br>
<h3>Tools</h3>
<p class="afterh">We have provided you with an autograding program, called <code>test-trans.c</code> that tests the correctness
and performance of each of the transpose functions that you have registered with the autograder.</p>

<p>You can register up to 100 versions of the transpose function in your <code>trans.c</code> file. Eache transpose version has the
following form:</p>

<pre><code>/* Header comment */
char trans_simple_desc[] = "A simple transpose";
void trans_simple(int M, int N, int A[N][M], int B[M][N])
{
    /* your transpose code here */
}</code></pre>

<p>Register a particular transpose function witht he autograder by making a call of the form:</p>
<pre><code>registerTransFunction(trans_simple, trans_simple_desc);</code></pre>
<p>in the <code>registerFunctions</code> routine in <code>trans.c</code>. At runtime, the autograder will evaluate each registered
transpose function and print the results. Of course, one of the registered functions must be the
<code>transpose_submit</code> function that you are submitting for credit:</p>
<pre><code>registerTransFunction(transpose_submit, transpose_submit_desc);</code></pre>

<p>See the default <code>trans.c</code> function for an example of how this works.</p>

<p>The autograder takes the matrix size as input. It uses <code>valgrind</code> to generate a trace of each registered transpose
function. It then evaluates each trace by running a chache simulator called <code>csim-ref</code> on a cache with 
parameters <code>s=5, E=1, b=5</code>,
though the csim-ref uses the equlivent notation from the book <code>s=5, E=1, b=5</code>.</p>

<p>For example, to test your registered transpose functions on a 32 x 32 matrix, rebuild <code>test-trans</code>, and then run it
with the appropriate values for M and N:</p>

<pre><code>linux> make
linux> ./test-trans -M 32 -N 32
Step 1: Evaluating registered transpose funcs for correctness:
func 0 (Transpose submission): correctness: 1
8
func 1 (Simple row-wise scan transpose): correctness: 1
func 2 (column-wise scan transpose): correctness: 1
func 3 (using a zig-zag access pattern): correctness: 1
Step 2: Generating memory traces for registered transpose funcs.
Step 3: Evaluating performance of registered transpose funcs (s=5, E=1, b=5)
func 0 (Transpose submission): hits:1766, misses:287, evictions:255
func 1 (Simple row-wise scan transpose): hits:870, misses:1183, evictions:1151
func 2 (column-wise scan transpose): hits:870, misses:1183, evictions:1151
func 3 (using a zig-zag access pattern): hits:1076, misses:977, evictions:945
Summary for official submission (func 0): correctness=1 misses=287</pre></code>

<p>In this example, we have registered four different transpose functions in <code>trans.c</code>. The <code>test-trans</code>
program tests each of the registered functions, displays the results for each, and extracts the results for the
official submission.</p>

</section>
<hr>
<div class="unspacesection"></div>
<section id="hints">
<br>
<h3>Hints</h3>
<ul class="afterh">
<li>
<p>The <code>test-trans</code> program saves the trace for the function <em>i</em> in the file <code>trace.f<em>i</em></code>. These
trace files are invaluable debugging tools that can help you understand exactly where the hits and misses for each transpose function are coming
from. To debug a particular function, simply run its trace through the reference simulator with the verbose option:</p>

<pre><code>linux> ./csim-ref -v -s 5 -E 1 -b 5 -t trace.f0
S 68312c,1 miss
L 683140,8 miss
L 683124,4 hit
L 683120,4 hit
L 603124,4 miss eviction
S 6431a0,4 miss
...</code></pre>


</li>
<li>If you find mention online of a recursive "cache-oblivious algorithm" for matrix transpose, is not a good choice as recursion is not allowed in your solution.</li>
<li>Since your transpose function is being evaluated on a direct-mapped cache, conflict misses are a
potential problem. Think about the potential for conflict misses in your code, especially along the
diagonal. Try to think of access patterns that will decrease the number of these conflict misses.</li>
<li>Blocking is a useful technique for reducing cache misses. See <a href="http://csapp.cs.cmu.edu/public/waside/waside-blocking.pdf">http://csapp.cs.cmu.edu/public/waside/waside-blocking.pdf</a>
and <a href="https://software.intel.com/en-us/articles/how-to-use-loop-blocking-to-optimize-memory-use-on-32-bit-intel-architecture">this intel post</a> for more information.</li>
<li>Only memory accesses to the heap are monitored. This may be helpful.... Just be careful not to break any programming rules!</li>
<li>Your code only needs to work on the three array sizes given. While in CS we often try to avoid writing
non-generalized code, in this case it may be quite helpful to optimize to specific cases to reach the desired
level of performance.</li>
</ul>
</section>
</section>
    </div>
</div>


<a name="reflect"></a>
<div class="panel panel-default">
    <div class="panel-heading"><h3>Lab 4 Reflection</h3></div>
    <div class="panel-body">
        <p>One use of knowing/looking at assembly is understanding what's actually going on, since some "magic" happens between your source code and executable.</p>
        <p>Go back to <code>lab0.c</code> and revert the nested for loops in <code>part4()</code> to the "ijk" ordering.
        Compile <code>lab0.c</code> with the following two optimization levels and compare the dissassembly for <code>part4()</code>:</p>
        <pre><code>$ gcc -g -std=c99 -o lab0 lab0.c
$ gcc -g -O2 -std=c99 -o lab0opt lab0.c</code></pre>
        
        <ol>
            <li class="afterh">What is the ratio of <em>data</em> memory accesses (i.e. ignore instruction fetches) between the <em>text</em> of the unoptimized code and the <em>text</em> of the optimized code (i.e. ignoring the looping mechanics)? &nbsp;[1 pt]
            <br><b>Note:</b> <code>nop*</code> is a family of instructions that do nothing.</li>
            <li class="afterh">Provide at least one reason for the reduction in memory accesses via compiler optimization. &nbsp;[1 pt]</li>
            <li class="afterh">Name two different ways that you have been taught to make "faster" code, one from this class and one from another class you have taken.
            Include an example of each method. &nbsp;[1 pt]</li>
            <li class="afterh">Consider execution time as a possible measurement of performance.
            Name one pro and one con of using this method. &nbsp;[1 pt]</li>
        </ol>
    </div>
</div>


<a name="submit"></a>
<div class="panel panel-default">
    <div class="panel-heading"><h3>Submission</h3></div>
    <div class="panel-body">
        <p>Submit the following files to the <a href="../submit.php"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_canvas.png"/> assignments page</button></a>:</p>
        <ol>
            <li><code>cache-test-skel.c</code></li>
            <li><code>trans.c</code></li>
            <li><code>lab4reflect.txt</code></li>
        </ol>
        <p style="font-style:italic;">Make sure that you have included the geometry of the four mystery caches in a comment in <code>cache-test-skel.c</code> and your final transpose code is in a function named <code>transpose_submit</code>.</p>
    </div>
</div>


<?php printFooter(".."); ?>
