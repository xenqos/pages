#!/bin/bash

dir_name="."

file_input='02'
file_ext='mp3'

time_start='00:00:04.00'
time_stop='00:05:00.00'

date_start=$(date --utc --date "1970-01-01 ${time_start}" "+%s")
date_stop=$(date --utc --date "1970-01-01 ${time_stop}" "+%s")
date_duration=$(( ${date_stop}-${date_start} ))

time_duration=$(date --utc -d @${date_duration} +"%T")

ffmpeg \
  -y \
  -i "${file_input}.${file_ext}" \
  -ss ${time_start} \
  -t ${time_duration} \
  -acodec copy \
  -vcodec copy \
  "${file_input}-new.${file_ext}"

