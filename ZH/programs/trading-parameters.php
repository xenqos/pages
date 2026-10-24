<?php
#!/bin/php
#---------------------------------------------------------------------------------------------------

include("./global-objects.php");
include("./simple-html-dom.php");

#---------------------------------------------------------------------------------------------------

# http://localhost/hypers/trading-parameters.php?varInstrument=crypto&varMedia=csv
# http://localhost/hypers/trading-parameters.php?varInstrument=forex&varMedia=csv
# http://localhost/hypers/trading-parameters.php?varInstrument=margins&varMedia=csv
# http://localhost/hypers/trading-parameters.php?varInstrument=benchmarks&varMedia=csv
# http://localhost/hypers/trading-parameters.php?varInstrument=interests&varMedia=csv
# http://localhost/hypers/trading-parameters.php?varInstrument=pricing&varMedia=csv

# https://home.ayurveda.help/hypers/trading-parameters.php?varInstrument=crypto&varMedia=csv
# https://home.ayurveda.help/hypers/trading-parameters.php?varInstrument=forex&varMedia=csv
# https://home.ayurveda.help/hypers/trading-parameters.php?varInstrument=margins&varMedia=csv
# https://home.ayurveda.help/hypers/trading-parameters.php?varInstrument=benchmarks&varMedia=csv
# https://home.ayurveda.help/hypers/trading-parameters.php?varInstrument=interests&varMedia=csv

#---------------------------------------------------------------------------------------------------

$var_instrument = $_GET['varInstrument'];
#$var_instrument = 'crypto';
#$var_instrument = 'forex';
#$var_instrument = 'margins';
#$var_instrument = 'benchmarks';
#$var_instrument = 'interests';
#$var_instrument = 'pricing';

$var_media = $_GET['varMedia'];
#$var_media = 'csv';
#$var_media = 'html';

#---------------------------------------------------------------------------------------------------

$page_title         = "Trading Parameters";
$data_area          = "fn";

#---------------------------------------------------------------------------------------------------

$crypto_link = 'https://www.widgets.investing.com/crypto-currency-rates?theme=darkTheme&cols=last&pairs=PAIRS';

# Source of Data: Investing.com, Kraken

$crypto_items =
[
    ['BTC/EUR'     , '49800']
  , ['ETH/EUR'     , '1001803']
  , ['XRP/EUR'     , '1010773']
  , ['USDT'        , '1061453']
];

#  , ['ETH/BTC'     , '1010776']

#---------------------------------------------------------------------------------------------------

$forex_link = 'https://www.widgets.investing.com/live-currency-cross-rates?theme=darkTheme&cols=bid,ask,last&pairs=PAIRS';

$forex_items =
[
    ['EUR/USD',  '1']
#  , ['GBP/USD',  '2']
];

#---------------------------------------------------------------------------------------------------

$margins_link = 'https://www.interactivebrokers.ie/en/index.php?f=39020&hm=eu&ex=gl&rgt=1&rsk=0&pm=0&rst=010101010101010808';

$margins_items =
[
    'USD'
  , 'EUR'
#  , 'GBP'
];

#---------------------------------------------------------------------------------------------------

$benchmarks_link = 'https://www.interactivebrokers.ie/en/index.php?f=46789&p=i';

$benchmarks_items =
[
    'USD'
  , 'EUR'
#  , 'GBP'
];

#---------------------------------------------------------------------------------------------------

$interests_link = 'https://www.interactivebrokers.ie/en/index.php?f=46782&p=m';

$interests_items =
[
    'USD'
  , 'EUR'
#  , 'GBP'
#  , 'ZAR'
];

$cfds_pairs =
[
    'EUR.USD'
#  , 'GBP.USD'
#  , 'USD.ZAR'
];

#------------------------------------------------------------------------------------------------------------

$template_html    = "../{$dir_templates}/trading-parameters.html";

#------------------------------------------------------------------------------------------------------------

