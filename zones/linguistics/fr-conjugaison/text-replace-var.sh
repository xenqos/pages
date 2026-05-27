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

#regex="s~<head>(.*?)<title>~<head>\n  <meta charset='UTF-8'>\n  <meta name='viewport' content='width=device-width, initial-scale=1.0'>\n  <title>~sg"
#regex="s~<\/title>(.*?)<\/head>~</title>\n  <link rel='preload' href='./styles/fonts/Roboto-400.woff2' as='font' type='font/woff2' crossorigin>\n  </head>~sg"
#regex="s~  <\/head>~  <link rel='icon' type='image/x-icon' href='../../../../favicon.ico'>\n</head>~sg"
#regex="s~<\/head>~  <link rel='icon' type='image/png' sizes='32x32'   href='../../../../images/favicons/favicon-032.png'>\n</head>~sg"
#regex="s~<\/head>~  <link rel='icon' type='image/png' sizes='128x128' href='../../../../images/favicons/favicon-128.png'>\n</head>~sg"
#regex="s~<\/head>~  <link rel='icon' type='image/png' sizes='180x180' href='../../../../images/favicons/favicon-180.png'>\n</head>~sg"
#regex="s~<\/head>~  <link rel='icon' type='image/png' sizes='192x192' href='../../../../images/favicons/favicon-192.png'>\n</head>~sg"
#regex="s~<\/head>~  <link rel='icon' type='image/png' sizes='512x512' href='../../../../images/favicons/favicon-512.png'>\n</head>~sg"
#regex="s~<\/head>~  <link rel='stylesheet' media='screen' href='../../../../styles/global.css'>\n</head>~sg"
#regex="s~<\/head>~  <link rel='stylesheet' media='screen' href='../styles/local.css'>\n</head>~sg"
#regex="s~<\/head>~  <script defer src='../../../../scripts/global.js'></script>\n</head>~sg"
#regex="s~<\/head>~  <script defer src='../scripts/local.js'></script>\n</head>~sg"

#regex="s~<div id='idTopbarNavigation'>(.*?)</div>~~sg"
regex="s~<div id='idTopbar'>(.*?)</div>~~sg"

#-------------------------------------------------------------------------------

cd ${dir}

for file in $(find . -name "${ext}" | sort); do
  perl -i -0pe "${regex}" "${file}"
done

#-------------------------------------------------------------------------------
