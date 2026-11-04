<?php
#---------------------------------------------------------------------------------------------------

#print_r(date_parse("Sep 2021"));

#exit;

#---------------------------------------------------------------------------------------------------

include("./global-objects.php");

#---------------------------------------------------------------------------------------------------
# http://localhost/hypers/indicators-outlook.php?varId=batch
#---------------------------------------------------------------------------------------------------

#$var_mode = $_GET['varMode'];
$var_mode = 'batch';
#$var_mode = 'html';

#---------------------------------------------------------------------------------------------------

$page_title     = "Indicators Outlook";
$data_area       = "fn";
$dir_name       = "indicators_outlook";
$dir_config     = "../{$dir_zones}/{$data_area}/{$dir_name}";

#---------------------------------------------------------------------------------------------------

$sleep_time  = 2;

$url_prefix = 'https://tradingeconomics.com';
$url_suffix = 'indicators';

$array_countries =
[
    [  0, 'Bulgaria'       , 'bulgaria'       ]
  , [  1, 'Canada'         , 'canada'         ]
  , [  2, 'China'          , 'china'          ]
  , [  3, 'EU'             , 'euro-area'      ]
  , [  4, 'France'         , 'france'         ]
  , [  5, 'Germany'        , 'germany'        ]
  , [  6, 'Greece'         , 'greece'         ]
  , [  7, 'Hungary'        , 'hungary'        ]
  , [  8, 'Italy'          , 'italy'          ]
  , [  9, 'Japan'          , 'japan'          ]
  , [ 10, 'Poland'         , 'poland'         ]
  , [ 11, 'Spain'          , 'spain'          ]
  , [ 12, 'Suisse'         , 'switzerland'    ]
  , [ 13, 'UK'             , 'united-kingdom' ]
  , [ 14, 'US'             , 'united-states'  ]
  , [ 15, 'Turkey'         , 'turkey'         ]
];

$array_indicators =
[
    [  0, 'GDP Growth YoY %'          , 'gdp-growth-annual'       ]
  , [  1, 'GDP Growth QoQ %'          , 'gdp-growth'              ]
  , [  2, 'Interest %'                , 'interest-rate'           ]
  , [  3, 'Inflation %'               , 'inflation-cpi'           ]
  , [  4, 'Inflation MoM %'           , 'inflation-rate-mom'      ]
  , [  5, 'Unemployment %'            , 'unemployment-rate'       ]
  , [  6, 'Governemt Budget to GDP %' , 'government-budget'       ]
  , [  7, 'Governemt Debt to GDP %'   , 'government-debt-to-gdp'  ]
  , [  8, 'Current Account to GDP %'  , 'current-account-to-gdp'  ]
  , [  9, 'Credit Rating'             , 'rating'                  ]
  , [ 10, 'Corruption Index'          , 'corruption-index'        ]
  , [ 11, 'Corruption Rank'           , 'corruption-rank'         ]
  , [ 12, 'Population'                , 'population'              ]
];

#---------------------------------------------------------------------------------------------------

$template_html    = "../{$dir_templates}/indicators-outlook.html";

#---------------------------------------------------------------------------------------------------

function get_data()
{
  global $dir_config, $sleep_time, $url_prefix, $url_suffix, $array_countries;

  date_default_timezone_set('UTC');
  $date_today =  date('Ymd');

  foreach($array_countries as $array_country)
  {
    $country_number = $array_country[0];
    $country_name   = $array_country[1];
    $country_id     = $array_country[2];

#    echo "{$country_name}\n";

    $url_link = "{$url_prefix}/{$country_id }/${url_suffix}";
    $file_name = "{$dir_config}/{$country_id}.html";

    if (! file_exists($file_name) || ($date_today > date("Ymd", filemtime($file_name))))
    {
      $url_content = get_url($url_link);
      file_put_contents($file_name, $url_content);
      sleep($sleep_time);
    }
  }
}

#---------------------------------------------------------------------------------------------------

