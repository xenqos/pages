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

dir='./texts'

#ext='*.html'
ext='*.txt'

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
#regex="s~ sound-word\"~\"~sg"
#regex="s~ example__line_sound~~sg"
#regex="s~<div class=\"example__line\">(.*?)</div>~\[\!\n\1\n\!\]~sg"
#regex="s~<span class=\"eng\">(.*?)</span>~\%\[m\|\1\]~sg"
#regex="s~<div class=\"example\">~~sg"
#regex="s~</div>~~sg"
#regex="s~ data-sound-file=\"(.*?)\"~~sg"
#regex="s~ data-sound-type=\"(.*?)\"~~sg"
#regex="s~<div class=\"article\">~~sg"
#regex="s~^\s+~~sg"
#regex="s~\[\!\n\n~\[\!\n~sg"
#regex="s~\n\n\!\]~\n\!\]~sg"
#regex="s~\!\]\n\[\!~\!\]\n\n\[\!~sg"
#regex="s~<div class=\"example__line example__line_break\">(.*?)</span>~\n\[\!\n\1</span>\n\!\]~sg"
#regex="s~\]<br>~\]~sg"
#regex="s~<span class=\"rus\">(.*?)</span>~\1~sg"
#regex="s~<ul class=\"list\">~~sg"
#regex="s~</ul>~~sg"
#regex="s~<li class=\"list__item\">~~sg"
#regex="s~</li>~~sg"
#regex="s~\!\]\n\n\[\!~\n\n~sg"
#regex="s~\n\n\n\n\n~\n\n~sg"
#regex="s~\n\n\n\n~\n\n~sg"
#regex="s~\n\n\n~\n\n~sg"
#regex="s~ class=\"mtitle\"~~sg"
#regex="s~<h2>\n~<h2>~sg"
#regex="s~^<h2>(.*?)</h2>~# \1~sg"
#regex="s~<p>~~sg"
#regex="s~</p>~~sg"
#regex="s~<b>(.*?)</b>~\*\*\1\*\*~sg"
#regex="s~<strong>(.*?)</strong>~\*\*\1\*\*~sg"

#-------------------------------------------------------------------------------

cd ${dir}

for file in $(find . -name "${ext}" | sort); do
  perl -i -0pe "${regex}" "${file}"
done

#-------------------------------------------------------------------------------
