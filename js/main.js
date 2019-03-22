/** Course Website Main
 *  @author Adam Blank
 */


 
String.prototype.padLeft = function (len, chr) {
    return (new Array(len||2).join(chr||0)+this).slice(-len)
};
String.prototype.contains = String.prototype.includes;

var Course = {
    $: jQuery,
    forceExternal: function() {
        Course.$( 'a.external').attr('target','_blank');
        Course.$( 'a.pdf').attr('target','_blank');
        Course.$( 'a.txt').attr('target','_blank');
        Course.$( 'a.notes').attr('target','_blank');
        Course.$( 'a.java').attr('target','_blank');
        Course.$( 'a.html').attr('target','_blank');
    },
    foundToday: false,
    lastHash: null,
    currentHash: "",
    URL: window.location.href.replace(/[\/]*#.*/, ""),
    onHash: function(hash) {
        var url = Course.URL.split("/"); 
        if (/[0-9][0-9](sp|su|au|wi)/.exec(url[url.length - 1])) {
            Course.$.getScript("js/polyfill.js");
        }
        else {
            Course.$.getScript("../js/polyfill.js");
        }
        try {
            if (hash === "home" || hash === "") {
                window.scrollTo(0, 0);
            }
            else {
                window.scrollTo(0, Course.$("#" + hash).offset().top);
            }
            window.location.hash = "#"+ hash;
        } catch(e) {
        }
    },
    removeEmptyAnnouncements: function() {
        if (Course.$("ul.announcements li").length < 1) {
            var annHeader = Course.$("#announcements");
            var anns = annHeader.next();
            annHeader.remove();
            anns.remove();
        }
    },
    switchNav: function() {
        var sections = Course.$('section[id]'), nav = Course.$('nav'), nav_height = nav.outerHeight();
        var cur_pos = Course.$(window).scrollTop();
        var min = -1;
        sections.each(function() {
            var top = Course.$(this).offset().top - nav_height, bottom = top + Course.$(this).outerHeight();

            if (min == -1) {
                min = top;
            }
            else {
                min = Math.min(min, top);
            }

            if (cur_pos >= top && cur_pos <= bottom) {
                sections.each(function() {
                    nav.find('a[href="#'+Course.$(this).attr('id')+'"]').parent().removeClass('current');
                });
                nav.find('a[href="#home"]').parent().removeClass('current');

                nav.find('a[href="#'+Course.$(this).attr('id')+'"]').parent().addClass('current');
            }
        });

        if (cur_pos - 3 <= min) {
            sections.each(function() {
                nav.find('a[href="#'+Course.$(this).attr('id')+'"]').parent().removeClass('current');
            });

            nav.find('a[href="#home"]').parent().addClass('current');
        }
        /*
           Course.$('h2[id]').each(function () {
           var top = window.pageYOffset;
           var distance = top - (Course.$(this).offset().top - 90);
           var hash = Course.$(this).attr('id');

           if (distance < 30 && distance > -30 && Course.currentHash != hash) {
           Course.recolorNav(null, "#" + hash);
           Course.currentHash = hash;
           }
           });
           */
    },
    lastDate: null,
    currentDate: null,
    thisWeek: null,
    startDate: null,
    allDays: null,
    lectureDays: null,
    sectionDays: null,
    numberOfWeeks: null,
    currentNumbers: {lecture: 1, section: 1},
    specialAddDates: null,
    dayLetterToDay: function(dayLetter) {
        var dayMap = {U:0, M:1, T:2, W:3, R:4, F:5, S:6};
        return dayMap[dayLetter];
    },
    makeSet: function(iterable) {
        var set = {};
        _.each(iterable, function(x) {
            set[x] = true;
        });
        return set;

    },
    maxMeetings: function(which) {
        var daysPerWeek = Object.keys(which == "lecture" ? 
                Course.lectureDays : 
                Course.sectionDays).length;
        return (daysPerWeek * Course.numberOfWeeks);
    },
    setSchedule: function(startDate, lectureDays, sectionDays, weeks, lastDate) {
        Course.init();
        Course.slug = Course.name.replace(" ", "").toLowerCase() + "-" + qtr();
        Course.allDays = _.map(lectureDays + sectionDays, Course.dayLetterToDay);
        Course.allDays.sort();

        if (_.intersection(lectureDays, sectionDays).length > 0) {
            throw "Lecture and Section are on the same day?";
        }
        if (Course.allDays.length === 0) {
            throw "Tried to make a schedule with no days.";
        }

        Course.lectureDays = Course.makeSet(_.map(lectureDays, Course.dayLetterToDay));
        Course.sectionDays = Course.makeSet(_.map(sectionDays, Course.dayLetterToDay));
        Course.numberOfWeeks = weeks;

        Course.thisWeek = _.clone(Course.allDays);

        Course.startDate = moment(startDate, "MM-DD-YY");
        while (Course.thisWeek[0] <= Course.startDate.day()) {
            Course.thisWeek.shift();
        }

        Course.currentDate = Course.startDate.clone();
        Course.newWeek = true;

        if (Course.allDays.length === 1) {
            Course.$(document).ready(function() {
                Course.$(".calendar .row").last().css("border-bottom", "1px solid #004400");
            });
        }

        Course.lastDate = lastDate || (Course.startDate.clone().add({'weeks': weeks}));
    },
    addDates: function(){
        if (Course.specialAddDates) {
            throw "addDates should only be called once.";
        }
        Course.specialAddDates = _.map(
                _.clone(arguments), 
                function(date) { return moment(date, "MM-DD-YY"); }
                );
        Course.specialAddDates.sort();
    },
    savedNextDates: [],
    noLetter: false,
    weeksDone: 1,
    currentWeek: 0,
    scrollyQueue: [],
    makeScrollies: function() {
        for (var i = 0; i < Course.scrollyQueue.length; i++) {
            var $thing = Course.scrollyQueue[i][0];
            var $origThing = $thing;
            var thing = $thing.position().top;
            var fromTop = (thing/ (Course.$(".calendar").height() * 1.2) * window.innerHeight) - window.innerHeight * 0.1;
            if (typeof(Course.topScrolly) === "undefined" || fromTop < Course.topScrolly) {
                Course.topScrolly = fromTop - 40;
            }
        }

        Course.scrollyQueue.sort(function(a, b) { return (a[0].position().top - b[0].position().top);});

        for (var i = 0; i < Course.scrollyQueue.length; i++) {
            Course._makeScrolly.apply(this, Course.scrollyQueue[i]);
        }
    },
    makeScrolly: function($thing, id, text, offset) {
        Course.scrollyQueue.push([$thing, id, text, offset]);
    },
    lastScrolly: -1,
    _makeScrolly: function($thing, id, text, offset) {
        var $origThing = $thing;
        var $prevThing = null;
        for (var i = 0; i < 2; i++) {
            do { 
                $prevThing = $thing;
                $thing = $thing.prev();
                if ($thing.length === 0) { console.debug("break1"); break; }
            } while (!$thing.is("div") && $prevThing !== $thing);
        }
        var thing = $thing.position().top;

        var $id = Course.$(id);
        var $previd = null;
        for (var i = 0; i < 1; i++) {
            do { 
                $previd = $id;
                $id = $id.next();
                if ($id.length === 0) { console.debug("break2"); break; }
            } while (!$id.is("div") && $id !== $previd);
        }

        var classes = $id.attr('class').split(/\s+/).filter(function(x) { return x !== "row" && x !== "scrolly" && x !== "blue"}).join(" ");

        var HEIGHT = 10;
        if (Math.abs(Course.lastScrolly - thing) < HEIGHT) {
            //offset += 35 + Math.abs(Course.lastScrolly - thing);
        }

        Course.lastScrolly = thing;

        var container = Course.$("<div>")
            var link = Course.$("<a>", {
                href: id,
                class: "scroll-nav badge hw-scrolly" + " " + classes,
                style: "top:" + (offset - Course.topScrolly + ((thing / (Course.$(".calendar").height() * 1.2) * window.innerHeight))),
                text: text,
            });
        var arrow = Course.$("<a>", {
            href: id,
            class: "side-arrow scroll-nav" + " " + classes,
            style: "right: -10px;" + "top:" + (offset - Course.topScrolly + 10 + (thing / (Course.$(".calendar").height() * 1.2) * window.innerHeight))
        });

        container.append(link);
        container.append(arrow);
        Course.$(".scroll-navs").prepend(container);
        return container;
    },
    doneDates: function() {
        Course.$(document).ready(function() { 
            var todayDate = moment().startOf('day');
            if (Course.currentWeek > 0 && Course.lastDate.diff(todayDate) > 0) {
                var today = Course.$(".today");
                if (today.prev()) {
                    today = today.prev();
                }
                var container = Course._makeScrolly(today, "#today", "Today", 0);
                container.addClass("today-scrolly");
                Course.$(".scroll-navs").append(container); 
            }

            Course.$(".scrolly").each(function(_, x) {
                var id = Course.$(x).attr("id");
                var $x = Course.$(x);
                for (var i = 0; i < 2; i++) {
                    do { 
                        $x = $x.prev();
                        if ($x.length === 0) { console.debug("break3"); break; }
                    } while (!$x.is("div"));
                }
                $x.attr("id", id);
                Course.$(x).removeAttr("id");
                
                var name = Course.$(x).attr("name");
                Course._makeScrolly(Course.$(x), "#" + id, name, 0);
                //Course.$(".scroll-navs").prepend(container);
            });
        });

        Course.$(".row .section").each(function(_, x) {
            Course.$(x).parent().addClass("section");
        });

        Course.$(".row .lecture").each(function(_, x) {
            Course.$(x).parent().addClass("lecture");
        });

    },
    date: function(which, whichnum, date, justGet, isSpecial) {
        var isSpecified = which == "" && !(date === null || typeof(date) === "undefined");
        var isTBD = false;
        if (date === "TBD") {
            isTBD = true;
            date = null;
        }
        if (date === null || typeof(date) === "undefined") {
            date = Course.currentDate;
        }
        if (Course.$.type(date) === "string") {
            date = moment(date, "MM/DD/YY");
        }

        if (Course.allDays.length > 1 && Course.thisWeek.length == Math.floor(Course.allDays.length/2) && !isSpecified && !justGet) {
            Course.$(".calendar .row").last().addClass("mid-week");
        }


        if (moment().startOf('day').diff(date) > 0 && !justGet) {
            Course.$(".calendar .row").last().addClass("past");
        }

        var todayDate = moment().startOf('day');
        if (todayDate.diff(date) < 0 && !Course.foundToday && !justGet) {
            var $rows = Course.$(".calendar .row");
            $rows.last().addClass("today");
            $rows.last().attr("style", "background-color: inherit");

            var $prev = Course.$($rows.get($rows.length - 3));

            if ($prev.attr('id') !== undefined) {
                $prev.before('<span id="today" class=""></span>');
            }
            else {
                $prev.attr("id", "today");
            }

            Course.foundToday = true;
            Course.currentWeek = Course.weeksDone - 1;
        }

        if (moment().startOf('day').endOf('isoweek').diff(date) < 0 && !justGet) {
            var $rows = Course.$(".calendar .row");
            $rows.last().addClass("future");
        }

        if (Course.allDays.length > 1 && Course.newWeek) {
            if (!justGet) {
                var row = Course.$(".calendar .row").last();
                row.addClass("new-week");

                var prev = row;
                do { 
                    prev = prev.prev(); 
                    if (prev.length === 0) { console.debug("break4"); break; }
                } while (!prev.is("div"));
                if (Course.weeksDone !== 1) {
                    //if (typeof(prev.attr('id')) !== 'undefined') {
                        var prev2 = Course.$('<span id="week' + Course.weeksDone + '"></span>');
                        if (typeof(prev.prev()) !== 'undefined') {
                            prev = prev.prev();
                        }
                        prev.before(prev2);
                        prev2.addClass(row.attr("class"));
                        prev2.removeClass("row");
                        /*
                    }
                    else {
                        prev.attr("id", "week" + Course.weeksDone);
                    }
                    */
                }
            }

            Course.newWeek = false;
            Course.weeksDone++;
        }

        if (moment().startOf('day').diff(date) === 0 && !justGet) {
            Course.foundToday = true;
            var $rows = Course.$(".calendar .row");
            $rows.last().addClass("today");
            Course.$($rows.get($rows.length - 3)).before('<span id="today"></span>');

            Course.currentWeek = Course.weeksDone - 1;
        }

        var isSpecial = false;
        if (Course.savedNextDates.length > 0) {
            Course.currentDate = Course.savedNextDates.shift();
            isSpecial = true;
        }
        else {
            if (Course.thisWeek.length === 0) {
                Course.thisWeek = _.clone(Course.allDays);
                Course.currentDate = date.clone().day(Course.thisWeek.shift()).add(1, "week");
                Course.newWeek = true;
            }
            else {
                if (!isSpecified) {
                    Course.currentDate = date.clone().day(Course.thisWeek.shift());
                    Course.newWeek = false;
                }
                else {
                    Course.currentDate = date.clone().day(date.clone().day() + 1);
                    Course.newWeek = false;
                }
            }

            while (Course.specialAddDates && Course.specialAddDates.length > 0 &&
                    date < Course.specialAddDates[0] && Course.specialAddDates[0] < Course.currentDate) {
                Course.savedNextDates.push(Course.currentDate);
                Course.currentDate = Course.specialAddDates.shift();
            }
            Course.savedNextDates.sort();
        }

        if (!justGet) {
            Course.$(".calendar .row").last().attr("date", date.format("MM/DD/YY"));
            document.write('<div class="sched-lecnum ' + which + '">' + 
                    (isSpecial ? "&nbsp;" : ((Course.noLetter ? "" : whichnum))) + 
                    '</div>');
            document.write('<div class="sched-day">' +
                    (isTBD ? "TBD" : date.format("ddd, MMM DD")) +
                    '</div>');
        }
    },
    nextDate: function(justGet) {
        if (!Course.currentDate) {
            throw "Forgot to set schedule.";
        }

        var date = Course.currentDate;
        var which = date.day() in Course.lectureDays ? "lecture" : "section";
        var num = (Course.currentNumbers[which]++).toString().padLeft(
                Course.maxMeetings(which).toString().length,
                "0"
        );

        var whichnum = which[0].toUpperCase() + num;

        Course.date(which, whichnum, date, justGet);
        return {type: which, date: date};
    },
    init: function() {
        Course.$(document).ready(function() {
            Course.$(window).on('scroll', Course.switchNav);
            Course.removeEmptyAnnouncements();

            if (window.location.href.match(/\#.*/)) {
                Course.onHash(window.location.hash.substr(1));
            }

            Course.$('.nav a').bind('click', function() {
                Course.onHash(Course.$(this).attr('href').substr(1));
            });

            Course.$('a.external').attr('target', '_blank');

        });
        Course.$(document).ready(function() {
            Course.updateCode('.code ul');
            Course.updateSlides('.slides ul');
            Course.updateSections('.section-handouts ul');
            Course.replaceCodeDownloadLinks('.code-download');

            Course.$('.code-space').each(function(_, sp) {
                var $sp = Course.$(sp);
                $sp.after("<div class='calign'></div>");
            });
     
            Course.$('ul.quickcheck-practice').each(function(_, qc) {
                var $qc = Course.$(qc);
                var hide = $qc.attr("hide");
                if (hide !== undefined) {
                    $qc.attr("style", "display: none");
                }
                $qc.before("<div style='padding-right:3px; display:inline; font-size: 12px'>Follow-Ups:</div>");
            });

            Course.$('ul.topic-list li').each(function(_, topic) {
                var $topic = Course.$(topic);
                var link = $topic.attr("link");
                var name = $topic.html();
                
                try {
                    var classes = Course.$("#" + link).attr('class').split(/\s+/).filter(function(x) { 
                        return x !== "row" && x !== "calendar" && x !== "level-one" && x !== "scrolly" && x !== "blue"; 
                    }).join(" ");
                    $topic.html("<a class='hw-scrolly " + classes + "' href='#" + link + "'>" + name + "</a>");
                } catch (e) {}
            });

            Course.$('section.exercises').each(function(_, hw) {
                var $hw = Course.$(hw);
                var type = $hw.attr("type");
                var title = $hw.attr("title");
                var lnk = $hw.attr("lnk");
                var notready = $hw.attr("notready");
                var online = $hw.attr("online");
                var notimeline = $hw.attr("notimeline");
                var number = title.replace(" ", "").replace(",", "-").replace("/", "-");
                var hide = $hw.attr("hide");
                if (hide !== undefined) {
                    $hw.attr("style", "display: none");
                }

                var dueDate = Course.$("div.row[date='" + moment($hw.attr("due"), "MM/DD/YY HH:mma").format("MM/DD/YY") + "']");
                do { 
                    dueDate = dueDate.prev();
                    if (dueDate.length === 0) { console.debug("Date " + $hw.attr("due") + " is not on schedule."); break; }
                } while (!dueDate.is("div"));

                if (dueDate.attr('id') !== undefined) {
                    dueDate.before('<span id="hw-' + number + '-due"></span>');
                }
                else {
                    dueDate.attr('id', 'hw-' + number + '-due');
                }

                var placer = $hw.parent().parent();
                for (var i = 0; i < 2; i++) {
                    do { 
                        placer = placer.prev(); 
                        if (placer.length === 0) { console.debug("break6"); break; }
                    } while (!placer.is("div"));
                }
                if (placer.attr('id') !== undefined) {
                    placer.before('<span id="hw-' + number + '"></span>');
                }
                else {
                    placer.attr('id', 'hw-' + number);
                }


                var ready = "<fieldset>";
                if (typeof(notready) !== 'undefined') {
                    ready = "<fieldset disabled>";
                }
                
                var link = "href='hw/" + title.toLowerCase()  + ".pdf' "; 
                if (type == 'hw') {
                    link = "href='hw/" + lnk.toLowerCase() + "' ";
                }
                else if (type == 'lab') {
                    link = "href='labs/" + lnk.toLowerCase() + "' ";
                }
                if (typeof(online) !== 'undefined') {
                    link = "href='https://grinch.cs.washington.edu/" + online + "' ";
                }

                $hw.append(
                    ready + "<a target='_blank'" + link + 
                                "class='btn btn-default programming-specification'" + "'>" +
                    "<span style='margin-left: -5px'></span><span style='vertical-align: top; font-size: 12px' class='glyphicon glyphicon-book'></span>" +
                        "<span><h4 class='written-title'>" +
                        
                        title + " Due</h4></span>" + 
                    "</a></div></fieldset>"
                );

                if (typeof(notimeline) === 'undefined') {
                    Course.makeScrolly(Course.$("#hw-" + number + '-due'), "#hw-" + number, number + " Due", 0);
                }
            });


            Course.$('section.written-homework').each(function(_, hw) {
                var $hw = Course.$(hw);
                var number = $hw.attr("number");
                var title = $hw.attr("title");
                var checkpoint = $hw.attr("checkpoint") || "";
                var diff = $hw.attr("diff");
                var late = $hw.attr("late") || "default";
                var notready = $hw.attr("notready");
                var notimeline = $hw.attr("notimeline");

                var hide = $hw.attr("hide");
                if (hide !== undefined) {
                    $hw.attr("style", "display: none");
                }

                var when = moment($hw.attr("due"), "MM/DD/YY HH:mma");
                var dueDate = Course.$("div.row[date='" + when.format("MM/DD/YY") + "']");
                do { 
                    dueDate = dueDate.prev();
                    if (dueDate.length === 0) { console.debug("break5"); break; }
                } while (!dueDate.is("div"));

                if (dueDate.attr('id') !== undefined) {
                    dueDate.before('<span id="hw-' + number + '-due"></span>');
                }
                else {
                    dueDate.attr('id', 'hw-' + number + '-due');
                }

                var placer = $hw.parent().parent();
                for (var i = 0; i < 2; i++) {
                    do { 
                        placer = placer.prev(); 
                        if (placer.length === 0) { console.debug("break6"); break; }
                    } while (!placer.is("div"));
                }
                if (placer.attr('id') !== undefined) {
                    placer.before('<span id="hw-' + number + '"></span>');
                }
                else {
                    placer.attr('id', 'hw-' + number);
                }


                var ready = "<fieldset>";
                var isReady = true;
                if (typeof(notready) !== 'undefined') {
                    isReady = false;
                    ready = "<fieldset disabled>";
                }

                var isAlreadyDue = false;
                var alreadyDue = "";

                if (when < moment()) {
                    isAlreadyDue = true;
                    alreadyDue = "<a target='_blank' href='https://grinch.cs.washington.edu/feedback?course=" + Course.canvas +
                                "' class='btn btn-default written-button'>" +
                    "<span style='margin-left: -5px'></span><span style='vertical-align: top; font-size: 12px; min-height: 14px' class='glyphicon glyphicon-list-alt'></span>" +
                        "<span class='hidden-sm hidden-xs'><h4 class='written-title'>" +
                       "Feedback</h4></span>" + 
                    "</a>";
                }

                var currentHW = "";
                var isCurrentHW = false;
                if (when > moment() && isReady) {
                    isCurrentHW = true;
                    currentHW = "<a target='_blank' href='https://grinch.cs.washington.edu/submit?homework=" + title.replace("Homework ", "HW") + "&course=" + Course.canvas +
                                "' class='btn btn-default written-button'>" +
                    "<span style='margin-left: -5px'></span><span style='vertical-align: top; font-size: 12px; min-height: 14px;' class='glyphicon glyphicon-upload'></span>" +
                        "<span class='hidden-sm hidden-xs'><h4 class='written-title'>" +
                       "Upload</h4></span>" + 
                    "</a>";
                }

                $hw.append(
                    ready + (isReady ? ("<div class='btn-group'> <a target='_blank' href='homework/" + number + ".pdf' " +
                                "class='btn btn-default written-button' number='" + number + "'>" + 
                    "<span style='margin-left: -5px'></span><span style='vertical-align: top; font-size: 12px' class='glyphicon glyphicon-book'></span>" +
                        "<span><h4 class='written-title'>" +
                        
                        title.replace("Homework ", "HW") + "</h4></span>" + 
                    "</a>") : ("<h4 style='color: #999' class='written-title'>" + title.replace("Homework ", "HW") + (!isReady ? " Due" : "") + "</h4>")) + alreadyDue + currentHW + "</div>" +
                    (isReady ? ("<div class='due'" + (isAlreadyDue ? "style='color: #999'" : (isCurrentHW ? "style='color: green'" : "")) + ">Due <div date='" + $hw.attr("due") + "'" + 
                        "class='auto-date'></div></div>") : "") + "</div></fieldset>"
                );

                if (!isReady) {
                    $hw.css('margin-top', '0px');
                }

                if (typeof(notimeline) === 'undefined') {
                    Course.makeScrolly(Course.$("#hw-" + number + '-due'), "#hw-" + number, Course.programmingHWTitle(number + checkpoint.toUpperCase(), title), 0);
                }
            });

     
            Course.$('section.programming-homework').each(function(_, hw) {
                var $hw = Course.$(hw);
                var number = $hw.attr("number");
                var title = $hw.attr("title");
                var checkpoint = $hw.attr("checkpoint") || "";
                var diff = $hw.attr("diff");
                var late = $hw.attr("late") || "default";
                var notready = $hw.attr("notready");
                var notimeline = $hw.attr("notimeline");

                var hide = $hw.attr("hide");
                if (hide !== undefined) {
                    $hw.attr("style", "display: none");
                }

                var dueDate = Course.$("div.row[date='" + moment($hw.attr("due"), "MM/DD/YY HH:mma").format("MM/DD/YY") + "']");
                do { 
                    dueDate = dueDate.prev(); 
                    if (dueDate.length === 0) { console.debug($hw); break; }
                } while (!dueDate.is("div"));

                if (dueDate.attr('id') !== undefined) {
                    dueDate.before('<span id="hw-' + number + '-due"></span>');
                }
                else {
                    dueDate.attr('id', 'hw-' + number + '-due');
                }


                var placer = $hw.parent().parent();
                for (var i = 0; i < 2; i++) {
                    do { 
                        placer = placer.prev(); 
                        if (placer.length === 0) { console.debug("break9"); break; }
                    } while (!placer.is("div"));
                }
                if (placer.attr('id') !== undefined) {
                    placer.before('<span id="hw-' + number + '"></span>');
                }
                else {
                    placer.attr('id', 'hw-' + number);
                }


                var ready = "<div class='project-buttons'><a target='_blank' href='homework/" + number + "/spec.pdf' " +
                                "class='specification btn btn-xs btn-default programming-specification' number='" + number + "'>" +
                                "<span class='glyphicon glyphicon-book'></span><span style='margin-left: 3px' class='text'>Spec</span>" +
                            "</a>" +
                            "<a class='btn btn-xs btn-default programming-files' title='" + Course.programmingHWTitle(number, title) + "' number='" + 
                            number + "' diff='" + diff + "' due='" + $hw.attr("due") + "' late='" + late + "'>" +
                                "<span class='glyphicon glyphicon-file'></span> Resources" +
                            "</a>" + Course.programmingTurnin(number) + "</div>";

                if (typeof(notready) !== 'undefined') {
                    ready = "Not Yet!";
                }

                $hw.append(
                    "<div class='programming-panel panel panel-default'>" +
                        "<div class='hwpanel panel-heading'><h4>" + Course.programmingHWTitle(number, title) + "</h4><h5>Due <div date='" + $hw.attr("due") + "'" + 
                        "class='auto-date'></div></h5></div>" +
                            "<div class='hwpanel panel-body'>" + ready + "</div>" + 
                    "</div>"
                );

                if (typeof(notimeline) === 'undefined') {
                    Course.makeScrolly(Course.$("#hw-" + number + '-due'), "#hw-" + number, Course.programmingHWTitle(number + checkpoint.toUpperCase(), title), 0);
                }
            });

            Course.$('section.programming-checkpoint').each(function(_, hw) {
                var $hw = Course.$(hw);
                var number = $hw.attr("number");
                var checkpoint = $hw.attr("checkpoint");
                var title = $hw.attr("title");
                var notimeline = $hw.attr("notimeline");

                var hide = $hw.attr("hide");
                if (hide !== undefined) {
                    $hw.attr("style", "display: none");
                }
                    
                var special = typeof(checkpoint) === 'undefined';
                if (special) {
                    checkpoint = title;
                }
                var t = checkpoint;

                checkpoint = checkpoint.replace(/\s/, "");

                var dueDate = Course.$("div.row[date='" + moment($hw.attr("due"), "MM/DD/YY HH:mma").format("MM/DD/YY") + "']");
                do { 
                    dueDate = dueDate.prev(); 
                    if (dueDate.length === 0) { console.debug("break8"); break; }
                } while (!dueDate.is("div"));
                 if (dueDate.attr('id') !== undefined) {
                    dueDate.before('<span id="hw-' + number + checkpoint + '-due"></span>');
                }
                else {
                    dueDate.attr('id', 'hw-' + number + checkpoint + '-due');
                }

                if (special) {
                    $hw.append(
                        '<a href="#hw-' + number + '" style="margin-top: -4px" class="btn btn-default written-button">' +
                            '<span><h4 style="padding-left: 5px; padding-right: 5px; margin: 0px; display: block" class="written-title">' + 
                                (t.contains("Homework") ? t.replace("Homework", "HW") + ' Due' : t) +
                            '</h4></span>' +
                        '</a>' +
                        '<div style="min-height: 15px"></div>' 
                    );
                }

                if (typeof(notimeline) === 'undefined') {
                    if (!special) {
                        t = (number + checkpoint).toUpperCase() + ": " + title;
                    }
                    Course.makeScrolly(
                        Course.$("#hw-" + number + checkpoint + '-due'), 
                        "#hw-" + number,
                        t,
                        "", 
                    0);
                }
            });

            Course.makeScrollies();

            if (typeof(Course.installPopovers) !== 'undefined') {
                Course.installPopovers();
            }

            ////////
            Course.$('[data-toggle="tooltip"]').tooltip({html: true}); 
            Course.$('[data-toggle="popover"]').popover({
                trigger: 'click',
                'placement': 'bottom',
                'show': true
            });
            Course.$('.staff-popover').popover({
                trigger: 'click',
                'placement': 'bottom',
                html : true,
                title: function() {
                    return $(this).parent().parent().children(".staff-blurb-title").html();
                },
                content: function() {
                    return $(this).parent().parent().children(".staff-blurb-content").html();
                }
            });

            Course.updateTimes();
            setInterval(Course.updateTimes, 1000);


            Course.$("ul.topic-list li .hw-scrolly.blue").removeClass("blue");

            Course.forceExternal();
        });
    },
    popover: function(spec, title, url, fourohfour, duef, after) {
        Course.$(spec).popover({
            'trigger': 'manual',
            'placement': 'bottom',
            'show': true,
            'html': true,
            'title': function() {
                var number = Course.$(this).attr('number');
                var t = Course.$(this).attr('title');
                var due = moment(Course.$(this).attr('due'), "MM/DD/YY HH:mma");
                return title(number, t, due);
            },
            'content': function() {
                var number = Course.$(this).attr('number');
                var due = moment(Course.$(this).attr('due'), "MM/DD/YY HH:mma");
                var diff = Course.$(this).attr('diff') === "true";
                var late = Course.$(this).attr('late');
                var request = new XMLHttpRequest();
                request.open("GET", url(number, due), false);
                request.send(null);
                if (request.status === 404) {
                    return fourohfour;
                }

                var result = request.responseText;
                if (duef) {
                    dueText = "<h4>Due <font color='blue'>" + moment(due, "MM/DD/YY HH:mma").format("LLLL") + "</font>.<br>";
                    
                    if (duef(late) !== 0) {
                        dueText += 
                            "No submissions accepted after <font color='red'>" + 
                            moment(due, "MM/DD/YY HH:mma").add(duef(late), 'days').format("LLLL") + 
                            ".</font></h4>";
                    }
                    
                    dueText += "<div class='programming-homework-files'>" + 
                        "<ul class='list-group'>";
                    result = dueText + result;
                }

                if (after) {
                    result = result + after(number, diff);
                }

                return '<div id="hw-resources-' + number + '">' + result + '</div><script>GA.logAll(Course.$("#hw-resources-' + number + '")[0]); Course.forceExternal();</script>';
            },
            'width': '200px',
            template: '<div class="popover"><div class="arrow"></div><h3 class="popover-title"></h3><div class="popover-content"></div></div>\n'
        }).click(function(e) {
            Course.$(this).popover('toggle');
            e.stopPropagation();
        });
    },
    times: 0,
    updateTimes: function() {
        Course.$('.auto-date').each(function(_, auto) {
            var $auto = Course.$(auto);
            var due = moment($auto.attr("date"), "MM/DD/YY hh:mma").calendar(null, {
                sameDay: '[Today] @ hh:mma',
                nextDay: '[Tomorrow] @ hh:mma',
                nextWeek: 'ddd @ hh:mma',
                lastDay: '[Yesterday] @ hh:mma',
                lastWeek: '[Last] ddd @ hh:mma'
            });
            $auto.html(due);
        });
    },
    updateCode: function(codeul, x) {
        if (typeof(x) === "undefined") { x = ""; }
        Course.$(codeul).each(function(_, code) {
            var $code = Course.$(code);
            var hide = $code.attr("hide");
            if (hide !== undefined) {
                $code.attr("style", "display: none");
                return;
            }
            var len = 0;
            var line = 0;
            $code.children('li').each(function(num, file) {
                var $file = Course.$(file);
                if (num === 0) {
                    $file.remove();
                    return;
                }
                var width = $code.parent().parent().width();
                var filename = $file.text().trim();
                len += filename.length + 3;
                if (len != filename.length + 3 && len >= (width / 950) * (line == 0 ? 65 : 45)) {
                    $file.before('<div class="code-space"></div>');
                    len = 0;
                }
                var ext = filename.split(".");
                ext = ext[ext.length - 1];
                $file = $file.children();
                var lectureNumber = $code.parent().parent().attr("lecture");
                var sectionNumber = $code.parent().parent().attr("section");
                if (lectureNumber) {
                    $file.attr("href", x + "lectures/" + lectureNumber + "/code/" + filename);
                }
                else if (sectionNumber) {
                    $file.attr("href", x + "sections/" + sectionNumber + "/code/" + filename);
                }
                $file.addClass("code-download");
                // filename hack for PHP redirects to Compiler Explorer (CE) URLs
                if (ext == "php") 
                    $file.html(filename.split(".")[0] + " (CE)");
                else
                    $file.html("<samp>" + filename + "</samp>");
                $file.addClass(ext);
            });
        });
    },
    updateSections: function(slidesul, x) {
        if (typeof(x) === "undefined") { x = ""; }
        Course.$(slidesul).each(function(_, slides) {
            var $slides = Course.$(slides);
            var lectureNumber = $slides.parent().parent().attr("section");

            var hide = $slides.attr("hide");

            if (hide !== undefined) {
                $slides.attr("style", "display: none");
                return;
            }

            $slides.children('li').each(function(num, file) {
                var $file = Course.$(file);
                if (num === 0) {
                    $file.remove();
                    return;
                }
                var filename = $file.text().trim();
                $file = $file.children();
                $file.attr("href", x + "sections/" + lectureNumber + "/" + filename);

                var cls = "pdf";
                function onOne(filename, alt) {
                    if (filename.startsWith("section") && filename.endsWith(".pdf") && filename.indexOf("-") < 0) {
                        return "pdf";
                    }
                    else if (filename.startsWith("section") && filename.endsWith("-solutions.pdf")) {
                        return "solutions";
                    }
                    else if (filename.startsWith("quickcheck") && filename.endsWith(".pdf") && filename.indexOf("-") < 0) {
                        return "qc";
                    }
                    else if (filename.startsWith("quickcheck") && filename.endsWith("-solutions.pdf")) {
                        return "qc-solutions";
                    }
                    else if (filename.endsWith(".pdf")) {
                        return alt;
                    }
                    else {
                        cls = filename.split(".");
                        cls = cls[cls.length - 1];
                        return filename;
                    }
                }

                $file.html("<samp>" + onOne(filename, filename.replace(".pdf", "")) + "</samp>");

                $file.addClass(cls);
            });
        });
    },

    updateSlides: function(slidesul, x) {
        if (typeof(x) === "undefined") { x = ""; }
        Course.$(slidesul).each(function(_, slides) {
            var $slides = Course.$(slides);
            var lectureNumber = $slides.parent().parent().attr("lecture");
            var sectionNumber = $slides.parent().parent().attr("section");
            var pdfName = $slides.children('li').map(function(_, x) { return Course.$(x).children('a').attr('href'); });
            pdfName = pdfName.filter(function(_, x) { return /[0-9]up/.exec(x); });
            if (pdfName.length == 0) {
                pdfName = "ZZZ__XXXX";
            }
            else {
                pdfName = pdfName[0].replace(/-[0-9]up\.pdf/, "");
            }
            if (!$slides.parent().hasClass('topic-list')) {
                var children = $slides.children('li').detach().sort(function(a, b) {
                    a = Course.$(a).children('a').attr('href');
                    b = Course.$(b).children('a').attr('href');
                    if (a.contains('.') && !b.contains('.')) {
                        return 1;
                    }
                    else if (b.contains('.') && !a.contains('.')) {
                        return -1;
                    }
                    else if (!b.contains('.') && !a.contains('.')) {
                        return 0;
                    }
                    else if (a.startsWith(pdfName) && !b.startsWith(pdfName)) {
                        return -1;
                    }
                    else if (b.startsWith(pdfName) && !a.startsWith(pdfName)) {
                        return 1;
                    }
                    else if (a.startsWith('lecture') && !b.startsWith('lecture')) {
                        return -1;
                    }
                    else if (b.startsWith('lecture') && !a.startsWith('lecture')) {
                        return 1;
                    }
                    else if (a.startsWith('reference') && !b.startsWith('reference')) {
                        return 1;
                    }
                    else if (b.startsWith('reference') && !a.startsWith('reference')) {
                        return -1;
                    }

                    else if (a.split(".")[0].replace(/-[0-9]up/, '') == b.split(".")[0]) {
                        return 1;
                    }
                    else if (b.split(".")[0].replace(/-[0-9]up/, '') == a.split(".")[0]) {
                        return -1;
                    }
                    else if (a.contains("ink") && !b.contains('ink')) {
                        return -1;
                    }
                    else if (b.contains("ink") && !a.contains('ink')) {
                        return 1;
                    }
                    return a.localeCompare(b);
                })

                $slides.append(children);
            }

            var hide = $slides.attr("hide");

            if (hide !== undefined) {
                $slides.attr("style", "display: none");
                return;
            }

            $slides.children('li').each(function(num, file) {
                var $file = Course.$(file);
                if (num === 0) {
                    $file.remove();
                    return;
                }
                var filename = $file.text().trim();
                $file = $file.children();
                var intermed = "lectures/" + lectureNumber + "/";
		if(!lectureNumber)
			intermed = "sections/" + sectionNumber + "/";
                if ($slides.parent().hasClass('topics-list')) {
                    intermed = 'documents';
                }
                $file.attr("href", x + intermed + filename);

                //var cls = "pdf";
                var cls = filename.split(".");
                cls = cls[cls.length - 1];
                function onOne(filename, alt) {
                    if (filename.endsWith(".pdf")) {
                        if (alt === "up") {
                            var parts = filename.split("-");
                            return parts[parts.length - 1].split(".")[0];
                        }
                        return alt;
                    }
                    else {
                        cls = filename.split(".");
                        cls = cls[cls.length - 1];
                        return filename;
                    }
                }

                //$file.html("<samp>" + (num === 1 ? onOne(filename, "pdf") : (num === 2 ? onOne(filename, "up") : onOne(filename, filename.replace(".pdf", "").replace(/^Z-/, "")))) + "</samp>");
                if (lectureNumber)
                    $file.html("<samp>" + (filename.includes("ink") ? "ink" : (filename.includes("6up") ? "6up" : filename.split(".")[1])) + "</samp>");
                else
                    if (filename.includes("sec"))
                        $file.html("<samp>" + (filename.includes("sol") ? "solutions" : "worksheet") + "</samp>");
                    else
                        $file.html("<samp>" + filename.split(".")[0] + "</samp>");
                $file.addClass(cls);
            });
        });
    },
    replaceCodeDownloadLinks: function(codesdl, x) {
        if (typeof(x) === "undefined") { x = ""; }
        Course.$(document).ready(function() {
            Course.$(codesdl).each(function(_, link) {
                var dest = Course.$(link).attr("href");
                // don't use highlight if .txt, .zip, .php, .pdf, or .jar
                if (!Course.$(link).hasClass("txt") && !Course.$(link).hasClass("zip") && !Course.$(link).hasClass("php") && !Course.$(link).hasClass("pdf") && !Course.$(link).hasClass("jar")) {
                    Course.$(link).removeAttr("target");
                    Course.$(link).attr("href", x + "highlight/#" + link);
                    //Course.$(link).attr("href", link);
                }
            });
        });
    },
    programmingTurnin: function(name) {
        return "";
    },
    programmingHWTitle: function(number, title) {
        return number + ": " + title;
    },
    Exams: {
        all: [],
        addExam: function(id, name, date, start, end, location) {
            Course.Exams.all.push({
                id: id, 
                name: name, 
                date: moment(date, "MM/DD/YY"),
                start: moment(date + " " + start, "MM/DD/YY h:mma"),
                end: moment(date + " " + end, "MM/DD/YY h:mma"),
                location: location
            });
        }
    },
    Holidays: {
        all: [],
        addHoliday: function(name, date) {
            Course.Holidays.all.push({
                name: name, 
                date: moment(date, "MM/DD/YY"),
            });
        }
    },
    StaffMap: null,
    getStaffMap: function() {
        if (Course.StaffMap !== null) {
            return Course.StaffMap;
        }
        Course.StaffMap = {};
        for (var i = 0; i < Course.Staff.length; i++) {
            var ta = Course.Staff[i];
            Course.StaffMap[ta.netid] = ta;
        } 
        return Course.StaffMap;
    },
    examIdx: 0, 
    nextExam: function() {
        var exam = Course.Exams.all[Course.examIdx++];
        document.write('<div id="' + exam.id + '" class="row blue scrolly" name="' + exam.name + '">');
        Course.date(exam.date.format("MM/DD/YY"), ":O");
        document.write('<div class="sched-topic"><b>' + exam.name + '</b>' +
                       '<div class="programming-panel panel panel-default">' +
                       '<div class="hwpanel panel-heading"><h4>Details</h4></div>' +
                       '<div class="hwpanel panel-body"><ul class="item">' +
                       '<li><u>' + exam.start.format("h:mma") + '<div class="to"></div>' + exam.end.format("h:mma") + ' in ' + exam.location + '</u></li></ul>' +
                        '<ul class="item"><div class="item-header">Quick Links</div> ' +
                        '<li><a class="external" href="exams/#' + exam.id + '-materials">Materials</a></li>' +
                        '<li><a class="external" href="exams/#' + exam.id + '-topics">Topics</a></li>' + 
                        '<li><a class="external" href="exams/#' + exam.id + '-past">Past Exams</a></li>' +
                        '</ul></div></div></div><div class="sched-documents middle"></div></div>');
    },
    holidayIdx: 0,
    nextHoliday: function() {
        var holiday = Course.Holidays.all[Course.holidayIdx++];
        document.write('<div class="row red">');
        Course.date("", ":D");
        //, holiday.date.format("MM/DD/YY")
        document.write('<div class="sched-topic">' + holiday.name + ': No Class!</div><div class="sched-documents middle"></div></div>');
    }
};

Course.$.fn.hasAttr = function(name) {  
    return this.attr(name) !== undefined;
};


var make_link = function(link) {
    document.write('<a href="' + make_url(link) +  '" target="_blank">');
}

var make_url = function(link) {
    return link + qtr();
}
var end_link = function(link) {
    document.write('</a>');
}
