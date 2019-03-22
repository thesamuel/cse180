<?php
    include '../include.php';
    printHeader("..","CSE 351 Linux Tips");
?>


    <ul class="item">
        <div class="item-header">Quick Links</div>
        <li style="font-weight:bold;"><a href="#access">Getting a Shell</a></li>
        <li><a href="#attu">Logging onto attu</a></li>
        <li style="font-weight:bold;"><a href="#shell">Shell Basics</a></li>
        <li style="font-weight:bold;"><a href="#edit">Text Editing</a></li>
        <li style="font-weight:bold;"><a href="#debug">Debugging</a></li>
    </ul>

    <div style="margin-top: 20px;"></div>

    <h2>Using Linux in 351</h2>

    <p class="afterh">This course explores low-level topics in machine representation of programs and data.
    For our reference system, we're using CentOS Linux.
    Other Linux and Mac OS X systems are very similar, and Windows machines also use the same underlying processors and memory organization.
    But for assignments in this course, your submissions need to work on, <em>and will be graded on</em>, our reference system.</p>

    <p>This is a quick little tutorial on how to get yourself up and running on Linux.
    If you are a CSE major, then you have access to departmental servers collectively called <strong>attu</strong> (actually reached at <em>attu.cs.washington.edu</em>).
    You are welcome to use attu or the <a class="external" href="https://www.cs.washington.edu/lab/software/linuxhomevm"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_uw.png"/> CSE virtual machine</button></a>, which are running the same Linux image.
    If you are using the CSE virtual machine, then read just &ldquo;Shell on Linux&rdquo; and then from &ldquo;Finding your way around the shell&rdquo; onward.</p>

    <div class="unspace"></div>

    <section id="access"><br>
    <div class="panel panel-default">
        <div class="panel-heading"><h3>Getting a Shell</h3></div>
        <div class="panel-body">

            <p>The shell is the bread and butter of Linux.
            I know &ndash; graphical things are nice &ndash; but the Linux shell brings you a lot of power with not very many key presses.
            As computing becomes more and more prevalent across <i>all</i> industries, you may find yourself using a Linux shell at some point, so it's a good skill to have/know.</p>

            <hr>

            <h3>Shell on Windows</h3>
            <p class="afterh">Windows' default command line interfaces are Command Prompt and PowerShell, which use a different set of commands and tools and behave differently than the shells on Mac and Linux.
            Instead, you can <b>connect to <a href="#attu">attu</a></b> using either of the following methods:</p>
            <ul>
                <li><b><em>bash:</em></b>  If you are running a 64-bit version of Windows 10 and have installed the "Anniversary Update" (released Aug. 2016) then you can enable a bash terminal (command line interface) directly within Windows!
                Here is one useful link for <a class="external" href="http://www.omgubuntu.co.uk/2016/08/enable-bash-windows-10-anniversary-update"><button type="button" class="btn btn-default btn-lg link-button"/>installing bash</button></a>.</li>
                <li><b><em>PuTTY:</em></b>  A lightweight SSH client that lets you interact with another computer over the Internet (like opening a shell).
                For our purposes you can directly download <a href="http://the.earth.li/~sgtatham/putty/latest/x86/putty.exe"><button type="button" class="btn btn-default btn-lg link-button"/>putty.exe</button></a> onto your computer.</li>
            </ul>

            <hr>

            <h3>Shell on Mac OS X</h3>
            <p class="afterh">The Mac OS X <b><em>Terminal</em></b> behaves very similarly to most Linux shells.
            As a result, most of the commands on Terminal will be the same as those from a Linux shell.
            However, to use the Linux shell commands for 351, we will <b>connect to <a href="#attu">attu</a></b>.</p>

            <ul>
                <li>Click the Spotlight Search button in the upper-right, type "terminal", and press return.</li>
            </ul>

            <hr>

            <h3>Shell on Linux</h3>
            <p class="afterh">You won't need to do any special setup on Linux, as you have a shell installed.
            It is still recommended that you <b>connect to <a href="#attu">attu</a></b> to ensure that you have all of the tools needed and are using the same environment as everyone else.</p>

            <ul>
                <li>Click Applications at the top, mouse to Accessories, and click Terminal.</li>
            </ul>

            <hr>

            <div class="unspacesection"></div>

            <section id="attu"><br>
            <h3>Logging onto attu</h3>
            <p class="afterh">attu is a powerful computer sitting in the CSE building that is ready to run your work, except that it has no screen.
            It runs linux, and can only be accessed over the network.
            You will be granted an account (your UWNetID) on attu for the quarter.
            attu has all of the commands that you will need in the 351 labs, and is built to be fast, so more often than not it's most convenient to run lab programs on attu.</p>

            <h4>Accessing attu from Windows (PuTTY)</h4>
            <ol class="afterh">
                <li>Open <code>putty.exe</code> from wherever you downloaded it.</li>
                <li>For the host name, type <code>&lt;your-csenetid&gt;@attu.cs.washington.edu</code></li>
                <li>Click Open at the bottom.</li>
                <li>If you're prompted about an RSA key, click Yes.</li>
                <li>Put in your Kerberos password when asked for a password.
                It will look like you're not typing anything &ndash; that's done on purpose so people looking over your shoulder won't know your password.</li>
            </ol>

            <h4>Accessing attu from Windows (bash), OS X, or Linux</h4>
            <ol class="afterh">
                <li>Open the shell on your computer (see "Getting a Shell" above).</li>
                <li>Now that you have a terminal up, type <code>ssh &lt;your-uwnetid&gt;@attu.cs.washington.edu</code> and press [Enter].</li>
                <li>If prompted about a server key, type <code>yes</code> and press [Enter].</li>
                <li>When prompted, enter your Kerberos password and press [Enter].
                Like PuTTY, it won't look like you're typing.
                This is done on purpose :)</li>
            </ol>

            <h4>Changing your attu password</h4>
            <p class="afterh">If you would like to change your Kerberos password, type <code>passwd</code> into the command prompt and press [Enter], then follow the instructions given.</p>
            </section>
        </div>
    </div>
    </section>


    <div class="unspacepanel"></div>

    <section id="shell"><br>
    <div class="panel panel-default">
        <div class="panel-heading"><h3>Finding Your Way Around the Shell</h3></div>
        <div class="panel-body">

            <div style="margin-top: -20px;"></div>

            <h3>How files and folders work on Linux</h3>
            <p class="afterh">First off: folders are a fancy word that Microsoft invented to make computers seem more human.
            While folders are great, they're called <em>directories</em> on Linux.</p>

            <p>The first thing that most new users shifting from Windows will find confusing is navigating the Linux filesystem.
            The Linux filesystem does things a lot more differently than the Windows filesystem.</p>

            <h4>The Root Directory (<code>/</code>)</h4>
            <p class="afterh">For starters, there is only a single hierarchal directory structure.
            Everything starts from the root directory, represented by '<code>/</code>', and then expands into sub-directories.
            Where DOS/Windows had various drives (C:, D:, etc) and then directories under those partitions, Linux places all the drives under the root directory by 'mounting' them under specific directories.
            The closest parallel to the root directory in Windows would probably be C:.</p>

            <p>Another point likely to confuse newbies is the use of the frontslash '/' instead of the backslash '\' as in DOS/Windows.
            So <code>c:\windows\system</code> would be <code>/c/windows/system</code>.
            Well, Linux is not going against convention here.
            Unix has been around a lot longer than Windows and was the standard before Windows was.
            Rather, it was DOS that took the different path, using '/' for
