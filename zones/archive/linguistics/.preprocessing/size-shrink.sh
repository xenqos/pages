#!/bin/bash

dir_src='sounds'
dir_dst='sounds-shrunk'

cd ..

[[ ! -d ${dir_dst} ]] && mkdir -p ${dir_dst}

cd ./${dir_src}

for file in *; do
  ffmpeg -i ${file} -ar 16000 -b:a 24k ../${dir_dst}/$file
done
