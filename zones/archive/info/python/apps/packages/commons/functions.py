import logging
import os
import re
import requests
import sys
import time
import traceback
import packages.commons.constants as cns


# -----------------------------------------------------------------------------

def out_exceptions(ex_class, ex_instance, traceback_obj):
    logging.critical(''.join(traceback.format_tb(traceback_obj)))
    logging.critical('{0}: {1}'.format(ex_class, ex_instance))


# -----------------------------------------------------------------------------

def get_exceptions():
    # loglevel = logging.DEBUG
    loglevel = logging.ERROR

    module = os.path.splitext(
        os.path.basename(sys.modules['__main__'].__file__))[0]

    logging.basicConfig(
        level=loglevel, filename=f'{cns.logs}/{module}.log', filemode='w')

    sys.excepthook = out_exceptions


# -----------------------------------------------------------------------------

def get_template(cfg, file):
    templates = cfg.params['templates']
    module = cfg.params['module']

    with open(f"{templates}/{module}/{file}.html", 'r') as object:
        page = object.read()

    return page


# -----------------------------------------------------------------------------

def get_url_response(url, headers, params=None, data=None):
    if data is None:
        response = requests.get(url, headers=headers, params=params)
    else:
        response = requests.post(url, headers=headers, data=data)

    response.raise_for_status()
    return response.text


# -----------------------------------------------------------------------------

def clean_content(regexes, content):
    for regex in regexes:
        if not regex[0]:
            continue
        content = re.sub(regex[0], regex[1], content, flags=(re.S | re.I))
    return content


# -----------------------------------------------------------------------------

def get_utc_offset():
    is_dst = time.daylight and time.localtime().tm_isdst > 0
    utc_offset = int(- (time.altzone if is_dst else time.timezone)/60/60)
    return utc_offset


# -----------------------------------------------------------------------------

def log_debug(item, mode):
    filename = f'{cns.logs}/debug.log'
    with open(filename, mode) as file:
        file.write(str(item))


# -----------------------------------------------------------------------------
# fnc.log_debug(item, 'w')
# -----------------------------------------------------------------------------