command-line options and '\' as the directory separator.</p>

            <h4>Your Home Directory (<code>~</code>)</h4>
            <p class="afterh">To keep people (users) from stepping on each other's toes, everyone has one directory ("folder") that they can write and make changes to.
            This is called your "home directory".
            On any Unix system, you can refer to the home directory with a tilde, so a folder called <code>frogs</code> inside of your home directory would have a path like: <code>~/frogs</code>.</p>

            <p>When you run a command, your shell will replace <code>~</code> with the path to your home directory.
            If you want to know what that is or how to manipulate the shell, read the next section on basic Unix commands.</p>

            <h4>Other Important Directories (<code>.</code> and <code>..</code>)</h4>
            <p class="afterh">The shell also allows you to directly reference directories relative to your current working directory.
            '<code>.</code>' represents the current working directory.
            '<code>..</code>' refers to the direct parent of the current working directory.
            Every additional '<code>.</code>' refers to the directory one level higher.</p>

            <p>This can be pretty handy in working your way around your directory structure.
            For example, if you are in the folder <code>lab1</code>, a sibling directory <code>lab2</code> would be referred to as: <code>../lab2</code>.</p>

            <hr>

            <h3>Basic Unix commands</h3> 
            <p class="afterh">To move around through the directory structure in your terminal window, you'll need to know a few basic Unix commands.
            Note that you always start in your home directory when you open a terminal.</p>

            <p>To get help on some command, say you want to know how to use <code>ls</code>, type "<code>man ls</code>" and you will get the manual pages for that command.
            (Alternatively, you can use "info" in the same way.)</p>

