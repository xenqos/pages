<?php
#------------------------------------------------------------------------------------------------------------

include("./global-objects.php");
include("./simple-html-dom.php");

#---------------------------------------------------------------------------------------------------

$func_id       = $_GET['varFuncId']      ?? "";
$in_nm_country = $_GET['varInNmCountry'] ?? "";
$in_nm_name    = $_GET['varInNmName']    ?? "";
$in_id_country = $_GET['varInIdCountry'] ?? "";
$in_id_name    = $_GET['varInIdName']    ?? "";

#------------------------------------------------------------------------------------------------------------

$app_title          = "Economics Outlook";
$data_area          = "fn";
$dir_name           = "economics-outlook";

#------------------------------------------------------------------------------------------------------------

$debug_file = "/home/" . get_current_user() . "/mnt/data/Temp/debug_economics_outlook.txt";

#------------------------------------------------------------------------------------------------------------

$url_prefix = 'https://tradingeconomics.com';

# https://tradingeconomics.com/blog

$array_indicators =
[
    [ 'div' , 'United States'  , 'united-states'  , 'Currency'          , 'currency'                ]
  , [ '   ' , 'United States'  , 'united-states'  , 'Stock'             , 'stock-market'            ]
  , [ '   ' , 'United States'  , 'united-states'  , 'Bond 10Y'          , 'government-bond-yield'   ]
  , [ '   ' , 'United States'  , 'united-states'  , 'Inflation CPI'     , 'inflation-cpi'           ]
  , [ '   ' , 'United States'  , 'united-states'  , 'Money Supply M0'   , 'money-supply-m0'         ]
  , [ '   ' , 'United States'  , 'united-states'  , 'Money Supply M2'   , 'money-supply-m2'         ]
  , [ '   ' , 'United States'  , 'united-states'  , 'Interest Rate'     , 'interest-rate'           ]
  , [ '   ' , 'United States'  , 'united-states'  , 'GDP'               , 'gdp'                     ]
  , [ '   ' , 'United States'  , 'united-states'  , 'Unemployment Rate' , 'unemployment-rate'       ]
  , [ '   ' , 'United States'  , 'united-states'  , 'Non Farm Payrolls' , 'non-farm-payrolls'       ]
  , [ '   ' , 'United States'  , 'united-states'  , 'Balance of Trade'  , 'balance-of-trade'        ]
  , [ 'div' , 'Euro Area'      , 'euro-area'      , 'Currency'          , 'currency'                ]
  , [ '   ' , 'Euro Area'      , 'euro-area'      , 'Stock'             , 'stock-market'            ]
  , [ '   ' , 'Euro Area'      , 'euro-area'      , 'Inflation CPI'     , 'inflation-cpi'           ]
  , [ '   ' , 'Euro Area'      , 'euro-area'      , 'Money Supply M2'   , 'money-supply-m2'         ]
  , [ '   ' , 'Euro Area'      , 'euro-area'      , 'Interest Rate'     , 'interest-rate'           ]
  , [ '   ' , 'Euro Area'      , 'euro-area'      , 'GDP'               , 'gdp'                     ]
  , [ '   ' , 'Euro Area'      , 'euro-area'      , 'Unemployment Rate' , 'unemployment-rate'       ]
  , [ '   ' , 'Euro Area'      , 'euro-area'      , 'Balance of Trade'  , 'balance-of-trade'        ]
  , [ 'div' , 'United Kingdom' , 'united-kingdom' , 'Currency'          , 'currency'                ]
  , [ '   ' , 'United Kingdom' , 'united-kingdom' , 'Stock'             , 'stock-market'            ]
  , [ '   ' , 'United Kingdom' , 'united-kingdom' , 'Bond 10Y'          , 'government-bond-yield'   ]
  , [ '   ' , 'United Kingdom' , 'united-kingdom' , 'Inflation CPI'     , 'inflation-cpi'           ]
  , [ '   ' , 'United Kingdom' , 'united-kingdom' , 'Money Supply M0'   , 'money-supply-m0'         ]
  , [ '   ' , 'United Kingdom' , 'united-kingdom' , 'Money Supply M2'   , 'money-supply-m2'         ]
  , [ '   ' , 'United Kingdom' , 'united-kingdom' , 'Interest Rate'     , 'interest-rate'           ]
  , [ '   ' , 'United Kingdom' , 'united-kingdom' , 'GDP'               , 'gdp'                     ]
  , [ '   ' , 'United Kingdom' , 'united-kingdom' , 'Unemployment Rate' , 'unemployment-rate'       ]
  , [ 'div' , 'Germany'        , 'germany'        , 'Currency'          , 'currency'                ]
  , [ '   ' , 'Germany'        , 'germany'        , 'Stock'             , 'stock-market'            ]
  , [ '   ' , 'Germany'        , 'germany'        , 'Bond 10Y'          , 'government-bond-yield'   ]
  , [ '   ' , 'Germany'        , 'germany'        , 'Inflation CPI'     , 'inflation-cpi'           ]
  , [ '   ' , 'Germany'        , 'germany'        , 'Money Supply M2'   , 'money-supply-m2'         ]
  , [ '   ' , 'Germany'        , 'germany'        , 'Interest Rate'     , 'interest-rate'           ]
  , [ '   ' , 'Germany'        , 'germany'        , 'GDP'               , 'gdp'                     ]
  , [ '   ' , 'Germany'        , 'germany'        , 'Unemployment Rate' , 'unemployment-rate'       ]
  , [ '   ' , 'Germany'        , 'germany'        , 'Balance of Trade'  , 'balance-of-trade'        ]
  , [ 'div' , 'Bulgaria'       , 'bulgaria'       , 'Interest Rate'     , 'interest-rate'           ]
  , [ '   ' , 'Bulgaria'       , 'bulgaria'       , 'Inflation CPI'     , 'inflation-cpi'           ]
  , [ '   ' , 'Bulgaria'       , 'bulgaria'       , 'Money Supply M0'   , 'money-supply-m0'         ]
  , [ '   ' , 'Bulgaria'       , 'bulgaria'       , 'Money Supply M2'   , 'money-supply-m2'         ]
  , [ '   ' , 'Bulgaria'       , 'bulgaria'       , 'GDP'               , 'gdp'                     ]
  , [ '   ' , 'Bulgaria'       , 'bulgaria'       , 'Unemployment Rate' , 'unemployment-rate'       ]
  , [ '   ' , 'Bulgaria'       , 'bulgaria'       , 'Balance of Trade'  , 'balance-of-trade'        ]
  , [ 'div' , 'Commodities'    , 'commodity'      , 'Crude Oil'         , 'crude-oil'               ]
  , [ '   ' , 'Commodities'    , 'commodity'      , 'Brent Oil'         , 'brent-crude-oil'         ]
  , [ '   ' , 'Commodities'    , 'commodity'      , 'Natural Gas'       , 'natural-gas'             ]
  , [ '   ' , 'Commodities'    , 'commodity'      , 'Gold'              , 'gold'                    ]
#  , [ 'div' , 'Switzerland'    , 'switzerland'    , 'Currency'          , 'currency'                ]
#  , [ '   ' , 'Switzerland'    , 'switzerland'    , 'Stock'             , 'stock-market'            ]
#  , [ '   ' , 'Switzerland'    , 'switzerland'    , 'Bond 10Y'          , 'government-bond-yield'   ]
#  , [ '   ' , 'Switzerland'    , 'switzerland'    , 'Inflation CPI'     , 'inflation-cpi'           ]
#  , [ '   ' , 'Switzerland'    , 'switzerland'    , 'Money Supply M0'   , 'money-supply-m0'         ]
#  , [ '   ' , 'Switzerland'    , 'switzerland'    , 'Money Supply M2'   , 'money-supply-m2'         ]
#  , [ '   ' , 'Switzerland'    , 'switzerland'    , 'Interest Rate'     , 'interest-rate'           ]
#  , [ '   ' , 'Switzerland'    , 'switzerland'    , 'GDP'               , 'gdp'                     ]
#  , [ '   ' , 'Switzerland'    , 'switzerland'    , 'Unemployment Rate' , 'unemployment-rate'       ]
#  , [ '   ' , 'Switzerland'    , 'switzerland'    , 'Balance of Trade'  , 'balance-of-trade'        ]
];

