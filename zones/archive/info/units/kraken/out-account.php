<?php
#--------------------------------------------------------------------------------------------------
# Аccount Balance
#--------------------------------------------------------------------------------------------------

function out_account_balance()
{
  $dict_assets = $GLOBALS['dict_assets'];
  $tag = '';

  $result = get_account_balance();
  ksort($result, SORT_STRING);

  foreach($result as $key => $value)
  {
    $key = $dict_assets[$key][0];
    $value = number_format((float)$value, 4);

    $tag .= <<<DOC
      <tr><td>{$key}</td><td class='clAlignRight'>{$value}</td></tr>
    DOC;
  }

  $content = get_template('action-account-balance');
  eval("\$content = \"{$content}\";");
  return $content;
}

#--------------------------------------------------------------------------------------------------
# Trade Balance
#--------------------------------------------------------------------------------------------------

function out_trade_balance()
{
  $base_asset = $GLOBALS['base_asset'];
  $dict_trade_balance = $GLOBALS['dict_trade_balance'];

  $post = ['asset' => $base_asset];
  $result = get_trade_balance($post);

  $tag = '';

  foreach($result as $key => $value)
  {
    $key = $dict_trade_balance[$key];
    $value = number_format((float)$value, 4);

    $tag .= <<<DOC
      <tr><td>{$key}</td><td class='clAlignRight'>{$value}</td></tr>
    DOC;
  }

  $content = get_template('action-trade-balance');
  eval("\$content = \"{$content}\";");
  return $content;
}

#--------------------------------------------------------------------------------------------------
# Trades History
#--------------------------------------------------------------------------------------------------

function out_trades_history()
{
  $user = $GLOBALS['user'];
  $logs = $GLOBALS['logs'];
  $dict_tickers = $GLOBALS['dict_tickers'];
  $trades_history_type = $GLOBALS['trades_history_type'];
  $trades_history_fmt = $GLOBALS['trades_history_fmt'];
  $post = ['type' => $trades_history_type];
  $result = get_trades_history($post);

  $result = $result['trades'];

  $tag = '';
  $csv_list = [];

  foreach($result as $key => $value)
  {
    $fmt_1 = $dict_tickers[$value['pair']][1];
    $fmt_2 = $dict_tickers[$value['pair']][2];

    $trade_txid = $key;
    $trade_ordertxid = $value['ordertxid'];
    $trade_postxid = $value['postxid'];

    $trade_pair = $value['pair'];
    $trade_type = $value['type'];
    $trade_ordertype = $value['ordertype'];
    $trade_time = gmdate($trades_history_fmt, (int)$value['time']);
    $trade_price = number_format($value['price'], $fmt_1);
    $trade_cost = number_format($value['cost'], $fmt_2);
    $trade_fee = number_format($value['fee'], $fmt_2);
    $trade_vol = number_format($value['vol'], $fmt_2);
    $trade_margin = number_format($value['margin'], 0);
    $trade_leverage = number_format($value['leverage'], 0);

    $csv_time = gmdate('YmdHis', (int)$value['time']);

    $tag .= <<<DOC
      <tr data-txid='{$trade_txid}' data-ordertxid='{$trade_ordertxid}' data-postxid='{$trade_postxid}'>
        <td>{$trade_time}</td>
        <td>{$trade_pair}</td>
        <td>{$trade_type}</td>
        <td>{$trade_ordertype}</td>
        <td class='clRight'>{$trade_price}</td>
        <td class='clRight'>{$trade_cost}</td>
        <td class='clRight'>{$trade_fee}</td>
        <td class='clRight'>{$trade_vol}</td>
        <td class='clRight'>{$trade_margin}</td>
        <td class='clRight'>{$trade_leverage}</td>
      </tr>
    DOC;

    $csv_line  = '';
    $csv_line .= "\"{$trade_time}\",\"{$value['pair']}\",\"{$value['type']}\",\"{$value['ordertype']}\",";
    $csv_line .= "\"{$value['price']}\",\"{$value['cost']}\",\"{$value['fee']}\",";
    $csv_line .= "\"{$value['vol']}\",\"{$value['margin']}\",\"{$value['leverage']}\",";
    $csv_line .= "\"{$key}\",\"{$value['ordertxid']}\",\"{$value['postxid']}\"";

    array_push($csv_list, $csv_line);
  }

  $csv_head = 'time,pair,side,type,price,cost,fee,volume,mrgn,lvrg,txid,ordertxid,postxid';
  array_push($csv_list, $csv_head);
  $csv_list = array_reverse($csv_list);
  $csv_list = implode("\n", $csv_list);

  $csv_name = "{$logs}/trades-history-{$user}-{$csv_time}.csv";
  file_put_contents($csv_name, $csv_list);

  $content = get_template('action-trades-history');
  eval("\$content = \"{$content}\";");
  return $content;
}