<style> 
  td { 
    background-color: #eeeeee;
    font-size: 13px;
    padding: 3;
  }
  th {
    background-color: #4B2A85;
    color: white;
    font-size: 14px;
    padding: 3;
  }
</style>

<table border="1">
  <tr>
    <th>Command</th>
    <th>Function</th>
    <th>Example</th>
    <th>Explanation</th>
    <th>Notes</th>
  </tr>
  <tr>
    <td><code>mkdir</code></td>
    <td>Creates a new directory with the given name in the current working directory.</td>
    <td><code>mkdir lab1<code></td>
    <td>This will create a new directory called "<code>lab1</code>".</td>
    <td></td>
  </tr>
  <tr>
    <td><code>ls</code></td>
    <td>Lists all directories and files in the current directory.</td>
    <td><code>ls -A</code></td>
    <td>This will list all sub-directories and files. The -A flag means that hidden directories and files will also be printed to the console.</td>
    <td>Check the manual page for <code>ls</code> to find out various flags to show directories and files in different forms.</td>
  </tr>
  <tr>
    <td><code>cd</code></td>
    <td>Navigates to the specified directory, given its relative path.</td>
    <td><code>cd lab1<code></td>
    <td>This will navigate to the <code>lab1</code> directory inside the current directory.</td>
    <td>This is a common place where <code>.</code> and <code>..</code> are used. Also, to use a directory's absolute path, start the directory name with either <code>/</code> or <code>~</code>. For example:<p><code>cd ~/cse351/lab2</code></p></td>
  </tr>
  <tr>
    <td><code>pwd</code></td>
    <td>Prints the current working directory path.</td>
    <td><code>pwd<code></td>
    <td>This will print the current working directory's absolute path to the console.</td>
    <td></td>
  </tr>
  <tr>
    <td><code>exit</code></td>
    <td>Exits the console, or logs out of the current SSH session.</td>
    <td><code>exit<code></td>
    <td>This will terminate the current terminal window. If you are SSH'd into attu, this will terminate your session.</td>
    <td></td>
  </tr>
</table>

            <p class="afterh">Here is a sample execution of some Unix commands.
            The <code>[attu]$</code> is just the prompt telling you that
  you're logged into attu.
            Lines that don't start with this prompt are output returned by the shell in response to the previous command.</p>

<pre>
[attu]$ <b>mkdir mydir</b>
[attu]$ <b>ls</b>
<b>mail  mydir</b>
[attu]$ <b>cd mydir</b>
[attu]$ <b>pwd</b>
<b>/homes/jhsia/mydir</b>
[attu]$ <b>exit</b>
</pre>

            <p>These are just the very minimum basics, of course.</p>

            <hr>
 
            <h3>Changing your shell</h3> 
            <p class="afterh">The shell is the program where you type in commands.
            There are different shell programs, which are all similar but have different rules and features.
            For sake of uniformity, we will use a shell called "bash," and your account <i>should</i> be set-up to use this by default.
            You can check using the following command: <code>[attu]$ echo $0</code>.</p>

            <p>In case the output isn't <code>bash</code> or <code>-bash</code> (or you're updating your personal Linux machine), you can change the shell <i>temporarily</i> or <i>permanently</i>.
            We strongly recommend the latter, but we'll explain the former first to help you understand what is going on.</p> 
 
            <p><b>Temporarily:</b> Type <code>[attu]$ bash</code>.</p>
            <p>Now you <i>may</i> have a different-looking prompt (such as <code>[bash-3.00]$</code>), but otherwise at this point you will not notice any differences.
            Note that instead of <i>changing</i> your shell, you've actually opened up a <i>new</i> shell (we'll discuss processes in this course), so when you type <code>[bash-3.00]$ exit</code>, you'll actually return to the original shell (the one you typed <code>bash</code> into).</p>
 
            <p><b>Permanently:</b> Instead, you can tell the operating system that the "first shell" for every terminal should be bash for your account.  
            From any prompt, type: <code>[attu]$ chsh -s /bin/bash</code>.</p>
            <p>You are running the "<i><b>ch</b></i>ange <i><b>sh</b></i>ell" program and specifying that your new shell can be found at <code>/bin/bash</code>.
            It's almost that simple:</p>
 
            <ul> 
                <li>To be sure you have the right to do this, you'll be prompted for your password.</li>
                <li>Before that, you'll be warned that typing passwords can be
