<?php
#--------------------------------------------------------------------------------------------------

require_once('../units/commons/simplehtmldom.php');

#----------------------------------------------------------------------------------------------------------------------
# Get Quotes
#----------------------------------------------------------------------------------------------------------------------

function get_quotes($type)
{
  $url = $GLOBALS["url_{$type}"];
  $quotes = $GLOBALS["quotes_{$type}"];

  $pairs = '';
  $text = '';

  foreach($quotes as $key => $value) { $pairs .= "{$value[0]},"; }
  $GLOBALS['query']['pairs'] = rtrim($pairs, ',');
  $query = $GLOBALS['query'];

  $content = get_url($url, query: $query);
  $htmldom = str_get_html($content);

  foreach($quotes as $key => $value)
  {
    $selector_last = $GLOBALS['selector_last'];
    $selector_last = preg_replace('~number~s', $value[0], $selector_last);

    $last = $htmldom->find($selector_last, 0)->innertext;
    $last = preg_replace('/,/s', '', $last);
    $last = trim($last);

    $selector_pc = $GLOBALS['selector_pc'];
    $selector_pc = preg_replace('~number~s', $value[0], $selector_pc);

    $pc = $htmldom->find($selector_pc, 0)->innertext;
    $pc = preg_replace('/,/s', '', $pc);
    $pc = trim($pc);

    if     ((float)$pc < 0.0) { $direction_color = 'clColorDown';  }
    elseif ((float)$pc > 0.0) { $direction_color = 'clColorUp';    }
    else                      { $direction_color = 'clColorBlack'; }

    $prev = number_format((float)$last + (float)$pc * -1, $value[2]);
    $last = number_format((float)$last, $value[2]);
    $pc = number_format((float)$pc, $value[2]);

    $text .= <<<DOC
      <tr><td class='clSymbol'>{$value[1]}</td>
      <td class='clValue'>{$last}</td>
      <td class='clValue'>{$prev}</td>
      <td class='clValueDiff {$direction_color}'>{$pc}</td>
    DOC;
  }

  return $text;
}

#----------------------------------------------------------------------------------------------------------------------
# Get Dashboard
#----------------------------------------------------------------------------------------------------------------------

function get_dashboard()
{
  $fiat   = get_quotes('fiat');
  $crypto = get_quotes('crypto');

#  $fiat   = '';
#  $crypto = '';

  $title      = $GLOBALS['title'];
  $unit       = $GLOBALS['unit'];
  $zones      = $GLOBALS['zones'];
  $zone       = $GLOBALS['zone'];
  $date_today = $GLOBALS['date_today'];

  $html = get_template("dashboards");
  eval("\$html = \"{$html}\";");
  echo $html;
}

#----------------------------------------------------------------------------------------------------------------------
# Get Tickers
#----------------------------------------------------------------------------------------------------------------------

function get_tickers($type)
{
  $url = $GLOBALS["url_{$type}"];
  $tickers = $GLOBALS["tickers_{$type}"];
  $date_short = $GLOBALS['date_short'];

  $pairs = '';
  $content = '';

  foreach($tickers as $key => $value) { $pairs .= "{$value},"; }
  $GLOBALS['query']['pairs'] = rtrim($pairs, ',');
  $query = $GLOBALS['query'];

  $content = get_url($url, query: $query);
  $htmldom = str_get_html($content);

  $content = ucfirst($type) . ",{$date_short}\n";

  foreach($tickers as $key => $value)
  {
    $selector_last = $GLOBALS['selector_last'];
    $selector_last = preg_replace('~number~s', $value, $selector_last);

    $last = $htmldom->find($selector_last, 0)->innertext;
    $last = preg_replace('/,/s', '', $last);
    $last = trim($last);
    $content.= "{$key},{$last}\n";
  }

  header("Content-Type: mime/type");
  header('Content-Disposition: attachment; filename="tickers.csv"');
  echo $content;
}

#----------------------------------------------------------------------------------------------------------------------
# Get Margins
#----------------------------------------------------------------------------------------------------------------------

