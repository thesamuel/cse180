<?php
    include '../include.php';
    printHeader("..","CSE 351 Lab 3");
?>


<a name="info"></a>
<div class="panel panel-default">
    <div class="panel-heading"><h2>Lab 3: Buffer Overflows?|?d??|?d?Segmentation fault: 11</h2></div>
    <div class="panel-body">
        <div class="exam-listing">
            <div class="exam-name topic">Assigned</div>
            Wednesday, November 1, 2017
        </div>
        <div class="exam-listing">
            <div class="exam-name topic">Due Date</div>
            <em>Friday, November 10, 2017 at 11:59pm</em>
        </div>
        <div class="exam-listing">
            <div class="exam-name topic">Video(s)</div>
            Watch this <a href="../../videos/tutorials/lab3-phase0.mp4"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_vid.png"/> video on Phase 0</button></a> <a href="https://www.youtube.com/watch?v=45l-rHoicVc"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_yt.png"/> (with captions)</button></a> before you begin!
            You may also find this <a href="../../videos/tutorials/lab3-endianness.mp4"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_vid.png"/> video on endianness</button></a> <a href="https://www.youtube.com/watch?v=LVPvgq4D63k"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_yt.png"/> (with captions)</button></a> helpful as you work with GDB throughout the lab.
        </div>
    </div>
</div>

<a name="overview"></a>
<div class="panel panel-default">
    <div class="panel-heading"><h3>Overview</h3></div>
    <div class="panel-body">
        <b>Learning Objectives:</b>
        <ul>
            <li>Gain a detailed understanding of x86-64 stack organization.</li>
            <li>Gain a better understanding of what decisions are made at compile time vs. what modifications/decisions can occur when the program runs.</li>
            <li>Refine your skills examining x86-64 assembly in <code>gdb</code>.</li>
            <li>Understand how several types of buffer overflow exploits can affect a program.</li>
        </ul>
        <p>This assignment involves applying a series of buffer overflow attacks on an executable file called <code>bufbomb</code> (for some reason, the textbook authors have a penchant for pyrotechnics).</p>
        <p>You will gain firsthand experience with one of the methods commonly used to exploit security weaknesses in operating systems and network servers.
        Our purpose is to help you learn about the runtime operation of programs and to understand the nature of this form of security weakness so that you can avoid it when you write system code.
        <em>We do not condone the use of these or any other form of attack to gain unauthorized access to any system resources.
        There are criminal statutes governing such activities.</em></p>
    </div>
</div>


<a name="code"></a>
<div class="panel panel-default">
    <div class="panel-heading"><h3>Code for this lab</h3></div>
    <div class="panel-body">
        <div class="exam-listing">
            <div class="exam-name topic">Browser</div>
            <a href="lab3.tar"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_zip.gif"/> Download here</button></a>
        </div>
        <div class="exam-listing">
            <div class="exam-name topic">Terminal</div>
            <code>wget https://courses.cs.washington.edu/courses/cse351/17au/labs/lab3.tar</code>
        </div>
        <div class="exam-listing">
            <div class="exam-name topic">Unzip</div>
            Running <code>tar xvf lab3.tar</code> from the terminal will extract the lab files to a directory called <code>lab3</code> with the following files:
            <ul>
                <li><code>bufbomb</code> - The executable you will attack</li>
                <li><code>bufbomb.c</code> - The important bits of C code used to compile <code>bufbomb</code></li>
                <li><code>lab3reflect.txt</code> - For your Reflection responses</li>
                <li><code>Makefile</code> - For testing your exploits prior to submission</li>
                <li><code>makecookie</code> - Generates a "cookie" based on some string (which will be your username)</li>
                <li><code>sendstring</code> - A utility to help convert between string formats</li>
            </ul>
        </div>
    </div>
</div>



<a name="inst"></a>
<div class="panel panel-default">
    <div class="panel-heading"><h3>Lab 3 Instructions</h3></div>
    <div class="panel-body">