dangerous.  Say "y".</li>
                <li>As the message says, the change may take a few hours.
                In the meantime, see the "Temporarily" instructions above.</li>
            </ul> 

            <p>As a final note, if your shell already is bash, <code>chsh</code> will just say "Shell not changed."</p> 

        </div>
    </div>
    </section>

    <div class="unspacepanel"></div>

    <section id="edit"><br>
    <div class="panel panel-default">
        <div class="panel-heading"><h3>Editing Files</h3></div>
        <div class="panel-body">

            <p>First thing's first:  
            <a class="external" href="http://en.wikipedia.org/wiki/Editor_war">There</a>
            <a class="external" href="http://peabody.weeman.org/editor_wars.html">is</a>
            <a class="external" href="http://xkcd.com/378/">a</a>
            <a class="external" href="http://en.wikipedia.org/wiki/List_of_text_editors">ton</a>
            <a class="external" href="http://wordwarvi.sourceforge.net/">of</a>
            <a class="external" href="http://www.spiritus-temporis.com/editor-war/">debate</a>
            <a class="external" href="http://www.dina.kvl.dk/~abraham/religion/">about</a>
            <a class="external" href="http://en.wikipedia.org/wiki/Comparison_of_text_editors">this</a>.</p>

            <hr>

            <h3>CSE 351 Text Editing</h3>
            <p class="afterh">For this course, you can use something as simple as Notepad.
            However, we strongly recommend something better to help you read and debug your code.
            Here is a list of text editors, listed by OS, that we recommend:</p>

            <ul>
                <li class="afterh"><b>On Windows</b><ul>
                    <li><a class="external" href="http://www.flos-freeware.ch/notepad2.html">Notepad2</a></li>
                    <li><a class="external" href="https://notepad-plus-plus.org/">Notepad++</a></li>
                    <li><a class="external" href="https://www.sublimetext.com/3">Sublime Text</a></li>
                </ul></li>
                <li class="afterh"><b>On Linux</b> (already installed on attu)<ul>
                    <li>Emacs (<a class="external" href="http://xahlee.org/emacs/emacs.html">tutorial</a>)</li>
                    <li>vim (<a class="external" href="http://www.openvim.com/">tutorial</a>)</li>
                    <li>pico</li>
                </ul></li>
                <li class="afterh"><b>On Mac OS X</b><ul>
                    <li><a class="external" href="http://aquamacs.org/">Aquamacs</a> (<a href="http://xahlee.org/emacs/emacs.html">tutorial</a>)</li>
                    <li><a class="external" href="https://www.sublimetext.com/3">Sublime Text</a></li>
                    <li><a class="external" href="https://macromates.com/">TextMate</a></li>
                </ul></li>
            </ul>

            <hr>

            <h3>Working from home</h3>
            <ol>
                <li class="afterh"><b>Use the <a class="external" href="http://www.cs.washington.edu/lab/vms">CSE Virtual Machine</a>:</b>  Running locally on your machine, so no performance issues.</li>
                <li class="afterh"><b>Connect remotely (ssh) to attu:</b>  Don't have to transfer files, but you might have to deal with latency (time between your key stroke and your computer's response, which includes the time it takes for attu to receive, process, and respond to it) issues.</li>
                <li class="afterh"><b>Work locally:</b>  Download the necessary files to your machine's hard drive (directly from the web or attu), then use a text editor to make changes.
      After that, you'll need to copy the updated text files back to attu using one of the following suggested methods:
      <ul>
        <li><b><em>scp:</em></b>  (from a shell)  Uses the command line interface you'll be getting accustomed to in this course.  A quick overview can be found on <a class="external" href="https://linuxacademy.com/blog/linux/ssh-and-scp-howto-tips-tricks/#scp">this blog post</a>.
        <li><b><em>WinSCP:</em></b>  (Windows only)  GUI version of SCP that allows for drag-and-drop and limited remote file system manipulation (e.g. file renaming, file deletion, file permissions, directory creation).  Download <a class="external" href="http://winscp.net/eng/index.php">here</a>.
      </ul></li>
