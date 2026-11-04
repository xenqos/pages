<?php
#!/bin/php
#----------------------------------------------------------------------------------------------------

include("./global-objects.php");
include("./simple-html-dom.php");

#---------------------------------------------------------------------------------------------------
# https://simplehtmldom.sourceforge.io/docs/1.9/api/str_get_html/
#---------------------------------------------------------------------------------------------------

0 ? $debug_flag = true : $debug_flag = false;

#---------------------------------------------------------------------------------------------------

$debug_file = "/home/" . get_current_user() . "/mnt/data/Temp/debug-currencies-quotes.txt";

#---------------------------------------------------------------------------------------------------

$url_fiat = 'https://www.widgets.investing.com/live-currency-cross-rates?theme=darkTheme&cols=bid,ask,last&pairs=PAIRS';

$array_fiat  =
[
    ['EUR/USD',  '1',  0, '€/$‎', 0, 0.0, '%6.4f']
#  , ['GBP/USD',  '2',  1, '£‎/$', 0, 0.0, '%6.4f']
];

#---------------------------------------------------------------------------------------------------

$url_crypto = 'https://www.widgets.investing.com/crypto-currency-rates?theme=darkTheme&cols=last&pairs=PAIRS';

$array_crypto  =
[
    ['BTC/EUR' , '49800',    0, 'B/€' , 0, 0.0, '%6d'  ]
  , ['ETH/EUR' , '1001803',  1, 'E/€' , 0, 0.0, '%6d'  ]
  , ['XRP/EUR' , '1010773',  2, 'X/€' , 0, 0.0, '%6.4f']
];

# ₿ Ξ

#---------------------------------------------------------------------------------------------------

$currencies_string = '';
$time_diff = '';

#---------------------------------------------------------------------------------------------------

$app_title      = "Currencies Quotes";
$page_title     = "{$app_title}";

$dir_zones       = "zones";
$dir_area       = "fn";
$dir_name       = "currencies_quotes";

$file_fiat      = "../{$dir_zones}/{$dir_area}/{$dir_name}/quotes_fiat.conf";
$file_crypto    = "../{$dir_zones}/{$dir_area}/{$dir_name}/quotes_crypto.conf";

#---------------------------------------------------------------------------------------------------

$template_content = "../{$dir_templates}/currencies-quotes.html";
$template_html    = "../{$dir_templates}/global-template.html";

#------------------------------------------------------------------------------------------------------------

function get_quotes($array_currencies, $url_string, $file_data)
{
  global $debug_file, $debug_flag, $array_fiat, $array_crypto, $currencies_string, $time_current, $time_diff;

  $link_items ='';

  foreach($array_currencies as $currency_item)
  {
    $link_items .= "{$currency_item[1]},";
  }

  $url_string = str_replace("PAIRS", rtrim($link_items, ","), $url_string);
  $input_string = get_url($url_string);
  $html_array = str_get_html($input_string);

  if ($debug_flag)
  {
    file_put_contents($debug_file, $input_string, FILE_APPEND);
  }

  if (file_exists($file_data))
  {
    foreach(file($file_data) as $line)
    {
      $config = explode('|', $line);
      $array_currencies[$config[2]][4] = $config[3];
      $array_currencies[$config[2]][5] = $config[4];
    }
  }
  else
  {
    $time_previous=time();
    file_put_contents($file_data, '');

    foreach($array_currencies as $currency_item)
    {
      file_put_contents($file_data, "{$currency_item[0]}|$currency_item[1]|$currency_item[2]|{$time_previous}|0.0\n", FILE_APPEND);
    }
  }

  $time_diff = $time_current - (int)$array_currencies[$config[2]][4];
  $time_diff = date('H:i:s', (int)$time_diff);

  file_put_contents($file_data, '');

  foreach($array_currencies as $currency_item)
  {
    $html_found = $html_array->find("div[class*=pid-{$currency_item[1]}-last]", 0)->innertext;
    $currency_value = preg_replace("/,/is",  "", $html_found);
    $currency_value = trim($currency_value);
    $currency_value = (float)sprintf($currency_item[6], $currency_value);
    $currency_diff = (float)($currency_value - (float)$array_currencies[$currency_item[2]][5]);

    if ($currency_diff == 0.0)
    {
      $direction_color = 'clColorWhite';
      $direction_symbol_color = 'clColorBlack';
      $direction_symbol = '&blacktriangle;';
    }
    elseif ($currency_diff < 0.0)
    {
      $direction_color = 'clColorDown';
      $direction_symbol_color = 'clColorDown';
      $direction_symbol = '&blacktriangledown;';
    }
    elseif ($currency_diff > 0.0)
    {
      $direction_color = 'clColorUp';
      $direction_symbol_color = 'clColorUp';
      $direction_symbol = '&blacktriangle;';
    }

    if ($currency_diff < 0)
    {
      $currency_diff = $currency_diff * -1;
    }

    $currency_value = sprintf($currency_item[6], $currency_value);
    $currency_diff = sprintf($currency_item[6], $currency_diff);

    $currencies_string .= "<tr><td class='clSymbol'>{$currency_item[3]}</td><td class='clValue {$direction_color}'>{$currency_value}</td><td class='clValueDiff'><span class='{$direction_symbol_color}'>{$direction_symbol}</span> {$currency_diff}</td></tr>\n";

    file_put_contents($file_data, "{$currency_item[0]}|$currency_item[1]|$currency_item[2]|{$time_current}|{$currency_value}\n", FILE_APPEND);
  }

  $html_array->clear();
  unset($html_array);
}

#----------------------------------------------------------------------------------------------------

$time_current=time();

date_default_timezone_set('Europe/Sofia');
$time_string_current =  date('H:i:s');

date_default_timezone_set('UTC');
$time_string_current_utc =  date('H:i:s');

#----------------------------------------------------------------------------------------------------

if ($debug_flag)
{
  file_put_contents($debug_file, '');
}

get_quotes($array_fiat,   $url_fiat,   $file_fiat);
get_quotes($array_crypto, $url_crypto, $file_crypto);

#----------------------------------------------------------------------------------------------------

$page_content = get_file_template($template_content);
$page_html = get_file_template($template_html);

#----------------------------------------------------------------------------------------------------

eval("\$page_content = \"{$page_content}\";");
eval("\$page_html = \"{$page_html}\";");
echo $page_html;

#------------------------------------------------------------------------------------------------------------
?>