<p><b>Note:</b> All the provided programs are compiled to run on the 64-bit CSE VM or <code>attu</code>.
The rest of the instructions assume that you will be performing your work on one of those platforms.
You should be sure your solution works on one of those platforms before submitting it!</p>

<p>Be sure to read this write-up in its entirety before beginning your
work.</p>

<h4>A Note about Line Endings</h4>
<p class="afterh">Linux (and UNIX machines in general) use a different line ending from
Windows and traditional MacOS in text files. The reason for this difference
is historical: early printers need more time to move the print head back
to the beginning of the next line than to print a single character, so
someone introduced the idea of separate line feed <code>\n</code> and carriage
return <code>\r</code> characters. Windows and HTTP use the <code>\r\n</code>
pairs, MacOS uses <code>\r</code>, and Linux uses <code>\n</code>. In this lab,
it is important that your lines end with line feed (<code>\n</code>), not any
of the alternative line endings. If you are working on the VM or attu or 
even another Linux system this will probably not be a problem, but if you 
working across systems, check your line endings. You can also use the Unix tool
<code>dos2unix</code> to convert the line endings from your host OS (Windows or
Mac) to Unix line endings.</p>

<h4>Making Your Cookie</h4>

<p class="afterh">A cookie is a string of eight bytes (or 16 hexadecimal digits) that
is (with high probability) unique to you. You can generate your cookie
with the <code>makecookie</code> program giving your UWNetID as the
argument (note, you must use your UWNetID, CSE students should NOT use
their CSEID &mdash; for some people these two IDs are different):

<pre><code>$ ./makecookie your_UWNetID
0x5e57e63274f39587
</code></pre>

<p>As an example, if your UW email address
is <code>thecookiemonster42@uw.edu</code>, you would
run <code>./makecookie thecookiemonster42</code>.</p>

<p>While you are doing this, you might as well prepare the first file
you need to turn in: UW_ID.txt</p>

<pre><code>$ echo your_UWNetID > UW_ID.txt</code></pre>

<p>Where you replaced <code>your_UWNetID</code> with your real username as
above, this will generate a text file containing your UWNetID 
followed by a single new line. You could also use a text editor,
but you have to be careful about line endings.</p>

<p>In most of the attacks in this lab, your objective will be to make your cookie show up in places where it ordinarily would not.</p>

<h4>Using the <code>bufbomb</code> Program</h4>

<p class="afterh">The <code>bufbomb</code> program reads a string from standard input
with the function <code>getbuf()</code>:</p>

<pre><code>unsigned long long getbuf() {
   char buf[36];
   volatile char* variable_length;
   int i;
   unsigned long long val = (unsigned long long)Gets(buf);
   variable_length = alloca((val % 40) < 36 ? 36 : val % 40);
   for(i = 0; i < 36; i++) {
      variable_length[i] = buf[i];
   }
   return val % 40;
}</code></pre>

<p>Don't worry about what's going on with <code>variable_length</code>
and <code>val</code> and <code>alloca</code> for now; all you need
to know is that <code>getbuf()</code> calls the function <code>Gets</code>
and returns some arbitrary value.</p>

<p>The function <code>Gets</code> is similar to the standard C
library function <code>gets</code>&mdash;it reads a string from
standard input (terminated by '<code>\n</code>')
and stores it (along with a null terminator) at the specified
destination. In the above code, the destination is an
array <code>buf</code> having sufficient space for 36 characters.</p>

<p>Neither <code>Gets</code> nor <code>gets</code> have any way to
determine whether there is enough space at the destination to store
the entire string. Instead, they simply copy the entire string,
possibly overrunning the bounds of the storage allocated at the
destination.</p>

<p>If the string typed by the user to <code>getbuf</code> is no more
than 36 characters long, it is clear that <code>getbuf</code> will
return some value less than 0x28, as shown by the following execution example:</p>

<pre><code>$ ./bufbomb
Type string: <strong>howdy doody</strong>
Dud: getbuf returned 0x20
</code></pre>

