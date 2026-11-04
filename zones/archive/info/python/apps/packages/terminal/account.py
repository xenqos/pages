import time
import packages.commons.functions as fnc


# -----------------------------------------------------------------------------
# Account Balance
# -----------------------------------------------------------------------------

def out_account_balance(cfg, rapi):
    result = rapi.get_account_balance()
    result = dict(sorted(result.items(), key=lambda item: item[0]))
    prc = '4'
    tag = ''

    for key, value in result.items():
        asset = cfg.params['dict_assets'][key][0]
        tag += f"""
        <tr>
        <td>{asset}</td><td class='clRight'>{float(value):,.{prc}f}</td>
        </tr>
        """

    return fnc.get_template(cfg, 'action_account_balance').format(**locals())


# -----------------------------------------------------------------------------
# Trade Balance
# -----------------------------------------------------------------------------

def out_trade_balance(cfg, rapi):
    result = rapi.get_trade_balance()
    dictionary = cfg.params['dict_trade_balance']
    prc = '2'
    tag = ''

    for key, value in result.items():
        tag += f"""
        <tr>
        <td>{dictionary[key]}</td>
        <td class='clRight'>{float(value):,.{prc}f}</td>
        </tr>
        """

    return fnc.get_template(cfg, 'action_trade_balance').format(**locals())


# -----------------------------------------------------------------------------
# Closed Orders
# -----------------------------------------------------------------------------

def out_closed_orders(cfg, rapi):
    fmt = "%m/%d/%y %H:%M:%S"
    prc = ''
    tag = ''

    user = cfg.params['user']
    initfile = cfg.params['initfile']
    result = rapi.get_closed_orders()
    orders = result['closed']

    for key, value in orders.items():
        opentm = time.strftime(fmt, time.gmtime(value['opentm']))
        status = value['status']
        pair = value['descr']['pair']
        side = value['descr']['type']
        type = value['descr']['ordertype']
        price = value['price']

        for key_dt, value_dt in cfg.params['dict_tickers'].items():
            if value_dt[0] == pair:
                prc = value_dt[1]
                break

        url_order_info = ''
        url_order_info += f"<a href='{initfile}?"
        url_order_info += f"varUser={user}&varAction=OrderInfo"
        url_order_info += f"&varInput={key}'>{opentm}</a>"

        tag += f"""
        <tr>
        <td>{url_order_info}</td>
        <td>{pair}</td>
        <td>{side}</td>
        <td>{type}</td>
        <td class='clRight'>{float(price):,.{prc}f}</td>
        <td>{status}</td>
        </tr>
        """

    return fnc.get_template(cfg, 'action_closed_orders').format(**locals())


# -----------------------------------------------------------------------------
# Order Info
# -----------------------------------------------------------------------------

