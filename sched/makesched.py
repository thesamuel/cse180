import json
import re

SCHEDULE_PATH = "../schedule.html"

# read json data from files
sched = json.load(open('sched.json', 'r'))
lectures = json.load(open('lec.json', 'r'))
sections = json.load(open('sec.json', 'r'))
labs = json.load(open('lab.json', 'r'))
hws = json.load(open('hw.json', 'r'))

# list counters
lec_i = 0
section_i = 0
lab_i = 0
hw_i = 0


def write_row(f, day):
    global lec_i, section_i, lab_i, hw_i
    day_str = ""
    if "lec" in day:
        day_obj = lectures[lec_i]
        day_str = "lecture"
        lec_i += 1
    if "sec" in day:
        day_obj = sections[section_i]
        day_str = "section"
        section_i += 1

    # start new schedule row
    f.write('<div class="row">\n')
    f.write('    <script>Course.nextDate();</script>\n')

    # topic (and directory location)
    f.write('    <div class="sched-topic pandhw" ' + day_str + '="' + day_obj["Num"] + '">\n')
    f.write('        ' + day_obj["Topic"] + '\n')

    # link files
    if day_obj["File"]:
        f.write('        <!--#include virtual="' + day_str + 's/' + day_obj["Num"] + '/" -->\n')

    # link code
    if day_obj["Code"]:
        f.write(
            '        <!--#include virtual="' + day_str + 's/' + day_obj["Num"] + '/code/" -->\n')

    # lecture reading
    if day_obj["Read"]:
        f.write('        <div class="read">' + day_obj["Read"] + '</div>\n')

    # close lecture div
    f.write('    </div>\n')

    # lab & hw columns
    f.write('    <div class="sched-projects middle">\n')
    for i in range(0, day.count("lab")):
        labObj = labs[lab_i]
        labObj["Num"] = re.sub(' ', '', re.sub('[,\/]', '-', labObj["Title"]));
        # linkTitle = labObj["Title"].replace(/[ ,\/]/g, "-");
        f.write(
            '        <section class="exercises" type="lab" title="' + labObj["Title"] + '" lnk="' +
            labObj["Link"] + '" number="' + labObj["Num"] + '" due="' + labObj["Due"] + '"')
        if not labObj["Active"]:
            f.write(' notready')
        f.write('></section><div style="min-height: 5px"></div>\n')
        lab_i += 1
    f.write('    </div>\n')
    f.write('    <div class="sched-homework middle">\n')
    for i in range(0, day.count("hw")):
        hwObj = hws[hw_i]
        hwObj["Num"] = re.sub('[ ,\/]', '-', hwObj["Title"]);
        f.write(
            '        <section class="exercises" type="hw" title="' + hwObj["Title"] + '" lnk="' +
            hwObj["Link"] + '" number="' + hwObj["Num"] + '" due="' + hwObj["Due"] + '"')
        if not hwObj["Active"]:
            f.write(' notready')
        f.write('></section><div style="min-height: 5px"></div>\n')
        hw_i += 1
    f.write('    </div>\n')

    # close schedule row
    f.write('</div>\n')
    return


with open(SCHEDULE_PATH, 'w') as f:
    f.write('<!--#config errmsg=""-->\n')

    for week in sched:
        for day in week["Week"]:
            if "holiday" in day:
                f.write('<script>Course.nextHoliday();</script>\n')
            elif "exam" in day:
                f.write('<script>Course.nextExam();</script>\n')
            else:
                write_row(f, day)
