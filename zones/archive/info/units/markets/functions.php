<?php
#--------------------------------------------------------------------------------------------------

require_once('../units/commons/simplehtmldom.php');

#--------------------------------------------------------------------------------------------------
# Centralbanks
#--------------------------------------------------------------------------------------------------

function get_centralbanks()
{
  $url = $GLOBALS['url_centralbanks'];
  $centralbanks = $GLOBALS['centralbanks'];

  $text = get_url($url);
  $htmldom = str_get_html($text);

  $content = <<<DOC
    <h3><a href='{$url}' target='_blank' rel='noreferrer'>Central Banks Rates</a></h3>\n
    <table>\n
  DOC;

  foreach($centralbanks as $centralbank)
  {
    foreach($htmldom->find('tr') as $htmldom_block)
    {
      $name = $htmldom_block->find("span[class=dirLtr]", 0)->innertext ?? "";
      $name = preg_replace("~\(|\)~s", "", $name);

      if ($centralbank[0] == $name)
      {
        $matches = [];
        $return_value = preg_match("/<span class=\"dirLtr\">(.*)<\/span><\/td>(.*)<td>(.*)<\/td>(.*)<td>(.*)<\/td>(.*)<td>(.*)<\/td>/iU", $htmldom_block, $matches);
        $strRatePct  = $matches[3];
        $strDateNext = $matches[5];
        $strDateTmp  = $matches[7];
        unset($matches);

        $strDateNext = date('m/d/y', strtotime($strDateNext));
        $strDateTmp = preg_replace("~\)~s", "", $strDateTmp);
        list($strDateLast, $strRateChange) = explode('(', $strDateTmp);
        $strDateLast = date('m/d/y', strtotime($strDateLast));

        $strRateChange = preg_replace("~bp~s", "", $strRateChange);

        $content .= <<<DOC
          <tr>
          <td>{$centralbank[1]}</td>
          <td class='right'>{$strRatePct}</td>
          <td class='right'>{$strDateNext}</td>
          <td class='right'>{$strDateLast}</td>
          <td class='right'>{$strRateChange}</td>
          </tr>\n
        DOC;
      }
    }
  }

  $htmldom->clear();
  unset($htmldom);

  $content .= "</table>\n";
  $content = preg_replace("~0\.00\%-~s", "", $content);

  return $content;
}

#--------------------------------------------------------------------------------------------------
# Tradingeconomics
#--------------------------------------------------------------------------------------------------