#--------------------------------------------------------------------------------------------------
# Ledgers Info
#--------------------------------------------------------------------------------------------------

function out_ledgers_info()
{
  $input = $GLOBALS['input'];
  $user = $GLOBALS['user'];
  $logs = $GLOBALS['logs'];
  $dict_assets = $GLOBALS['dict_assets'];
  $ledger_info_fmt = $GLOBALS['ledger_info_fmt'];

  if ($input == 'select')
  {
    $prog = $GLOBALS['prog'];
    $user = $GLOBALS['user'];
    $url = "{$prog}?varUser={$user}&varAction=Ledgers&varInput=";
    $tag = '';

    foreach($dict_assets as $key => $value)
    {
      $tag .= <<<DOC
        <tr>
          <td><input class='clSelector' id='{$key}' type='radio' name='sl'></td>
          <td>{$value[0]}</td>
        </tr>\n
      DOC;
    }

    $content = get_template('select-ledgers-info');
    eval("\$content = \"{$content}\";");
  }
  else
  {
    $heading = $dict_assets[$input][0];
    $fmt_1 = $dict_assets[$input][1];
    $fmt_2 = $dict_assets[$input][2];

    $post = ['asset' => $input];
    $result = get_ledgers_info($post);
    $result = $result['ledger'];

    $tag = '';
    $csv_list = [];

    foreach($result as $key => $value)
    {
      $ledger_id = $key;
      $ledger_refid = $value['refid'];
      $ledger_time = gmdate($ledger_info_fmt, (int)$value['time']);
      $ledger_type = $value['type'];
      $ledger_asset = $dict_assets[$input][0];
      $ledger_amount = number_format($value['amount'], $fmt_1);
      $ledger_balance = number_format($value['balance'], $fmt_2);
      $ledger_fee = number_format($value['fee'], $fmt_1);

      $csv_time = gmdate('YmdHis', (int)$value['time']);

      $tag .= <<<DOC
      <tr data-ledgerid='{$ledger_id}' data-refid='{$ledger_refid}'>
        <td>{$ledger_time}</td>
        <td>{$ledger_type}</td>
        <td>{$ledger_asset}</td>
        <td class='clRight'>{$ledger_amount}</td>
        <td class='clRight'>{$ledger_balance}</td>
        <td class='clRight'>{$ledger_fee}</td>
      </tr>\n
      DOC;

      $csv_line  = '';
      $csv_line .= "\"{$ledger_time}\",\"{$value['type']}\",\"{$ledger_asset}\",\"{$value['amount']}\",";
      $csv_line .= "\"{$value['balance']}\",\"{$value['fee']}\",\"{$value['fee']}\",";
      $csv_line .= "\"{$key}\",\"{$value['refid']}\"";

      array_push($csv_list, $csv_line);
    }

    $csv_head = 'time,type,asset,amount,balance,fee,id,refid';
    array_push($csv_list, $csv_head);
    $csv_list = array_reverse($csv_list);
    $csv_list = implode("\n", $csv_list);

    $csv_name = "{$logs}/ledger-info-{$user}-{$ledger_asset}-{$csv_time}.csv";
    file_put_contents($csv_name, $csv_list);

    $content = get_template('action-ledgers-info');
    eval("\$content = \"{$content}\";");
  }

  return $content;
}

#--------------------------------------------------------------------------------------------------
# Closed Orders
#--------------------------------------------------------------------------------------------------

function out_closed_orders()
{
  $post = [];
  $user = $GLOBALS['user'];
  $logs = $GLOBALS['logs'];
  $prog = $GLOBALS['prog'];
  $dict_tickers = $GLOBALS['dict_tickers'];
  $dict_pairs = $GLOBALS['dict_pairs'];
  $closed_orders_fmt = $GLOBALS['closed_orders_fmt'];

  $result = get_closed_orders($post);
  $result = $result['closed'];

  $tag = '';

  foreach($result as $key => $value)
  {
    $order_pair = $value['descr']['pair'];
    $ticker_name = $dict_pairs[$order_pair];
    $fmt_1 = $dict_tickers[$ticker_name][1];
    $fmt_2 = $dict_tickers[$ticker_name][2];

    $order_time = gmdate($closed_orders_fmt, (int)$value['opentm']);
    $order_time = "<a href='{$prog}?varUser={$user}&varAction=OrderInfo&varInput={$key}'>{$order_time}</a>";

    $order_side = $value['descr']['type'];
    $order_type = $value['descr']['ordertype'];
    $order_price = number_format($value['price'], $fmt_1);
    $order_status = $value['status'];

    $tag .= <<<DOC
    <tr>
      <td>{$order_time}</td>
      <td>{$order_pair}</td>
      <td>{$order_side}</td>
      <td>{$order_type}</td>
      <td class='clRight'>{$order_price}</td>
      <td>{$order_status}</td>
    </tr>\n
    DOC;
  }

  $content = get_template('action-closed-orders');
  eval("\$content = \"{$content}\";");
  return $content;
}

