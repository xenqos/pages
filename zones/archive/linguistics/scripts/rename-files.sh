#!/bin/bash
#-------------------------------------------------------------------------------

dir_src="${HOME}/mnt/data/Download"

#-------------------------------------------------------------------------------

[[ ! -d "${dir_src}" ]] && exit 0

for file in "${dir_src}"/*; do
  file_noext="${file%.*}"
  file_ext="${file##*.}"
  file_name="${file##*/}"
  file_path="${file%/*}"
  file_dst=$(date -r "${file}" +"%H%M%S")
  echo "${file} > ${file_path}/${file_dst}.${file_ext}"
  mv "${file}" "${file_path}/${file_dst}.${file_ext}"
done

#-------------------------------------------------------------------------------