#------------------------------------------------------------------------------------------------------------

# $template_html    = "../{$dir_templates}/economics-outlook.html";

#---------------------------------------------------------------------------------------------------

function get_index()
{
  global $dir_templates, $dir_zones, $app_title, $data_area, $array_indicators;

  $file_template = "../{$dir_templates}/economics-index.html";

  $page_title = $app_title;
  $page_content  = "<h1>{$page_title}</h1>\n";
  $page_content .= "<p class='clMediaName'><a href='./economics-outlook.php?varFuncId=latest'>Latest</a></p>\n";
  $page_content .= "<p class='clMediaName'><a href='./economics-outlook.php?varFuncId=blog'>Week Ahead</a></p>\n";

  $config_files_counter = 1;

  foreach ($array_indicators as &$array_indicator)
  {
    $in_div            = $array_indicator[0];

    $in_nm_country     = $array_indicator[1];
    $in_nm_name        = $array_indicator[3];
    $in_id_country     = $array_indicator[2];
    $in_id_name        = $array_indicator[4];

    $in_nm_enc_country = rawurlencode($in_nm_country);
    $in_nm_enc_name    = rawurlencode($in_nm_name);

    if ($in_div == "div")
    {
      if ($config_files_counter > 1)
      {
        $page_content .= "</div>\n";
      }

      $div_id_number = sprintf('%02d', $config_files_counter);
      $page_content .= "<p class='clMediaName'><a href='javascript:fncShowHideWithMemory(&quot;idDiv{$div_id_number}&quot;)'>{$in_nm_country}</a></p>\n";
      $page_content .= "<div id='idDiv{$div_id_number}'>\n";
      $config_files_counter++;
    }

    $page_content .= "<p class='clMediaName'><a href='./economics-outlook.php?varFuncId=indicator&varInNmCountry={$in_nm_enc_country}&varInNmName={$in_nm_enc_name}&varInIdCountry={$in_id_country}&varInIdName={$in_id_name}'>{$in_nm_name}</a></p>\n";
  }

  $page_content .= "</div>\n";

  $page_html = get_file_template($file_template);

  eval("\$page_html = \"{$page_html}\";");
  echo $page_html;
}

