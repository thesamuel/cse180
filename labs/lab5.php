<?php
    include '../include.php';
    printHeader("..","CSE 351 Lab 5");
?>


<a name="info"></a>
<div class="panel panel-default">
    <div class="panel-heading"><h2>Lab 5: Writing a Dynamic Storage Allocator</h2></div>
    <div class="panel-body">
        <div class="exam-listing">
            <div class="exam-name topic">Assigned</div>
            Tuesday, November 28, 2017
        </div>
        <div class="exam-listing">
            <div class="exam-name topic">Due Date</div>
            <em>Friday, December 8, 2017 at 11:59pm</em>
        </div>
        <div class="exam-listing">
            <div class="exam-name topic">Video(s)</div>
            You may find the following videos helpful for getting started with the lab:
            <ul class="afterh">
                <li><a href="../../videos/tutorials/lab5-struct.mp4"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_vid.png"/> BlockInfo struct</button></a> <a href="https://www.youtube.com/watch?v=wX4iQlgdoww"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_yt.png"/> (with captions)</button></a></li>
                <li><a href="../../videos/tutorials/lab5-blocks.mp4"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_vid.png"/> Dynamic memory blocks</button></a> <a href="https://www.youtube.com/watch?v=pBN3WlvZFcU"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_yt.png"/> (with captions)</button></a></li>
                <li><a href="../../videos/tutorials/lab5-macros.mp4"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_vid.png"/> Macros in C</button></a> <a href="https://www.youtube.com/watch?v=-5O2ACWJdPQ"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_yt.png"/> (with captions)</button></a></li>
                <li><a href="../../videos/tutorials/lab5-givenmacros.mp4"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_vid.png"/> Lab 5 macros</button></a> <a href="https://www.youtube.com/watch?v=NraMz0luf94"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_yt.png"/> (with captions)</button></a></li>
            </ul>
        </div>
    </div>
</div>


<a name="overview"></a>
<div class="panel panel-default">
    <div class="panel-heading"><h3>Overview</h3></div>
    <div class="panel-body">
        <b>Learning Objectives:</b>
        <ul>
            <li>Implement a memory allocator using an explicit free list.</li>
            <li>Examine how algorithm choice impacts tradeoffs between utilization and throughput.</li>
            <li>Read and modify a substantial C program.</li>
            <li>Improve your C programming skills including gaining more experience with structs, pointers, macros, and debugging.</li>
        </ul>
        <p>In this lab, you will be writing a dynamic storage allocator for C programs, i.e., your own version of the <code>malloc</code> and <code>free</code> routines.
        This is a classic implementation problem with many interesting algorithms and opportunities to put several of the skills you have learned in this course to good use.
        It is quite involved.
        <em>Start early!</em></p>
    </div>
</div>


<a name="code"></a>
<div class="panel panel-default">
    <div class="panel-heading"><h3>Code for this lab</h3></div>
    <div class="panel-body">
        <div class="exam-listing">
            <div class="exam-name topic">Browser</div>
            <a href="lab5.tar.gz"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_zip.gif"/> Download here</button></a>
        </div>
        <div class="exam-listing">
            <div class="exam-name topic">Terminal</div>
            <code>wget https://courses.cs.washington.edu/courses/cse351/17au/labs/lab5.tar.gz</code>
        </div>
        <div class="exam-listing">
            <div class="exam-name topic">Unzip</div>
            Running <code>tar xzvf lab5.tar.gz</code> from the terminal will extract the lab files to a directory called <code>lab5</code>.
        </div>
    </div>
</div>


<a name="inst"></a>
<div class="panel panel-default">
    <div class="panel-heading"><h3>Lab 5 Instructions</h3></div>
    <div class="panel-body">
<p>The only file you will modify and turn in is <code>mm.c</code> (unless you decide to do extra credit).
You may find the short <code>README</code> file useful to read.</p>

