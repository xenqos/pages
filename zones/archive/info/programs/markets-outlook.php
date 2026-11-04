<?php
#------------------------------------------------------------------------------------------------------------

include("./global-objects.php");
include("./simple-html-dom.php");

#------------------------------------------------------------------------------------------------------------

$page_title             = "Markets Outlook";
$data_area              = "fn";

$url_cbrates            = 'https://www.investing.com/central-banks/';
$url_tradingeconomics   = 'https://tradingeconomics.com/';

$array_cbrates =
[
    ['FED', 'FED']
  , ['ECB', 'ECB']
#  , ['BOE', 'BOE']
#  , ['SNB', 'SNB']
];

$array_currencies =
[
    ['DXY:CUR'   , 'DXY']
  , ['EURUSD:CUR', 'EUR/USD']
#  , ['GBPUSD:CUR', 'GBP/USD']
#  , ['USDCHF:CUR', 'USD/CHF']
];

$array_bonds =
[
    ['USGG10YR:IND', 'United States']
  , ['GDBR10:IND'  , 'Germany']
#  , ['GUKG10:IND'  , 'United Kingdom']
#  , ['GSWISS10:IND', 'Suisse']
];

$array_indices =
[
    ['INDU:IND', 'Dow Jones' ]
  , ['SPX:IND' , 'S&P 500'   ]
  , ['NDX:IND' , 'Nasdaq 100']
];

$array_commodities =
[
    ['CL1:COM'   , 'Crude Oil WTI']
  , ['CO1:COM'   , 'Brent Oil'    ]
#  , ['NG1:COM'   , 'Natural gas'  ]
#  , ['XAUUSD:CUR', 'Gold'         ]
];

#------------------------------------------------------------------------------------------------------------

$template_html    = "../{$dir_templates}/global-template.html";

#------------------------------------------------------------------------------------------------------------

function get_cbrates()
{
  global $url_cbrates, $array_cbrates;

  $url_content = get_url($url_cbrates);
  $html_objects = str_get_html($url_content);

  $output_content  = "<h3><a href='{$url_cbrates }' target='_blank' rel='noreferrer'>Central Banks Rates</a></h3>\n";
  $output_content .= "<table>\n";

  foreach($array_cbrates as $item_entry)
  {
    foreach($html_objects->find('tr') as $html_objects_block)
    {
      $item_name = $html_objects_block->find("span[class=dirLtr]", 0)->innertext ?? "";
      $item_name = preg_replace("/\(|\)/is", "", $item_name);

      if ($item_entry[0] == $item_name)
      {
        $matches_array = array();
        $return_value = preg_match("/<span class=\"dirLtr\">(.*)<\/span><\/td>(.*)<td>(.*)<\/td>(.*)<td>(.*)<\/td>(.*)<td>(.*)<\/td>/iU", $html_objects_block, $matches_array);
        $strRatePct  = $matches_array[3];
        $strDateNext = $matches_array[5];
        $strDateTmp  = $matches_array[7];
        unset($matches_array);

        $strDateNext = date('m/d/y', strtotime($strDateNext));
        $strDateTmp = preg_replace("/\)/is", "", $strDateTmp);
        list($strDateLast, $strRateChange) = explode('(', $strDateTmp);
        $strDateLast = date('m/d/y', strtotime($strDateLast));

        $strRateChange = preg_replace("/bp/is", "", $strRateChange);

        $output_content .= "<tr>";
        $output_content .= "<td>{$item_entry[1]}</td>";
        $output_content .= "<td class='right'>{$strRatePct}</td>";
        $output_content .= "<td class='right'>{$strDateNext}</td>";
        $output_content .= "<td class='right'>{$strDateLast}</td>";
        $output_content .= "<td class='right'>{$strRateChange}</td>";
        $output_content .= "</tr>\n";

        $output_content .= "</tr>\n";
      }
    }
  }

  $html_objects->clear();
  unset($html_objects);

  $output_content .= "</table>\n";

  $output_content = preg_replace("/0\.00\%-/is", "", $output_content);
#  $output_content = preg_replace("/(\d\d)\/(\d\d)\/(\d\d)/is", "$2/$1/$3", $output_content);

  return $output_content;
}

#------------------------------------------------------------------------------------------------------------