<p>It's possible that the value returned might differ for you, since
the returned value is derived from the location on the stack
that <code>Gets</code> is writing to.  The returned value will also
be different depending on whether you run the bomb inside gdb or run
it outside of gdb for the same reason.</p>

<p>Typically an error occurs if we type a longer string:</p>

<pre><code>$ ./bufbomb
Type string: <strong>This string is too long and it starts overwriting things.</strong>
Ouch!: You caused a segmentation fault!
</code></pre>

<p>As the error message indicates, overrunning the buffer typically
causes the program state (e.g., the return addresses and other data
structures that were stored on the stack) to be corrupted, leading to
a memory access error. Your task is to be more clever with the strings
you feed <code> bufbomb</code> so that it does more interesting
things. These are called exploit strings.</p>

<p><code>bufbomb</code> must be run with
the <code>-u your_UWNetID</code> flag, which operates the bomb
for the indicated UWNetID. (We will feed bufbomb your UWNetID 
with the <code>-u</code> flag when grading your solutions.)
<code>bufbomb</code> determines the cookie you will be using based on
this flag value, just as the program <code>makecookie</code>
does. Some of the key stack addresses you will need to use depend on
your cookie.</p>


<h4>Formatting Your Exploit Strings</h4>

<p class="afterh">Your exploit strings will typically contain byte values that do not
correspond to the ASCII values for printing characters. The program
<code>sendstring</code> can help you generate these raw
strings. <code>sendstring</code> takes as input a hex-formatted string
and prints the raw string to standard output. In a hex-formatted
string, each byte value is represented by two hex digits. Byte values
are separated by spaces. For example, the string <code>"012345"</code>
could be entered in hex format as <code>30 31 32 33 34 35</code>. (The
ASCII code for decimal digit <code>Z</code> is <code>0x3Z</code>.
Run <code>man ascii</code> for a full table.)  Non-hex digit
characters are ignored, including the blanks in the example shown.</p>

<p>If you generate a hex-formatted exploit string in a file
named <code>exploit.txt</code>, you can send it
  to <code>bufbomb</code> through a couple of pipes (see <a href="http://courses.cs.washington.edu/courses/cse391/17sp/lectures/2/391Lecture02_17sp.pdf">CSE391 course notes</a>
if you are unfamiliar with Unix pipes that take the output of one program
and direct it as input to another program):</p>

<pre><code>$ cat exploit.txt | ./sendstring | ./bufbomb -u your_UWNetID
</code></pre>

<p>Or you can store the raw bytes in a file and use I/O
redirection to supply it to <code>bufbomb</code>:</p>
<pre><code>$ ./sendstring &lt; exploit.txt &#62; exploit.bytes
$ ./bufbomb -u your_UWNetID &lt; exploit.bytes
</code></pre>

<p>With the above method, when running <code>bufbomb</code> from
within <code>gdb</code>, you can pass in the exploit string as
follows:</p>

<pre><code>$ gdb ./bufbomb
(gdb) run -u your_UWNetID &lt; exploit.bytes
</code></pre>

<p>One important point: your exploit string must not contain byte value
<code>0x0A</code> at any intermediate position, since this is the
ASCII code for newline ('<code>\n</code>'). When <code>Gets</code>
encounters this byte, it will assume you intended to terminate the
string. <code>sendstring</code> will warn you if it encounters this
byte value.</p>

<p>When using <code>gdb</code>, you may find it useful to save a
series of <code>gdb</code> commands to a text file and then use
the <code>-x commands.txt</code> flag. This saves you the trouble of
retyping the commands every time you run <code>gdb</code>. You can
read more about the <code>-x</code> flag
in <code>gdb</code>'s <code>man</code> page.</p>

<h4 id="byte-codes">Generating Byte Codes</h4>

<p class="afterh">(You may wish to come back and read this section later after looking at
the problems.)</p>

<p>Using <code>gcc</code> as an assembler and <code>objdump</code> as
a disassembler makes it convenient to generate the byte codes for
instruction sequences.  For example, suppose we write a
file <code>example.s</code> containing the following assembly
code:</p>

