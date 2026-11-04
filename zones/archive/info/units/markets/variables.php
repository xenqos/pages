<?php
#--------------------------------------------------------------------------------------------------

$title = 'Markets';
$zone = 'fn';

#--------------------------------------------------------------------------------------------------

$url_centralbanks       = 'https://www.investing.com/central-banks/';
$url_tradingeconomics   = 'https://tradingeconomics.com/';

#--------------------------------------------------------------------------------------------------

$centralbanks =
[
  ['FED', 'FED']
, ['ECB', 'ECB']
 , ['BOE', 'BOE']
# , ['SNB', 'SNB']
];

$currencies =
[
  ['DXY:CUR'   , 'DXY']
, ['EURUSD:CUR', 'EUR/USD']
 , ['GBPUSD:CUR', 'GBP/USD']
# , ['USDCHF:CUR', 'USD/CHF']
];

$bonds =
[
  ['USGG10YR:IND', 'United States']
, ['GDBR10:IND'  , 'Germany']
, ['GUKG10:IND'  , 'United Kingdom']
# , ['GSWISS10:IND', 'Suisse']
];

$indices =
[
  ['INDU:IND', 'Dow Jones' ]
, ['SPX:IND' , 'S&P 500'   ]
, ['NDX:IND' , 'Nasdaq 100']
];

$commodities =
[
  ['CL1:COM'   , 'Crude Oil WTI']
, ['CO1:COM'   , 'Brent Oil'    ]
# , ['NG1:COM'   , 'Natural gas'  ]
# , ['XAUUSD:CUR', 'Gold'         ]
];

#--------------------------------------------------------------------------------------------------
?>
