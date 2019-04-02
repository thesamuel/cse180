/** Quarter Specific Configuration Page
 *  @author Adam Blank
 *  @author Justin Hsia
 *  @author Sam Gehman
 */

var quarter = function () {
    return "Spring 2019";
};

var qtr = function () {
    return "19sp";
};

Course.name = "CSE 180";
Course.canvas = "";

Course.setSchedule("04/01/19", "MWF", "R", 10);
Course.noLetter = true;

Course.Holidays.addHoliday("Memorial Day", "05/27/19");

Course.Lectures = {
    A: {from: "9:30am", to: "10:20am", location: "OUG 136"}
};

Course.Staff = [
    {netid: "maas", name: "Ryan Maas"},
    {netid: "bboiko", name: "Bob Boiko"},
    {netid: "ryanfok", name: "Ryan Fok"},
    {netid: "sgehman", name: "Sam Gehman"},
    {netid: "kevink97", name: "Kevin Kang"},
    {netid: "tperrier", name: "Trevor Perrier"},
    {netid: "nowei", name: "Andrew Wei"}
];

Course.Sections = {
    AA: {time: "1:30pm", location: "MLR 316", ta: ["tperrier", "kevink97"]},
    AB: {time: "2:30pm", location: "CLK 219", ta: ["maas"]},
    AC: {time: "3:30pm", location: "LOW 202", ta: ["sgehman", "ryanfok"]}
};

Course.OfficeHours = {
    DefaultLocation: "TBA",
    Times: {
        monday: [
            {
                from: "2:30pm",
                to: "4:00pm",
                who: "ryanfok",
                location: "CSE2 152",
                exceptions: ["05/27/19"]
            }
        ],
        tuesday: [
            {
                from: "12:00pm",
                to: "1:00pm",
                who: "ryanfok",
                location: "CSE2 214",
                exceptions: ["05/27/19"]
            }
        ],
        wednesday: [
            {
                from: "2:00pm",
                to: "3:30pm",
                who: "tperrier",
                location: "CSE2 276",
                exceptions: ["05/27/19"]
            },
            {
                from: "12:30pm",
                to: "2:00pm",
                who: "kevink97",
                location: "CSE2 153",
                exceptions: ["05/27/19"]
            }
        ],
        thursday: [
            {
                from: "12:30pm",
                to: "1:30pm",
                who: "sgehman",
                exceptions: ["05/27/19"]
            }
        ],
        friday: [
            {
                from: "11:00am",
                to: "2:00pm",
                who: "nowei",
                location: "CSE 4th Floor Landing",
                exceptions: ["05/27/19"]
            }
        ],
        saturday: [],
        sunday: []
    }
};

Course.Events = [];
