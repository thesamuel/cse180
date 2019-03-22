$(document).ready(function() {
    Course.$('div.practice-exam')});

Course.Exams.generateList = function() {
    document.write('<div class="panel panel-default"><div class="panel-heading"><h3>Exam Overview</h3></div><div class="panel-body">');

    for (var i = 0; i < Course.Events.length; i++) {
        var ev = Course.Events[i];
        if ( ev.name.includes("Review") ) {
            Course.Exams.all.push({
                id: "",
                name: ev.name,
                date: moment(ev.start, "MM/DD/YY h:mma"),
                start: moment(ev.start, "MM/DD/YY h:mma"),
                end: moment(ev.end, "MM/DD/YY h:mma"),
                location: ev.location
            });
        }
    }

    Course.Exams.all.sort(function(a,b) { return b.date>a.date ? -1 : b.date<a.date ? 1 : 0; } );
    for (var i = 0; i < Course.Exams.all.length; i++) {
        var exam = Course.Exams.all[i];
        document.write('<div class="exam-listing"><div class="exam-name topic">' + 
            exam.name + '</div> ' + 
            exam.date.format("dddd, MMMM DD, YYYY") + 
            " (" + exam.start.format("h:mm a") + '<div class="to"></div>' +
            exam.end.format("h:mm a") + ", " +
            exam.location + ")</div>"
            );
    }
    document.write('<p style="margin-top:20px;">Both exams will use the following <a class="pdf" href="seating-chart.pdf">seating chart</a> (by section).</p>');
    document.write('</div></div>');
}

Course.Exams.generateDetails = function() {
    for (var i = 0; i < Course.Exams.all.length; i++) {
        var exam = Course.Exams.all[i];

        var $policies = Course.$('.exam-policies').clone();
        $policies.find('.exam-time').text(moment.duration(exam.end.subtract(exam.start)).asMinutes() + " minutes");
        document.write(
            '<div class="panel panel-default"><div class="panel-heading"><h3>' + exam.name + ' Details</h3></div><div class="panel-body"><div style="margin-top: -105px" class="unspace"></div>' +
            '<section id="' + exam.id + '-exam-policies"><br><h4>Exam Policies</h4>' + $policies.html() + '</section><div class="unspace"></div>' +
            '<section id="' + exam.id + '-exam-topics"><br><h4>Exam Topics</h4>' + $('.exam-details-' + exam.id).html() + '</p></section><div class="unspace"></div>' +
            '<section id="' + exam.id + '-exam-practice"><br><h4>Practice Exams</h4>We strongly suggest that you try to solve all of these problems yourself, <b>on paper</b> ' +
            'without looking at the answer key until you\'re done. You may also want to time yourself to practice your pacing.<br>'
        );

        var $practice = $('.exam-practice-' + exam.id).clone();
        $practice.children('.practice-exam').each(function(_, practice) {
            var $p = $(practice);
            var file = $p.attr('file');
            $p.after('<a class="pdf" href="' + file + '.pdf">Exam</a>&nbsp;<b>|</b>&nbsp;<a class="pdf" href="' + file + '-soln.pdf">Solutions</a><br>');
        });

       document.write($practice.html() + '</section></div></div>');
    }
}
