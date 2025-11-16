#!/bin/bash
#-------------------------------------------------------------------------------

dir_prefix="${HOME}/mnt/data/Webpages/zones/linguistics/de-phonetics"
dir_sounds="${dir_prefix}/sounds"
dir_sources="${dir_prefix}/sources"
dir_texts="${dir_prefix}/texts"

cd "${dir_prefix}/${dir_texts}"

mv z03.txt 01.txt
mv z01.txt 02.txt
mv z04.txt 03.txt
mv z05.txt 04.txt
mv z02.txt 05.txt

#-------------------------------------------------------------------------------