#------------------------------------------------------------------------------------------------------------

function get_latest()
{
  global $dir_templates, $dir_zones, $dir_name, $app_title, $data_area, $url_prefix;
  global $debug_file;

  $file_template = "../{$dir_templates}/economics-latest.html";

  $page_title = $app_title;

  $page_content  = "";
  $page_content .= "<h1>Latest</h1>\n";

  $url_link = "{$url_prefix}";
  $url_content = get_url($url_link);
  $url_content = preg_replace("/<div id=\"ctl00_ContentPlaceHolder1_ctl00_headlineWithImage\" class=\"thumbnail\">/s", "<div class=\"home-tile-inside\">", $url_content);
  $url_content = preg_replace("/<div style=\"padding(.*?)>(.*?)<\/div>/s", "$2", $url_content);
  $url_content = preg_replace("/<div class=\"col-md-7\">(.*?)<\/div>/s", "$1", $url_content);
  $url_content = preg_replace("/<div class=\"col-md-5\"(.*?)>(.*?)<\/div>/s", "$2", $url_content);
  $url_content = preg_replace("/<div class=\"row\">(.*?)<\/div>/s", "$1", $url_content);
  $url_content = preg_replace("/<a style=\"line-height(.*?)>(.*?)<\/a>(\s*?)<br \/>(\s*?)<br \/>/s", "<b>$2</b>", $url_content);

#  file_put_contents($debug_file, $url_content);

  $html_objects = str_get_html($url_content);
  $stream_articles = $html_objects->find("div[class=home-tile-inside]");

  foreach ($stream_articles as &$stream_article)
  {
    $stream_article = preg_replace("/<br \/>/s", "<br>", $stream_article);
    $stream_article = preg_replace("/<br>(\s*?)<br>/s", "<br>", $stream_article);
    $stream_article = preg_replace("/<br>(\s*?)<br>/s", "<br>\n<br>\n", $stream_article);
    $stream_article = preg_replace("/<a(.*?)>(.*?)<\/a>/s", "$2", $stream_article);
    $stream_article = preg_replace("/<span(.*?)>(.*?)<\/span>/s", "$2", $stream_article);
    $stream_article = preg_replace("/<div style=\"color: #808080; text-align: left; width: 100%; font-size: 0.8em\">(.*?)<\/div>/s", "&ensp;<strong>$1</strong><br>", $stream_article);
    $stream_article = preg_replace("/<div(\s*?)style(.*?)>(.*?)<\/div>/s", "$3", $stream_article);
    $stream_article = preg_replace("/<div(.*?)style(.*?)>(.*?)<\/div>/s", "$3", $stream_article);
    $stream_article = preg_replace("/<div(.*?)>/s", "", $stream_article);
    $stream_article = preg_replace("/<\/div>/s", "", $stream_article);
    $stream_article = preg_replace("/<b>(.*?)<\/b>/s", "\n<h3>$1</h3>", $stream_article);

    $page_content .= $stream_article;
  }

  $html_objects->clear();
  unset($html_objects);

  $page_html = get_file_template($file_template);

  eval("\$page_html = \"{$page_html}\";");
  echo $page_html;
}

