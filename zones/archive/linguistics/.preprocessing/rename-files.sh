#!/bin/bash

file_ext='mp3'

for file_src in *.${file_ext}; do
  [[ -e "${file_src}" ]] || continue
  file_dst=$(date -r "${file_src}" +"%H%M%S.${file_ext}")
  mv "${file_src}" "${file_dst}"
  echo "${file_src} -> ${file_dst}"
done
