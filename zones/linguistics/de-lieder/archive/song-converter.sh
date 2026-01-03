#!/bin/bash
#-------------------------------------------------------------------------------

# file_src='i.mp4'
file_src='01.mp3'
file_mid='a'
file_dst='z'

# ffprobe -hide_banner "${file_src}"

ext=$(ffprobe -v error -select_streams a:0 -show_entries stream=codec_name -of default=noprint_wrappers=1:nokey=1 "${file_src}")
# echo $ext

# ffmpeg -i "${file_src}"  -map 0:a:0 -c copy "${file_mid}.${ext}"
# ffmpeg -i "${file_mid}.${ext}" -ac 1 -b:a 128k "${file_dst}.mp3"

ffmpeg -i "${file_src}" -af "rubberband=pitch=0.9, highpass=f=200, equalizer=f=100:width_type=h:width=100:g=-10" output.mp3

#-------------------------------------------------------------------------------