#------------------------------------------------------------------------------------------------------------

function get_blog()
{
  global $dir_templates, $dir_zones, $dir_name, $app_title, $data_area, $url_prefix;

  $file_template = "../{$dir_templates}/economics-blog.html";

  $page_title = $app_title;

  $page_content  = "";
  $page_content .= "<h1>Week Ahead</h1>\n";

  $url_link = "{$url_prefix}/blog";
  $url_content = get_url($url_link);

  $html_objects = str_get_html($url_content);
  $blogpost_articles  = $html_objects->find("div[class=blog-post]");

  $counter = 1;

  foreach ($blogpost_articles as &$blogpost_article)
  {
    $div_id_number = sprintf('%02d', $counter);

    $blogpost_article = preg_replace("/<br \/>/s", "<br>", $blogpost_article);
    $blogpost_article = preg_replace("/<div class=\"blog-post\">(\s*?)<small>(.*?)<\/small>(\s*?)<br>/s", "\n<h3>$2</h3>\n", $blogpost_article);
    $blogpost_article = preg_replace("/<a href='\/calendar(.*?)a>/s", "", $blogpost_article);
    $blogpost_article = preg_replace("/<a href='\/articles(.*?)a>/s", "", $blogpost_article);
    $blogpost_article = preg_replace("/<small>(.*?)<\/small>(\s*?)<br>/s", "", $blogpost_article);
    $blogpost_article = preg_replace("/<\/h3>(\s*?)<br>(\s*?)<br>/s", "</h3>", $blogpost_article);
    $blogpost_article = preg_replace("/<div(.*?)>/s", "", $blogpost_article);
    $blogpost_article = preg_replace("/<\/div>/s", "<br>", $blogpost_article);
    $blogpost_article = preg_replace("/<br>(\s*?)<br>/s", "<br>", $blogpost_article);
    $blogpost_article = preg_replace("/<br>(\s*?)<br>/s", "<br>\n<br>\n", $blogpost_article);
    $blogpost_article = preg_replace("/<a(.*?)>(.*?)<\/a>/s", "$2", $blogpost_article);
    $blogpost_article = preg_replace("/<h3>(Monday|Tuesday|Wednesday|Thursday|Friday|Saturday|Sunday) /s", "<h3>$1, ", $blogpost_article);
    $blogpost_article = preg_replace("/ (\d{2}) (\d{4})<\/h3>/s", " $1, $2</h3>", $blogpost_article);
    $blogpost_article = preg_replace("/<h3>(.*?)<\/h3>/s", "</div>\n<p class='clIndex'><a href='javascript:fncShowHideWithMemory(&quot;idDivArticle{$div_id_number}&quot;)'><h3>$1</h3></a></p>\n<div id='idDivArticle{$div_id_number}'>", $blogpost_article);

    $page_content .= $blogpost_article;
    $counter++;
  }

  $page_content = preg_replace("/<\/h1>(\s*?)<\/div>/s", "</h1>\n", $page_content);
  $page_content = preg_replace("/<img(.*?)src='(.*?)'(.*?)>/s", "<a target='_blank' href='$2'><img class='clImageThumb' src='$2'></a><br>", $page_content);

  $html_objects->clear();
  unset($html_objects);

  $page_html = get_file_template($file_template);

  eval("\$page_html = \"{$page_html}\";");
  echo $page_html;
}

#------------------------------------------------------------------------------------------------------------