def out_order_info(cfg, rapi):
    fmt = "%m/%d/%y %H:%M:%S"
    tag = ''

    txid = cfg.params['input']
    result = rapi.get_order_info(txid)
    order = result[txid]

    refid = order['refid']
    userref = order['userref']
    status = order['status']
    opentm = time.strftime(fmt, time.gmtime(order['opentm']))
    closetm = time.strftime(fmt, time.gmtime(order['closetm']))
    starttm = time.strftime(fmt, time.gmtime(order['starttm']))
    expiretm = time.strftime(fmt, time.gmtime(order['expiretm']))

    if starttm == '01/01/70 00:00:00':
        starttm = '0'

    if expiretm == '01/01/70 00:00:00':
        expiretm = '0'

    side = order['descr']['type']
    type = order['descr']['ordertype']
    pair = order['descr']['pair']
    price = order['descr']['price']
    price2 = order['descr']['price2']
    leverage = order['descr']['leverage']
    close = order['descr']['close']
    vol = order['vol']
    vol_exec = order['vol_exec']
    cost = order['cost']
    fee = order['fee']
    price_a = order['price']
    stopprice = order['stopprice']
    limitprice = order['limitprice']
    misc = order['misc']
    oflags = order['oflags']
    reason = order['reason']

    tag += f"""
    <tr><td>Refid</td><td>{refid}</td></tr>
    <tr><td>Userref</td><td>{userref}</td></tr>
    <tr><td>Status</td><td>{status}</td></tr>
    <tr><td>Open Time</td><td>{opentm}</td></tr>
    <tr><td>Start Time</td><td>{starttm}</td></tr>
    <tr><td>Expire Time</td><td>{expiretm}</td></tr>
    <tr><td>Pair</td><td>{pair}</td></tr>
    <tr><td>Side</td><td>{side}</td></tr>
    <tr><td>Type</td><td>{type}</td></tr>
    <tr><td>Primary Price</td><td>{price}</td></tr>
    <tr><td>Secondary Price</td><td>{price2}</td></tr>
    <tr><td>Leverage</td><td>{leverage}</td></tr>
    <tr><td>Close</td><td>{close}</td></tr>
    <tr><td>Volume<sup>b</sup></td><td>{vol}</td></tr>
    <tr><td>Volume Exec<sup>b</sup></td><td>{vol_exec}</td></tr>
    <tr><td>Cost<sup>q</sup></td><td>{cost}</td></tr>
    <tr><td>Fee<sup>q</sup></td><td>{fee}</td></tr>
    <tr><td>Average Price<sup>q</sup></td><td>{price_a}</td></tr>
    <tr><td>Stop Price<sup>q</sup></td><td>{stopprice}</td></tr>
    <tr><td>Limit Price<sup>q</sup></td><td>{limitprice}</td></tr>
    <tr><td>Miscellaneous</td><td>{misc}</td></tr>
    <tr><td>Flags<sup>f</sup></td><td>{oflags}</td></tr>
    <tr><td>Reason</td><td>{reason}</td></tr>
    <tr><td>Close Time</td><td>{closetm}</td></tr>
    """

    return fnc.get_template(cfg, 'action_order_info').format(**locals())


# -----------------------------------------------------------------------------
# Trades History
# -----------------------------------------------------------------------------

def out_trades_history(cfg, rapi):
    user = cfg.params['user']
    result = rapi.get_trades_history()
    trades = result['trades']

    iternum = 0
    fmt_trds = "%m/%d/%y %H:%M:%S"
    fmt_file = "%Y%m%d%H%M%S"
    csv_list = []
    csv_head = ''
    tag = ''

    # -------------------------------------------------------------------------
    # Screen
    # -------------------------------------------------------------------------

    for key, value in trades.items():
        trade_time = time.strftime(fmt_trds, time.gmtime(value['time']))

        if iternum == 0:
            file_date = time.strftime(fmt_file, time.gmtime(value['time']))
            iternum += 1

        trade_pair = cfg.params['dict_tickers'][value['pair']][0]
        trade_side = value['type']
        trade_type = value['ordertype']
        trade_txid = key
        trade_ordertxid = value['ordertxid']
        trade_postxid = value['postxid']

        prc_p = cfg.params['dict_tickers'][value['pair']][1]
        prc_v = cfg.params['dict_tickers'][value['pair']][2]

        trade_price = f"{float(value['price']):,.{prc_p}f}"
        trade_volume = f"{float(value['vol']):,.{prc_v}f}"

        prc = '2'
        trade_cost = f"{float(value['cost']):,.{prc}f}"
        trade_fee = f"{float(value['fee']):,.{prc}f}"

        prc = '0'
        trade_margin = f"{float(value['margin']):,.{prc}f}"
        trade_leverage = f"{float(value['leverage']):,.{prc}f}"

        tag += f"""
        <tr data-txid='{trade_txid}'
            data-ordertxid='{trade_ordertxid}'
            data-postxid='{trade_postxid}'>
        <td>{trade_time}</td>
        <td>{trade_pair}</td>
        <td>{trade_side}</td>
        <td>{trade_type}</td>
        <td class='clRight'>{trade_price}</td>
        <td class='clRight'>{trade_cost}</td>
        <td class='clRight'>{trade_fee}</td>
        <td class='clRight'>{trade_volume}</td>
        <td class='clRight'>{trade_margin}</td>
        <td class='clRight'>{trade_leverage}</td>
        </tr>
        """

        csv_list.append(
            f'"{trade_time}","{trade_pair}","{trade_side}","{trade_type}",' +
            f'"{trade_price}","{trade_cost}","{trade_fee}",' +
            f'"{trade_volume}","{trade_margin}","{trade_leverage}",' +
            f'"{trade_txid}","{trade_ordertxid}","{trade_postxid}"'
        )

    # -------------------------------------------------------------------------
    # CSV File
    # -------------------------------------------------------------------------

    csv_list.reverse()

    csv_head += 'time,pair,side,type,price,cost,fee,volume,mrgn,lvrg,'
    csv_head += 'txid,ordertxid,postxid\n'

    filename = cfg.params['logs'] + \
        f'/trades_{user}_{file_date}.csv'
    with open(filename, 'w') as file:
        file.write(csv_head)
    with open(filename, 'a') as file:
        file.write('\n'.join(csv_list))

    # -------------------------------------------------------------------------

    return fnc.get_template(cfg, 'action_trades_history').format(**locals())


