var Calendar = {download: null};

function displayCalendar() {
    createCourseICal(false, function (cal, allsectionscal) {
        $(document).ready(function () {
            // Find last date of course
            var lastDate = Course.lastDate;
            if (Course.Exams.all.length > 0) {
                lastDate = moment.max(lastDate, Course.Exams.all[Course.Exams.all.length - 1].date)
            }
            lastDate = lastDate.add(1, 'day');

            // Create calendar
            $('#calendar').fullCalendar({
                header: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'basicWeek,agendaWeek,listWeek, download'
                },
                buttonText: {
                    basicWeek: 'Compact',
                    agendaWeek: 'Week',
                    list: 'List',
                },
                customButtons: {
                    download: {
                        icon: 'download glyphicon glyphicon-download-alt',
                        click: function () {
                            return allsectionscal.download(Course.slug + "-calendar");
                        },
                    }
                },
                displayEventEnd: true,
                defaultView: 'basicWeek', // or 'agenda' or 'basic'
                //duration: { days: 3 },
                nowIndicator: true,
                scrollTime: moment(),
                height: 'auto',
                contentHeight: 'auto',
                /*height: function() {
                    return window.innerHeight < 400 + Course.$("nav").height() ? window.innerHeight - 100 - Course.$("nav").height() : 400;
                }, */
                eventRender: function (event, element) {
                    var isAllDay = false;

                    if (event.title.toLowerCase().contains("exam")) {
                        element.addClass("fc-exam");
                    } else if (event.title.toLowerCase().contains("lecture")) {
                        element.addClass("fc-lecture");
                    } else if (event.title.toLowerCase().contains("section")) {
                        element.addClass("fc-section");
                    } else if (event.title.toLowerCase().contains("homework") || /p[0-9].*:.*/.exec(event.title.toLowerCase()) || event.title.toLowerCase().startsWith("ex")) {
                        element.addClass("fc-homework");
                        isAllDay = true;
                    } else if (event.title.toLowerCase().replace(/ /g, "").contains("officehours")) {
                        element.addClass("fc-office-hours");
                    } else {
                        element.addClass("fc-other");
                    }

                    var move = element.children('.fc-content').html();
                    var hasParen = false;
                    if (!isAllDay) {
                        element.children('.fc-content').html('<div class="fc-wrapper">' + move + '</div>');
                    } else {
                        element.children('.fc-content').html('<div class="fc-wrapper"></div>' + move);
                    }
                    element.children('.fc-content').append('<div class="fc-wrapper2"></div>');
                    if (event.description && event.title.toLowerCase().replace(/ /g, "").contains("officehours")) {
                        element.find('.fc-time').append("<div class='fc-office-hours-names'>" + event.description.replace(/\n.*/g, "") + "</div>");
                        element.find('.fc-time').children().css("display", "inline");
                        hasParen = true;
                        element.find('.fc-list-item-title').append(" (" + event.description.replace(/\n.*/g, "") + "; ");
                    } else if ($("#calendar").find(".fc-basic-view").length > 0) {
                        if (event.description) {
                            if (event.title.toLowerCase().replace(/ /g, "").contains("officehours")) {
                                element.find('.fc-wrapper2').append("<div class='fc-office-hours-names'>" + event.description.replace(/\n.*/g, "") + "</div>");
                            } else {
                                element.find('.fc-wrapper').append("<div class='fc-description'>" + event.description.replace(/\n.*/g, "") + "</div>");
                            }
                        }
                    }
                    if (event.location) {
                        element.find('.fc-wrapper2').append(
                            "<div class='fc-location'>" + event.location + "<div style='margin-left: 3px'></div></div>"
                        );
                        element.find('.fc-list-item-title').append((hasParen ? "" : " (") + event.location + ")");
                    }
                    if ($("#calendar").find(".fc-basic-view").length > 0) {
                        element.find(".fc-location").css('font-size', '7pt');
                        //var loc = element.find(".fc-location");
                    }
                },
                slotEventOverlap: false,
                validRange: {
                    start: Course.startDate,
                    end: lastDate
                },
                minTime: "09:00:00",
                maxTime: "20:00:00"
            });

            $('#calendar').fullCalendar('addEventSource', fc_events(cal.toString()));
            $('#calendar').fullCalendar('addEventSource', expand_recur_events);
        });
    });
}

$(document).ready(displayCalendar);