</ol>


        </div>
    </div>
    </section>

    <div class="unspacepanel"></div>

    <section id="debug"><br>
    <div class="panel panel-default">
        <div class="panel-heading"><h3>Debugging</h3></div>
        <div class="panel-body">

            <div style="margin-top: -20px;"></div>

            <h3>Viewing all of the output when you run commands</h3>

            <p class="afterh">When you run a command like <code>btest</code> on attu, you may see something like the following:</p>

<pre>  Gives 1942614435[0x73c9f1a3].  Should be 204869213[0xc360e5d]
... 9 total errors for function abs
Test abs score: 0.00/4.00
Test addOK(-2147483648[0x80000000],-2147483648[0x80000000]) failed.
  Gives -2147483648[0x80000000].  Should be 0[0x0]
Test addOK(-2147483648[0x80000000],2147483647[0x7fffffff]) failed.
  Gives -2147483648[0x80000000].  Should be 1[0x1]
Test addOK(-2147483648[0x80000000],-3[0xfffffffd]) failed.
  Gives -2147483648[0x80000000].  Should be 0[0x0]
Test addOK(-2147483648[0x80000000],811666840[0x30610d98]) failed.
  Gives -2147483648[0x80000000].  Should be 1[0x1]
Test addOK(-2147483648[0x80000000],-2147483647[0x80000001]) failed.
  Gives -2147483648[0x80000000].  Should be 0[0x0]
... 321 total errors for function addOK
Test addOK score: 0.00/3.00
Overall correctness score: 14.00/36.00
1541 errors encountered.
</pre>

            <p>What happened to the first part of it?
            Answer: it scrolled up past the top of your terminal.
            You'll have to tell attu you want to see all of that output.</p> 

            <p><b>Save as a file:</b> If you run <code>btest</code> (or any command) as follows:</p>
            <p><code>[attu]$ ./btest &gt; feedback_filename</code></p>
            <p>Linux will save its output in the file called "feedback_filename" (careful, it will overwrite existing files) for you to view later in your favorite text editor.</p>

            <p><b>View output screen-by-screen:</b> Instead, run:</p>
            <p><code>[attu]$ ./btest | less</code></p>
            <p>You can then use the up/down arrow keys to move around your output in a quick and dirty fashion.
            Use the 'q' key to quit.
            <i>Be aware: Once you quit, the output is gone for good!</i>
            But, luckily for you, you can just re-run <code>btest</code> to get it back.
            You can also use <code>less</code> to view the output from your saved file, like <code>less feedback_filename</code>.</p>

            <hr>

            <h3>Make clean and corrupt builds</h3>

            <p class="afterh">Not everything is perfect, sadly :(.
            One of those is our build system.
            Though it is unlikely, the rule of thumb when running the <code>make</code> command is:</p>
            <ul><li>If something really doesn't look like it's running right, do a <code>make clean</code>, then a <code>make</code> and try it again.</li></ul>

            <p>To save time, <code>make</code> and <code>gcc</code> will save some of the computation required to build your software.
            However, at times, this can become corrupt and interfere with changes you're making.</p>

        </div>
    </div>
    </section>

    <hr style="background-color: #fff; border-top: 2px dotted #8c8b8b;">

    <p style="margin-top: -10px;">Written by Andrew Reusch (<i>areusch@gmail.com</i>).
    Updated by Sarang Joshi (<i>sarangj@cs.uw.edu</i>) and Justin Hsia (<i>jhsia@cs.uw.edu</i>).</p>


<?php printFooter(".."); ?> 
