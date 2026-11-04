import re
import time
import packages.commons.functions as fnc


# -----------------------------------------------------------------------------
# Set Logo
# -----------------------------------------------------------------------------

def set_logo(cfg):
    module = cfg.params['module']
    content = f"""
    <span id='idLogo'><img src='../images/{module}/logo.png'></span>
    """
    return content


# -----------------------------------------------------------------------------
# Switch User
# -----------------------------------------------------------------------------

def set_switch_user(cfg):
    if (cfg.params['input'] != 'select'):
        return None
    else:
        initfile = cfg.params['initfile']
        url = f'{initfile}?varUser='
        tag = ''

        for item in cfg.params['list_users']:
            tag += f"""
            <tr>
            <td>
            <input class='clSelector' id='{item}' type='radio' name='sl'>
            </td>
            <td>{item}</td>
            </tr>
            """

        return fnc.get_template(cfg, 'select_switch_user').format(**locals())


# -----------------------------------------------------------------------------
# System Status
# -----------------------------------------------------------------------------

def out_system_status(cfg, rapi):
    result = rapi.get_system_status()

    result['timestamp'] = \
        re.sub('Z', '', result['timestamp'], flags=(re.S | re.I))
    result['timestamp'] = \
        re.sub('T', ' ', result['timestamp'], flags=(re.S | re.I))

    tag = f"""
    <td>{result['status']}</td>
    <td>{result['timestamp']}</td>
    """
    return fnc.get_template(cfg, 'action_system_status').format(**locals())


# -----------------------------------------------------------------------------
# Ticker Info
# -----------------------------------------------------------------------------

def out_ticker_info(cfg, rapi):
    if (cfg.params['input'] == 'select'):
        user = cfg.params['user']
        initfile = cfg.params['initfile']
        url = f'{initfile}?varUser={user}&varAction=Ticker&varInput='
        tag = ''

        for key, value in cfg.params['dict_tickers'].items():
            tag += f"""
            <tr>
            <td>
            <input class='clSelector' id='{key}' type='radio' name='sl'>
            </td>
            <td>{value[0]}</td>
            </tr>
            """

        return fnc.get_template(cfg, 'select_ticker_info').format(**locals())
    else:
        pair = cfg.params['input']
        heading = cfg.params['dict_tickers'][pair][0]
        prc = cfg.params['dict_tickers'][pair][1]
        tag01 = ''
        tag02 = ''
        tag03 = ''

        result = rapi.get_ticker_info(pair)
        ticker = list(result.keys())[0]
        info = result[ticker]

        dictionary = cfg.params['dict_trade_info']
        for key in ('a', 'b', 'c'):
            tag01 += f"""
            <tr>
            <td>{dictionary[key]}</td>
            <td class='clRight'>{float(info[key][0]):,.{prc}f}</td>
            </tr>
            """

        tag01 += f"""
        <tr>
        <td>{dictionary['o']}</td>
        <td class='clRight'>{float(info['o']):,.{prc}f}</td>
        </tr>
        """

        for key in ('l', 'h'):
            tag02 += f"""
            <tr>
            <td>{dictionary[key]}</td>
            <td class='clRight'>{float(info[key][0]):,.{prc}f}</td>
            <td class='clRight'>{float(info[key][1]):,.{prc}f}</td>
            </tr>
            """

        prc = '0'

        for key in ('t', 'v'):
            tag03 += f"""
            <tr>
            <td>{dictionary[key]}</td>
            <td class='clRight'>{float(info[key][0]):,.{prc}f}</td>
            <td class='clRight'>{float(info[key][1]):,.{prc}f}</td>
            </tr>
            """

        return fnc.get_template(cfg, 'action_ticker_info').format(**locals())


# -----------------------------------------------------------------------------
# Order Book
# -----------------------------------------------------------------------------

def out_order_book(cfg, rapi):
    if (cfg.params['input'] == 'select'):
        user = cfg.params['user']
        initfile = cfg.params['initfile']
        url = f'{initfile}?varUser={user}&varAction=Depth&varInput='
        tag = ''

        for key, value in cfg.params['dict_tickers'].items():
            tag += f"""
            <tr>
            <td>
            <input class='clSelector' id='{key}' type='radio' name='sl'>
            </td>
            <td>{value[0]}</td>
            </tr>
            """

        return fnc.get_template(cfg, 'select_order_book').format(**locals())
    else:
        pair = cfg.params['input']
        heading = cfg.params['dict_tickers'][pair][0]
        prc_p = cfg.params['dict_tickers'][pair][1]
        prc_v = cfg.params['dict_tickers'][pair][2]
        tag_b = ''
        tag_a = ''

        result = rapi.get_order_book(pair)
        ticker = list(result.keys())[0]
        info = result[ticker]
        info_asks = sorted(info['asks'], key=lambda k: k[0], reverse=False)
        info_bids = sorted(info['bids'], key=lambda k: k[0], reverse=True)

        for (iter_b, iter_a) in zip(info_bids, info_asks):
            time_b = time.strftime("%H:%M:%S", time.gmtime(iter_b[2]))
            time_a = time.strftime("%H:%M:%S", time.gmtime(iter_b[2]))

            tag_b += f"""<tr>
            <td class='clRight'>{float(iter_b[0]):,.{prc_p}f}</td>
            <td class='clRight'>{float(iter_b[1]):,.{prc_v}f}</td>
            <td class='clRight'>{time_b}</td>
            </tr>"""

            tag_a += f"""<tr>
            <td class='clRight'>{float(iter_a[0]):,.{prc_p}f}</td>
            <td class='clRight'>{float(iter_a[1]):,.{prc_v}f}</td>
            <td class='clRight'>{time_a}</td>
            </tr>"""

        return fnc.get_template(cfg, 'action_order_book').format(**locals())


# -----------------------------------------------------------------------------
