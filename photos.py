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

photogroup = 1

for photo in photos:

 	#if photo is directory
		#do what?
	#if photo is compressed file
		#do what?
	
	filepath = join(fileroot, photo)

	ext = os.path.splitext(photo)[1][1:].lower()
	
	name = os.path.splitext(photo)[0]
	
	# date format: yyyymmdd_hhmmss
	#y = name[0:4]
	m = name[4:6]
	d = name[6:8]
	#h = name[9:11]
	#i = name[11:13]
	#s = name[13:15]
		
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
	
