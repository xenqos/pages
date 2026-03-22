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

#regex="s~<script(.*?)script>~~sg"
#regex="s~<button(.*?)button>~~sg"
#regex="s~<svg(.*?)svg>~~sg"
#regex="s~^(.*?)<h1~<h1~sg"
#regex="s~<\!-- Pagination Section -->(.*?)$~~sg"
#regex="s~<h1(.*?)>~<h1>~sg"
#regex="s~<div class=\"w-full wysiwyg-content mb-8\">~~sg"
#regex="s~<hr(.*?)>~~sg"
#regex="s~<\!--(.*?)-->~~sg"
#regex="s~<\/div>~~sg"
#regex="s~<div(.*?)>~~sg"
#regex="s~\n\s+~\n~sg"

#regex="s~ loading=\"lazy\"~~sg"
#regex="s~  alt=\"(.*?)\"~~sg"
#regex="s~ alt=\"(.*?)\"~~sg"
#regex="s~ style=\"(.*?)\"~~sg"
regex="s~ class=\"max-w-full mx-auto\"~~sg"

#-------------------------------------------------------------------------------

cd ${dir}

for file in $(find . -name "${ext}" | sort); do
  perl -i -0pe "${regex}" "${file}"
done

#-------------------------------------------------------------------------------
