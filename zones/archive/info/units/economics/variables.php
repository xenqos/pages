<?php
#--------------------------------------------------------------------------------------------------

$title = 'Economics';
$zone = 'fn';

#--------------------------------------------------------------------------------------------------

$action     = $_GET['varAction']    ?? '';
$nm_country = $_GET['varNmCountry'] ?? '';
$nm_name    = $_GET['varNmName']    ?? '';
$id_country = $_GET['varIdCountry'] ?? '';
$id_name    = $_GET['varIdName']    ?? '';

#--------------------------------------------------------------------------------------------------

$url      = 'https://tradingeconomics.com';
$url_blog = 'https://tradingeconomics.com/blog';

#--------------------------------------------------------------------------------------------------

$indicators =
[
  [ 'div' , 'United States'  , 'united-states'  , 'Currency'          , 'currency'              ]
, [ '   ' , 'United States'  , 'united-states'  , 'Stock'             , 'stock-market'          ]
, [ '   ' , 'United States'  , 'united-states'  , 'Bond 10Y'          , 'government-bond-yield' ]
, [ '   ' , 'United States'  , 'united-states'  , 'Inflation CPI'     , 'inflation-cpi'         ]
, [ '   ' , 'United States'  , 'united-states'  , 'Money Supply M0'   , 'money-supply-m0'       ]
, [ '   ' , 'United States'  , 'united-states'  , 'Money Supply M2'   , 'money-supply-m2'       ]
, [ '   ' , 'United States'  , 'united-states'  , 'Interest Rate'     , 'interest-rate'         ]
, [ '   ' , 'United States'  , 'united-states'  , 'GDP'               , 'gdp'                   ]
, [ '   ' , 'United States'  , 'united-states'  , 'Unemployment Rate' , 'unemployment-rate'     ]
, [ '   ' , 'United States'  , 'united-states'  , 'Non Farm Payrolls' , 'non-farm-payrolls'     ]
, [ '   ' , 'United States'  , 'united-states'  , 'Balance of Trade'  , 'balance-of-trade'      ]
, [ 'div' , 'Euro Area'      , 'euro-area'      , 'Currency'          , 'currency'              ]
, [ '   ' , 'Euro Area'      , 'euro-area'      , 'Stock'             , 'stock-market'          ]
, [ '   ' , 'Euro Area'      , 'euro-area'      , 'Inflation CPI'     , 'inflation-cpi'         ]
, [ '   ' , 'Euro Area'      , 'euro-area'      , 'Money Supply M2'   , 'money-supply-m2'       ]
, [ '   ' , 'Euro Area'      , 'euro-area'      , 'Interest Rate'     , 'interest-rate'         ]
, [ '   ' , 'Euro Area'      , 'euro-area'      , 'GDP'               , 'gdp'                   ]
, [ '   ' , 'Euro Area'      , 'euro-area'      , 'Unemployment Rate' , 'unemployment-rate'     ]
, [ '   ' , 'Euro Area'      , 'euro-area'      , 'Balance of Trade'  , 'balance-of-trade'      ]
, [ 'div' , 'United Kingdom' , 'united-kingdom' , 'Currency'          , 'currency'              ]
, [ '   ' , 'United Kingdom' , 'united-kingdom' , 'Stock'             , 'stock-market'          ]
, [ '   ' , 'United Kingdom' , 'united-kingdom' , 'Bond 10Y'          , 'government-bond-yield' ]
, [ '   ' , 'United Kingdom' , 'united-kingdom' , 'Inflation CPI'     , 'inflation-cpi'         ]
, [ '   ' , 'United Kingdom' , 'united-kingdom' , 'Money Supply M0'   , 'money-supply-m0'       ]
, [ '   ' , 'United Kingdom' , 'united-kingdom' , 'Money Supply M2'   , 'money-supply-m2'       ]
, [ '   ' , 'United Kingdom' , 'united-kingdom' , 'Interest Rate'     , 'interest-rate'         ]
, [ '   ' , 'United Kingdom' , 'united-kingdom' , 'GDP'               , 'gdp'                   ]
, [ '   ' , 'United Kingdom' , 'united-kingdom' , 'Unemployment Rate' , 'unemployment-rate'     ]
, [ 'div' , 'Germany'        , 'germany'        , 'Currency'          , 'currency'              ]
, [ '   ' , 'Germany'        , 'germany'        , 'Stock'             , 'stock-market'          ]
, [ '   ' , 'Germany'        , 'germany'        , 'Bond 10Y'          , 'government-bond-yield' ]
, [ '   ' , 'Germany'        , 'germany'        , 'Inflation CPI'     , 'inflation-cpi'         ]
, [ '   ' , 'Germany'        , 'germany'        , 'Money Supply M2'   , 'money-supply-m2'       ]
, [ '   ' , 'Germany'        , 'germany'        , 'Interest Rate'     , 'interest-rate'         ]
, [ '   ' , 'Germany'        , 'germany'        , 'GDP'               , 'gdp'                   ]
, [ '   ' , 'Germany'        , 'germany'        , 'Unemployment Rate' , 'unemployment-rate'     ]
, [ '   ' , 'Germany'        , 'germany'        , 'Balance of Trade'  , 'balance-of-trade'      ]
, [ 'div' , 'Bulgaria'       , 'bulgaria'       , 'Interest Rate'     , 'interest-rate'         ]
, [ '   ' , 'Bulgaria'       , 'bulgaria'       , 'Inflation CPI'     , 'inflation-cpi'         ]
, [ '   ' , 'Bulgaria'       , 'bulgaria'       , 'Money Supply M0'   , 'money-supply-m0'       ]
, [ '   ' , 'Bulgaria'       , 'bulgaria'       , 'Money Supply M2'   , 'money-supply-m2'       ]
, [ '   ' , 'Bulgaria'       , 'bulgaria'       , 'GDP'               , 'gdp'                   ]
, [ '   ' , 'Bulgaria'       , 'bulgaria'       , 'Unemployment Rate' , 'unemployment-rate'     ]
, [ '   ' , 'Bulgaria'       , 'bulgaria'       , 'Balance of Trade'  , 'balance-of-trade'      ]
, [ 'div' , 'Commodities'    , 'commodity'      , 'Crude Oil'         , 'crude-oil'             ]
, [ '   ' , 'Commodities'    , 'commodity'      , 'Brent Oil'         , 'brent-crude-oil'       ]
, [ '   ' , 'Commodities'    , 'commodity'      , 'Natural Gas'       , 'natural-gas'           ]
, [ '   ' , 'Commodities'    , 'commodity'      , 'Gold'              , 'gold'                  ]
];

