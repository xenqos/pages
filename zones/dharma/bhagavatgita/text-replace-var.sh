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

ext='*.txt'

#-------------------------------------------------------------------------------

#regex="s~^(.*?)<body class=\"z\">~~sg"
#regex="s~\n<span id=\"(.*?)\"><div class=\"title1\">~~sg"
#regex="s~^\n~~sg"
#regex="s~<p class=\"p\">Глава (.*?)<\/p>~###### Бхагавадгита\n\n# Глава \1~sg"
#regex="s~</div><div class=\"poem\">~~sg"
#regex="s~<\/div>\n<div class=\"stanza\">~~sg"
#regex="s~<div class=\"stanza\">\n~~sg"
#regex="s~\n\t+~~sg"
regex="s~<p class=\"v\"><em>(.*?)<\/em><\/p>~<em>\1</em>\n~sg"

#-------------------------------------------------------------------------------

cd ${dir}

for file in $(find . -name "${ext}" | sort); do
  perl -i -0pe "${regex}" "${file}"
done

#-------------------------------------------------------------------------------