<pre><code># Example of hand-generated assembly code
movq $0x1234abcd,%rax    # Move 0x1234abcd to %rax
pushq $0x401080          # Push 0x401080 on to the stack
retq                     # Return
</code></pre>

<p>The code can contain a mixture of instructions and data.  Anything
to the right of a '<code>#</code>' character is a comment.</p>

<p>We can now assemble and disassemble this file:
<pre><code>$ gcc -c example.s
$ objdump -d example.o &#62; example.d
</code></pre>

<p>The generated file <code>example.d</code> contains the following lines</p>

<pre><code>
   0:	48 c7 c0 cd ab 34 12 	mov    $0x1234abcd,%rax
   7:	68 80 10 40 00       	pushq  $0x401080
   c:	c3                   	retq
</code></pre>

<p>Each line shows a single instruction. The number on the left
indicates the starting address (starting with 0), while the hex digits
after the '<code>:</code>' character indicate the byte codes for the
instruction. Thus, we can see that the instruction <code>pushq
$0x<span style="color: orange">40</span><span style="color: green">10</span><span style="color: blue">80</span></code> has a hex-formatted byte code of <code>68 <span style="color: blue">80</span> <span style="color: green">10</span> <span style="color: orange">40</span> 00</code>.</p>

<p>If we read off the 4 bytes starting at address 8 we
get: <code><span style="color: blue">80</span> <span style="color: green">10</span> <span style="color: orange">40</span> 00</code>.  This is a byte-reversed version of the
data word <code>0x00<span style="color: orange">40</span><span style="color: green">10</span><span style="color: blue">80</span></code>.  This byte reversal
represents the proper way to supply the bytes as a string, since a
little-endian machine lists the least significant byte first. </p>