function get_tradingeconomics()
{
  $url = $GLOBALS['url_tradingeconomics'];
  $currencies = $GLOBALS['currencies'];
  $bonds = $GLOBALS['bonds'];
  $indices = $GLOBALS['indices'];
  $commodities = $GLOBALS['commodities'];

  $text = get_url($url);
  $text = preg_replace("~<input(.*?)>~s", "", $text);
  $text = preg_replace("~<style(.*?)style>~s", "", $text);
  $text = preg_replace("~<script(.*?)script>~s", "", $text);

  $htmldom = str_get_html($text);

  #------------------------------------------------------------------------------------------------
  # Currencies
  #------------------------------------------------------------------------------------------------

  $content = <<<DOC
    <h3><a href='{$url}/currencies' target='_blank' rel='noreferrer'>Currencies</a></h3>\n
    <table>\n
  DOC;

  foreach($currencies as $currency)
  {
    $p   = $htmldom->find("tr[data-symbol={$currency[0]}] td[id=p]", 0)->innertext ?? "";
    $nch = $htmldom->find("tr[data-symbol={$currency[0]}] td[id=nch]", 0)->innertext ?? "";
    $pch = $htmldom->find("tr[data-symbol={$currency[0]}] td[id=pch]", 0)->innertext ?? "";

    $p   = trim(preg_replace("~<span(.*?)span>~s", "", $p));
    $nch = trim(preg_replace("~<span(.*?)span>~s", "", $nch));
    $pch = trim(preg_replace("~<span(.*?)span>~s", "", $pch));

#    $float_decimals = ($currency[0] === 'DXY:CUR') ? 2 : 4;
    $float_decimals = 4;
    $p = preg_replace("~,~s", "", $p);
    $p = number_format((float) $p, $float_decimals, '.', ',');

    $color_name_pch = (strpos($pch, '-') === false) ? 'green' : 'red';
    $color_name_nch = $color_name_pch;
    $nch = (strpos($pch, '-') === false) ? "&nbsp;" . $nch : "-" . $nch;

    $content .= <<<DOC
      <tr>
      <td>{$currency[1]}</td>
      <td class='right'>{$p}</td>
      <td class='{$color_name_nch} right'>{$nch}</td>
      <td class='{$color_name_pch} right'>{$pch}</td>
      </tr>\n
    DOC;
  }

  $content .= "</table>\n";

  #------------------------------------------------------------------------------------------------
  # Bonds
  #------------------------------------------------------------------------------------------------

  $content .= <<<DOC
    <h3><a href='{$url}/bonds' target='_blank' rel='noreferrer'>Bonds</a></h3>\n
    <table>\n
  DOC;

  foreach($bonds as $bond)
  {
    $p   = $htmldom->find("tr[data-symbol={$bond[0]}] td[id=p]", 0)->innertext ?? "";
    $nch = $htmldom->find("tr[data-symbol={$bond[0]}] td[id=nch]", 0)->innertext ?? "";
    $pch = $htmldom->find("tr[data-symbol={$bond[0]}] td[id=pch]", 0)->innertext ?? "";

    $p   = trim(preg_replace("~<span(.*?)span>~s", "", $p));
    $nch = trim(preg_replace("~<span(.*?)span>~s", "", $nch));
    $pch = trim(preg_replace("~<span(.*?)span>~s", "", $pch));

    $float_decimals = 3;
    $p   = preg_replace("~,~s", "", $p);
    $p   = number_format((float) $p, $float_decimals, '.', ',');

    $color_name_pch = (strpos($pch, '-') === false) ? 'green' : 'red';
    $color_name_nch = $color_name_pch;
    $nch = (strpos($pch, '-') === false) ? "&nbsp;" . $nch : "-" . $nch;

    $content .= <<<DOC
      <tr>
      <td>{$bond[1]}</td>
      <td class='right'>{$p}</td>
      <td class='{$color_name_nch} right'>{$nch}</td>
      <td class='{$color_name_pch} right'>{$pch}</td>
      </tr>\n
    DOC;
  }

  $content .= "</table>\n";

  #------------------------------------------------------------------------------------------------
  # Indices
  #------------------------------------------------------------------------------------------------

  $content .= <<<DOC
    <h3><a href='{$url}/stocks' target='_blank' rel='noreferrer'>Indices</a></h3>\n
    <table>\n
  DOC;

  foreach($indices as $index)
  {
    $p   = $htmldom->find("tr[data-symbol={$index[0]}] td[id=p]", 0)->innertext ?? "";
    $nch = $htmldom->find("tr[data-symbol={$index[0]}] td[id=nch]", 0)->innertext ?? "";
    $pch = $htmldom->find("tr[data-symbol={$index[0]}] td[id=pch]", 0)->innertext ?? "";

    $p   = trim(preg_replace("~<span(.*?)span>~s", "", $p));
    $nch = trim(preg_replace("~<span(.*?)span>~s", "", $nch));
    $pch = trim(preg_replace("~<span(.*?)span>~s", "", $pch));

    $float_decimals = 0;
    $p   = preg_replace("~,~is", "", $p);
    $p   = number_format((float) $p, $float_decimals, '.', ',');

    $color_name_pch = (strpos($pch, '-') === false) ? 'green' : 'red';
    $color_name_nch = $color_name_pch;
    $nch = (strpos($pch, '-') === false) ? "&nbsp;" . $nch : "-" . $nch;

    $content .= <<<DOC
      <tr>
      <td>{$index[1]}</td>
      <td class='right'>{$p}</td>
      <td class='{$color_name_nch} right'>{$nch}</td>
      <td class='{$color_name_pch} right'>{$pch}</td>
      </tr>\n
    DOC;
  }

  $content .= "</table>\n";

  #------------------------------------------------------------------------------------------------
  # Commodities
  #------------------------------------------------------------------------------------------------

  $content .= <<<DOC
    <h3><a href='{$url}/commodities' target='_blank' rel='noreferrer'>Commodities</a></h3>\n
    <table>\n
  DOC;

  foreach($commodities as $commodity)
  {
    $p   = $htmldom->find("tr[data-symbol={$commodity[0]}] td[id=p]", 0)->innertext ?? "";
    $nch = $htmldom->find("tr[data-symbol={$commodity[0]}] td[id=nch]", 0)->innertext ?? "";
    $pch = $htmldom->find("tr[data-symbol={$commodity[0]}] td[id=pch]", 0)->innertext ?? "";

    $p   = trim(preg_replace("~<span(.*?)span>~s", "", $p));
    $nch = trim(preg_replace("~<span(.*?)span>~s", "", $nch));
    $pch = trim(preg_replace("~<span(.*?)span>~s", "", $pch));

    $float_decimals = 2;
    $p = preg_replace("~,~s", "", $p);
    $p = number_format((float) $p, $float_decimals, '.', ',');

    $color_name_pch = (strpos($pch, '-') === false) ? 'green' : 'red';
    $color_name_nch = $color_name_pch;
    $nch = (strpos($pch, '-') === false) ? "&nbsp;" . $nch : "-" . $nch;

    $content .= <<<DOC
      <tr>
      <td>{$commodity[1]}</td>
      <td class='right'>{$p}</td>
      <td class='{$color_name_nch} right'>{$nch}</td>
      <td class='{$color_name_pch} right'>{$pch}</td>
      </tr>\n
    DOC;
  }

  $content .= "</table>\n";

  $htmldom->clear();
  unset($htmldom);

  return $content;
}

#--------------------------------------------------------------------------------------------------
?>