# -----------------------------------------------------------------------------
# Ledgers Info
# -----------------------------------------------------------------------------

def out_ledgers_info(cfg, rapi):
    if (cfg.params['input'] == 'select'):
        user = cfg.params['user']
        initfile = cfg.params['initfile']
        url = f'{initfile}?varUser={user}&varAction=Ledgers&varInput='
        tag = ''

        for key, value in cfg.params['dict_assets'].items():
            tag += f"""
            <tr>
            <td>
            <input class='clSelector' id='{key}' type='radio' name='sl'>
            </td>
            <td>{value[0]}</td>
            </tr>
            """

        return fnc.get_template(cfg, 'select_ledgers_info').format(**locals())
    else:
        asset = cfg.params['input']
        heading = cfg.params['dict_assets'][asset][0]
        user = cfg.params['user']
        result = rapi.get_ledgers_info(asset)
        ledger = result['ledger']

        iternum = 0
        fmt_ldgr = "%m/%d/%y %H:%M:%S"
        fmt_file = "%Y%m%d%H%M%S"
        csv_list = []
        csv_head = ''
        tag = ''

        # ---------------------------------------------------------------------
        # Screen
        # ---------------------------------------------------------------------

        for key, value in ledger.items():
            prc_p = cfg.params['dict_assets'][value['asset']][1]
            prc_v = cfg.params['dict_assets'][value['asset']][2]

            ledger_id = key
            ledger_refid = value['refid']
            ledger_time = time.strftime(fmt_ldgr, time.gmtime(value['time']))

            if iternum == 0:
                file_date = time.strftime(fmt_file, time.gmtime(value['time']))
                iternum += 1

            ledger_type = value['type']
            ledger_asset = cfg.params['dict_assets'][value['asset']][0]
            ledger_amount = f"{float(value['amount']):,.{prc_v}f}"
            ledger_balance = f"{float(value['balance']):,.{prc_p}f}"
            ledger_fee = f"{float(value['fee']):,.{prc_p}f}"

            tag += f"""
            <tr data-ledgerid='{ledger_id}'
                data-refid='{ledger_refid}'>
            <td>{ledger_time}</td>
            <td>{ledger_type}</td>
            <td>{ledger_asset}</td>
            <td class='clRight'>{ledger_amount}</td>
            <td class='clRight'>{ledger_balance}</td>
            <td class='clRight'>{ledger_fee}</td>
            </tr>
            """

            csv_list.append(
                f'"{ledger_time}","{ledger_type}","{ledger_asset}",' +
                f'"{ledger_amount}","{ledger_balance}","{ledger_fee}",' +
                f'"{ledger_id}","{ledger_refid}"'
            )

        # -------------------------------------------------------------------------
        # CSV File
        # -------------------------------------------------------------------------

        csv_list.reverse()

        csv_head += 'time,type,asset,amount,balance,fee,'
        csv_head += 'id,refid\n'

        filename = cfg.params['logs'] + \
            f'/ledger_{user}_{ledger_asset}_{file_date}.csv'
        with open(filename, 'w') as file:
            file.write(csv_head)
        with open(filename, 'a') as file:
            file.write('\n'.join(csv_list))

        return fnc.get_template(cfg, 'action_ledgers_info').format(**locals())


# -----------------------------------------------------------------------------
# Trade Volume (Fee Tiers)
# -----------------------------------------------------------------------------

def out_trade_volume(cfg, rapi):
    # pair = 'ZEURZUSD'
    # pair = 'XXBTZEUR'
    pair = 'XXBTZUSD'
    result = rapi.get_trade_volume(pair)
    tag = ''
    tag = str(result)

    return fnc.get_template(cfg, 'action_trade_volume').format(**locals())

# -----------------------------------------------------------------------------