function extract_data()
{
  global $dir_config, $array_countries, $array_indicators;

#  for($counter = 0; $counter < count($array_countries); $counter++)
  foreach($array_countries as $array_country)
  {
    $country_number = $array_country[0];
    $country_name   = $array_country[1];
    $country_id     = $array_country[2];

#    echo "{$country_name}\n";

    $file_name = "{$dir_config}/{$country_id}.html";
    $url_content = file_get_contents($file_name);

    foreach($array_indicators as $array_indicator)
    {
      $indicator_number = $array_indicator[0];
      $indicator_name   = $array_indicator[1];
      $indicator_id     = $array_indicator[2];

      $regex_string  = "";
      $regex_string .= "<a href='\/{$country_id}\/{$indicator_id}'>(.*?)<\/a><\/td>(\s*?)";
      $regex_string .= "<td>(.*?)<\/td>(\s*?)";
      $regex_string .= "<td>(.*?)<\/td>(\s*?)";
      $regex_string .= "<td>(.*?)<\/td>(\s*?)";
      $regex_string .= "<td class=\"hidden-xs\">(.*?)<\/td>";

#      $regex_string .= "<td class=\"table-value\"><span>(.*?)<\/span>(\s*?)";


#    echo $regex_string . "\n";

      $match_result = preg_match("/{$regex_string}/s", $url_content, $match_array);
      $matched_item_name = trim($match_array[1]);
      $matched_item_last = trim($match_array[3]);
      $matched_item_prev = trim($match_array[5]);
      $matched_item_unit = trim($match_array[7]);
      $matched_item_date = trim($match_array[9]);

      $matched_item_last = preg_replace("/<span(.*?)>(.*?)<\/span>/sU", "$2", $matched_item_last);
      $matched_item_prev = preg_replace("/<span(.*?)>(.*?)<\/span>/sU", "$2", $matched_item_prev);

#      $matched_item_chng = sprintf('%.2f%%', ((float) $matched_item_last / (float) $matched_item_prev - 1) * 100.00);
#      $matched_item_chng = ($matched_item_chng == 'NaN%') ? '0.00%' : $matched_item_chng;

      $matched_item_last = number_format((float) $matched_item_last, 2, '.', ',');
#      $matched_item_last = preg_replace("/\.00/sU", "", $matched_item_last);

      $matched_item_prev = number_format((float) $matched_item_prev, 2, '.', ',');
#      $matched_item_prev = preg_replace("/\.00/sU", "", $matched_item_prev);

      $matched_item_date = preg_replace("/\//sU", " 20", $matched_item_date);
      $date_parsed = date_parse($matched_item_date);
      $matched_item_date = sprintf('%02d', $date_parsed['month']) . '/' . substr(sprintf('%02d', $date_parsed['year']), 2, 2);

      array_push($array_countries[$country_number], array($matched_item_last, $matched_item_prev, $matched_item_date));
    }
  }
#  print_r($array_countries);
}

#---------------------------------------------------------------------------------------------------

function output_data()
{
  global $dir_zones, $data_area;
  global $page_title, $array_countries, $array_indicators, $template_html, $url_prefix, $url_suffix;

#  print_r($array_countries);

#  date_default_timezone_set('UTC'); # . ' UTC';
  date_default_timezone_set('Europe/Sofia');
  $time_current = date('l, F d, Y') . '&ensp;' . date('H:i');

  $page_content  = "<h1>{$page_title}</h1>\n";
  $page_content .= "<h2>{$time_current}</h2>\n";

  foreach($array_indicators as $array_indicator)
  {
    $indicator_number = $array_indicator[0];
    $indicator_name   = $array_indicator[1];
    $indicator_id     = $array_indicator[2];

#    $page_content .= "\n<h4><a href='javascript:fncShowHideWithMemory(&quot;idDivIndex{$indicator_number}&quot;)'>{$indicator_name}</a></h4>\n";
    $page_content .= "\n<div class='clIndex'><a href='javascript:fncShowHideWithMemory(&quot;idDivIndex{$indicator_number}&quot;)'>{$indicator_name}</a></div>\n";
    $page_content .= "<div id='idDivIndex{$indicator_number}' class='clOverflow'>\n";
    $page_content .= "<table>\n";

    foreach($array_countries as $array_country)
    {
      $country_number = $array_country[0];
      $country_name   = $array_country[1];
      $country_id     = $array_country[2];

      $page_content .= "<tr>";
      $page_content .= "<td class='clIndex'><a target='_blank' href='{$url_prefix}/{$country_id}/{$indicator_id}'>{$country_name}</a></td>";
      $page_content .= "<td class='right'>{$array_country[$indicator_number + 3][0]}</td>";
      $page_content .= "<td class='right'>{$array_country[$indicator_number + 3][1]}</td>";
      $page_content .= "<td class='right'>{$array_country[$indicator_number + 3][2]}</td>";
      $page_content .= "</tr>\n";
    }

    $page_content .= "</table>\n";
    $page_content .= "</div>\n";
  }

  $page_content = preg_replace("/<p><\/p>/sU", "", $page_content);

#  echo $page_content;

  $page_html = get_file_template($template_html);

  eval("\$page_html = \"{$page_html}\";");
  echo $page_html;
}

#---------------------------------------------------------------------------------------------------

get_data();
extract_data();
output_data();

#---------------------------------------------------------------------------------------------------
?>