function get_margins()
{
  $url = $GLOBALS['url_margins'];
  $margins = $GLOBALS['margins'];
  $date_short = $GLOBALS['date_short'];

  $content = '';

  $content = get_url($url);
  $htmldom = str_get_html($content);

  $content  = "Margins,{$date_short},,,\n";
  $content .= "Symbol,Init. %,Init. Ratio,Maint. %,Maint. Ratio\n";

  foreach($margins as $key)
  {
    $selector_margins = $GLOBALS['selector_margins'];

    foreach($htmldom->find('tr') as $htmldom_tr)
    {
      $item_name = $htmldom_tr->find($selector_margins)[0]->innertext ?? '';

      if ($key != $item_name) { continue; }

      $margin_int = $htmldom_tr->find($selector_margins)[1]->innertext ?? '';
      $margin_mnt = $htmldom_tr->find($selector_margins)[2]->innertext ?? '';

      if (strpos($margin_int, ':') === false) { continue; }

      $exploded = explode('%', $margin_int);
      $margin_int_pct = sprintf('%4.2f%%', (float)$exploded[0]);
      $margin_int_rat = trim($exploded[1]);
      $margin_int_rat = preg_replace("~\(|\)~is", '', $margin_int_rat);

      $exploded = explode('%', $margin_mnt);
      $margin_mnt_pct = sprintf('%4.2f%%', (float)$exploded[0]);
      $margin_mnt_rat = trim($exploded[1]);
      $margin_mnt_rat = preg_replace("~\(|\)~is", '', $margin_int_rat);

      $margin_int_pct = preg_replace('~%~is',  '', $margin_int_pct);
      $margin_int_pct = sprintf('%6.3f', (float)$margin_int_pct / 100.0);
      $margin_mnt_pct = preg_replace('~%~is',  '', $margin_mnt_pct);
      $margin_mnt_pct = sprintf('%6.3f', (float)$margin_mnt_pct / 100.0);

      $content .= "{$key},{$margin_int_pct},{$margin_int_rat},{$margin_mnt_pct},{$margin_mnt_rat}\n";
    }
  }

  header("Content-Type: mime/type");
  header('Content-Disposition: attachment; filename="tickers.csv"');
  echo $content;
}

#----------------------------------------------------------------------------------------------------------------------
# Get Benchmarks
#----------------------------------------------------------------------------------------------------------------------

function get_benchmarks()
{
  $url = $GLOBALS['url_benchmarks'];
  $benchmarks = $GLOBALS['benchmarks'];
  $date_short = $GLOBALS['date_short'];

  $content = get_url($url);
  $htmldom = str_get_html($content);

  $content  = "Benchmarks,{$date_short},\n";
  $content .= "Symbol,Rate,Date\n";

  foreach($benchmarks as $key)
  {
    foreach($htmldom->find('table') as $htmldom_table)
    {
      $th_0 = trim($htmldom_table->find('th', 0)->plaintext) ?? '';
      $th_1 = trim($htmldom_table->find('th', 1)->plaintext) ?? '';
      $th_2 = trim($htmldom_table->find('th', 2)->plaintext) ?? '';

      if ($th_2 !== 'Rate') { continue; }

      foreach($htmldom_table->find('tr') as $htmldom_tr)
      {
        $td_0 = $htmldom_tr->find('td', 0);
        if (! is_null($td_0)) { $td_0 = trim($td_0->innertext); } else { continue; }

        $td_1 = $htmldom_tr->find('td', 1);
        if (! is_null($td_1)) { $td_1 = trim($td_1->innertext); } else { continue; }

        $td_2 = $htmldom_tr->find('td', 2);
        if (! is_null($td_2)) { $td_2 = trim($td_2->innertext); } else { continue; }

        $td_3 = $htmldom_tr->find('td', 3);
        if (! is_null($td_3)) { $td_3 = trim($td_3->innertext); } else { continue; }

        if (strpos($td_0, $key) === false) { continue; }

        $td_2 = preg_replace('~<(.*?)>~is', '', $td_2);
        $td_3 = preg_replace('~<(.*?)>~is', '', $td_3);
        $td_2 = preg_replace('~%~is', '', $td_2);
        $td_2 = sprintf('%8.5f', (float)$td_2 / 100);
        $td_3 = preg_replace('~(\d\d\d\d)(\d\d)(\d\d)~is', '$2/$3/$1', $td_3);

        $content .= "{$td_0},{$td_2},{$td_3}\n";
      }
    }
  }

  header("Content-Type: mime/type");
  header('Content-Disposition: attachment; filename="tickers.csv"');
  echo $content;
}

#----------------------------------------------------------------------------------------------------------------------
# Get Interests
#----------------------------------------------------------------------------------------------------------------------