function get_quotes($page_name, $parameter_link, $parameter_items)
{
  global $time_current;

  $page_return = "{$page_name},{$time_current}\n";

  $link_items = "";

  foreach($parameter_items as $parameter_item)
  {
    $link_items .= "{$parameter_item[1]},";
  }

  $parameter_link = str_replace("PAIRS", rtrim($link_items, ","), $parameter_link);

  $html_contents = get_url($parameter_link);
  $html_object = str_get_html($html_contents);

  foreach($parameter_items as $parameter_item)
  {
    $html_found = $html_object->find("div[class*=pid-{$parameter_item[1]}-last]", 0)->innertext;
    $html_found = preg_replace("/,/is",  "", $html_found);
    $page_return .= "{$parameter_item[0]},{$html_found}\n";
  }

  $html_object->clear();
  unset($html_object);

#echo   $page_return;

  return $page_return;
}

#---------------------------------------------------------------------------------------------------

function get_margins($parameter_link, $parameter_items)
{
  global $time_current, $var_media;

  if ($var_media == "html")
  {
    $page_return  = "";
    $page_return .= "<h3>Margins</h3>\n";
    $page_return .= "<div class='clOverflow'>\n";
    $page_return .= "<table>\n";
    $page_return .= "<tr>";
    $page_return .= "<th>IN</th>";
    $page_return .= "<th>IR</th>";
    $page_return .= "<th>IP</th>";
    $page_return .= "<th>MR</th>";
    $page_return .= "<th>MP</th>";
    $page_return .= "</tr>\n";
  }
  elseif ($var_media == "csv")
  {
    $page_return = "Margins,{$time_current},,,\n";
  }

  $html_contents = get_url($parameter_link);
  $html_object = str_get_html($html_contents);

  foreach($parameter_items as $parameter_item)
  {
    foreach($html_object->find("tr") as $html_block)
    {
      $html_item_name = $html_block->find("td.text-price")[0]->innertext;

      if ($parameter_item != $html_item_name)
      {
        continue;
      }

      $html_item_margin_int = $html_block->find("td.text-price")[1]->innertext;
      $html_item_margin_mnt = $html_block->find("td.text-price")[2]->innertext;

      if (strpos($html_item_margin_int, ':') === false)
      {
        continue;
      }

      $exploded_array = explode("%", $html_item_margin_int);
      $html_item_margin_int_pct = sprintf("%4.2f%%", (float)$exploded_array[0]);
      $html_item_margin_int_rat = trim($exploded_array[1]);
      $html_item_margin_int_rat = preg_replace("/\(|\)/is",  "", $html_item_margin_int_rat);

      $exploded_array = explode("%", $html_item_margin_mnt);
      $html_item_margin_mnt_pct = sprintf("%4.2f%%", (float)$exploded_array[0]);
      $html_item_margin_mnt_rat = trim($exploded_array[1]);
      $html_item_margin_mnt_rat = preg_replace("/\(|\)/is",  "", $html_item_margin_int_rat);

      if ($var_media == "html")
      {
        $page_return .= "<tr>";
        $page_return .= "<td>{$html_item_name}</td>";
        $page_return .= "<td>{$html_item_margin_int_pct}</td>";
        $page_return .= "<td>{$html_item_margin_int_rat}</td>";
        $page_return .= "<td>{$html_item_margin_mnt_pct}</td>";
        $page_return .= "<td>{$html_item_margin_mnt_rat}</td>";
        $page_return .= "</tr>";
      }
      elseif ($var_media == "csv")
      {
#        $html_item_margin_int_pct = preg_replace("/%/is",  "", $html_item_margin_int_pct);
#        $html_item_margin_int_pct = sprintf("%6.3f", (float)$html_item_margin_int_pct / 100.0);
#        $html_item_margin_mnt_pct = preg_replace("/%/is",  "", $html_item_margin_mnt_pct);
#        $html_item_margin_mnt_pct = sprintf("%6.3f", (float)$html_item_margin_mnt_pct / 100.0);

        $page_return .= "{$html_item_name},";
        $page_return .= "{$html_item_margin_int_pct},";
        $page_return .= "{$html_item_margin_int_rat},";
        $page_return .= "{$html_item_margin_mnt_pct},";
        $page_return .= "{$html_item_margin_mnt_rat}\n";
      }
    }
  }

  $html_object->clear();
  unset($html_object);

  if ($var_media == "html")
  {
    $page_return .= "</table>\n";
    $page_return .= "</div>\n";
    $page_return .= "<blockquote>\n";
    $page_return .= "IN - instrument<br>\n";
    $page_return .= "IP - initial percentage<br>\n";
    $page_return .= "IR - initial rate<br>\n";
    $page_return .= "MP - maintenanace percentage<br>\n";
    $page_return .= "MR - maintenanace rate<br>\n";
    $page_return .= "</blockquote>\n";
  }

  return $page_return;
}

