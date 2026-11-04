<?php
#----------------------------------------------------------------------------------------------------------------------

require_once("../units/{$unit}/api.php");
require_once("../units/{$unit}/out-account.php");
require_once("../units/{$unit}/out-market.php");
require_once("../units/{$unit}/out-trading.php");

#----------------------------------------------------------------------------------------------------------------------
# Main Cycle
#----------------------------------------------------------------------------------------------------------------------

function get_main()
{
  $action = $GLOBALS['action'];

  $content  = '';

  switch ($action)
  {
    case '':                $content = out_start_page();      break;
    case 'SwitchUser':      $content = out_switch_user();     break;
    case 'SystemStatus':    $content = out_system_status();   break;
    case 'Ticker':          $content = out_ticker_info();     break;
    case 'Depth':           $content = out_order_book();      break;

    case 'AccountBalance':  $content = out_account_balance(); break;
    case 'TradeBalance':    $content = out_trade_balance();   break;
    case 'TradesHistory':   $content = out_trades_history();  break;
    case 'Ledgers':         $content = out_ledgers_info();    break;
    case 'TradeVolume':     $content = out_trade_volume();    break;

    case 'ClosedOrders':    $content = out_closed_orders();   break;
    case 'OrderInfo':       $content = out_order_info();      break;

    # case 'Test':            $content = get_ticker_info(['pair' => 'XXBTZUSD']);
    # case 'Test':            $content = get_recent_spreads(['pair' => 'XXBTZUSD']);
    # case 'Test':            $content = get_recent_trades(['pair' => 'XXBTZUSD']);
    # case 'Test':            $content = get_order_book(['pair' => 'XXBTZUSD', 'count' => 6]);
    # case 'Test':            $content = get_trades_history(['type' => 'all']);
    # case 'Test':            $content = get_ledgers_info(['asset' => 'ZEUR']);
    # case 'Test':            $content = get_trade_volume(['pair' => 'USDTEUR']);
    # case 'Test':            $content = get_closed_orders([]);
    case 'Test':            $content = get_order_info(['txid' => 'O3JUK7-KCP57-2WDBKS']);

    $content = '<pre>' . print_r($content, true) . '</pre>';
    break;
  }

  return $content;
}

#----------------------------------------------------------------------------------------------------------------------
?>
