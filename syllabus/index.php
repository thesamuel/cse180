<?php 
    include '../include.php';
    printHeader("..","CSE 351 Syllabus and Policies");
?>

    <style>hr {border-top: 1px solid #8c8b8b;}</style>

    <div class="unspacepanel"></div>

    <section id="syllabus"><br>
    <div class="panel panel-default">
        <div class="panel-heading"><h2>Syllabus</h2></div>
        <div class="panel-body">
            <ul class="item">
                <div class="item-header">Quick Links</div>
                <li style="font-weight:bold;"><a href="#goals">Goals</a></li>
                <li style="font-weight:bold;"><a href="#themes">Themes</a></li>
                <li style="font-weight:bold;"><a href="#objectives">Objectives</a></li>
                <li style="font-weight:bold;"><a href="#csyll">Syllabus</a></li>
                <li style="font-weight:bold;"><a href="#components">Components</a></li>
            </ul>

            <hr>

            <div class="unspacesection"></div>

            <section id="goals"><br>
            <h3>Course Goals</h3>
            <p class="afterh">This course should develop students' sense of what really happens when software runs &#8212; and that this question can be answered at several levels of abstraction, including the hardware architecture level, the assembly level, the C programming level, and the Java programming level.
            The core around which the course is built is C, assembly, and low-level data representation, but this is connected to higher levels (roughly how basic Java could be implemented), lower levels (the general structure of a processor), and the role of the operating system (but not how the operating system is implemented).</p>
            <p>For (computer science) students wanting to specialize at higher levels of abstraction, this could, in the extreme, be the only course they take that considers the &#8220;C level&#8221; and below.
            However, most will take a subset of 
            <a href="https://www.cs.washington.edu/education/courses/cse333/"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_uw.png"/> Systems Programming (CSE333)</button></a>,
            <a href="https://www.cs.washington.edu/education/courses/cse451/"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_uw.png"/> Operating Systems (CSE451)</button></a>,
            <a href="https://www.cs.washington.edu/education/courses/cse401/"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_uw.png"/> Compilers (CSE401)</button></a>,
            etc.</p>
            <p>For students interested in hardware, embedded systems, computer engineering, computer architecture, etc., this course is the introductory course after which other courses will delve both deeper (into specific topics) and lower (into hardware implementation, circuit design, etc.).
            Of particular interest are
            <a href="https://www.cs.washington.edu/education/courses/cse369/"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_uw.png"/> Introduction to Digital Design (CSE369)</button></a>,
            <a href="https://www.cs.washington.edu/education/courses/cse371/"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_uw.png"/> Design of Digital Circuits and Systems (CSE371)</button></a>,
            <a href="https://www.cs.washington.edu/education/courses/cse466/"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_uw.png"/> Embedded Software (CSE466)</button></a>, and
            <a href="https://www.cs.washington.edu/education/courses/cse469/"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_uw.png"/> Computer Architecture I (CSE469)</button></a>.
            </p>
            </section>

            <hr>

            <div class="unspacesection"></div>

            <section id="themes"><br>
            <h3>Course Themes</h3>
            <p class="afterh">The course has three principal themes:</p>
            <ul style="margin-top: 10px">
                <li><b>Representation:</b> How different data types (from simple integers to arrays of data structures) are represented in memory, how instructions are encoded, and how memory addresses (pointers) are generated and used to create complex structures.</li>
                <li><b>Translation:</b> How high-level languages are translated into the basic instructions embodied in process hardware with a particular focus on C and Java.</li>
                <li><b>Control Flow:</b> How computers organize the order of their computations, keep track of where they are in large programs, and provide the illusion of multiple processes executing in parallel.</li>
            </ul>
            </section>

            <hr>

            <div class="unspacesection"></div>

            <section id="objectives"><br>
            <h3>Course Objectives</h3>
            <p class="afterh">At the end of this course, students should:</p>
            <ul class="afterh">
                <li>understand the multi-step process by which a high-level program becomes a stream of instructions executed by a processor;</li>
                <li>know what a pointer is and how to use it in manipulating complex data structures;</li>
                <li>be facile enough with assembly programming (x86-64) to write simple pieces of code and understand how it maps to high-level languages (and vice-versa);</li>
                <li>understand the basic organization and parameters of memory hierarchy and its importance for system performance;</li>
                <li>be able to explain the role of an operating system;</li>
                <li>know how Java fundamentally differs from C;</li>
                <li>be more effective programmers (more efficient at finding bugs, improved intuition about system performance).</li>
            </ul>
            </section>

            <hr>

            <div class="unspacesection"></div>

            <section id="csyll"><br>
            <h3>Course Syllabus</h3>
            <p class="afterh">Approximate list of topics:</p>
            <ul class="afterh">
                <li>Memory and data representation</li>
                <li>Number representation for integers and floats</li>
                <li>Machine code and the C programming language</li>
                <li>x86-64 assembly language</li>
                <li>Procedures and stacks</li>
                <li>Arrays and other data structures</li>
                <li>Memory and caches</li>
                <li>Operating system process model</li>
                <li>Virtual memory</li>
                <li>Memory allocation</li>
                <li>Implementation of high-level languages (e.g. Java)</li>
            </ul>
            <p>Note that even more important than the topics at various levels of abstraction is the connection between them: students should get an informal sense of how Java could be translated to C, C to assembly, and assembly to binary.</p>
            </section>

            <hr>

            <div class="unspacesection"></div>

            <section id="components"><br>
            <h3>Course Components</h3>
            <p class="afterh">The course consists of the following elements:</p>
            <ul class="afterh">
                <li><b>Lectures:</b> There will be 29 lectures.
                Attendance and participation is expected at all of them.</li>
                <li><b>Online Assignments (Homework):</b> There are 5 homework assignments, due roughly every other week, that will be mostly problems from the text.
                Homework is done online via Canvas.
                Students may receive slightly different problems on homework.</li>
                <li><b>Programming Assignments (Labs):</b> There are 6 total labs, due roughly every other week.
                All the undergraduate lab machines (and <a href="https://www.cs.washington.edu/lab/vms/" target="_blank">the VM</a>) will have access to the necessary tools.
                We will use these assignments to reinforce key concepts and will strive to have them be as practical as possible.</li>
                <li><b>Reading:</b> We will assign readings from <a href="http://csapp.cs.cmu.edu/" target="_blank">the course textbook</a> that correspond to lecture topics.</li>
                <li><b>Exams:</b> There will be a midterm and a final &#8212; see the <a href="../exams/"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_txt.png"/> Exams page</button></a> for more information.</li>
            </ul>
            <p>We will try to ensure that the workload is typical for a 4-credit course, namely, 9-12 hours per week outside of the lectures.
            If we do not succeed, please let us know in whichever way you feel the most comfortable (in-person, email, <a href="../feedback.php"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/mail.png"/> anonymous feedback</button></a>) and explain which parts of the course are causing you to spend too much time non-productively.</p>
            <p><span style="color:red;">We have structured the course so that spending a few hours per day will maximize your efficiency.</span>
            You will work this way in the real world &ndash; you cannot cram a three-month design assignment into the last night &ndash; so you may as well work this way now.
            Plus, you will understand the material better.
            If you leave an assignment for the day before it is due you will not have time to ask questions when (<em>not if</em>) the software misbehaves.</p>
            </section>
        </div>
    </div>
    </section>

    <div class="unspacepanel"></div>

    <section id="policies"><br>
    <div class="panel panel-default">
        <div class="panel-heading"><h2>Policies</h2></div>
        <div class="panel-body">
            <ul class="item">
                <div class="item-header">Quick Links</div>
                <li style="font-weight:bold;"><a href="#grades">Grades</a></li>
                <li><a href="#clobber">Clobber Policy</a></li>
                <li><a href="#epa">EPA</a></li>
                <li><a href="#poll">Peer Instruction</a></li>
                <li><a href="#xtra">Extra Credit</a></li>
                <li style="font-weight:bold;"><a href="#assignments">Assignments</a></li>
                <li><a href="#late">Late Days</a></li>
                <li><a href="#cheating">Cheating</a></li>
                <li><a href="#regrade">Regrades</a></li>
                <li style="font-weight:bold;"><a href="#drs">Disability</a></li>
                <li style="font-weight:bold;"><a href="#circumstances">Circumstances</a></li>
            </ul>

            <hr>

            <div class="unspacesection"></div>

            <section id="grades"><br>
            <h3>Grading Policies</h3>
            <p class="afterh">We will compute your course grade as follows:</p>
            <ul class="afterh">
                <li><b>Homework:</b> 20%</li>
                <li><b>Labs:</b> 30%</li>
                <li><b>Midterm:</b> 15%</li>
                <li><b>Final:</b> 30%</li>
                <li><b>Effort, Participation, and Altruism:</b> 5%</li>
            </ul>
            </section>

            <div style="margin-top: -120px;"></div> 

            <section id="clobber"><br>
            <h4>Midterm "Clobber" Policy</h4>
            <p class="afterh">The clobber policy allows you to override your Midterm score with the score of the Midterm section of the Final.
            Note that the reverse is not true &ndash; you must take the entire Final, regardless of your Midterm score.</p>
            <ul>
                <li><b>Potential replacement score</b> = (Final_MT_subscore - Final_MT_mean) / Final_MT_stddev * MT_stddev + MT_mean
                <li><b>Clobbered Midterm score</b> = MAX(original MT score, potential replacement score)
            </ul>
            <p><i>Final_MT_subscore is your score on the Midterm section of the Final, Final_MT_mean and Final_MT_stddev are the mean and standard deviation of the Midterm section of the Final, and MT_stdev and MT_mean are the standard deviation and mean of the Midterm.</i></p>
            <p>"Clobbered MT score" is then filled in as your Midterm score for the final grade calculation.</p>
            </section>

            <div style="margin-top: -120px;"></div>

            <section id="epa"><br>
            <h4>EPA: Effort, Participation, and Altruism</h4>
            <p class="afterh">You can earn "points" for each of the following:</p>
            <ul class="afterh">
                <li><strong>Effort:</strong> Attending office hours, keeping up with Piazza.
                <li><strong>Participation:</strong> Attending lecture, voting on peer instruction questions, interacting with TAs and other students, asking questions on Piazza.
                <li><strong>Altruism:</strong> Helping others in lecture, during office hours, and on Piazza.
            </ul>
            <p>EPA scores are kept internal to the staff (i.e. not disclosed to students).</p>
            </section>

            <div style="margin-top: -120px;"></div>

            <section id="poll"><br>
            <h4>Peer Instruction</h4>
            <p class="afterh">You will receive credit for voting on peer instruction questions in lecture.
            This quarter we will be using <a href="https://www.polleverywhere.com/" target="_blank"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_poll.png"/> Poll Everywhere</button></a>, which will be attached to your UWNetID.
            <span style="color:red;">Make sure you first register your account</span> and then all you will need is an Internet-enabled device during lecture!
            There is a mobile app available as well.
            More information can be found from <a href="https://itconnect.uw.edu/learn/tools/polleverywhere/" target="_blank"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_uw.png"/> IT Connect</button></a>.</p>

            <p>These questions are designed to give you a chance to check your understanding of the material by applying it on-the-spot, as well as an opportunity to interact with your classmates.
            This will be graded primarily on participation (i.e. your answer does not need to be correct).</p>
            </section>

            <div style="margin-top: -120px;"></div>

            <section id="xtra"><br>
            <h4>Extra Credit</h4>
            <p class="afterh">We will keep track of any extra credit items you complete on labs.
            You won't see these affecting your grades for individual labs, but they will be accumulated over the course and will be used to bump up borderline grades at the end of the quarter.</p>

            <p>The bottom line is that these will only have a small effect on your overall grade (possibly none if you are not on a borderline) and you want to be sure you have completed the non-extra credit portions of the lab in perfect form before attempting any extra credit.
            They are meant to be fun extensions to the assignments, so if you complete some extra credit it *may* positively impact your overall grade.</p>
            </section>

            <hr>

            <div class="unspacesection"></div>

            <section id="assignments"><br>
            <h3>Assignment Policies</h3>
            <p class="afterh">All assignments are due at <strong>11:59pm (and zero seconds)</strong> on the dates specified.
            <span style="color:red;">This means that if your clock reads "11:59", then your assignment is late!</span>
            In addition, online submission can be fickle, so we highly recommend making partial submissions as you go and not waiting until the last (literal) minute to submit.</p>

            <ul class="afterh">
                <li><strong>Written assignments (homework)</strong> are autograded via Canvas and late submissions are NOT allowed.
                You are allowed <strong>20 attempts</strong> for each quiz and you will receive credit for every question that you answer correctly.
                As long as you make a submission before the deadline, you will be able to review the homework questions and your responses at any time.</li>
                <li class="afterh"><strong>Programming assignments (labs)</strong> are submitted by uploading files to Canvas assignments.
                Late lab submissions are subject to the <strong>late day policy</strong> described below.
                Labs are graded by a combination of grading scripts and TAs.</li>
                <li class="afterh"><strong>Exams</strong> are taken simultaneously by both lectures.
                See <a href="..#schedule">the schedule</a> or the <a href="../exams/"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_txt.png"/> Exams page</button></a> for dates.
                Exams are graded by the staff and uploaded to <a href="https://www.gradescope.com/" target="_blank"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_gradescope.png"> Gradescope</button></a> along with the rubric.</li>
            </ul>
            </section>

            <div style="margin-top: -120px;"></div>

            <section id="late"><br>
            <h4>Late Day Policy</h4>
            <p class="afterh">You are allocated a total of <strong>4
late days</strong> for the entirety of the quarter to utilize should the need arise.</p>
            <ul class="afterh">
                <li>A late day is defined as the 24 hour period after an assignment's due date: <code>num_late_days = ceil(hours_late / 24)</code>.</li>
                <li>You are not allowed to use more than <strong>two late days</strong> for any given lab.</li>
                <li>An exception is made for weekends, which count as a single late day.
                That is, if an assignment is due at 11:59pm on Friday, submitting before Sunday at 11:59pm counts as only ONE day late (submitting by 11:59pm on Monday would count as TWO days late).</li>
                <li>There is no bonus for having leftover late days at the end of the quarter.</li>
            </ul>

            <p>If you exceed the late days afforded to you, you will lose <strong>20%</strong> of the assignment score for each day an assignment is overdue.
            Note that all assignment submissions close at most 4 days after the due date.</p>
            </section>

            <div style="margin-top: -120px;"></div>

            <section id="cheating"><br>
            <h4>Collaboration and Cheating</h4>
            <p class="afterh">In general, we <em>encourage</em> collaboration, but there is a very fine line between collaboration and cheating.
            We can learn a lot from working with each other and it can make the course more fun, but we also want to ensure that <em>every</em> student can get the maximum benefit from the material this course has to offer.
            <strong>Keep in mind that the overall goal is for *YOU* to learn the material so you will be prepared for the exams and for job interviews etc. in the future.</strong>
            Cheating turns the assignments into an exercise that is a silly waste of both your time and ours; save us both by not doing it.</p>

            <p><u>Permitted collaboration</u>:</p>
            <ul class="afterh">
                <li><strong>Homework:</strong> Collaboration and discussion is encouraged (find a homework group!), but you are responsible for understanding the solutions on your own, as the problems are meant to be preparation for the exams.</li>
                <li><strong>Labs:</strong> Collaboration should be restricted to <em>high-level</em> discussion (i.e. ideas only).
                A good rule of thumb is that you should <em>never</em> show your own code while helping another student (viewing their code is highly discouraged, as it often leads to problematic situations).</li>
                <li><strong>Exams:</strong> Exams are taken individually and any attempt to use unpermitted materials or copy off of another student's exam will be heavily punished.</li>
            </ul>

            <p style="color:red; font-weight:bold;">Cheating consists of sharing code or solutions to assignments by either copying, retyping, looking at, or supplying a copy of a file.
            Examples include:</p>
            <ul class="afterh"> 
                <li style="color:red;">Coaching a friend to arrive at a solution by simply following your instructions (i.e. no thinking involved).
                An example is helping a friend write a program line-by-line.</li>
                <li style="color:red;">Copying code from a similar course at another university or using solutions/code on the web, including GitHub.</li>
                <li style="color:red;">Communicating your solution with another student via electronic or non-electronic means.</li>
            </ul>

            <p>Cheating is a very serious offense.
            If you are caught cheating, you can expect a failing grade and initiation of a cheating case in the University system.
            Cheating is an insult to the instructor and course staff, to the department and major program, and most importantly, to you and your fellow students.
            If you feel that you are having a problem with the material, or don't have time to finish an assignment, or have any number of other reasons to cheat, then talk with the instructor.
            Just don't cheat.</p>

            <p>If you are in doubt about what might constitute cheating, send the instructor an email describing the situation and we will be happy to clarify it for you.
            For more information, you may consult the department's <a href="http://www.cs.washington.edu/education/AcademicMisconduct/"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_txt.png"/> Academic Misconduct Policy</button></a>.</p>
            </section>

            <div style="margin-top: -120px;"></div>

            <section id="regrade"><br>
            <h4>Solutions and Regrades</h4>
            <ul class="afterh">
                <li><strong>Homework:</strong> <em>Solutions will not be provided.</em>
                Since you are allowed multiple attempts, make sure to go to office hours or talk to classmates if you feel stuck.</li>
                <li><strong>Labs:</strong> <em>Solutions will not be provided.</em>
                Most labs will include testing tools to allow you to evaluate whether or not your solution is likely working.
                Your lab grades will provide comments for any portion deemed incorrect.</li>
                <li><strong>Exams:</strong> Solutions will be posted on the <a href="../exams/"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_txt.png"/> Exams page</button></a> after all students have taken the exam.</li>
            </ul>
            <p class="afterh">
            <p>Learning from our mistakes is often one of the most memorable ways of learning and the staff is not immune from making them, too!
            If you have a question about a graded assignment or exam, please don't hesitate to ask a staff member about it during their office hours.
            If, after discussing your question, you feel that your work was misunderstood or otherwise should be looked at again to see if an appropriate grade was given, we ask that you submit an electronic regrade request:
            </p>
            <ul class="afterh">
                <li>Note that an assignment is regraded, <em>the entire work will be regraded</em>.
                This means that while it is possible to regain some points, it is also possible to lose points.</li>
                <li><strong>Lab regrades:</strong> Send an email to the grader (find who commented on your assignment submission) and CC the instructor.</li>
                <ul>
                    <li>Include a written summary describing why your work should be looked at again.</li>
                    <li>Regrade requests should be submitted within a week of when the lab was graded.</li>
                </ul></li>
                <li><strong>Exam regrades:</strong> Requests are made via <a href="https://www.gradescope.com/" target="_blank"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_gradescope.png"> Gradescope</button></a>.
                <ul>
                    <li>Submit separate regrade requests for <em>each subquestion</em>.
                    Each regrade box is for only that particular part of the exam.</li>
                    <li>Regrade requests will typically be closed 2-3 days after grades are released.
                    Pay attention to lecture announcements for exact dates.</li>
                </ul></li>
            </ul>
            </section>

            <hr>

            <div class="unspacesection"></div>

            <section id="drs"><br>
            <h3>Disability Resources</h3>
            <p class="afterh">The <a href="http://depts.washington.edu/uwdrs/" target="_blank"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_uw.png"/> Disability Resources for Students (DRS)</button></a> is a unit within the Division of Student Life and is dedicated to ensuring access and inclusion for all students with disabilities on the Seattle campus.
            They offer a wide range of services for students with disabilities that are individually designed and remove the need to reveal sensitive medical information to the course staff.
            If you have a medical need for extensions of exam times or assignment deadlines, these will only be granted through official documentation from DRS.
            Browse to <a href="http://depts.washington.edu/uwdrs/prospective-students/getting-started/" target="_blank"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_uw.png"/> this link</button></a> to start the process as soon as possible to avoid delays.</p>
            </section>

            <hr>

            <div class="unspacesection"></div>

            <section id="circumstances"><br>
            <h3>Extenuating Circumstances and Inclusiveness</h3>
            <p class="afterh">We recognize that our students come from varied backgrounds and can have widely-varying circumstances.
            If you have any unforeseen or extenuating circumstance that arise during the course, please do not hesitate to contact the instructor in office hours, via email, or private Piazza post to discuss your situation.
            The sooner we are made aware, the more easily these situations can be resolved.  
            Extenuating circumstances include work-school balance, familial responsibilities, religious observations, military duties, unexpected travel, or anything else beyond your control that may negatively impact your performance in the class.</p>

           <p>Additionally, if at any point you are made to feel uncomfortable, disrespected, or excluded by a staff member or fellow student, please report the incident so that we may address the issue and maintain a supportive and inclusive learning environment.
           Should you feel uncomfortable bringing up an issue with a staff member directly, you may consider sending <a href="../feedback.php" target="_blank"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/mail.png"/> anonymous feedback</button></a> or contacting the <a href="https://www.washington.edu/ombud/" target="_blank"><button type="button" class="btn btn-default btn-lg link-button"><img class="link-button" src="../images/icon_uw.png"/> Office of the Ombud</button></a>.</p>
            </section>
        </div>
    </div>
    </section>

<?php 
    printFooter("..");
?>