#---------------------------------------------------------------------------------------------------

function get_benchmarks($parameter_link, $parameter_items)
{
  global $time_current, $var_media;


  if ($var_media == "html")
  {
    $page_return  = "";
    $page_return .= "<h3>Benchmarks</h3>\n";
    $page_return .= "<div class='clOverflow'>\n";
    $page_return .= "<table>\n";
    $page_return .= "<tr>";
    $page_return .= "<th>IN</th>";
    $page_return .= "<th>BR</th>";
    $page_return .= "<th>DT</th>";
    $page_return .= "</tr>";
  }
  elseif ($var_media == "csv")
  {
    $page_return = "Benchmarks,{$time_current},\n";
  }

  $html_contents = get_url($parameter_link);
  $html_object = str_get_html($html_contents);

  foreach($parameter_items as $parameter_item)
  {
    foreach($html_object->find("table") as $html_block)
    {
      $html_item_th_0 = trim($html_block->find("th", 0)->plaintext);
      $html_item_th_1 = trim($html_block->find("th", 1)->plaintext);
      $html_item_th_2 = trim($html_block->find("th", 2)->plaintext);

      if ($html_item_th_2 !== "Rate")
      {
        continue;
      }

      foreach($html_block->find("tr") as $html_block_tr)
      {
        $html_item_td_0 = trim($html_block_tr->find("td", 0)->innertext);
        $html_item_td_1 = trim($html_block_tr->find("td", 1)->plaintext);
        $html_item_td_2 = trim($html_block_tr->find("td", 2)->plaintext);
        $html_item_td_3 = trim($html_block_tr->find("td", 3)->plaintext);

        if (strpos($html_item_td_0, $parameter_item) === false)
        {
          continue;
        }

        $html_item_td_1 = preg_replace("/Reference Benchmark +/is",  "", $html_item_td_1);
        $html_item_td_1 = preg_replace("/{$parameter_item}/is",      "", $html_item_td_1);
        $html_item_td_1 = trim($html_item_td_1);

        $html_item_td_2 = preg_replace("/\(/is",                     "-", $html_item_td_2);
        $html_item_td_2 = preg_replace("/\)/is",                     "", $html_item_td_2);

        $html_item_td_3_csv  = preg_replace("/(\d\d)(\d\d)(\d\d)(\d\d)/is", "$3/$4/$2", $html_item_td_3);
        $html_item_td_3_html = preg_replace("/(\d\d)(\d\d)(\d\d)(\d\d)/is", "$3/$4/$2", $html_item_td_3);

        if ($html_item_td_1 !== "Libor")
        {
          if ($var_media == "html")
          {
            $page_return .= "<tr>";
            $page_return .= "<td>{$html_item_td_0}</td>";
            $page_return .= "<td>{$html_item_td_2}</td>";
            $page_return .= "<td>{$html_item_td_3_html}</td>";
            $page_return .= "</tr>";
          }
          elseif ($var_media == "csv")
          {
            $html_item_td_2 = preg_replace("/%/is",  "", $html_item_td_2);
            $html_item_td_2 = sprintf("%8.5f", (float)$html_item_td_2 / 100);

            $page_return .= "{$html_item_td_0},";
            $page_return .= "{$html_item_td_2},";
            $page_return .= "{$html_item_td_3_csv}\n";
          }
        }
      }
    }
  }

  $html_object->clear();
  unset($html_object);

  if ($var_media == "html")
  {
    $page_return .= "</table>\n";
    $page_return .= "</div>\n";
    $page_return .= "<blockquote>\n";
    $page_return .= "IN - instrument<br>\n";
    $page_return .= "BR - benchmark rate<br>\n";
    $page_return .= "DT - date<br>\n";
    $page_return .= "</blockquote>\n";
  }

  return $page_return;
}