<p>Finally, we can read off the byte sequence for our code (omitting the
final <code>0</code>'s) as:</p>

<pre><code>48 c7 c0 cd ab 34 12 68 80 10 40 00 c3
</code></pre>

<hr>
<div class="unspacesection"></div>
<section id="exploits"><br>
<h3>The Exploits</h3>

<p class="afterh">There are three functions that you must exploit for this lab. The
exploits increase in difficulty. For those of you looking for a
challenge, there is a fourth function you can exploit for extra
credit.</p>

<h4>Level 0: Candle</h4>

<p class="afterh">The function <code>getbuf</code> is called
within <code>bufbomb</code> by a function
<code>test</code>:</p>

<pre><code>void test()
{
   volatile unsigned long long val;
   volatile unsigned long long local = 0xdeadbeef;
   char* variable_length;
   entry_check(3);  /* Make sure entered this function properly */
   val = <strong>getbuf()</strong>;
   if (val <= 40) {
      variable_length = alloca(val);
   }
   entry_check(3);
   /* Check for corrupted stack */
   if (local != 0xdeadbeef) {
      printf("Sabotaged!: the stack has been corrupted\n");
   }
   else if (val == cookie) {
      printf("Boom!: getbuf returned 0x%llx\n", val);
      if (local != 0xdeadbeef) {
         printf("Sabotaged!: the stack has been corrupted\n");
      }
      validate(3);
   }
   else {
      printf("Dud: getbuf returned 0x%llx\n", val);
   }
}
</code></pre>

<!--
this seems unnecessary, but just in case we need it...
if (val != cookie) {
     printf("Sabotaged!: control flow has been disrupted\n");
}
-->

<p>When <code>getbuf</code> executes its return statement, the
program ordinarily resumes execution within function
<code>test</code>. Within the file <code>bufbomb</code>, there is a
function <code>smoke</code>:</p>

<pre><code>void smoke()
{
    entry_check(0); /* Make sure entered this function properly */
    printf("Smoke!: You called smoke()\n");
    validate(0);
    exit(0);
}</code></pre>

<p>Your task is to get <code>bufbomb</code> to execute the code
for <code>smoke</code> when <code>getbuf</code> executes its
return statement, rather than returning to <code>test</code>. You
can do this by supplying an exploit string that overwrites the stored
return address in the stack frame for <code> getbuf</code> with the
address of the first instruction in <code>smoke</code>.  Note that
your exploit string may also corrupt other parts of the stack state,
but this will not cause a problem, because <code>smoke</code> causes
the program to exit directly.</p>

<h5>Advice:</h5>

<ul>
  <li> All the information you need to devise your exploit string for
  this level can be determined by examining a disassembled version
  of <code>bufbomb</code>.</li>
  <li>Be careful about byte ordering.</li>
  <li>You might want to use <code>gdb</code> to step the program
  through the last few instructions of <code>getbuf</code> to make
  sure it is doing the right thing.</li>
  <li>The placement of <code>buf</code> within the stack frame
  for <code>getbuf</code> depends on which version
  of <code>gcc</code> was used to compile <code> bufbomb</code>. You
  will need to pad the beginning of your exploit string with the
  proper number of bytes to overwrite the return pointer. The values
  of these bytes can be arbitrary.</li>
  <li>Check the line endings in your smoke.txt with
    <code>od -c smoke.txt</code> or <code>hexdump -C smoke.txt</code>.</li>
</ul>


<h4>Level 1: Sparkler</h4>

<p class="afterh">Within the file <code>bufbomb</code> there is also a
function <code>fizz</code>:</p>

<pre><code>void fizz(int arg1, char arg2, long arg3,
    char* arg4, short arg5, short arg6, unsigned long long val)
{
    entry_check(1); /* Make sure entered this function properly */
    if (val == cookie)
    {
        printf("Fizz!: You called fizz(0x%llx)\n", val);
        validate(1);
    }
    else
    {
        printf("Misfire: You called fizz(0x%llx)\n", val);
    }
    exit(0);
}</code></pre>

<p>Similar to Level 0, your task is to get <code>bufbomb</code> to
execute the code for <code>fizz()</code> rather than returning
to <code>test</code>. In this case, however, you must make it appear
to <code>fizz</code> as if you have passed your cookie as its
argument. You can do this by encoding your cookie in the appropriate
place within your exploit string.</p>

<h5>Advice:</h5>

<ul>
  <li>Note that in x86-64, the first six arguments are passed into
  registers and additional arguments are passed through the
  stack. Your exploit code needs to write to the appropriate
  place within the stack.</li>

  <li>You can use <code>gdb</code> to get the information you need to
  construct your exploit string. Set a breakpoint
  within <code>getbuf</code> and run to this breakpoint.  Determine
  parameters such as the address of the buffer <code>buf</code>.</li>
</ul>


<h4>Level 2: Firecracker</h4>

<p class="afterh">A much more sophisticated form of buffer attack involves supplying
a string that encodes actual machine instructions. The exploit string
then overwrites the return pointer with the starting address of these
instructions. When the calling function (in this
case <code>getbuf</code>) executes its <code>ret</code> instruction,
the program will start executing the instructions on the stack rather
than returning. With this form of attack, you can get the program to
do almost anything. The code you place on the stack is called
the exploit code. This style of attack is tricky, though,
because you must get machine code onto the stack and set the return
pointer to the start of this code.</p>

<p>For level 2, you will need to run your exploit
within <code>gdb</code> for it to succeed. (the CSE VM and <code>attu</code> have special memory protection that prevents execution of
memory locations in the stack. Since <code>gdb</code> works a little
differently, it will allow the exploit to succeed.)</p>

<p>Within the file <code>bufbomb</code> there is a
function <code>bang</code>:</p>

<pre><code class="cpp">unsigned long long global_value = 0;

void bang(unsigned long long val)
{
    entry_check(2); /* Make sure entered this function properly */
    if (global_value == cookie)
    {
       printf("Bang!: You set global_value to 0x%llx\n", global_value);
       validate(2);
    }
    else
    {
        printf("Misfire: global_value = 0x%llx\n", global_value);
    }
    exit(0);
}</code></pre>

<p>Similar to Levels 0 and 1, your task is to get <code>bufbomb</code>
 to execute the code for <code>bang</code> rather than returning
 to <code>test</code>. Before this, however, you must set global
 variable <code>global_value</code> to your cookie. Your exploit code
 should set <code>global_value</code>, push the address
 of <code>bang</code> on the stack, and then execute
 a <code>retq</code> instruction to cause a jump to the code
 for <code>bang</code>.</p>

<h5>Advice:</h5>
<ul>
  <li>You can use <code>gdb</code> to get the information you need to
  construct your exploit string. Set a breakpoint
  within <code>getbuf</code> and run to this breakpoint.  Determine
  parameters such as the address of <code>global_value</code> and the
  address of the buffer <code>buf</code>.</li>

  <li>Determining the byte encoding of instruction sequences by hand
  is tedious and prone to errors. You can let tools do all of the work
  by writing an assembly code file containing the instructions and
  data you want to put on the stack. Assemble this file
  with <code>gcc</code> and disassemble it
  with <code>objdump</code>. You should be able to get the exact byte
  sequence that you will type at the prompt. (A brief example of how
  to do this is included in the <a href="#byte-codes">Generating Byte Codes</a> section
  above.)</li>

  <li>Keep in mind that your exploit string depends on your machine,
  your compiler, and even your cookie. Make sure your exploit
  string works on <code>attu</code> or your VM, and make sure you 
  include your UWNetID on the command line to <code>bufbomb</code>.</li>

  <li>Watch your use of address modes when writing assembly code. Note
  that <code>movq $0x4, %rax</code> moves the
  value <code>0x0000000000000004</code> into register <code>%rax</code>;
  whereas <code>movq 0x4, %rax</code> moves the value <em>at</em>
  memory location <code>0x0000000000000004</code>
  into <code>%rax</code>. Because that memory location is usually
  undefined, the second instruction will cause a segmentation
  fault!</li>

  <li>Do not attempt to use either a <code>jmp</code> or
  a <code>call</code> instruction to jump to the code
  for <code>bang</code>. These instructions use PC-relative
  addressing, which is very tricky to set up correctly. Instead, push
  an address on the stack and use the <code>retq</code>
  instruction.</li>
</ul>


<h4>Level 3: Dynamite &nbsp;[Extra Credit]</h4>

<p class="afterh">For level 3, you will need to run your exploit
within <code>gdb</code> for it to succeed.</p>

<p>Our preceding attacks have all caused the program to jump to the
code for some other function, which then causes the program to
exit. As a result, it was acceptable to use exploit strings that
corrupt the stack, overwriting the saved value of
register <code>%rbp</code> and the return pointer.</p>

<p>The most sophisticated form of buffer overflow attack causes the
program to execute some exploit code that patches up the stack and
makes the program return to the original calling function
(<code>test</code> in this case). The calling function is oblivious
to the attack. This style of attack is tricky, though, since you must:
(1) get machine code onto the stack, (2) set the return pointer to the
start of this code, and (3) undo the corruptions made to the stack
state.</p>

<p>Your job for this level is to supply an exploit string that will
cause <code>getbuf</code> to return your cookie back
to <code>test</code>, rather than the value 1. You can see in the
code for <code>test</code> that this will cause the program to go
"<code>Boom!</code>". Your exploit code should set your cookie as the
return value, restore any corrupted state, push the correct return
location on the stack, and execute a <code>ret</code> instruction to
really return to <code>test</code>.</p>

<h5>Advice:</h5>

<ul>
  <li>In order to overwrite the return pointer, you must also
  overwrite the saved value of <code>%rbp</code>. However, it is
  important that this value is correctly restored before you return
  to <code>test</code>. You can do this by either (1) making sure that
  your exploit string contains the correct value of the
  saved <code>%rbp</code> in the correct position, so that it never
  gets corrupted, or (2) restore the correct value as part of your
  exploit code. You'll see that the code for <code>test</code> has
  some explicit tests to check for a corrupted stack.</li>

  <li>You can use <code>gdb</code> to get the information you need to
  construct your exploit string. Set a breakpoint
  within <code>getbuf</code> and run to this breakpoint. Determine
  parameters such as the saved return address and the saved value
  of <code>%rbp</code>.</li>

  <li>Again, let tools such as <code>gcc</code>
  and <code>objdump</code> do all of the work of generating a byte
  encoding of the instructions.</li>

  <li>Keep in mind that your exploit string depends on your machine,
  your compiler, and even your cookie. Again, again make sure your
  exploit string works
  on <code>attu</code> or the VM, and make sure you include your UWNetID on the
  command line to <code>bufbomb</code>.</li>
</ul>

<p>Reflect on what you have accomplished. You caused a program to execute
machine code of your own design. You have done so in a sufficiently stealthy
way that the program did not realize that anything was amiss.</p>

<p><code>execve</code> is system call that replaces the currently
running program with another program inheriting all the open file
descriptors. What are the limitations of the exploits you have
performed so far? How could calling
<code>execve</code> allow you to circumvent this limitation? If you have time,
try writing an additional exploit that uses <code>execve</code> and another
program to print a message.</p>
</section>

</div></div>


<a name="reflect"></a>
<div class="panel panel-default">
    <div class="panel-heading"><h3>Lab 3 Reflection</h3></div>
    <div class="panel-body">
        <p>Go back to <code>part2()</code> and Q2A in <code>lab0.c</code>.
        Change the second argument to <code>fillArray()</code> so that it segfaults.
        Examine the contents of memory in GDB to figure out what happened and answer the following questions:</p>
        
        <ol>
            <li>It turns out that you can figure out when you will get a segfault in part2 just by looking at the assembly code!
            What is the <em>address of the instruction</em> that determines the limit on the second argument to fillArray? &nbsp;[1 pt]</li>
            <li class="afterh">In your own words, <em>explain</em> the cause of this specific segmentation fault. &nbsp;[1 pt]</li>
            <li class="afterh">Someone claims that creating <code>array</code> on the Heap would remove the possibility of segmentation faults.
            Do you agree?  Briefly explain why or why not. &nbsp;[1 pt]</li>
        </ol>
    </div>
</div>


<a name="submit"></a>
<div class="panel panel-default">
    <div class="panel-heading"><h3>Submission</h3></div>
    <div class="panel-body">
        <p><em>Please follow the formatting specified here.
           Our grading scripts won't be nice if you don't name the files like we've asked or if you include additional text in any of the files.</em></p>
        <p>You should submit the following files:</p>
        <ol>
            <li><code>UW_ID.txt</code></li>
            <li><code>lab3reflect.txt</code></li>
            <li><code>smoke.txt</code></li>
            <li><code>fizz.txt</code></li>
            <li><code>bang.txt</code></li>
            <li><code>dynamite.txt</code> (if you did the extra credit)</li>
        </ol>

        <p>The <code>UW_ID.txt</code> file should contain your UWNetID (<em>without</em> the <code>@uw.edu</code> part) followed by an empty line.
        <code>lab3reflect.txt</code> should contain your answers to the reflection.</p>
        <p>The other four files correspond to the different exploits and should <em>only</em> contain the hex-formatted exploit string.
           Note that they should have the data that is sent to <code>sendstring</code>, <i>not</i> the data produced by <code>sendstring</code>.</p>

<p>Before submitting your exploits, you can check them by placing them
in the same directory as <code>bufbomb</code> and running <code>make
test</code>. This will output a summary of your exploits (the Makefile
looks for all the files ending with <code>.txt</code> and sends the
contents of each to <code>bufbomb</code>, one by one) and whether they
succeed.  You need to create <code>UW_ID.txt</code> before using the Makefile.</p>

<p>Once you're satisfied with your solutions, submit them through the <a href="../submit.php"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_canvas.png"/> assignments page</button></a>.
There will not be partial credit given within a level.</p>

</div></div>


<?php printFooter(".."); ?>
