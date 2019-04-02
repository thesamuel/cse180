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


def include_files(day_str, day_num, path_suffix=""):
    return f'<!--#include virtual="{day_str}s/{day_num}/{path_suffix}" -->'


def reading(reading_str):
    return f'<div class="read">{reading_str}</div>'


def make_row(day):
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

    row_html = f"""
    <div class="row">
        <script>Course.nextDate();</script>\n
        <div class="sched-topic pandhw" {day_str}="{day_obj["Num"]}">
            {day_obj["Topic"]}
            {include_files(day_str, day_obj["Num"]) if day_obj["File"] else ""}
            {include_files(day_str, day_obj["Num"], "code/") if day_obj["Code"] else ""}
            {reading(day_obj["Read"]) if day_obj["Read"] else ""}
        </div>
    """

    # Add to challenge column
    row_html += '\t<div class="sched-documents middle">\n'
    for i in range(0, day.count("lab")):
        lab_obj = labs[lab_i]
        lab_obj["Num"] = re.sub(' ', '', re.sub('[,/]', '-', lab_obj["Title"]))
        # linkTitle = lab_obj["Title"].replace(/[ ,\/]/g, "-");
        row_html += '\t\t<section class="exercises" type="lab" title="' + lab_obj["Title"] + '" lnk="' + lab_obj["Link"] + '" number="' + lab_obj["Num"] + '" due="' + lab_obj["Due"] + '"'
        if not lab_obj["Active"]:
            row_html += ' notready'
        row_html += '></section><div style="min-height: 5px"></div>\n'
        lab_i += 1
    row_html += '\t</div>\n'

    # Close schedule row
    row_html += '</div>\n'

    return row_html


with open(SCHEDULE_PATH, 'w') as f:
    f.write('<!--#config errmsg=""-->\n')

    for week in sched:
        for day in week["Week"]:
            if "holiday" in day:
                f.write('<script>Course.nextHoliday();</script>\n')
            elif "exam" in day:
                f.write('<script>Course.nextExam();</script>\n')
            else:
                row = make_row(day)
                f.write(row)
