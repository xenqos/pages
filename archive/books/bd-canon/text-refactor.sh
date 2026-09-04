#!/bin/bash
#-------------------------------------------------------------------------------

dir_prefix="${HOME}/mnt/data/Webpages/zones/de-grammatik"
dir_sounds="${dir_prefix}/sounds"
dir_sources="${dir_prefix}/sources"
dir_texts="${dir_prefix}/texts"

number_start=3
number_shift=1

exit 0

#-------------------------------------------------------------------------------

files_refactor()
{
  cd $@

  for file in $(find . -type f | sort -r); do
    file_old=$(basename "${file}")
    file_ext="${file_old##*.}"
    file_number="${file_old%.*}"

    if [[ $((number_start)) -gt $(sed 's/^0*//'<<< $file_number) ]]; then
      break
    fi

    echo $((number_start)) $(sed 's/^0*//'<<< $file_number)

    file_new="$(printf "%02d" $((10#${file_number}+10#${number_shift}))).${file_ext}"
    mv ${file_old} ${file_new}
  done
}

#-------------------------------------------------------------------------------

files_refactor ${dir_sounds}
files_refactor ${dir_sources}
files_refactor ${dir_texts}

#-------------------------------------------------------------------------------