function get_tradingeconomics()
{
  global $url_tradingeconomics, $array_currencies, $array_bonds, $array_indices, $array_commodities;

  $url_content = get_url($url_tradingeconomics);
  $url_content = preg_replace("/<input(.*?)>/is", "", $url_content);
  $url_content = preg_replace("/<style(.*?)style>/is", "", $url_content);
  $url_content = preg_replace("/<script(.*?)script>/is", "", $url_content);

  $html_objects = str_get_html($url_content);

  $output_content  = "<h3><a href='{$url_tradingeconomics}/currencies' target='_blank' rel='noreferrer'>Currencies</a></h3>\n";
  $output_content .= "<table>\n";

  foreach($array_currencies as $item_entry)
  {
    $item_p   = $html_objects->find("tr[data-symbol={$item_entry[0]}] td[id=p]", 0)->innertext ?? "";
    $item_nch = $html_objects->find("tr[data-symbol={$item_entry[0]}] td[id=nch]", 0)->innertext ?? "";
    $item_pch = $html_objects->find("tr[data-symbol={$item_entry[0]}] td[id=pch]", 0)->innertext ?? "";

    $item_p   = trim(preg_replace("/<span(.*?)span>/is", "", $item_p));
    $item_nch = trim(preg_replace("/<span(.*?)span>/is", "", $item_nch));
    $item_pch = trim(preg_replace("/<span(.*?)span>/is", "", $item_pch));

#    $float_decimals = ($item_entry[0] === 'DXY:CUR') ? 2 : 4;
    $float_decimals = 4;
    $item_p = preg_replace("/,/is", "", $item_p);
    $item_p = number_format((float) $item_p, $float_decimals, '.', ',');

    $item_color_name_pch = (strpos($item_pch, '-') === false) ? 'green' : 'red';
    $item_color_name_nch = $item_color_name_pch;
    $item_nch = (strpos($item_pch, '-') === false) ? "&nbsp;" . $item_nch : "-" . $item_nch;

    $output_content .= "<tr>";
    $output_content .= "<td>{$item_entry[1]}</td>";
    $output_content .= "<td class='right'>{$item_p}</td>";
    $output_content .= "<td class='{$item_color_name_nch} right'>{$item_nch}</td>";
    $output_content .= "<td class='{$item_color_name_pch} right'>{$item_pch}</td>";
    $output_content .= "</tr>\n";
  }

  $output_content .= "</table>\n";

  $output_content .= "<h3><a href='{$url_tradingeconomics}/bonds' target='_blank' rel='noreferrer'>Bonds</a></h3>\n";
  $output_content .= "<table>\n";

  foreach($array_bonds as $item_entry)
  {
    $item_p   = $html_objects->find("tr[data-symbol={$item_entry[0]}] td[id=p]", 0)->innertext ?? "";
    $item_nch = $html_objects->find("tr[data-symbol={$item_entry[0]}] td[id=nch]", 0)->innertext ?? "";
    $item_pch = $html_objects->find("tr[data-symbol={$item_entry[0]}] td[id=pch]", 0)->innertext ?? "";

    $item_p   = trim(preg_replace("/<span(.*?)span>/is", "", $item_p));
    $item_nch = trim(preg_replace("/<span(.*?)span>/is", "", $item_nch));
    $item_pch = trim(preg_replace("/<span(.*?)span>/is", "", $item_pch));

    $float_decimals = 3;
    $item_p   = preg_replace("/,/is", "", $item_p);
    $item_p = number_format((float) $item_p, $float_decimals, '.', ',');

    $item_color_name_pch = (strpos($item_pch, '-') === false) ? 'green' : 'red';
    $item_color_name_nch = $item_color_name_pch;
    $item_nch = (strpos($item_pch, '-') === false) ? "&nbsp;" . $item_nch : "-" . $item_nch;

    $output_content .= "<tr>";
    $output_content .= "<td>{$item_entry[1]}</td>";
    $output_content .= "<td class='right'>{$item_p}</td>";
    $output_content .= "<td class='{$item_color_name_nch} right'>{$item_nch}</td>";
    $output_content .= "<td class='{$item_color_name_pch} right'>{$item_pch}</td>";
    $output_content .= "</tr>\n";
  }

  $output_content .= "</table>\n";

  $output_content .= "<h3><a href='{$url_tradingeconomics}/stocks' target='_blank' rel='noreferrer'>Indices</a></h3>\n";
  $output_content .= "<table>\n";

  foreach($array_indices as $item_entry)
  {
    $item_p   = $html_objects->find("tr[data-symbol={$item_entry[0]}] td[id=p]", 0)->innertext ?? "";
    $item_nch = $html_objects->find("tr[data-symbol={$item_entry[0]}] td[id=nch]", 0)->innertext ?? "";
    $item_pch = $html_objects->find("tr[data-symbol={$item_entry[0]}] td[id=pch]", 0)->innertext ?? "";

    $item_p   = trim(preg_replace("/<span(.*?)span>/is", "", $item_p));
    $item_nch = trim(preg_replace("/<span(.*?)span>/is", "", $item_nch));
    $item_pch = trim(preg_replace("/<span(.*?)span>/is", "", $item_pch));

    $float_decimals = 0;
    $item_p   = preg_replace("/,/is", "", $item_p);
    $item_p = number_format((float) $item_p, $float_decimals, '.', ',');

    $item_color_name_pch = (strpos($item_pch, '-') === false) ? 'green' : 'red';
    $item_color_name_nch = $item_color_name_pch;
    $item_nch = (strpos($item_pch, '-') === false) ? "&nbsp;" . $item_nch : "-" . $item_nch;

    $output_content .= "<tr>";
    $output_content .= "<td>{$item_entry[1]}</td>";
    $output_content .= "<td class='right'>{$item_p}</td>";
    $output_content .= "<td class='{$item_color_name_nch} right'>{$item_nch}</td>";
    $output_content .= "<td class='{$item_color_name_pch} right'>{$item_pch}</td>";
    $output_content .= "</tr>\n";
  }

  $output_content .= "</table>\n";

  $output_content .= "<h3><a href='{$url_tradingeconomics}/commodities' target='_blank' rel='noreferrer'>Commodities</a></h3>\n";
  $output_content .= "<table>\n";

  foreach($array_commodities as $item_entry)
  {
    $item_p   = $html_objects->find("tr[data-symbol={$item_entry[0]}] td[id=p]", 0)->innertext ?? "";
    $item_nch = $html_objects->find("tr[data-symbol={$item_entry[0]}] td[id=nch]", 0)->innertext ?? "";
    $item_pch = $html_objects->find("tr[data-symbol={$item_entry[0]}] td[id=pch]", 0)->innertext ?? "";

    $item_p   = trim(preg_replace("/<span(.*?)span>/is", "", $item_p));
    $item_nch = trim(preg_replace("/<span(.*?)span>/is", "", $item_nch));
    $item_pch = trim(preg_replace("/<span(.*?)span>/is", "", $item_pch));

    $float_decimals = 2;
    $item_p = preg_replace("/,/is", "", $item_p);
    $item_p = number_format((float) $item_p, $float_decimals, '.', ',');

    $item_color_name_pch = (strpos($item_pch, '-') === false) ? 'green' : 'red';
    $item_color_name_nch = $item_color_name_pch;
    $item_nch = (strpos($item_pch, '-') === false) ? "&nbsp;" . $item_nch : "-" . $item_nch;

    $output_content .= "<tr>";
    $output_content .= "<td>{$item_entry[1]}</td>";
    $output_content .= "<td class='right'>{$item_p}</td>";
    $output_content .= "<td class='{$item_color_name_nch} right'>{$item_nch}</td>";
    $output_content .= "<td class='{$item_color_name_pch} right'>{$item_pch}</td>";
    $output_content .= "</tr>\n";
  }

  $output_content .= "</table>\n";

  $html_objects->clear();
  unset($html_objects);

  return $output_content;
}

#------------------------------------------------------------------------------------------------------------

date_default_timezone_set('Europe/Sofia');
$time_current = date('l, F d, Y') . '&ensp;' . date('H:i');

$page_content  = "<h1>{$page_title}</h1>\n";
$page_content .= "<h2>{$time_current}</h2>\n";

$page_content .= get_cbrates($array_cbrates, $url_cbrates);
$page_content .= get_tradingeconomics();

#  $debug_file     = "/home/" . get_current_user() . "/mnt/data/Temp/debug_markets_outlook.txt";
#  file_put_contents($debug_file, '');
#  file_put_contents($debug_file, $url_content, FILE_APPEND);

#------------------------------------------------------------------------------------------------------------

$page_html = get_file_template($template_html);

#----------------------------------------------------------------------------------------------------

eval("\$page_content = \"{$page_content}\";");
eval("\$page_html = \"{$page_html}\";");
echo $page_html;

#------------------------------------------------------------------------------------------------------------
?>
