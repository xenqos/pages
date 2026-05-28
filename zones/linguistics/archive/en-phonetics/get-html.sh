#!/bin/bash

# -v verbose
# -s silent
# -H header
# -A user agent

user_agent='Mozilla/5.0 (X11; Linux x86_64; rv:143.0) Gecko/20100101 Firefox/143.0'

prefix='http://l90463d4.beget.tech/index.html'

dir='00'

cd ${dir}

sleep 1; echo '001'; curl -s -A "${user_agent}" "${prefix}/1/"   -o 001.html
