#!/bin/bash
#-------------------------------------------------------------------------------
# -i -- modifies input file
# -0 -- input record separator ($/) - octal
# -e -- program as argument, not in file
# -p -- places printing loop around command
# -w -- warnings
#-------------------------------------------------------------------------------

IFS=$'\n'

#-------------------------------------------------------------------------------

dir='./01'

#ext='*.txt'
ext='*.html'

#-------------------------------------------------------------------------------

#regex="s~^(.*?)<main>~~sg"
#regex="s~</main>(.*?)$~~sg"
#regex="s~\n\s+~\n~sg"
#regex="s~<div class=\"nav\">(.*?)$~~sg"
#regex="s~<div id=\"pointer-target\"></div>~~sg"
#regex="s~^(.*?)<section class=\"lesson\">~~sg"
#regex="s~<p>\n~<p>~sg"
#regex="s~\n</p>~</p>~sg"
#regex="s~<div class=\"container\">~~sg"
#regex="s~<div class=\"row align-items-start\">~~sg"
#regex="s~<div class=\"col\">~~sg"
#regex="s~<div class=\"lesson_text\">~~sg"
#regex="s~ data-word=\"(\d+)\"~~sg"
regex="s~ sound-word\"~\"~sg"


#-------------------------------------------------------------------------------

cd ${dir}

for file in $(find . -name "${ext}" | sort); do
  perl -i -0pe "${regex}" "${file}"
done

#-------------------------------------------------------------------------------
