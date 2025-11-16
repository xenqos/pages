#!/bin/bash
#-------------------------------------------------------------------------------

exit

#-------------------------------------------------------------------------------

dir_prefix="${HOME}/mnt/data/Webpages/zones/linguistics/de-phonetics"
dir_sounds="${dir_prefix}/sounds"
dir_sources="${dir_prefix}/sources"
dir_texts="${dir_prefix}/texts"

cd "${dir_texts}"

mv z03.txt 01.txt
mv z01.txt 02.txt
mv z04.txt 03.txt
mv z05.txt 04.txt
mv z02.txt 05.txt

cd "${dir_sources}"

mv z03.txt 01.txt
mv z01.txt 02.txt
mv z04.txt 03.txt
mv z05.txt 04.txt
mv z02.txt 05.txt

cd "${dir_sounds}"

mv z03.mp3 01.txt
mv z01.mp3 02.txt
mv z04.mp3 03.txt
mv z05.txt 04.txt
mv z02.mp3 05.txt

#-------------------------------------------------------------------------------
