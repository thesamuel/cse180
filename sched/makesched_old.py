import json


# read json data from files
sched    = json.load( open('sched.json', 'r') )
lectures = json.load( open('lec.json', 'r') )
sections = json.load( open('sec.json', 'r') )
labs     = json.load( open('lab.json', 'r') )
hws      = json.load( open('hw.json', 'r') )

# list counters
lecN = 0
secN = 0
labN = 0
hwN = 0


def printRow(day):
	dayStr = ""
	if "lec" in day:
		dayObj = lectures[lecN]
		dayStr = "lecture"
	if "sec" in day:
		dayObj = sections[secN]
		dayStr = "section"

	# start new schedule row
	f.write('<div class="row">\n')
	f.write('    <script>Course.nextDate();</script>\n')
	# topic (and directory location)
	f.write('    <div class="sched-topic pandhw" ' + dayStr + '="' + dayObj["Num"] + '">\n')
	f.write('        ' + dayObj["Topic"] + '\n')
	# link files
	if dayObj["File"]:
        	f.write('        <!--#include virtual="' + dayStr + 's/' + dayObj["Num"] + '/" -->\n')
	# link code
	if dayObj["Code"]:
        	f.write('        <!--#include virtual="' + dayStr + 's/' + dayObj["Num"] + '/code/" -->\n')
	# lecture reading
	if dayObj["Read"]:
		f.write('        <div class="read">' + dayObj["Read"] + '</div>\n')
	# close lecture div
	f.write('    </div>\n')
	
	# lab & hw columns
	f.write('    <div class="sched-projects middle">\n')
	if "lab" in day:
		labObj = labs[labN]
		if labObj["Active"]:
			f.write('        <section class="exercises" type="lab" title="' + labObj["Title"] + '" lnk="' + labObj["Link"] + '" due="' + labObj["Due"] + '"></section><div style="min-height: 5px"></div>\n')
		else:
			f.write('        <section class="exercises" type="lab" title="' + labObj["Title"] + '" lnk="' + labObj["Link"] + '" due="' + labObj["Due"] + '" notready></section><div style="min-height: 5px"></div>\n')

	f.write('    </div>\n')
	f.write('    <div class="sched-homework middle">\n')
	if "hw" in day:
		hwObj = hws[hwN]
		f.write('        <section class="exercises" type="hw" title="' + hwObj["Title"] + '" lnk="' + hwObj["Link"] + '" due="' + hwObj["Due"] + '"></section><div style="min-height: 5px"></div>\n')
	f.write('    </div>\n')
	
	# close schedule row
	f.write('</div>\n')
	return



f = open('../schedule.html','w')
f.write('<!--#config errmsg=""-->\n')


for week in sched:
	for day in week["Week"]:
		if "holiday" in day:
			f.write('<script>Course.nextHoliday();</script>\n')
		elif "exam" in day:
			f.write('<script>Course.nextExam();</script>\n')
		else:
			printRow(day)
			if "lec" in day:
				lecN += 1
			if "sec" in day:
				secN += 1
			if "lab" in day:
				labN += 1
			if "hw" in day:
				hwN += 1
f.close()