function get_interests()
{
  $url = $GLOBALS['url_interests'];
  $interests = $GLOBALS['interests'];
  $cfds = $GLOBALS['cfds'];
  $date_short = $GLOBALS['date_short'];

  $tier_array = [];
  $tiers_array = [];
  $parameters_array = [];
  $html_found_flag = false;

  $content = get_url($url);
  $htmldom = str_get_html($content);

  $content  = "Interests,{$date_short},,,,\n";
  $content .= "Symbol,Tier,Rate,Base Spread,,\n";

  foreach($interests as $key)
  {
    foreach($htmldom->find('table') as $htmldom_table)
    {
      $th_0 = trim($htmldom_table->find('th', 0)->plaintext) ?? '';
      $th_1 = trim($htmldom_table->find('th', 1)->plaintext) ?? '';
      $th_2 = trim($htmldom_table->find('th', 2)->plaintext) ?? '';

      foreach($htmldom_table->find('tr') as $htmldom_tr)
      {
        $td_0 = $htmldom_tr->find('td', 0);
        if (! is_null($td_0)) { $td_0 = trim($td_0->innertext); } else { continue; }

        $td_1 = $htmldom_tr->find('td', 1);
        if (! is_null($td_1)) { $td_1 = trim($td_1->plaintext); } else { continue; }

        $td_2 = $htmldom_tr->find('td', 2);
        if (! is_null($td_2)) { $td_2 = trim($td_2->plaintext); } else { continue; }

        $td_1 = preg_replace('~,~is',  '', $td_1);
        $exploded_1 = explode('%', $td_2);
        $exploded_2 = explode('+', $td_2);
        $rate  = sprintf('%8.5f%%', (float)$exploded_1[0]);
        $bm    = sprintf('%8.5f%%', (float)$exploded_2[1]);

        if (strpos($td_1, '≤') !== false)
        {
          $exploded_3 = explode('≤', $td_1);
          $tier_1 = trim($exploded_3[0]);
          $tier_2 = '≤';
          $tier_3 = trim($exploded_3[1]);
        }
        else
        {
          $exploded_3 = explode('>', $td_1);
          $tier_1 = trim($exploded_3[0]);
          $tier_2 = '>';
          $tier_3 = trim($exploded_3[1]);
          $tier_3 = '900000000';
        }

        # tier 1

        if ($html_found_flag === false && $td_0 === $key)
        {
          $rate = preg_replace('~%~is', '', $rate);
          $rate = sprintf('%8.5f', (float)$rate / 100);
          $bm = preg_replace('~%~is', '', $bm);
          $bm = sprintf('%8.5f', (float)$bm / 100);

          $content .= "{$td_0},{$tier_3},{$rate},{$bm},,\n";

          $tier_array = array($tier_3, $rate, $bm);
          array_push($tiers_array, $tier_array);
          $tier_array = array();
          $html_found_flag = true;
          continue;
        }

        # tier 2

        if ($html_found_flag === true && $td_0 === "")
        {
          $rate = preg_replace('~%~is', '', $rate);
          $rate = sprintf('%8.5f', (float)$rate / 100);
          $bm = preg_replace('~%~is', '', $bm);
          $bm = sprintf('%8.5f', (float)$bm / 100);

          $content .= "{$key},{$tier_3},{$rate},{$bm},,\n";

          $tier_array = array($tier_3, $rate, $bm);
          array_push($tiers_array, $tier_array);
          $tier_array = array();
          $html_found_flag = false;
          break;
        }
      }
    }

    $parameters_array[$key] = $tiers_array;
    $tiers_array = array();
  }

  $content .= ",,,,,\n";
  $content .= "CFDs,{$date_short},,,,\n";
  $content .= "Pair,Size,BM Rate,Base Spread,Rate Long,Rate Short\n";

  foreach($cfds as $pair)
  {
    list($base_currency, $quote_currency) = explode('.', $pair);

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

      $bencmark_pair_rate  = sprintf('%10.7f', (float)$bencmark_pair_rate);
      $rate_long  = sprintf('%10.7f', (float)$rate_long);
      $rate_short  = sprintf('%10.7f', (float)$rate_short);

      $content .= "{$pair},{$base_size},{$bencmark_pair_rate},{$base_spread},{$rate_long},{$rate_short}\n";
    }
  }

  header("Content-Type: mime/type");
  header('Content-Disposition: attachment; filename="tickers.csv"');
  echo $content;
}

#----------------------------------------------------------------------------------------------------------------------
# Main Cycle
#----------------------------------------------------------------------------------------------------------------------

function get_main()
{
  $action = $GLOBALS['action'];

  switch ($action)
  {
    case 'dashboard':  get_dashboard();       break;
    case 'fiat':       get_tickers('fiat');   break;
    case 'crypto':     get_tickers('crypto'); break;
    case 'margins':    get_margins();         break;
    case 'benchmarks': get_benchmarks();      break;
    case 'interests':  get_interests();       break;
  }
}

#--------------------------------------------------------------------------------------------------
?>
