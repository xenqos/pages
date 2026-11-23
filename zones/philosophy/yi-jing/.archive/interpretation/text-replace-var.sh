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


ext='*.md'

#-------------------------------------------------------------------------------

#regex="s~<link(.*?)<div id='idSymbolPinyin'>~\n<div id='idSymbolPinyin'>~sg"
#regex="s~^(.*?)<title>~~sg"
#regex="s~</title>(.*?)<div id='idTopbarName'>(.*?)</div>~\2\n~sg"
#regex="s~<div id='idTopbarNavigation'>(.*?)<div id='idSymbolPinyin'>~<div id='idSymbolPinyin'>~sg"
#regex="s~<div id='idSymbolPinyin'>(.*?)</div>~~sg"
#regex="s~</div>\n</div>\n</body>\n</html>~~sg"
#regex="s~\t~~sg"
regex="s~</div>\n<div~</div>\n\n<div~sg"

#-------------------------------------------------------------------------------

cd ${dir}

for file in $(find . -name "${ext}" | sort); do
  perl -i -0pe "${regex}" "${file}"
done

#-------------------------------------------------------------------------------
