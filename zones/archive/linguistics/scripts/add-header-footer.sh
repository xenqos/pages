#!/bin/bash
#-------------------------------------------------------------------------------

dir_name='sources'
dir_suffix='processed'

dir_prefix="${HOME}/mnt/data/Webpages/zones/linguistics/de-words"
dir_src="${dir_prefix}/${dir_name}"
dir_dst="${dir_prefix}/${dir_name}-${dir_suffix}"

lang='de'

#-------------------------------------------------------------------------------

[[ ! -d "${dir_dst}" ]] && mkdir -p "${dir_dst}"

for file in "${dir_src}"/*; do
  file_name="${file##*/}"
  cat "../headers/header-${lang}.txt" "${file}" > "${dir_dst}/${file_name}"
  cat "../headers/footer.txt" >> "${dir_dst}/${file_name}"
done

#-------------------------------------------------------------------------------
