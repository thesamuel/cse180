var rruleDays = "SU,MO,TU,WE,TH,FR,SA".split(",");
var DAY_NAMES = "sunday,monday,tuesday,wednesday,thursday,friday,saturday".split(",");
function makeRRULE(freq, days, endDate) {
    var by_day = [];
    if (typeof(days) === 'number') {
        by_day.push(rruleDays[days]);
    }
    else {
        for (var day in days) {
            by_day.push(rruleDays[day]);
        }
    }
    return "FREQ=" + freq.toUpperCase() + ";BYDAY=" + by_day.join(",") + ";INTERVAL=1;UNTIL=" + ICSFormatDate(endDate.toDate());
}

function datetime(date, time) {
    return moment(date.format("MM/DD/YY") + " " + time, "MM/DD/YY HH:mma").toDate();
}

function isHoliday(day) {
    day = day.date;
    for (var i = 0; i < Course.Holidays.all.length; i++) {
        var holiday = Course.Holidays.all[i].date;
        if (holiday.isSame(day, 'day')) {
            return true;
        }
    }
    for (var i = 0; i < Course.Exams.all.length; i++) {
        var exam= Course.Exams.all[i].date;
        if (exam.isSame(day, 'day')) {
            return true;
        }
    }

    return false;
}

function allOf(time, all) {
    var result = [];
    for (var i = 0; i < all.length; i++) {
        if (!all[i]._isAMomentObject) {
            all[i]= moment(all[i], "MM/DD/YY");
        }
        result.push(ICSFormatDate(datetime(all[i], time)));
    }
    result = result.join(",");
    return result;
}

function lookupStaff(mem, useNames) {
    var mems = Course.getStaffMap();
    if (typeof(mem) === 'string') {
        mem = [mem];
    }
    var result = [];
    for (var i = 0; i < mem.length; i++) {
        result.push(mems[mem[i]]);
    }
    return result;
}

function attendees(list) {
    var result = [];
    for (var i = 0; i < list.length; i++) {
        result.push("CN=" + list[i].name + ";CUTYPE=INDIVIDUAL;PARTSTATE=ACCEPTED;EMAIL="+ list[i].netid + "@cs.washington.edu;RSVP=TRUE:mailto:" + list[i].netid + "@cs.washington.edu");
    }
    return result;
}

function make_all_day_event(cal, date, summary, description, url) {
    cal.addEvent({
        DTSTART: 'VALUE=DATE:' + ICSFormatDate(date.toDate(), true),
        SUMMARY: summary,
        DESCRIPTION: description,
        URL: url
    })
}

function add_lectures_and_sections(cal, allsectionscal, lectures, sections, includeAllSections) {
    var number_of_lectures = Object.keys(Course.Lectures).length;
    // XXX fix to not deplete using for loop instead
    var iL = 0;
    var iS = 0;
    while (iL < lectures.length || iS < sections.length) {
        var day = null;
        do {
            day = Course.nextDate(true);
        } while (day == null || isHoliday(day));

        if (day.type === 'lecture') {
            var topic = lectures[iL++].topic.replace(/\r/g, "").replace(/\n\n\n/g, "\n").replace(/\r/g, "").replace(/\n/g, "");
            for (var lecture in Course.Lectures) {
                var setup = {
                    DTSTART: datetime(day.date, Course.Lectures[lecture].from),
                    DTEND: datetime(day.date, Course.Lectures[lecture].to),
                    SUMMARY: "Lecture" + (number_of_lectures < 2 ? "" : " " + lecture),
                    DESCRIPTION: topic,
                    LOCATION: Course.Lectures[lecture].location,
                    URL: "#week" + (Course.weeksDone),
                }
                cal.addEvent(setup);
                setup.SUMMARY = Course.name + " " + setup.SUMMARY;
                setup.URL = Course.URL + setup.URL; 
                allsectionscal.addEvent(setup);
            }
        }
        else if (day.type === 'section') {
            var topic = sections[iS++].topic.replace(/\r/g, "").replace(/\n\n\n/g, "\n").replace(/\r/g, "").replace(/\n/g, "");
            make_all_day_event(cal, day.date, "Section", topic, "#week" + (Course.weeksDone));
            for (var section in Course.Sections) {
                var setup = {
                    DTSTART: datetime(day.date, Course.Sections[section].time),
                    DTEND: datetime(day.date, moment(Course.Sections[section].time, "h:mm a").add(50, 'minutes').format("h:mm a")),
                    SUMMARY: Course.name + " Section " + section,
                    DESCRIPTION: topic,
                    LOCATION: Course.Sections[section].location,
                    //ATTENDEE: attendees(lookupStaff(Course.Sections[section].ta)),
                    URL: Course.URL + "#week" + (Course.weeksDone)
                }
                allsectionscal.addEvent(setup);
            }
        }
    }
}


/*
    for (var lecture in Course.Lectures) {
        var setup = {
            DTSTART: datetime(Course.startDate, Course.Lectures[lecture].from),
            DTEND: datetime(Course.startDate, Course.Lectures[lecture].to),
            SUMMARY: Course.name + " Lecture " + lecture,
            LOCATION: Course.Lectures[lecture].location,
            URL: "#week3",
            EXDATE: allHolidays(Course.Lectures[lecture].from)
        }
            
        setup.RRULE = makeRRULE("weekly", Course.lectureDays, Course.lastDate); 
        cal.addEvent(setup);
    }
*/

