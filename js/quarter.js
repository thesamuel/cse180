/** Quarter Specific Configuration Page
 *  @author Adam Blank
 *  @author Justin Hsia
 */


var quarter = function() {
    return "Autumn 2017";
}

var qtr = function() {
    return "17au";
}

Course.name = "CSE 351";
Course.canvas = "1115906";

Course.setSchedule("09/27/17", "MWF", "R", 11);
Course.noLetter = false;

Course.Exams.addExam("midterm", "Midterm Exam", "10/30/17", "5:00pm", "6:30pm", "KNE 120");
Course.Exams.addExam("final", "Final Exam", "12/13/17", "12:30pm", "2:20pm", "KNE 120");

Course.Holidays.addHoliday("Veterans Day", "11/10/17");
Course.Holidays.addHoliday("Thanksgiving", "11/23/17");
Course.Holidays.addHoliday("Thanksgiving", "11/24/17");
Course.Holidays.addHoliday("Exam Studying", "12/11/17");

Course.Lectures = {
    A: {from: "11:30am", to: "12:20pm", location: "EEB 125"},
    B: {from: "2:30pm", to: "3:20pm", location: "EEB 125"}
}

Course.Staff = [
    {netid: "jhsia",    name: "Justin Hsia"},
    {netid: "wottol",   name: "Lucas Wotton"}, 
    {netid: "mjqzhang", name: "Michael Zhang"},
    {netid: "pdewilde", name: "Parker DeWilde"},
    {netid: "ryanww",   name: "Ryan Wong"},
    {netid: "sgehman",  name: "Sam Gehman"},
    {netid: "wolfson",  name: "Sam Wolfson"},
    {netid: "savannay", name: "Savanna Yee"}, 
    {netid: "vinnyp",   name: "Vinny Palaniappan"}
]

Course.Sections = {
    AA: {time: "8:30am",  location: "EEB 025", ta: "wottol"},
    AB: {time: "9:30am",  location: "EEB 037", ta: "wolfson"},
    AC: {time: "11:30am", location: "EEB 025", ta: ["sgehman", "pdewilde"]},
    AD: {time: "12:30pm", location: "EEB 031", ta: "savannay"},
    BA: {time: "12:30pm", location: "SIG 225", ta: "mjqzhang"},
    BB: {time: "1:30pm",  location: "CHL 015", ta: "ryanww"},
    BC: {time: "2:30pm",  location: "SAV 166", ta: "vinnyp"}
}

Course.OfficeHours = {
    DefaultLocation: "2nd Floor Breakout",
    Times: {
        monday: [
            {from: "9:30am", to: "10:30am", who: "savannay", exceptions: ["12/11/17"]},
            {from: "12:30pm", to: "1:30pm", who: "wolfson", exceptions: ["12/11/17"]},
            {from: "3:30pm", to: "4:30pm", who: "vinnyp", exceptions: ["12/11/17"]},
            {from: "5:00pm", to: "6:00pm", who: "jhsia", location: "CSE 438", exceptions: ["10/30/17","12/11/17"]}
        ],
        tuesday: [
            {from: "10:30am", to: "11:30am", who: "ryanww", exceptions: ["11/7/17"]},
            {from: "1:30pm", to: "2:30pm", who: "wolfson", exceptions: ["12/12/17"]},
            {from: "4:30pm", to: "5:30pm", who: "pdewilde", exceptions: ["12/12/17"]}
        ],
        wednesday: [
            {from: "9:30am", to: "10:30am", who: "sgehman", exceptions: ["9/27/17","11/15/17"]},
            {from: "12:30pm", to: "1:30pm", who: "vinnyp", exceptions: ["11/15/17"]},
            {from: "4:30pm", to: "5:30pm", who: "jhsia", location: "CSE 438", exceptions: []}
        ],
        thursday: [
            {from: "1:30pm", to: "2:30pm", who: "sgehman", exceptions: ["11/23/17"]},
            {from: "2:30pm", to: "4:30pm", who: "mjqzhang", exceptions: ["11/23/17"]},
            {from: "6:30pm", to: "7:30pm", who: "pdewilde", exceptions: ["12/14/17"]}
        ],
        friday: [
            {from: "9:30am", to: "10:30am", who: "savannay", exceptions: ["11/10/17","11/24/17"]},
            {from: "10:30am", to: "11:30am", who: "ryanww", exceptions: ["11/10/17","11/24/17"]},
            {from: "12:30pm", to: "1:30pm", who: "wottol", exceptions: ["11/10/17","11/24/17"]},
            {from: "3:30pm", to: "4:30pm", who: "jhsia", location: "CSE 438", exceptions: ["11/3/17","11/10/17","11/24/17"]},
            {from: "4:30pm", to: "5:30pm", who: "wottol", exceptions: ["11/10/17","11/24/17"]}
        ],
        saturday: [],
        sunday: []
    }
}

Course.Events = [
    {name: "Midterm Review", location: "EEB 105", start: "10/27/17 5:30pm", end: "10/27/17 7:30pm", exceptions: []},
    {name: "Final Review", location: "EEB 105", start: "12/11/17 5:00pm", end: "12/11/17 8:00pm", exceptions: []},
    {name: "Midterm Office Hours", location: "CSE 438", start: "10/29/17 6:30pm", end: "10/29/17 8:30pm", exceptions: []},
    {name: "Midterm Office Hours", location: "CSE 438", start: "10/30/17 10:30am", end: "10/30/17 12:30pm", exceptions: []},
    {name: "Midterm Office Hours", location: "CSE 438", start: "10/30/17 2:30pm", end: "10/30/17 3:30pm", exceptions: []},
    {name: "Special Office Hours", location: "CSE 438", start: "11/3/17 1:30pm", end: "11/3/17 2:20pm", exceptions: []},
    {name: "Special Office Hours", location: "2nd Floor Breakout", start: "11/9/17 4:30pm", end: "11/9/17 5:30pm", exceptions: []},
    {name: "Special Office Hours", location: "CSE 007", start: "11/15/17 9:30am", end: "11/15/17 10:30am", exceptions: []},
    {name: "Special Office Hours", location: "3rd Floor Breakout", start: "11/15/17 12:30pm", end: "11/15/17 1:30pm", exceptions: []},
    {name: "Final Office Hours", location: "CSE 438", start: "12/11/17 10:30am", end: "12/11/17 11:30am", exceptions: []},
    {name: "Final Office Hours", location: "CSE 438", start: "12/11/17 3:30pm", end: "12/11/17 4:30pm", exceptions: []},
    {name: "Final Office Hours", location: "CSE 438", start: "12/12/17 12:30pm", end: "12/12/17 4:30pm", exceptions: []}
    //{name: "Workshop", location: "OUG 136", start: "10/27/17 6:00pm", end: "10/27/17 8:00pm", recurring: {type: "weekly", day: "Wednesday"}, exceptions: ["05/03/17"]}
]

//Course.Exams.addExam("mt-rev", "Midterm Review", "10/27/17", "6:00pm", "8:00pm", "TBD");