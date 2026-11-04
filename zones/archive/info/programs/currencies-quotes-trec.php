

<?php
#!/bin/php
#----------------------------------------------------------------------------------------------------

include("./global-objects.php");
include("./simple-html-dom.php");

#---------------------------------------------------------------------------------------------------
# https://simplehtmldom.sourceforge.io/docs/1.9/api/str_get_html/
#---------------------------------------------------------------------------------------------------

1 ? $debug_flag = true : $debug_flag = false;

#---------------------------------------------------------------------------------------------------

$debug_file = "/home/" . get_current_user() . "/mnt/data/Temp/debug-currencies-quotes.txt";

#---------------------------------------------------------------------------------------------------

$url_fiat = "https://tradingeconomics.com/currencies";
$url_crypto = "https://tradingeconomics.com/crypto";

$array_fiat  =
[
    ['EURUSD:CUR',  0, '<span style=&quot;font-size: 94% !important;&quot;>€</span>/$', 0, 0.0]
#  , ['GBPUSD:CUR',  1, '£/$', 0, 0.0]
];

$array_crypto  =
[
    ['BTCUSD:CUR',  0, '<span style="font-size: 90% !important;">₿</span>/$', 0, 0.0]
#  , ['ETHUSD:CUR',  1, 'Ξ/$', 0, 0.0]
];

$format_fiat = "%6.4f";
$format_crypto = " %6d";

$currencies_string  = '';
$time_diff = '';

#---------------------------------------------------------------------------------------------------

$app_title      = "Currencies Quotes";
$page_title     = "{$app_title}";

$dir_zones       = "zones";
$dir_area       = "fn";
$dir_name       = "currencies-quotes";

$file_fiat      = "../{$dir_zones}/{$dir_area}/{$dir_name}/quotes-fiat.conf";
$file_crypto    = "../{$dir_zones}/{$dir_area}/{$dir_name}/quotes-crypto.conf";

#---------------------------------------------------------------------------------------------------

$template_content = "../{$dir_templates}/currencies-quotes.html";
$template_html    = "../{$dir_templates}/global-template.html";

#------------------------------------------------------------------------------------------------------------

function get_quotes($url_string, $array_currencies, $file_data, $format_data)
{
  global $debug_file, $debug_flag, $array_fiat, $array_crypto, $currencies_string, $time_current, $time_diff;

  $input_string = get_url($url_string);

  $input_string = preg_replace("/<style(.*?)style>/s", "", $input_string);
  $input_string = preg_replace("/<script(.*?)script>/s", "", $input_string);
  $input_string = preg_replace("/<meta(.*?)>/s", "", $input_string);

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
      $array_currencies[$config[1]][3] = $config[3];
      $array_currencies[$config[1]][4] = $config[4];
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

  $time_diff = $time_current - (int)$array_currencies[$config[1]][3];
  $time_diff = date('H:i:s', (int)$time_diff);

  if ($debug_flag)
  {
    file_put_contents($debug_file, $time_current . "\n");
    file_put_contents($debug_file, $array_currencies[$config[1]][3] . "\n", FILE_APPEND);
    file_put_contents($debug_file, $time_diff . "\n", FILE_APPEND);
  }

  file_put_contents($file_data, '');

  foreach($array_currencies as $currency_item)
  {
    $currency_value = $html_array->find("td[id=p]", $currency_item[1])->innertext;
    $currency_value = trim($currency_value);
    $currency_value = (float)sprintf($format_data, $currency_value);
    $currency_diff = (float)($currency_value - $array_currencies[$currency_item[1]][4]);

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

    $currency_value = sprintf($format_data, $currency_value);
    $currency_diff = sprintf($format_data, $currency_diff);

    $currencies_string .= "<tr><td class='clSymbol'>{$currency_item[2]}</td><td class='clValue {$direction_color}'>{$currency_value}</td><td class='clValueDiff'><span class='{$direction_symbol_color}'>{$direction_symbol}</span> {$currency_diff}</td></tr>\n";

    file_put_contents($file_data, "{$currency_item[0]}|$currency_item[1]|$currency_item[2]|{$time_current}|{$currency_value}\n", FILE_APPEND);

#echo $time_diff;
#exit;

}

#echo "{$currencies_string}\n";

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

get_quotes($url_fiat, $array_fiat, $file_fiat, $format_fiat);
get_quotes($url_crypto, $array_crypto, $file_crypto, $format_crypto);

#----------------------------------------------------------------------------------------------------

$page_content = get_file_template($template_content);
$page_html = get_file_template($template_html);

#----------------------------------------------------------------------------------------------------

eval("\$page_content = \"{$page_content}\";");
eval("\$page_html = \"{$page_html}\";");
echo $page_html;

#------------------------------------------------------------------------------------------------------------
?>
