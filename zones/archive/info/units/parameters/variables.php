<?php
#--------------------------------------------------------------------------------------------------

$title = 'Parameters';
$zone = 'fn';

#--------------------------------------------------------------------------------------------------

$action = $_GET['varAction'] ?? '';

#--------------------------------------------------------------------------------------------------
# Test URLs
#--------------------------------------------------------------------------------------------------

# https://www.widgets.investing.com/live-currency-cross-rates?theme=darkTheme&cols=bid,ask,last&pairs=1001803
# https://www.widgets.investing.com/crypto-currency-rates?theme=darkTheme&cols=bid,ask,last&pairs=1031397

# http://localhost/programs/parameters.php?varAction=fiat&varRefresh=0
# http://localhost/programs/parameters.php?varAction=crypto&varRefresh=0
# http://localhost/programs/parameters.php?varAction=margins&varRefresh=0
# http://localhost/programs/parameters.php?varAction=benchmarks&varRefresh=0
# http://localhost/programs/parameters.php?varAction=interests&varRefresh=0

# =IMPORTDATA("https://home.ayurveda.help/programs/parameters.php?varAction=fiat&varRefresh=" & UpdateQuotes)
# =IMPORTDATA("https://home.ayurveda.help/programs/parameters.php?varAction=crypto&varRefresh=" & UpdateQuotes)
# =IMPORTDATA("https://home.ayurveda.help/programs/parameters.php?varAction=margins&varRefresh=" & UpdatePricing)
# =IMPORTDATA("https://home.ayurveda.help/programs/parameters.php?varAction=benchmarks&varRefresh=" & UpdatePricing)
# =IMPORTDATA("https://home.ayurveda.help/programs/parameters.php?varAction=interests&varRefresh=" & UpdatePricing)

#--------------------------------------------------------------------------------------------------
# Dashboards & Tickers
#--------------------------------------------------------------------------------------------------

$url_fiat   = 'https://www.widgets.investing.com/live-currency-cross-rates';
$url_crypto = 'https://www.widgets.investing.com/crypto-currency-rates';

$query =
[
  'theme' => 'darkTheme'
, 'cols'  => 'last,prev,change'
, 'pairs' => ''
];

#--------------------------------------------------------------------------------------------------
# Quotes
#--------------------------------------------------------------------------------------------------

$quotes_fiat =
[
  'EUR/USD' => ['1',       '€/$‎', 4 ]
#, 'GBP/USD' => ['2',       '£‎/$‎', 4 ]
];

$quotes_crypto =
[
  'XRP/EUR' => ['1010773', 'X/€', 4 ]
, 'BTC/EUR' => ['49800',   'B/€', 0 ]
, 'ETH/EUR' => ['1001803', 'E/€', 0 ]
];

$selector_last = 'div[class*=pid-number-last]';
$selector_pc   = 'div[class*=pid-number-pc]';

#--------------------------------------------------------------------------------------------------
# Tickers
#--------------------------------------------------------------------------------------------------

$tickers_fiat =
[
  'EUR/USD' => '1'
, 'GBP/USD' => '2'
];

$tickers_crypto =
[
  'BTC/EUR'  => '49800'
, 'ETH/EUR'  => '1001803'
, 'XRP/EUR'  => '1010773'
, 'USDT/USD' => '1031397'
];

#--------------------------------------------------------------------------------------------------
# Margins
#--------------------------------------------------------------------------------------------------

$url_margins = 'https://www.interactivebrokers.ie/en/index.php?f=39020&hm=eu&ex=gl&rgt=1&rsk=0&pm=0&rst=010101010101010808';

$margins =
[
  'USD'
, 'EUR'
, 'GBP'
];

$selector_margins = 'td.text-price';

#--------------------------------------------------------------------------------------------------
# Benchmarks
#--------------------------------------------------------------------------------------------------

$url_benchmarks = 'https://www.interactivebrokers.ie/en/index.php?f=46789&p=i';

$benchmarks =
[
  'USD'
, 'EUR'
, 'GBP'
];

#--------------------------------------------------------------------------------------------------
# Interests
#--------------------------------------------------------------------------------------------------

$url_interests = 'https://www.interactivebrokers.ie/en/index.php?f=46782&p=m';

$interests =
[
  'USD'
, 'EUR'
, 'GBP'
# , 'ZAR'
];

$cfds =
[
  'EUR.USD'
, 'GBP.USD'
#, 'USD.ZAR'
];

#--------------------------------------------------------------------------------------------------
?>