#--------------------------------------------------------------------------------------------------
# Order Info
#--------------------------------------------------------------------------------------------------

function out_order_info()
{
  $input = $GLOBALS['input'];
  $post = ['txid' => $input];
  $order_info_fmt = $GLOBALS['order_info_fmt'];

  $result = get_order_info($post);
  $result = $result[$input];

  $refid = $result['refid'];
  $userref = $result['userref'];
  $status = $result['status'];
  $opentm = gmdate($order_info_fmt, (int)$result['opentm']);
  $closetm = gmdate($order_info_fmt, (int)$result['closetm']);

  if (! (int)$result['starttm'] == 0)
  {
    $starttm = gmdate($order_info_fmt, (int)$result['starttm']);
  }
  else
  {
    $starttm = '';
  }

  if (! (int)$result['expiretm'] == 0)
  {
    $expiretm = gmdate($order_info_fmt, (int)$result['expiretm']);
  }
  else
  {
    $expiretm = '';
  }

  $pair = $result['descr']['pair'];
  $side = $result['descr']['type'];
  $type = $result['descr']['ordertype'];

  $price = $result['descr']['price'];
  $price2 = $result['descr']['price2'];
  $leverage = $result['descr']['leverage'];
  $close = $result['descr']['close'];
  $vol = $result['vol'];
  $vol_exec = $result['vol_exec'];
  $cost = $result['cost'];
  $fee = $result['fee'];
  $price_a = $result['price'];
  $stopprice = $result['stopprice'];
  $limitprice = $result['limitprice'];
  $misc = $result['misc'];
  $oflags = $result['oflags'];
  $reason = $result['reason'];

  $tag = <<<DOC
    <tr><td>Refid</td><td>{$refid}</td></tr>
    <tr><td>Userref</td><td>{$userref}</td></tr>
    <tr><td>Status</td><td>{$status}</td></tr>
    <tr><td>Open Time</td><td>{$opentm}</td></tr>
    <tr><td>Start Time</td><td>{$starttm}</td></tr>
    <tr><td>Expire Time</td><td>{$expiretm}</td></tr>
    <tr><td>Pair</td><td>{$pair}</td></tr>
    <tr><td>Side</td><td>{$side}</td></tr>
    <tr><td>Type</td><td>{$type}</td></tr>
    <tr><td>Primary Price</td><td>{$price}</td></tr>
    <tr><td>Secondary Price</td><td>{$price2}</td></tr>
    <tr><td>Leverage</td><td>{$leverage}</td></tr>
    <tr><td>Close</td><td>{$close}</td></tr>
    <tr><td>Volume<sup>b</sup></td><td>{$vol}</td></tr>
    <tr><td>Volume Exec<sup>b</sup></td><td>{$vol_exec}</td></tr>
    <tr><td>Cost<sup>q</sup></td><td>{$cost}</td></tr>
    <tr><td>Fee<sup>q</sup></td><td>{$fee}</td></tr>
    <tr><td>Average Price<sup>q</sup></td><td>{$price_a}</td></tr>
    <tr><td>Stop Price<sup>q</sup></td><td>{$stopprice}</td></tr>
    <tr><td>Limit Price<sup>q</sup></td><td>{$limitprice}</td></tr>
    <tr><td>Miscellaneous</td><td>{$misc}</td></tr>
    <tr><td>Flags<sup>f</sup></td><td>{$oflags}</td></tr>
    <tr><td>Reason</td><td>{$reason}</td></tr>
    <tr><td>Close Time</td><td>{$closetm}</td></tr>
  DOC;

  $content = get_template('action-order-info');
  eval("\$content = \"{$content}\";");
  return $content;
}

#--------------------------------------------------------------------------------------------------
# Trade Volume (Fee Tiers)
#--------------------------------------------------------------------------------------------------

function out_trade_volume()
{

}

#--------------------------------------------------------------------------------------------------
?>
