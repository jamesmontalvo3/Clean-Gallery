#!/usr/bin/python 

import os, subprocess
from os.path import join, getsize

# root = os.path.dirname(os.path.realpath(__file__))
photodir = "/photos/honeymoon"
fileroot = "/home1/montalv2/public_html" + photodir
httproot = "http://montalvo.us" + photodir

photos = os.listdir( fileroot )
photos.sort()

#year = ""
#month = ""
day = ""
#hour = ""
#minute = ""
#second = ""

mtext = {
	'01':'January',
	'02':'February',
	'03':'March',
	'04':'April',
	'05':'May',
	'06':'June',
	'07':'July',
	'08':'August',
	'09':'September',
	'10':'October',
	'11':'November',
	'12':'December'
}

def js (src):
	return "<script type='text/javascript' src='%s'></script>" % src

def css (href):
	return "<link rel='stylesheet' type='text/css' href='%s' />" % href

fbox = "http://montalvo.us/lib/fancyBox/source/"

print "Content-Type: text/html\n\n"
print "<!DOCTYPE html>"
print "<html><head>"
print "<title>Honeymoon Photos</title>"
print '<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />'

print js ("https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js")

print js (fbox + "jquery.fancybox.js?v=2.1.5")
print css (fbox + "jquery.fancybox.css?v=2.1.5")

print css (fbox + "helpers/jquery.fancybox-buttons.css?v=1.0.5")
print js (fbox + "helpers/jquery.fancybox-buttons.js?v=1.0.5")

print css (fbox + "helpers/jquery.fancybox-thumbs.css?v=1.0.7")
print js (fbox + "helpers/jquery.fancybox-thumbs.js?v=1.0.7")

print """<style>
body {
  font-family: sans-serif; 
}
img {
  border:none;
  margin:5px;
}
div {
  margin: 30px 0 5px 0;
}
.fancybox-custom .fancybox-skin {
	box-shadow: 0 0 50px #222;
}
</style><script type='text/javascript'>
$(document).ready(function(){
	$('.fancybox').fancybox({
		openEffect : 'elastic',
		closeEffect : 'elastic',
		prevEffect : 'none',
		nextEffect : 'none',
		closeBtn : false,
		helpers : {
			title : { type : 'inside' }
		}
	});
});
</script></head><body>"""

intro = join( fileroot, "intro.txt")
if os.path.isfile( intro ):
	with open( intro, 'r') as f:
		text = f.read()
		print "<div>%s</div>" % (text)

photogroup = 1

for photo in photos:

 	if photo == "intro.txt":
		continue
	
	filepath = join(fileroot, photo)

	ext = os.path.splitext(photo)[1][1:].lower()
	
	if ext not in ("jpg", "txt"):
		continue

	name = os.path.splitext(photo)[0]
	
	# date format: yyyymmdd_hhmmss
	#y = name[0:4]
	m = name[4:6]
	d = name[6:8]
	#h = name[9:11]
	#i = name[11:13]
	#s = name[13:15]
	

 	if d != day:
		date = mtext[m] + " " + d
		print "<h2>%s</h2>" % (date)
		day = d
		photogroup += 1
		
	if ext == "txt":
		with open(filepath, 'r') as f:
			text = f.read()
			title = name.split(' ', 1)[1]
			print "<div><h3>%s</h3>%s</div>" % (title,text)
			photogroup += 1
			continue
	elif ext != "jpg":
		continue

		
		
	#name = name[15:].strip()
	#if name == "":
	#	name = "untitled"
		
	#minsec = "<small>(" + i +":" + s + ")</small>"
	
	#if m != month:
	#	print "<h1>", m, " ", y, "</h1>"
	
	thumbfilepath = join(fileroot,'thumbs',photo)
	
	loresfilepath = join(fileroot,'lores',photo)
	
	# create thumb if required
	# convert -thumbnail x200 abc.png thumb.abc.png
	if not os.path.isfile( thumbfilepath ):
		subprocess.call( ['convert','-define','jpeg:size=2240x320',filepath,'-auto-orient','-thumbnail','1200x160',thumbfilepath] )
		
	# create lores if required
	# convert -thumbnail x200 abc.png thumb.abc.png
	if not os.path.isfile( loresfilepath ):
		subprocess.call( ['convert',filepath,'-auto-orient','-resize','30%',loresfilepath] )
	
	img = httproot + "/" + photo
	thumb = httproot + "/thumbs/" + photo
	lores = httproot + "/lores/" + photo
	print "<a href='%s' class='fancybox' data-fancybox-group='%s' title='<a href=\"%s\">Full-Size Image</>'><img src='%s' /></a>" % (lores, photogroup, img, thumb)
	

print "</body></html>"