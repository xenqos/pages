<?php
#--------------------------------------------------------------------------------------------------

$title = 'Kraken Terminal';
$zone = 'fn';

#--------------------------------------------------------------------------------------------------

$user   = $_GET['varUser']   ?? '';
$action = $_GET['varAction'] ?? '';
$input  = $_GET['varInput']  ?? '';

#--------------------------------------------------------------------------------------------------

$url = 'https://api.kraken.com';

$apis = '/home/lux/mnt/data/Safe/Keys/Passwords/kraken.md';

#--------------------------------------------------------------------------------------------------

$users =
[
  'crux'
, 'lynx'
];

# $_SERVER['SHELL'] == '/bin/bash' ? $user = $users[0]: null;

#--------------------------------------------------------------------------------------------------

$base_asset = 'ZEUR';
$trades_history_type = 'all'; # 'any position', 'closing position', 'no position'
$trades_history_fmt = 'm/d/y H:i:s';
$order_book_count = 6;

$ledger_info_fmt = 'm/d/y H:i:s';
$closed_orders_fmt = 'm/d/y H:i:s';
$order_info_fmt = 'm/d/y H:i:s';

#--------------------------------------------------------------------------------------------------

$dict_tickers =
[
  'XXBTZEUR' => ['XBTEUR' , 0, 4]
, 'XXBTZUSD' => ['XBTUSD' , 0, 4]
, 'XETHZEUR' => ['ETHEUR' , 0, 4]
, 'XETHZUSD' => ['ETHUSD' , 0, 4]
, 'XXRPZEUR' => ['XRPEUR' , 4, 2]
, 'USDTEUR'  => ['USDTEUR', 4, 2]
, 'USDTZUSD' => ['USDTUSD', 4, 2]
, 'ZEURZUSD' => ['EURUSD' , 4, 2]
];

$dict_pairs =
[
  'XBTEUR'  => 'XXBTZEUR'
, 'XBTUSD'  => 'XXBTZUSD'
, 'ETHEUR'  => 'XETHZEUR'
, 'ETHUSD'  => 'XETHZUSD'
, 'XRPEUR'  => 'XXRPZEUR'
, 'USDTEUR' => 'USDTEUR'
, 'USDTUSD' => 'USDTZUSD'
, 'EURUSD'  => 'ZEURZUSD'
];

$dict_assets =
[
  'ZEUR' => ['EUR' , 2, 2]
, 'ZUSD' => ['USD' , 2, 2]
, 'XXBT' => ['XBT' , 6, 4]
, 'XETH' => ['ETH' , 6, 4]
, 'XXRP' => ['XRP' , 6, 4]
, 'USDT' => ['USDT', 2, 2]
];

$dict_trade_info =
[
  'a' => 'Ask'
, 'b' => 'Bid'
, 'c' => 'Last'
, 'v' => 'Volume'
, 'p' => 'Volume weighted average price'
, 't' => 'Trades'
, 'l' => 'Low'
, 'h' => 'High'
, 'o' => 'Open'
];

$dict_trade_balance =
[
  'eb' => 'Equivalent balance<sup>1</sup>'
, 'tb' => 'Trade balance<sup>2</sup>'
, 'm'  => 'Margin amount of open positions'
, 'n'  => 'Unrealized net profit/loss of open positions'
, 'c'  => 'Cost basis of open positions'
, 'v'  => 'Current floating valuation of open positions'
, 'e'  => 'Equity<sup>3</sup>'
, 'mf' => 'Free margin<sup>4</sup>'
, 'ml' => 'Margin level<sup>5</sup>'
, 'uv' => 'Unexecuted value<sup>6</sup>'
];

#--------------------------------------------------------------------------------------------------
?>
