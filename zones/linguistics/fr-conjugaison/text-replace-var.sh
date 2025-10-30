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

dir='./pages'

#ext='*.txt'
ext='*.html'

#-------------------------------------------------------------------------------

#regex="s~<script type='text\/javascript' src='\.\.\/\.\.\/\.\.\/scripts\/book\.js'><\/script>~<script type='text\/javascript' src='\.\.\/scripts\/local\.js'><\/script>~sg"
#regex="s~<script type='text\/javascript' src='\.\.\/\.\.\/\.\.\/scripts\/commons\.js'><\/script>~<script type='text\/javascript' src='\.\.\/\.\.\/\.\.\/\.\.\/scripts\/global\.js'><\/script>~sg"
#regex="s~<link rel='stylesheet' type='text\/css' media='screen' href='\.\.\/\.\.\/\.\.\/styles\/book.css'>~<link rel='stylesheet' type='text\/css' media='screen' href='\.\.\/\.\.\/\.\.\/\.\.\/styles\/global.css'>~sg"
#regex="s~<link rel='stylesheet' type='text/css' media='screen' href='../../../styles/commons.css'>~<ZZZ>~sg"

#regex="s~  <ZZZ>~  <link rel='icon' type='image\/x-icon' href='\.\.\/\.\.\/\.\.\/\.\./favicon\.ico'>\n  <ZZZ>~sg"
#regex="s~  <ZZZ>~  <link rel='icon' type='image\/png' sizes='32x32'   href='\.\.\/\.\.\/\.\.\/\.\.\/images\/favicons\/favicon-032\.png'>\n  <ZZZ>~sg"
#regex="s~  <ZZZ>~  <link rel='icon' type='image\/png' sizes='128x128' href='\.\.\/\.\.\/\.\.\/\.\.\/images\/favicons\/favicon-128\.png'>\n  <ZZZ>~sg"
#regex="s~  <ZZZ>~  <link rel='icon' type='image\/png' sizes='180x180' href='\.\.\/\.\.\/\.\.\/\.\.\/images\/favicons\/favicon-180\.png'>\n  <ZZZ>~sg"
#regex="s~  <ZZZ>~<link rel='icon' type='image\/png' sizes='192x192' href='\.\.\/\.\.\/\.\.\/\.\.\/images\/favicons\/favicon-192\.png'>\n  <ZZZ>~sg"
#regex="s~<link rel='icon' type='image/png' sizes='192x192'~  <link rel='icon' type='image\/png' sizes='192x192'~sg"
#regex="s~  <ZZZ>~  <link rel='icon' type='image\/png' sizes='512x512' href='\.\.\/\.\.\/\.\.\/\.\.\/images\/favicons\/favicon-512\.png'>\n  <ZZZ>~sg"
#regex="s~  <ZZZ>\n~~sg"
#regex="s~    <a href='\.\.\/\.\.\/\.\.\/index\.html'><span class='clNavHome'></span></a>\n~    <a href='\.\.\/\.\.\/\.\.\/\.\.\/index\.html'><span class='clNavHome'><\/span><\/a>~sg"
regex="s~    <a href='javascript:history.back\(\)'><span class='clNavLeft'><span><\/a>~    <a href='\.\.\/\.\.\/index\.html'><span class='clNavIndex'><\/span></a>~sg"

#-------------------------------------------------------------------------------

cd ${dir}

for file in $(find . -name "${ext}" | sort); do
  perl -i -0pe "${regex}" "${file}"
done

#-------------------------------------------------------------------------------
