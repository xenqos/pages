#!/usr/bin/env python

import os
import urllib.parse

import packages.commons.functions as fnc
import packages.commons.classes as cls
import packages.terminal.restapi as rpi
import packages.terminal.market as mrk
import packages.terminal.account as acc


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

    query = urllib.parse.parse_qs(os.getenv('QUERY_STRING'))

    cfg.params['url_request'] = \
        os.getenv('REQUEST_SCHEME') + '://' + \
        os.getenv('SERVER_NAME') + os.getenv('REQUEST_URI')

    if query.get('varUser') is None:
        cfg.params['user'] = cfg.params['list_users'][0]
    else:
        cfg.params['user'] = str(query['varUser'][0])

    if query.get('varAction') is None:
        cfg.params['action'] = ''
    else:
        cfg.params['action'] = str(query['varAction'][0])

    if query.get('varInput') is None:
        cfg.params['input'] = ''
    else:
        cfg.params['input'] = str(query['varInput'][0])

    rapi = rpi.RestApi(cfg)

    # -------------------------------------------------------------------------
    # Set Page Content
    # -------------------------------------------------------------------------

    match cfg.params['action']:
        # ---------------------------------------------------------------------
        case '':
            content = mrk.set_logo(cfg)
        case 'SwitchUser':
            content = mrk.set_switch_user(cfg)
        case 'SystemStatus':
            content = mrk.out_system_status(cfg, rapi)
        case 'Ticker':
            content = mrk.out_ticker_info(cfg, rapi)
        case 'Depth':
            content = mrk.out_order_book(cfg, rapi)
        # ---------------------------------------------------------------------
        case 'AccountBalance':
            content = acc.out_account_balance(cfg, rapi)
        case 'TradeBalance':
            content = acc.out_trade_balance(cfg, rapi)
        case 'TradesHistory':
            content = acc.out_trades_history(cfg, rapi)
        case 'Ledgers':
            content = acc.out_ledgers_info(cfg, rapi)
        case 'TradeVolume':
            content = acc.out_trade_volume(cfg, rapi)
        # ---------------------------------------------------------------------
        case 'ClosedOrders':
            content = acc.out_closed_orders(cfg, rapi)
        case 'OrderInfo':
            content = acc.out_order_info(cfg, rapi)
        # ---------------------------------------------------------------------
        case 'Test':
            # content = rapi.get_recent_trades('XBTUSD')
            # content = rapi.get_recent_spreads('XBTUSD')
            # content = rapi.get_trade_volume('XXBTZUSD')
            # content = rapi.get_asset_info('DOGE')
            # content = rapi.get_closed_orders()
            content = rapi.get_order_info('OS2B5O-M5MDJ-F2Y7WS')

    # -------------------------------------------------------------------------
    # Set Locals
    # -------------------------------------------------------------------------

    module = cfg.params['module']
    user = cfg.params['user']
    action = cfg.params['action']
    input = cfg.params['input']
    title = cfg.params['title']
    url_request = cfg.params['url_request']
    initfile = cfg.params['initfile']

    # -------------------------------------------------------------------------
    # Print Page
    # -------------------------------------------------------------------------

    print('Content-type: text/html;charset=utf-8\n')
    print(fnc.get_template(cfg, 'default').format(**locals()))


# -----------------------------------------------------------------------------

if __name__ == "__main__":
    if os.environ['SERVER_NAME'] == 'localhost':
        main()

# -----------------------------------------------------------------------------
