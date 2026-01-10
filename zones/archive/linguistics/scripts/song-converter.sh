#!/bin/bash
#-------------------------------------------------------------------------------

ext_src='mp3'
ext_dst='opus'
dir_name='sounds'
bit_rate='32k'

dir_prefix="${HOME}/mnt/data/Temp/Mireille-Mathieu/An-Einem-Sonntag-In-Avignon"
dir_src="${dir_prefix}/${dir_name}"
dir_dst="${dir_prefix}/${dir_name}-${ext_dst}"

#-------------------------------------------------------------------------------

[[ ! -d "${dir_dst}" ]] && mkdir -p "${dir_dst}"

for file in "${dir_src}"/*; do
  file_noext="${file%.*}"
  file_name="${file_noext##*/}"
  ffmpeg -i "${file}" -c:a libopus -b:a "${bit_rate}" "${dir_dst}/${file_name}.${ext_dst}"
done

#-------------------------------------------------------------------------------
