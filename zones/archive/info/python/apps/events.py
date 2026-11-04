#!/usr/bin/env python

import datetime
import io
import lxml.html
import re
import time
from urllib.parse import urlencode

import packages.commons.functions as fnc
import packages.commons.classes as cls


# -----------------------------------------------------------------------------
# Get Events
# -----------------------------------------------------------------------------

def get_events(cfg):
    cfg.params['params_events']['calType'] = 'day'
    url_events = cfg.params['url_events']
    headers = cfg.params['headers']
    params_events = cfg.params['params_events']
    rgx_evnt_body = cfg.params['rgx_evnt_body']
    rgx_evnt_date = cfg.params['rgx_evnt_date']
    rgx_evnt_time = cfg.params['rgx_evnt_time']
    rgxs_evnts = cfg.params['rgxs_evnts']
    content = ''

    # -------------------------------------------------------------------------
    # Get URL Response
    # -------------------------------------------------------------------------

    response = fnc.get_url_response(url_events, headers, params_events)

    # -------------------------------------------------------------------------
    # Process Result
    # -------------------------------------------------------------------------

    result_body = re.search(rgx_evnt_body, response, flags=(re.S | re.I))
    result_date = re.search(rgx_evnt_date, response, flags=(re.S | re.I))

    cfg.params['date_current'] = result_date.group(2)
    lines = fnc.clean_content(rgxs_evnts, result_body.group(2))

    utc_offset = fnc.get_utc_offset()

    for line in io.StringIO(lines):
        result = re.search(rgx_evnt_time, line.strip(), flags=(re.S | re.I))
        if result is not None:
            time_utc = result.group(1)
            time_obj = datetime.datetime.strptime(time_utc, '%H:%M') + \
                datetime.timedelta(hours=utc_offset)
            time_loc = time_obj.strftime('%H:%M')

            line_changed = re.sub(
                rgx_evnt_time, f'{time_loc}&emsp;{time_utc}</span>',
                line.strip(), flags=(re.S | re.I))

            content += f'{line_changed}\n'
        else:
            content += line

    return content


# -----------------------------------------------------------------------------
# Get Central Banks Rates
# -----------------------------------------------------------------------------

def get_cbrates(cfg):
    headers = cfg.params['headers']
    list_cbrates = cfg.params['list_cbrates']
    regexes_cbrates = cfg.params['regexes_cbrates']
    content = ''

    # -------------------------------------------------------------------------
    # Process Countries
    # -------------------------------------------------------------------------

    for item in list_cbrates:
        content += f'<h4>{item[0]}</h4>\n'
        content += '<div class="clOverflow">'

        response = fnc.get_url_response(item[1], headers)
        rgx_cbrts_body = 'table[id=calendar]'
        html_object = lxml.html.fromstring(response)
        html_elements = html_object.cssselect(rgx_cbrts_body)

        tag = lxml.html.tostring(
            html_elements[0], method='html', encoding='unicode')

        content += fnc.clean_content(regexes_cbrates, tag)
        content += '</div>'

    # -------------------------------------------------------------------------
    # Change Time To 24H
    # -------------------------------------------------------------------------

    def replace_match(match):
        string = f'{match.group(1)} {match.group(2)}M'
        object = datetime.datetime.strptime(string, '%I:%M %p')
        return f"<td>{object.strftime('%H:%M')}</td>"

    content = re.sub(r'<td>(\d\d:\d\d) (A|P)M</td>', replace_match, content)
    return content


# -----------------------------------------------------------------------------
# Main
# -----------------------------------------------------------------------------

def main():
    # -------------------------------------------------------------------------
    # Get Exceptions
    # -------------------------------------------------------------------------

    fnc.get_exceptions()

    # -------------------------------------------------------------------------
    # Get Congiguration
    # -------------------------------------------------------------------------

    cfg = cls.Config()

    # -------------------------------------------------------------------------
    # Get Contents
    # -------------------------------------------------------------------------

    events = get_events(cfg)
    cbrates = get_cbrates(cfg)

    # -------------------------------------------------------------------------
    # Set Locals
    # -------------------------------------------------------------------------

    module = cfg.params['module']
    title = cfg.params['title']
    zones = cfg.params['zones']
    zone = cfg.params['zone']
    url_events = cfg.params['url_events']
    params_events = cfg.params['params_events']
    date_current = cfg.params['date_current']

    time_local = time.strftime('%H:%M', time.localtime())
    time_utc = time.strftime('%H:%M', time.gmtime())

    url_events_week = url_events + '?' + urlencode(params_events)

    # -------------------------------------------------------------------------
    # Print Page
    # -------------------------------------------------------------------------

    print('Content-type: text/html;charset=utf-8\n')
    print(fnc.get_template(cfg, 'default').format(**locals()))


# -----------------------------------------------------------------------------

if __name__ == "__main__":
    main()

# -----------------------------------------------------------------------------