function get_indicator($in_nm_country, $in_nm_name, $in_id_country, $in_id_name)
{
  global  $dir_templates, $dir_zones, $dir_name, $app_title, $data_area, $url_prefix;

  $file_template = "../{$dir_templates}/economics-page.html";

  $in_nm_country = rawurldecode($in_nm_country);
  $in_nm_name    = rawurldecode($in_nm_name);

  $page_title = $app_title;

  $url_link = "{$url_prefix}/{$in_id_country}/{$in_id_name}";

  $url_content = get_url($url_link);

  $url_content = preg_replace("/TECategory(;|\)|\.)/s", "", $url_content);
  $url_content = preg_replace("/TECategory \!/s", "", $url_content);
  $url_content = preg_replace("/TECategory = ''/s", "", $url_content);
  $url_content = preg_replace("/TELastUpdate = ''/s", "", $url_content);
  $url_content = preg_replace("/TEChartUrl(2|\.|\)|;)/s", "", $url_content);
  $url_content = preg_replace("/TEChartUrl = '\//s", "", $url_content);
  $url_content = preg_replace("/TEChartUrl = (r|T)/s", "", $url_content);

  $matches_array = array();
  $return_value = preg_match("/TECategory = '(.*?)'/", $url_content, $matches_array);
  $indicator_nm_name = $matches_array[1];
  unset($matches_array);

  $matches_array = array();
  $return_value = preg_match("/TELastUpdate = '(.*?)'/", $url_content, $matches_array);
  $indicator_update = $matches_array[1];
  unset($matches_array);

  $matches_array = array();
  $return_value = preg_match("/TEChartUrl = '(.*?)'/", $url_content, $matches_array);
  $indicator_chart = $matches_array[1];
  unset($matches_array);

  $url_content = preg_replace("/<script(.*?)\/script>/s", "", $url_content);
  $url_content = preg_replace("/<style(.*?)\/style>/s", "", $url_content);
  $url_content = preg_replace("/<ins(.*?)\/ins>/s", "", $url_content);
  $url_content = preg_replace("/ class=\"(.*?)\"/s", "", $url_content);
  $url_content = preg_replace("/ style=\"(.*?)\"/s", "", $url_content);

#  file_put_contents('/home/lux/mnt/data/Temp/get_url.txt', $url_content);

  $indicator_date  = substr($indicator_update,  4, 2) . "/";
  $indicator_date .= substr($indicator_update,  6, 2) . "/";
  $indicator_date .= substr($indicator_update,  0, 4) . " ";
  $indicator_date .= substr($indicator_update,  8, 2) . ":";
  $indicator_date .= substr($indicator_update, 10, 2);

  $html_objects = str_get_html($url_content);

  $indicator_historical = $html_objects->find("div[id=historical-desc] h2", 0)->innertext;
  $indicator_forecast   = $html_objects->find("div[id=forecast-desc] h3", 0)->innertext;
  $indicator_stats      = $html_objects->find("div[id=stats] h2", 0)->innertext;

  $div_id_number = sprintf('%02d', $div_indicator_counter);

  $page_content  = "";
  $page_content .= "<h1>{$in_nm_country} - {$in_nm_name}</h1>\n";
  $page_content .= "<h2>{$indicator_date}</h2>\n";
  $page_content .= "<p>{$indicator_historical}</p>\n";
  $page_content .= "<a target='_blank' href='{$indicator_chart}'><img class='clImageThumb' src='{$indicator_chart}'></a><br>\n";
  $page_content .= "<p>{$indicator_forecast}</p>\n";
  $page_content .= "<p>{$indicator_stats}</p>\n";

  $page_content = preg_replace("/, according to Trading Economics(.*?)\./s", "", $page_content);
  $page_content = preg_replace("/This page provides the latest reported value for(.*?)\./s", "", $page_content);

  $html_objects->clear();
  unset($html_objects);

  $page_html = get_file_template($file_template);

  eval("\$page_html = \"{$page_html}\";");
  echo $page_html;
}

#---------------------------------------------------------------------------------------------------

if      ($func_id == "index")     { get_index();    }
elseif  ($func_id == "latest")    { get_latest();     }
elseif  ($func_id == "blog")      { get_blog(); }
elseif  ($func_id == "indicator") { get_indicator($in_nm_country, $in_nm_name, $in_id_country, $in_id_name); }

#------------------------------------------------------------------------------------------------------------
?>