#--------------------------------------------------------------------------------------------------

$clean_01 =
[
  ["/<div id=\"ctl00_ContentPlaceHolder1_ctl00_headlineWithImage\" class=\"thumbnail\">", "<div class=\"home-tile-inside\">"]
, ["/<div style=\"padding(.*?)>(.*?)</div>", "$2"]
, ["/<div class=\"col-md-7\">(.*?)</div>", "$1"]
, ["/<div class=\"col-md-5\"(.*?)>(.*?)</div>", "$2"]
, ["/<div class=\"row\">(.*?)</div>", "$1"]
, ["/<a style=\"line-height(.*?)>(.*?)</a>(\s*?)<br \/>(\s*?)<br />", "<b>$2</b>"]
];

$clean_02 =
[
  ["<br />", "<br>"]
, ["<br>(\s*?)<br>", "<br>"]
, ["<br>(\s*?)<br>", "<br>\n<br>\n"]
, ["<a(.*?)>(.*?)</a>", "$2"]
, ["<span(.*?)>(.*?)</span>", "$2"]
, ["<div style=\"color: #808080; text-align: left; width: 100%; font-size: 0.8em\">(.*?)</div>", "&ensp;<strong>$1</strong><br>"]
, ["<div(\s*?)style(.*?)>(.*?)</div>", "$3"]
, ["<div(.*?)style(.*?)>(.*?)</div>", "$3"]
, ["<div(.*?)>", ""]
, ["</div>", ""]
, ["<b>(.*?)</b>", "\n<h3>$1</h3>"]
];

$clean_03 =
[
  ["<br />", "<br>"]
, ["<div class=\"blog-post\">(\s*?)<small>(.*?)</small>(\s*?)<br>", "\n<h3>$2</h3>\n"]
, ["<a href='\/calendar(.*?)a>", ""]
, ["<a href='\/articles(.*?)a>", ""]
, ["<small>(.*?)</small>(\s*?)<br>", ""]
, ["</h3>(\s*?)<br>(\s*?)<br>", "</h3>"]
, ["<div(.*?)>", ""]
, ["</div>", "<br>"]
, ["<br>(\s*?)<br>", "<br>"]
, ["<br>(\s*?)<br>", "<br>\n<br>\n"]
, ["<a(.*?)>(.*?)</a>", "$2"]
, ["<h3>(Monday|Tuesday|Wednesday|Thursday|Friday|Saturday|Sunday) ", "<h3>$1, "]
, [" (\d{2}) (\d{4})</h3>", " $1, $2</h3>"]
];

$clean_04 =
[
  ["</h1>(\s*?)</div>", "</h1>\n"]
, ["<img(.*?)src='(.*?)'(.*?)>", "<a target='_blank' href='$2'><img class='clImageThumb' src='$2'></a><br>"]
];

$clean_05 =
[
  ["TECategory(;|\)|\.)", ""]
, ["TECategory \!", ""]
, ["TECategory = ''", ""]
, ["TELastUpdate = ''", ""]
, ["TEChartUrl(2|\.|\)|;)", ""]
, ["TEChartUrl = '\/", ""]
, ["TEChartUrl = (r|T)", ""]
];

$clean_06 =
[
  ["<script(.*?)/script>", ""]
, ["<style(.*?)/style>", ""]
, ["<ins(.*?)/ins>", ""]
, [" class=\"(.*?)\"", ""]
, [" style=\"(.*?)\"", ""]
];

$clean_07 =
[
  [", according to Trading Economics(.*?)\.", ""]
, ["This page provides the latest reported value for(.*?)\.", ""]
];

#--------------------------------------------------------------------------------------------------
?>