<p>(In the following instructions, we will assume that you are
executing programs on the CSE VM or in your local directory
on <code>attu</code>. For this lab, you can work anywhere
there's a C compiler and <code>make</code>.) </p>

<p>Your dynamic storage allocator will consist of the following three
functions (and several helper functions), which are declared in <code>mm.h</code>
and defined in <code>mm.c</code>:</p>

<pre><code>int   mm_init(void);
void* mm_malloc(size_t size);
void  mm_free(void* ptr);</code></pre>

<p>The <code>mm.c</code> file we have given you partially implements
an allocator using an explicit free list. Your job is to complete this
implementation by filling out <code>mm_malloc</code>
and <code>mm_free</code>. The three main memory management functions
should work as follows:</p>

<ul>
	<li>
		<code>mm_init</code> (provided): Before calling <code>mm_malloc</code> or
		<code>mm_free</code>, the application program (i.e., the
		trace-driven driver program that you will use to evaluate your
		implementation) calls <code>mm_init</code> to perform any necessary
		initializations, such as allocating the initial heap area. The
		return value is -1 if there was a problem in performing the
		initialization, 0 otherwise.</li>

	<li>
		<code>mm_malloc</code>: The <code>mm_malloc</code> routine
		returns a pointer to an allocated block payload of at least <code>size</code>
		bytes. (<code>size_t</code> is a type for describing sizes; it's an
		unsigned integer that can represent a size spanning all of memory, so
		on x86_64 it is a 64-bit unsigned value.)  The entire allocated block should
		lie within the heap region and should not overlap with any other
		allocated block.
	</li>

	<li>
		<code>mm_free</code>: The <code>mm_free</code> routine frees
		the block pointed to by <code>ptr</code>. It returns nothing. This routine
		is guaranteed to work only when the passed pointer (<code>ptr</code>) was
		returned by an earlier call to <code>mm_malloc</code> and has not yet been
		freed.  These semantics match the semantics of the corresponding malloc
		and free routines in libc. Type <code>man malloc</code> in the shell for
		complete documentation.
	</li>

</ul>

<p>We will compare your implementation to the version of malloc
supplied in the standard C library (libc). Since the libc malloc
always returns payload pointers that are aligned to 8 bytes, your
malloc implementation should do likewise and always return 8-byte
aligned pointers.</p>

<!-- Using H3 Here technically breaks style guide, but looks better -->
<h3>Provided Code</h3>

<p class="afterh">We define a <code>BlockInfo</code> struct designed to be used as a
node in a doubly-linked explicit free list, and the following
functions for manipulating free lists:</p>

<ul>
	<li><code>BlockInfo* searchFreeList(size_t reqSize)</code>: returns a block
			of at least the requested size if one exists (and <code>NULL</code>
			otherwise)
	</li>

	<li><code>void insertFreeBlock(BlockInfo* blockInfo)</code>: inserts the
			given block in the free list in a LIFO manner
	</li>

	<li><code>void removeFreeBlock(BlockInfo* blockInfo)</code>: removes the
			given block from the free list
	</li>
</ul>


<p>In addition, we implement <code>mm_init</code> and provide two helper
functions implementing important parts of the allocator:</p>

<ul>
	<li><code>void requestMoreSpace(size_t incr)</code>: enlarges the heap
			 by <code>incr</code> bytes (if enough memory is available on
			 the machine to do so)
	</li>

	<li><code>void coalesceFreeBlock(BlockInfo* oldBlock)</code>: coalesces any
			other free blocks adjacent in memory to <code>oldBlock</code> into a single
			new large block and updates the free list accordingly
	</li>
</ul>

<p>Finally, we use a number of C Preprocessor macros to extract common
pieces of code (constants, annoying casts/pointer manipulation) that
might be prone to error. Each is documented in the code. You are
welcome to create your own macros as well, though the ones already included
in <code>mm.c</code> are the only ones we used in our sample solution,
so it's possible without more. For more info on macros, check
the <a href="http://gcc.gnu.org/onlinedocs/cpp/Macros.html">GCC
manual</a>.<p>
		<ul>
			<li><code>FREE_LIST_HEAD</code>: returns a pointer to
					the first block in the free list (the head of the free list)
			</li>
			<li><code>UNSCALED_POINTER_ADD</code> and <code>UNSCALED_POINTER_SUB</code>: useful
					for calculating pointers without worrying about the size
					of <code>struct BlockInfo</code>
			</li>
			<li>Other short utilities for extracting the size field and
					determining block size
			</li>
		</ul>

<p>Additionally, for debugging purposes, you may want to print the contents
of the heap. This can be accomplished with the provided <code>examine_heap()</code> function.</p>


<h4>Memory System</h4>

<p class="afterh">The <code>memlib.c</code> package simulates the memory system for your
dynamic memory allocator. In your allocator, you can call the
following functions (if you use the provided code for an explicit free
list, most uses of the memory system calls are already covered).</p>

<ul>
	<li>
		<code>void* mem_sbrk(int incr)</code>: Expands the heap
			by <code>incr</code> bytes, where <code>incr</code> is a
			positive nonzero integer and returns a pointer to the first
			byte of the newly allocated heap area. The semantics are
			identical to the Unix <code>sbrk</code> function, except
			that <code>mem_sbrk</code> accepts only a positive nonzero
			integer argument.  (Run <code>man sbrk</code> if you want to
			learn more about what this does in Unix.)
	</li>

	<li>
		<code>void* mem_heap_lo()</code>: Returns a pointer to the first
		byte in the heap
	</li>

	<li>
		<code>void* mem_heap_hi()</code>: Returns a pointer to the last
		byte in the heap.
	</li>

	<li>
		<code>size_t mem_heapsize()</code>: Returns the current size of
		the heap in bytes.
	</li>

	<li><code>size_t mem_pagesize()</code>: Returns the system's page
		size in bytes (4K on Linux systems).
	</li>
</ul>


<h4>The Trace-driven Driver Program</h4>

<p class="afterh">The driver program <code>mdriver.c</code> in
the <code>lab5.tar.gz</code> distribution tests your <code>mm.c</code>
package for correctness, space utilization, and throughput.  Use the
command <code>make</code> to generate the driver code and run it with
the command <code>./mdriver&nbsp;-V</code> (the <code>-V</code> flag
displays helpful summary information as described below).</p>

<p>The driver program is controlled by a set of <em>trace files</em>
	that it will expect to find in a subdirectory
	called <code>traces</code>.  The .tar.gz file provided to you should
	unpack into a directory structure that places
	the <code>traces</code> subdirectory in the correct location
	relative to the driver. (If you want to move the trace files around,
	you can update the TRACEDIR path in <code>config.h</code>). Each
	trace file contains a sequence of allocate and free directions that
	instruct the driver to call your <code>mm_malloc</code> and <code>
	mm_free</code> routines in some sequence. The driver and the trace
	files are the same ones we will use when we grade your
	submitted <code>mm.c</code> file.</p>

<p>The <code>mdriver</code> executable accepts the following command
line arguments:</p>

<ul>
	<li>
		<code>-t &lt;tracedir&#62;</code>: Look for the default trace
		files in directory <code>tracedir</code> instead of the default
		directory defined in <code>config.h</code>.
	</li>

	<li>
		<code>-f &lt;tracefile&#62;</code>: Use one
		particular <code>tracefile</code> for testing instead of the
		default set of tracefiles.
	</li>

	<li>
		<code>-h</code>: Print a summary of the command line arguments.
	</li>

	<li>
		<code>-l</code>: Run and measure <code>libc</code> malloc in
		addition to the student's malloc package.
	</li>

	<li>
		<code>-v</code>: Verbose output. Print a performance breakdown for
		each tracefile in a compact table.
	</li>

	<li>
		<code>-V</code>: More verbose output. Prints additional diagnostic
		information as each trace file is processed.  Useful during
		debugging for determining which trace file is causing your malloc
		package to fail.
	</li>
</ul>

<!-- Using H3 Here technically breaks style guide, but looks better -->
<h3>Programming Rules</h3>

<ul class="afterh">
	<li>You should not change any of the interfaces in <code>mm.c</code>
	(e.g. names of functions, number and type of parameters, etc.).</li>

	<li>
		You should not invoke any memory-management related library calls
			or system calls.  This means you cannot use
			<code>malloc</code>, <code>calloc</code>, <code>free</code>, <code>realloc</code>, <code>sbrk</code>, <code>brk</code>
			or any variants of these calls in your code.  (You may use all
			the functions in <code>memlib.c</code>, of course.)
	</li>

	<li>You are not allowed to define any global or <code>static</code>
		compound data structures such as arrays, structs, trees, or lists
		in your <code>mm.c</code> program.  You <em>are</em> allowed to
		declare global scalar variables such as integers, floats, and
		pointers in <code>mm.c</code>, but try to keep these to a minimum.
		(It is possible to complete the implementation of the explicit
		free list without adding any global variables.)
	</li>

	<li>
		For consistency with the <code>malloc</code> implementation
		in <code>libc</code>, which returns blocks aligned on 8-byte
		boundaries, your allocator must always return pointers that are
		aligned to 8-byte boundaries.  The driver will enforce this
		requirement for you.
	</li>
</ul>


<!-- Using H3 Here technically breaks style guide, but looks better -->
<h3>Collaboration</h3>

<p class="afterh">In general we encourage students to discuss ideas from the labs and
homeworks. Please refer to
the <a href="http://courses.cs.washington.edu/courses/cse351/17sp/policies.html#collaboration">course
collaboration policy</a> for a reminder on what is appropriate
behavior.  In particular, we remind you that referring to solutions from
previous quarters or from a similar course at another university or on
the web is cheating.  As is done in CSE 142 and 143, we will run
similarity-detection software over submitted student programs,
including programs from past quarters. Please start early and make use
of all the resources we provide (office hours, GoPost) to help you
succeed!

<!-- Using H3 Here technically breaks style guide, but looks better -->
<h3>Evaluation</h3>

<p class="afterh">Your grade will be calculated (as a percentage) out of a total of
63 points as follows:</p>

<ul>
	<li><strong>Correctness (45 points).</strong> You will receive 5 points for
			each test performed by the driver program that your solution
			passes. (9 tests)

		</li>

	<li> <strong>Style (10 points).</strong>

		<ul>
			<li>Your code should use as few global variables as possible (ideally
				none!).
				</li>

			<li>
				Your code should be as clear and concise as possible.
				</li>
			<li>
				You should use provided macros
				whenever they do what is needed and
				make your code more readable.  You
				will lose points if you reimplement
				code or use "magic numbers" where you
				should have used a macro instead.
				</li>

			<li>
				Since some of the unstructured pointer
				manipulation inherent to allocators
				can be confusing, we expect to see short inline
				comments on steps of the allocation
				algorithms.
				(These will also help us give you
				partial credit if you have a partially
				working implementation.)
				</li>

			<li>
				Each function should have a header comment that describes
				what it does and how it does it.
				</li>
			</ul>
		</li>

	<li> <strong>Performance (5 points).</strong>  Performance represents a small
			portion of your grade.  We are most concerned about the correctness
			of your implementation.  For the most part, a correct implementation
			will yield reasonable performance.  Two performance metrics will be
			used to evaluate your solution:


		<ul>
			<li> <i>Space utilization</i>: The peak ratio between the aggregate
				amount of memory used by the driver (i.e., allocated via
				<code>mm_malloc</code>  but not yet freed via
				<code>mm_free</code>) and the size of the heap used by your
				allocator. The optimal ratio is 1, <font color="red">although in practice we
					will not be able to achieve that ratio</font>. You should find good
				policies to minimize fragmentation in order to make this ratio
				as close as possible to the optimal.

				</li>

			<li>
				<i>Throughput</i>: The average number of operations completed per second.

				</li>
			</ul>

		The driver program summarizes the performance of your
		allocator by computing a <strong>performance index</strong>, P, which is a
		weighted sum of the space utilization and throughput:

<pre><code>P = 0.6U + 0.4 min (1, T/Tlibc)</code></pre>

		where U is your space utilization, T is your throughput, and
		T<sub>libc</sub> is the estimated throughput of <code>libc</code>
		malloc on your system on the default traces.  The performance
		index favors space utilization over throughput.  You will receive
		5(P+ 0.1) points, rounded <strong>up</strong> to the closest whole
		point.  For example, a solution with a performance index of 0.63
		or 63% will receive 4 performance points.  Our complete version of
		the explicit free list allocator has a performance index between
		just over 0.7 and 0.8; it would receive a full 5 points. <b>Thus
		if you have a performance index GREATER THAN 0.7 (mdriver prints
		this as "70/100") then you will get the full 5 points for
		Performance.</b>

		Observing that both memory and CPU cycles are expensive system
		resources, we adopt this formula to encourage balanced optimization of
		both memory utilization and throughput.  Ideally, the performance
		index will reach  P = 1 or  100% .  To receive a good
		performance score, you must achieve a balance between utilization and
		throughput.
		</li>
	<li> <strong>Reflection (3 points).</strong> </li>
</ul>

<hr>
<div class="unspacesection"></div>
<section id="resources"><br>
<h3>Resources</h3>
        <p class="afterh">We are providing some extra homework-style practice problems for memory allocation in case you find them helpful in preparing for lab 5.
        You do not need to submit these, they are just good practice.
        Read section 9.9 from the textbook for review.
        (Note &ldquo;word&rdquo; means 4 bytes for these problems)</p>
        <ol>
	    <li>Practice Problem 9.6, p. 849</li>
	    <li>Practice Problem 9.7, p. 852</li>
	    <li>Practice Problem 9.10, p. 864</li>
	    <li>Homework Problem 9.15, p. 879</li>
	    <li>Homework Problem 9.16, p. 879</li>
        </ol>

        <h4>Heap Simulator</h4>

        <p class="afterh">This unofficial <a target="_blank" href="http://sarangjo.github.io/cse351-heap"><b>heap simulator</b></a> is helpful to get familiar with the operations of the heap.
        If you have any questions about the simulator, shoot an email to <code>sarangj (at) cs (dot) uw (dot) edu</code>.</p>
</section>

</section>

<hr>
<div class="unspacesection"></div>
<section id="hints"><br>
<h3>Hints</h3>

<h4 class="afterh">Getting Started</h3>
<ul class="afterh">
		<li>Read these instructions.</li>
		<li>Read over the provided code.</li>
		<li>Take notes while doing the above.</li>
		<li>Draw some diagrams of what the data structures should look like before and after various operations.</li>
</ul>

<h4>Debugging</h4>
<ul class="afterh">
	<li>Use the <code>mdriver</code> <code>-f</code> option. During initial
		development, using tiny trace files will simplify debugging and
		testing. We have included two such trace files (<code>short1-bal.rep</code>
		and <code>short2-bal.rep</code>) that you can use for initial debugging.
		</li>

	<li>Use the <code>mdriver</code> <code>-v</code> and <code>-V</code> options. The
		<code>-v</code> option will give you a detailed summary for each trace file.
		The <code>-V</code> will also indicate when each trace file is read, which
		will help you isolate errors.

		</li>

	<li>Compile with <code>gcc -g</code> and use <code>gdb</code>. The <code>-g</code>
		flag tells <code>gcc</code> to include debugging symbols, so <code>gdb</code> can
		follow the source code as it steps through the executable.  The
		<code>Makefile</code> should already be set up to do this.  A debugger will
		help you isolate and identify out of bounds memory references. You can specify
		any command line arguments for <code>mdriver</code> after the <code>run</code>
		command in <code>gdb</code> e.g. <code>run -f short1-bal.rep</code>.
	</li>

	<li>Understand every line of the malloc implementation in the
		textbook. The textbook has a detailed example of a simple
		allocator based on an implicit free list. Use this as a point of
		departure.  Don't start working on your allocator until you
		understand everything about the simple implicit list allocator.
	</li>

	<li>Write a function that treats the heap as an implicit list, and
	 prints all header information from all the blocks in the heap. Using
	 <code>fprintf</code> to print to <code>stderr</code> is helpful here
	 because standard error is not buffered so you will get output from your
	 print statements even if the next statement crashes your program.</li>

	<li>Encapsulate your pointer arithmetic in C preprocessor
		macros. Pointer arithmetic in memory managers is confusing and
		error-prone because of all the casting that is necessary. We have
		supplied maros that do this: see <code>UNSCALED_POINTER_ADD</code> and
		<code>UNSCALED_POINTER_SUB</code>.
	</li>

	<li>Use a profiler. You may find the <code>gprof</code> tool helpful
		for optimizing performance. (<code>man gprof</code> or searching online for
		<code>gprof</code> documentation will get you the basics.) If you
			use <code> gprof</code>, see the hint about debugging above for
			how to pass extra arguments to GCC in the <code>Makefile</code>.
	</li>

	<li>Start early! It is possible to write an efficient malloc package
	with a few pages of code. However, we can guarantee that it will be
	some of the most difficult and sophisticated code you have written
	so far in your career. So start early, and good luck!
	</li>
</ul>


<h4>Heap Consistency Checker</h4>

<p class="afterh"><em>This is an optional, but recommended, addition</em> that will help you
check to see if your allocator is doing what it should (or figure out what it's
doing wrong if not).  Dynamic memory allocators are notoriously tricky beasts to
program correctly and efficiently. They are difficult to program correctly
because they involve a lot of untyped pointer manipulation.  In addition to the
usual debugging techniques, you may find it helpful to write a heap checker that
scans the heap and checks it for consistency.</p>

<p>Some examples of what a heap checker might check are:</p>

<ul>
	<li>Is every block in the free list marked as free?</li>
	<li>Are there any contiguous free blocks that somehow escaped
		coalescing?</li>
	<li>Is every free block actually in the free list?</li>
	<li>Do the pointers in the free list point to valid free blocks?</li>
	<li>Do any allocated blocks overlap?</li>
	<li>Do the pointers in a heap block point to valid heap
		addresses?</li>
</ul>

<p>Your heap checker will consist of the function <code>int mm_check(void)</code> in <code>mm.c</code>.  Feel free to rename it, break it
into several functions, and call it wherever you want.  It should
check any invariants or consistency conditions you consider prudent.
It returns a nonzero value if and only if your heap is consistent.
This is not required, but may prove useful.  When you submit <code>mm.c</code>, make sure to remove any calls to <code>mm_check</code> as they will
slow down your throughput.</p>
</section>
<hr>
<div class="unspacesection"></div>
<section id="extra-credit"><br>
<h3>Extra Credit</h3>

<p class="afterh">As optional extra credit, implement a final memory allocation-related
function: <code>mm_realloc</code>. Write your implementation in
<code>mm-realloc.c</code>.</p>

<p>The signature for this function, which
you will find in your <code>mm.h</code> file, is:</p>

<pre><code>extern void* mm_realloc(void* ptr, size_t size);</code></pre>

<p>Similarly, you should find the following in your <code>mm-realloc.c</code> file:</p>

<pre><code>void* mm_realloc(void* ptr, size_t size) {
	// ... implementation here ...
}
</code></pre>

<p>To receive credit, you should follow the contract of the C library's
<code>realloc</code> exactly (pretending that <code>malloc</code> and
<code>free</code> are <code>mm_malloc</code> and <code>mm_free</code>, etc.).
The man page entry for <code>realloc</code> says:</p>

<pre>
The realloc() function changes the size of the memory block pointed to by
ptr to size bytes.  The contents will be unchanged in the range from the
start of the region up to the minimum of the old and new sizes.  If the
new size is larger than the old size, the added memory will not be
initialized.  If ptr is NULL, then the call is equivalent to
malloc(size), for all values of size; if size is equal to zero, and ptr
is not NULL, then the call is equivalent to free(ptr).  Unless ptr is
NULL, it must have been returned by an earlier call to malloc(), calloc()
or realloc().  If the area pointed to was moved, a free(ptr) is done.
</pre>

<p>A good test would be to compare the behavior of your <code>mm_realloc</code> to
that of <code>realloc</code>, checking each of the above cases.
Your implementation of <code>mm_realloc</code> should also be performant.
Avoid copying memory if possible, making use of nearby free blocks.
You should not use <code>memcpy</code> to copy memory; instead, copy
<code>WORD_SIZE</code> bytes at a time to the new destination while
iterating over the existing data.</p>

<p>To run tracefiles that test <code>mm_realloc</code>, compile using
<code>make mdriver-realloc</code>. Then, run <code>mmdriver-realloc</code>
with the <code>-f</code> flag to specify a tracefile, or first edit
<code>config.h</code> to include additional realloc tracefiles
(<code>realloc-bal.rep</code> and <code>realloc2-bal.rep</code>) in the
default list.</p>

<p>Don't forget to submit your finished <code>mm-realloc.c</code> along with <code>mm.c</code>.</p>

<h3>Extra Extra Credit</h3>

<p class="afterh">Do NOT spend time on this part until you have finished and turned in the core assignment.</p>

<p>In this extra credit portion, you will implement a basic mark and sweep
garbage collector. Write your implementation in <code>mm-gc.c</code>.</p>
<p>Some additional notes:</p>
<ul>
<li>To test the current garbage collector, use <code>make mdriver-garbage</code> which generates an executable called <code>mdriver-garbage</code>.</li>
<li>The driver assumes that you have a correctly working <code>mm_malloc</code> and <code>mm_free</code> implementation.</li>
<li>The tester checks that all of the blocks that should have been freed are freed and that all of the others remain allocated. On success it prints "Success! The garbage collector passed all of the tests".  You can look in <code>GarbageCollectorDriver.c</code> to see what the test code does.</li>
<li>This implementation assumes that the alignment is 8 bytes because the third bit of <code>sizeAndTags</code> is used as the mark bit to mark the block.</li>
<li>The function <code>is_pointer</code> only looks for pointers that
point to the beginning of a payload (like Java), and will return false
if it points to a free block.</li>
<li>Pointers will always be word aligned in the data block.</li>
</ul>

<p>Don't forget to submit your finished <code>mm-gc.c</code> along with <code>mm.c</code>.</p>
</section>
    </div>
</div>


<a name="reflect"></a>
<div class="panel panel-default">
    <div class="panel-heading"><h3>Lab 5 Reflection</h3></div>
    <div class="panel-body">
        <p>Go back to <code>part5</code> of <code>lab0.c</code> and add a <code>malloc</code> statement with 16 as its argument <em>before</em> the <code>malloc</code> for <code>class_grades</code>.
        Recompile the file and examine the difference in the addresses of the two heap blocks in <code>part5</code>.
        Play around with the size of the new malloc-ed block and answer the following questions:</p>
        <ol>
            <li>What is the alignment size this allocator is using? &nbsp;[0.5 pt]</li>
            <li class="afterh">What is the total size of the boundary tag(s) in each block in this implementation?
            Briefly describe how you came to this conclusion. &nbsp;[1.5 pt]
            <li class="afterh">Can you tell if this implementation uses a footer in allocated blocks?
            Briefly explain why or why not. &nbsp;[1 pt]</li>
        </ol>
    </div>
</div>


<a name="submit"></a>
<div class="panel panel-default">
    <div class="panel-heading"><h3>Submission</h3></div>
    <div class="panel-body">
        <p>Submit the following files to the <a href="../submit.php"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_canvas.png"/> assignments page</button></a>:
        <ul>
            <li><code>mm.c</code></li>
            <li><code>mm-realloc.c</code> [if you did the extra credit]</li>
            <li><code>mm-gc.c</code> [if you did the extra extra credit]</li>
            <li><code>lab5reflect.txt</code></li>
        </ul>
    </div>
</div>


<?php printFooter(".."); ?>
