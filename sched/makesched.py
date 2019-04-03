import json
import re

SCHEDULE_PATH = "../schedule.html"

# read json data from files
sched = json.load(open('sched.json', 'r'))
lectures = json.load(open('lec.json', 'r'))
sections = json.load(open('sec.json', 'r'))
labs = json.load(open('lab.json', 'r'))

# list counters
lec_i = 0
section_i = 0
lab_i = 0


def make_files(day_str, day_num, path_suffix=""):
    return f'<!--#include virtual="{day_str}s/{day_num}/{path_suffix}" -->'


def make_row(day):
    global lec_i, section_i, lab_i
    day_str = ""
    if "lec" in day:
        day_obj = lectures[lec_i]
        day_str = "lecture"
        lec_i += 1
    elif "sec" in day:
        day_obj = sections[section_i]
        day_str = "section"
        section_i += 1
    else:
        raise RuntimeError("Day must be a section or lecture")

    row_html = f'''
    <div class="row">
        <script>Course.nextDate();</script>\n
        <div class="sched-topic pandhw" {day_str}="{day_obj["Num"]}">
            {day_obj["Topic"]}
            {make_files(day_str, day_obj["Num"]) if day_obj["File"] else ""}
            {make_files(day_str, day_obj["Num"], "code/") if day_obj["Code"] else ""}
            {f'<div class="read">{day_obj["Read"]}</div>' if "Read" in day_obj and day_obj["Read"] else ""}
        </div>
        <div class="sched-documents middle">
    '''

    # Add items to challenge column
    for i in range(day.count("lab")):
        lab_obj = labs[lab_i]
        lab_obj["Num"] = re.sub(' ', '', re.sub('[,/]', '-', lab_obj["Title"]))

        row_html += f'''
                <section class="exercises" type="lab" title="{lab_obj["Title"]}" 
                    lnk="{lab_obj["Link"]}" number="{lab_obj["Num"]}" due="{lab_obj["Due"]}" 
                    {'' if lab_obj["Active"] else 'notready'}>
                </section>
                <div style="min-height: 5px"></div>
        '''

        lab_i += 1

    # Close divs
    row_html += '''
        </div>
    </div>
    '''

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