#---------------------------------------------------------------------------------------------------

function get_interests($parameter_link, $parameter_items, $parameter_pairs)
{
  global $time_current, $var_media;

  $tier_array = array();
  $tiers_array = array();
  $parameters_array = array();
  $html_found_flag = false;

  if ($var_media == "html")
  {
    $page_return  = "";
    $page_return .= "<h3>Interests</h3>\n";
    $page_return .= "<div class='clOverflow'>\n";
    $page_return .= "<table>\n";
    $page_return .= "<tr>";
    $page_return .= "<th>IN</th>";
    $page_return .= "<th>TR</th>";
    $page_return .= "<th>IR</th>";
    $page_return .= "<th>BS</th>";
    $page_return .= "</tr>";
  }
  elseif ($var_media == "csv")
  {
    $page_return = "Interests,{$time_current},,,,\n";
  }

  $html_contents = get_url($parameter_link);
  $html_object = str_get_html($html_contents);

  foreach($parameter_items as $parameter_item)
  {
    foreach($html_object->find("table") as $html_block)
    {
      $html_item_th_0 = trim($html_block->find("th", 0)->plaintext);
      $html_item_th_1 = trim($html_block->find("th", 1)->plaintext);
      $html_item_th_2 = trim($html_block->find("th", 2)->plaintext);

      foreach($html_block->find("tr") as $html_block_tr)
      {
        $html_item_td_0 = trim($html_block_tr->find("td", 0)->innertext);
        $html_item_td_1 = trim($html_block_tr->find("td", 1)->plaintext);
        $html_item_td_2 = trim($html_block_tr->find("td", 2)->plaintext);

        $html_item_td_1 = preg_replace("/,/is",  "", $html_item_td_1);
        $exploded_array_1 = explode("%", $html_item_td_2);
        $exploded_array_2 = explode("+", $html_item_td_2);
        $html_item_rate  = sprintf("%4.3f%%", (float)$exploded_array_1[0]);
        $html_item_bm    = sprintf("%4.3f%%", (float)$exploded_array_2[1]);

        if (strpos($html_item_td_1, "≤") !== false)
        {
          $exploded_array_3 = explode("≤", $html_item_td_1);
          $html_item_tier_1 = trim($exploded_array_3[0]);
          $html_item_tier_2 = "≤";
          $html_item_tier_3 = trim($exploded_array_3[1]);
        }
        else
        {
          $exploded_array_3 = explode(">", $html_item_td_1);
          $html_item_tier_1 = trim($exploded_array_3[0]);
          $html_item_tier_2 = ">";
          $html_item_tier_3 = trim($exploded_array_3[1]);
          $html_item_tier_3 = "900000000";
        }

# tier 1
        if ($html_found_flag === false && $html_item_td_0 === $parameter_item)
        {
          if ($var_media == "html")
          {
            $page_return .= "<tr>";
            $page_return .= "<td>{$html_item_td_0}</td>";
            $page_return .= "<td>{$html_item_tier_3}</td>";
            $page_return .= "<td>{$html_item_rate}</td>";
            $page_return .= "<td>{$html_item_bm}</td>";
            $page_return .= "</tr>";
          }
          elseif ($var_media == "csv")
          {
            $html_item_rate = preg_replace("/%/is",  "", $html_item_rate);
            $html_item_rate = sprintf("%7.4f", (float)$html_item_rate / 100);
            $html_item_bm = preg_replace("/%/is",  "", $html_item_bm);
            $html_item_bm = sprintf("%7.4f", (float)$html_item_bm / 100);

            $page_return .= "{$html_item_td_0},";
            $page_return .= "{$html_item_tier_3},";
            $page_return .= "{$html_item_rate},";
            $page_return .= "{$html_item_bm},,\n";
          }

          $tier_array = array($html_item_tier_3, $html_item_rate, $html_item_bm);
          array_push($tiers_array, $tier_array);
          $tier_array = array();
          $html_found_flag = true;
          continue;
        }

# tier 2
        if ($html_found_flag === true && $html_item_td_0 === "")
        {
          if ($var_media == "html")
          {
            $page_return .= "<tr>";
            $page_return .= "<td>{$parameter_item}</td>";
            $page_return .= "<td>{$html_item_tier_3}</td>";
            $page_return .= "<td>{$html_item_rate}</td>";
            $page_return .= "<td>{$html_item_bm}</td>";
            $page_return .= "</tr>";
          }
          elseif ($var_media == "csv")
          {
            $html_item_rate = preg_replace("/%/is",  "", $html_item_rate);
            $html_item_rate = sprintf("%7.4f", (float)$html_item_rate / 100);
            $html_item_bm = preg_replace("/%/is",  "", $html_item_bm);
            $html_item_bm = sprintf("%7.4f", (float)$html_item_bm / 100);

            $page_return .= "{$parameter_item},";
            $page_return .= "{$html_item_tier_3},";
            $page_return .= "{$html_item_rate},";
            $page_return .= "{$html_item_bm},,\n";
          }

          $tier_array = array($html_item_tier_3, $html_item_rate, $html_item_bm);
          array_push($tiers_array, $tier_array);
          $tier_array = array();
          $html_found_flag = false;
          break;
        }
      }
    }
    $parameters_array[$parameter_item] = $tiers_array;
    $tiers_array = array();
  }

  $html_object->clear();
  unset($html_object);

  if ($var_media == "html")
  {
    $page_return .= "</table>\n";
    $page_return .= "</div>\n";
    $page_return .= "<blockquote>\n";
    $page_return .= "IN - instrument<br>\n";
    $page_return .= "TR - tier<br>\n";
    $page_return .= "IR - interest rate<br>\n";
    $page_return .= "BS - base spread<br>\n";
    $page_return .= "</blockquote>\n";
  }

  if ($var_media == "html")
  {
    $page_return .= "";
    $page_return .= "<h3>Cfds</h3>\n";
    $page_return .= "<div class='clOverflow'>\n";
    $page_return .= "<table>\n";
    $page_return .= "<tr>";
    $page_return .= "<th>PR</th>";
    $page_return .= "<th>SZ</th>";
    $page_return .= "<th>BP</th>";
    $page_return .= "<th>BS</th>";
    $page_return .= "<th>RL</th>";
    $page_return .= "<th>RS</th>";
    $page_return .= "</tr>";
  }
  elseif ($var_media == "csv")
  {
    $page_return .= ",,,,,\n";
    $page_return .= "CFDs,{$time_current},,,,\n";
  }

  foreach($parameter_pairs as $parameter_pair)
  {
    list($base_currency, $quote_currency) = explode(".", $parameter_pair);

    for ($counter = 0; $counter <= 1; $counter++)
    {
      $base_size         = $parameters_array["$base_currency"][$counter][0];
      $base_benchmark    = $parameters_array["$base_currency"][$counter][1];
      $base_spread       = $parameters_array["$base_currency"][$counter][2];

      $quote_size        = $parameters_array["$quote_currency"][$counter][0];
      $quote_benchmark   = $parameters_array["$quote_currency"][$counter][1];
      $quote_spread      = $parameters_array["$quote_currency"][$counter][2];

      $bencmark_pair_rate = $base_benchmark - $quote_benchmark;
      $rate_long = $bencmark_pair_rate - $base_spread;
      $rate_short = $bencmark_pair_rate + $base_spread;

      if ($var_media == "html")
      {
        $bencmark_pair_rate  = sprintf("%5.3f%%", (float)$bencmark_pair_rate);
        $rate_long  = sprintf("%5.3f%%", (float)$rate_long);
        $rate_short  = sprintf("%5.3f%%", (float)$rate_short);

        $page_return .= "<tr>";
        $page_return .= "<td>{$parameter_pair}</td>";
        $page_return .= "<td>{$base_size}</td>";
        $page_return .= "<td>{$bencmark_pair_rate}</td>";
        $page_return .= "<td>{$base_spread}</td>";
        $page_return .= "<td>{$rate_long}</td>";
        $page_return .= "<td>{$rate_short}</td>";
        $page_return .= "</tr>";
      }
      elseif ($var_media == "csv")
      {
        $bencmark_pair_rate  = sprintf("%10.7f", (float)$bencmark_pair_rate);
        $rate_long  = sprintf("%10.7f", (float)$rate_long);
        $rate_short  = sprintf("%10.7f", (float)$rate_short);

        $page_return .= "{$parameter_pair},";
        $page_return .= "{$base_size},";
        $page_return .= "{$bencmark_pair_rate},";
        $page_return .= "{$base_spread},";
        $page_return .= "{$rate_long},";
        $page_return .= "{$rate_short}\n";
      }
    }
  }

  if ($var_media == "html")
  {
    $page_return .= "</table>\n";
    $page_return .= "</div>\n";
    $page_return .= "<blockquote>\n";
    $page_return .= "PR - pair<br>\n";
    $page_return .= "SZ - size<br>\n";
    $page_return .= "BP - benchmark pair rate<br>\n";
    $page_return .= "BS - base spread<br>\n";
    $page_return .= "RL - rate long<br>\n";
    $page_return .= "RS - rate short<br>\n";
    $page_return .= "</blockquote>\n";
  }

  return $page_return;
}