function add_exams(cal, full) {
    for (var i = 0; i < Course.Exams.all.length; i++) {
        var exam = Course.Exams.all[i];
        var setup = {
            DTSTART: exam.start.toDate(),
            DTEND: exam.end.toDate(),
            SUMMARY: exam.name,
            LOCATION: exam.location,
            URL: (typeof(full) !== 'undefined' ? Course.URL : "") + "#" + exam.id
        }
        cal.addEvent(setup);
    }
}

function add_homeworks(cal, programming_homeworks, exercises, written_homeworks, ckpts, full) {
    var homeworks = programming_homeworks.concat(exercises, written_homeworks, ckpts);
    for (var i = 0; i < homeworks.length; i++) {
        var hw = homeworks[i];
        make_all_day_event(cal, hw.due, hw.name + " Due", "", 
                (typeof(full) !== 'undefined' ? Course.URL : "") + "#hw-" + hw.number);
    }
}

function add_office_hours(cal) {
    for (var day in Course.OfficeHours.Times) {
        var oos = Course.OfficeHours.Times[day]; 
        day = DAY_NAMES.indexOf(day);
        for (var i = 0; i < oos.length; i++) {
            var oo = oos[i];
            var who = oo.who;
            if (!Array.isArray(who)) {
                who = [who];
            }
            var setup = {
                DTSTART: datetime(Course.startDate.clone().weekday(day), oo.from),
                DTEND: datetime(Course.startDate.clone().weekday(day), oo.to),
                SUMMARY: (who.includes("blank") ? "Adam's " : "") + "Office Hours",
                DESCRIPTION: who.join(", "), 
                LOCATION: oo.location || Course.OfficeHours.DefaultLocation,
            }

            var exs = allOf(oo.from, oo.exceptions);
            if (exs.length > 0) {
                setup.EXDATE = exs;
            }
            
            setup.RRULE = makeRRULE("weekly", day, Course.lastDate); 
            cal.addEvent(setup);
        }
    }
}

function add_extra_events(cal) {
    for (var i = 0; i < Course.Events.length; i++) {
        var ev = Course.Events[i];
        var from = moment(ev.start, "MM/DD/YY h:mma"); 
        var to = moment(ev.end, "MM/DD/YY h:mma"); 
        var setup = {
            DTSTART: from.toDate(),
            DTEND: to.toDate(),
            SUMMARY: ev.name,
            LOCATION: ev.location
        }

        var exs = allOf(from.format("h:mma"), ev.exceptions);
        if (exs.length > 0) {
            setup.EXDATE = exs;
        }
        
        if ('recurring' in ev) {
            setup.RRULE = makeRRULE(ev.recurring.type, DAY_NAMES.indexOf(ev.recurring.day.toLowerCase()), Course.lastDate);
        }
        cal.addEvent(setup);
    }
}

function createCourseICal(_, callback) {
    Course.currentDate = Course.startDate.clone();
    Course.weeksDone = 1;
    Course.newWeek = false;
    Course.examIdx = 0;
    Course.holidayIdx = 0;
    Course.thisWeek = window._.clone(Course.allDays);
    while (Course.thisWeek[0] <= Course.startDate.day()) {
        Course.thisWeek.shift();
    }
    Course.currentWeek = 0;
    Course.currentNumbers = {lecture: 1, section: 1};
    Course.savedNextDates = [];

    var cal = new ICS(Course.slug + "//calendar");
    var allsectionscal = new ICS(Course.slug + "//calendar");
    $.get(".", function(data) {
        // Get the topics for lectures and sections off of the calendar
        var schedule = $(data).find("section#schedule").find('.sched-topic').map(function(_, x) { 
            var $x = $(x); 
            $x.children(".slides").html("");
            $x.children(".code").html("");
            $x.children(".section-handouts").html("");
            var $read = $x.children(".read");
            $read.text("XXXReading: " + $read.text().replace(/\n/g, "").replace(/\r/g, ""));
            return {topic: $x.text().replace(/\s\s*/g, " ").replace(" XXX", "\\n\\n").replace(/ $/,""), type: $x.hasAttr('lecture') ? 'lecture' : $x.hasAttr('section') ? 'section' : null}; 
        });

        // Filter out the lectures and sections and add them to the calendar
        var lectures = schedule.filter(function(_, x) { return x.type === 'lecture'; }).toArray();
        var sections = schedule.filter(function(_, x) { return x.type === 'section'; }).toArray();
        add_lectures_and_sections(cal, allsectionscal, lectures, sections, false);

        // Find all the types of homeworks and add them to the calendar
        var califyhw = function(_, x) {
            var $x = $(x);
            var name = "";
            if ($x.hasClass('programming-homework')) {
                name += $x.attr('number').toUpperCase() + ": ";
            }
            name += $x.attr('title');
            return {name: name, number: $x.attr('number'), due: moment($x.attr('due'), "MM/DD/YY HH:mma")};
        }
        var programming_homeworks = $(data).find(".programming-homework").map(califyhw);
        var exercises = $(data).find(".exercises").map(califyhw);
        var written_homeworks = $(data).find(".written-homework").map(califyhw);
        // XXX check/FIXME?
        var ckpts = $(data).find(".programming-checkpoint").map(califyhw);

        add_homeworks(cal, programming_homeworks.toArray(), exercises.toArray(), written_homeworks.toArray(), ckpts.toArray()); 
        add_homeworks(allsectionscal, programming_homeworks.toArray(), exercises.toArray(), written_homeworks.toArray(), ckpts.toArray(), true); 

        add_exams(cal);
        add_exams(allsectionscal, true);

        add_office_hours(cal);
        add_office_hours(allsectionscal);

        add_extra_events(cal);
        add_extra_events(allsectionscal);

        if (typeof(callback) === 'function') {
            return callback(cal, allsectionscal);
        }
    });
}