#---------------------------------------------------------------------------------------------------

date_default_timezone_set('Europe/Sofia');
$time_current = date('d/m/Y H:i:s');

if ($var_instrument == "crypto")
{
  $page_content = get_quotes('Crypto', $crypto_link, $crypto_items);
}
elseif ($var_instrument == "forex")
{
  $page_content = get_quotes('Forex', $forex_link, $forex_items);
}
elseif ($var_instrument == "margins")
{
  $page_content = get_margins($margins_link, $margins_items);
}
elseif ($var_instrument == "benchmarks")
{
  $page_content = get_benchmarks($benchmarks_link, $benchmarks_items);
}
elseif ($var_instrument == "interests")
{
  $page_content = get_interests($interests_link, $interests_items, $cfds_pairs);
}
elseif ($var_instrument == "pricing")
{
  $page_content = "";
  $page_margins = get_margins($margins_link, $margins_items);
  $page_benchmarks .= get_benchmarks($benchmarks_link, $benchmarks_items);
  $page_interests .= get_interests($interests_link, $interests_items, $cfds_pairs);
}
else
{
  $page_content = "";
}

#---------------------------------------------------------------------------------------------------

if ($var_media == "html")
{
  date_default_timezone_set('Europe/Sofia');
  $time_current = date('l, F d, Y') . '&ensp;' . date('H:i');
  $page_html = get_file_template($template_html);
  eval("\$page_content = \"{$page_content}\";");
  eval("\$page_html = \"{$page_html}\";");
  echo $page_html;
}
elseif ($var_media == "csv")
{
  header("Content-Type: mime/type");
  header('Content-Disposition: attachment; filename="parameters.csv"');
  echo $page_content;
}

#---------------------------------------------------------------------------------------------------
?>
