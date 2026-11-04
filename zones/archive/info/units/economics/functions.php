<?php
#--------------------------------------------------------------------------------------------------

require_once('../units/commons/simplehtmldom.php');

#--------------------------------------------------------------------------------------------------
# Index
#--------------------------------------------------------------------------------------------------

function out_index()
{
  $unit       = $GLOBALS['unit'];
  $zones      = $GLOBALS['zones'];
  $zone       = $GLOBALS['zone'];
  $prog       = $GLOBALS['prog'];
  $title      = $GLOBALS['title'];
  $indicators = $GLOBALS['indicators'];

  $content  = '';
  $content .= "<h1>{$title}</h1>\n";
  $content .= "<p class='clMediaName'><a href='{$prog}?varAction=latest'>Latest</a></p>\n";
  $content .= "<p class='clMediaName'><a href='{$prog}?varAction=blog'>Week Ahead</a></p>\n";

  $config_files_counter = 1;

  foreach ($indicators as &$indicator)
  {
    $in_div     = $indicator[0];
    $nm_country = $indicator[1];
    $nm_name    = $indicator[3];
    $id_country = $indicator[2];
    $id_name    = $indicator[4];

    $nm_enc_country = rawurlencode($nm_country);
    $nm_enc_name    = rawurlencode($nm_name);

    if ($in_div == "div")
    {
      if ($config_files_counter > 1)
      {
        $content .= "</div>\n";
      }

      $div_id_number = sprintf('%02d', $config_files_counter);
      $content .= "<p class='clMediaName'><a href='javascript:fncShowHideWithMemory(&quot;idDiv{$div_id_number}&quot;)'>{$nm_country}</a></p>\n";
      $content .= "<div id='idDiv{$div_id_number}'>\n";
      $config_files_counter++;
    }

    $content .= <<<DOC
      <p class='clMediaName'>
        <a href='{$prog}?varAction=indicator&varNmCountry={$nm_enc_country}&varNmName={$nm_enc_name}&varIdCountry={$id_country}&varIdName={$id_name}'>
          {$nm_name}
        </a>
      </p>\n
    DOC;
  }

  $content .= "</div>\n";

  $html = get_template('index');
  eval("\$html = \"{$html}\";");
  echo $html;
}

#--------------------------------------------------------------------------------------------------
# Latest
#--------------------------------------------------------------------------------------------------

function out_latest()
{
  $unit  = $GLOBALS['unit'];
  $zones = $GLOBALS['zones'];
  $zone  = $GLOBALS['zone'];
  $prog  = $GLOBALS['prog'];
  $title = $GLOBALS['title'];
  $url   = $GLOBALS['url'];

  $clean_01 = $GLOBALS['clean_01'];
  $clean_02 = $GLOBALS['clean_02'];

  $content  = '';
  $content .= "<h1>Latest</h1>\n";

  $text = get_url($url);
  $text = get_clean($text, $clean_01);
  $htmldom = str_get_html($text);
  $articles = $htmldom->find("div[class=home-tile-inside]");

  foreach ($articles as &$article)
  {
    $article = get_clean($article, $clean_02);
    $content .= $article;
  }

  $htmldom->clear();
  unset($htmldom);

  $html = get_template('latest');
  eval("\$html = \"{$html}\";");
  echo $html;
}

#--------------------------------------------------------------------------------------------------
# Blog (Week Ahead)
#--------------------------------------------------------------------------------------------------

function out_blog()
{
  $unit  = $GLOBALS['unit'];
  $zones = $GLOBALS['zones'];
  $zone  = $GLOBALS['zone'];
  $prog  = $GLOBALS['prog'];
  $title = $GLOBALS['title'];
  $url   = $GLOBALS['url_blog'];

  $clean_03 = $GLOBALS['clean_03'];
  $clean_04 = $GLOBALS['clean_04'];

  $content  = '';
  $content .= "<h1>Week Ahead</h1>\n";

  $text = get_url($url);

  $htmldom = str_get_html($text);
  $articles  = $htmldom->find("div[class=blog-post]");

  $counter = 1;

  foreach ($articles as &$article)
  {
    $div_id_number = sprintf('%02d', $counter);
    $article = get_clean($article, $clean_03);
    $article = preg_replace("~<h3>(.*?)</h3>~", "</div>\n<p class='clIndex'><a href='javascript:fncShowHideWithMemory(&quot;idDivArticle{$div_id_number}&quot;)'><h3>$1</h3></a></p>\n<div id='idDivArticle{$div_id_number}'>", $article);
    $content .= $article;
    $counter++;
  }

  $content = get_clean($content, $clean_04);

  $htmldom->clear();
  unset($htmldom);

  $html = get_template('blog');
  eval("\$html = \"{$html}\";");
  echo $html;
}

#--------------------------------------------------------------------------------------------------
# Indicator
#--------------------------------------------------------------------------------------------------

function out_indicator()
{
  $unit  = $GLOBALS['unit'];
  $zones = $GLOBALS['zones'];
  $zone  = $GLOBALS['zone'];
  $prog  = $GLOBALS['prog'];
  $title = $GLOBALS['title'];
  $url   = $GLOBALS['url'];

  $nm_country = $GLOBALS['nm_country'];
  $nm_name    = $GLOBALS['nm_name'];
  $id_country = $GLOBALS['id_country'];
  $id_name    = $GLOBALS['id_name'];

  $clean_05 = $GLOBALS['clean_05'];
  $clean_06 = $GLOBALS['clean_06'];
  $clean_07 = $GLOBALS['clean_07'];

  $nm_country = rawurldecode($nm_country);
  $nm_name    = rawurldecode($nm_name);

  $url = "{$url}/{$id_country}/{$id_name}";

  $text = get_url($url);
  $text = get_clean($text, $clean_05);

  $matches = [];
  $return_value = preg_match("/TECategory = '(.*?)'/", $text, $matches);
  $indicator_nm_name = $matches[1];
  unset($matches);

  $matches = [];
  $return_value = preg_match("/TELastUpdate = '(.*?)'/", $text, $matches);
  $indicator_update = $matches[1];
  unset($matches);

  $matches = [];
  $return_value = preg_match("/TEChartUrl = '(.*?)'/", $text, $matches);
  $indicator_chart = $matches[1];
  unset($matches);

  $text = get_clean($text, $clean_06);

  $indicator_date  = substr($indicator_update,  4, 2) . "/";
  $indicator_date .= substr($indicator_update,  6, 2) . "/";
  $indicator_date .= substr($indicator_update,  0, 4) . " ";
  $indicator_date .= substr($indicator_update,  8, 2) . ":";
  $indicator_date .= substr($indicator_update, 10, 2);

  $htmldom = str_get_html($text);

  $indicator_historical = $htmldom->find("div[id=historical-desc] h2", 0)->innertext;
  $indicator_forecast   = $htmldom->find("div[id=forecast-desc] h3", 0)->innertext;
  $indicator_stats      = $htmldom->find("div[id=stats] h2", 0)->innertext;

  $content = <<<DOC
    <h1>{$nm_country} - {$nm_name}</h1>\n
    <h2>{$indicator_date}</h2>\n
    <p>{$indicator_historical}</p>\n
    <a target='_blank' href='{$indicator_chart}'><img class='clImageThumb' src='{$indicator_chart}'></a><br>\n
    <p>{$indicator_forecast}</p>\n
    <p>{$indicator_stats}</p>\n
  DOC;

  $content = get_clean($content, $clean_07);

  $htmldom->clear();
  unset($htmldom);

  $html = get_template('indicator');
  eval("\$html = \"{$html}\";");
  echo $html;
}

#----------------------------------------------------------------------------------------------------------------------
# Main Cycle
#----------------------------------------------------------------------------------------------------------------------

function get_main()
{
  $action = $GLOBALS['action'];

  $content  = '';

  switch ($action)
  {
    case 'index':       $content = out_index();       break;
    case 'latest':      $content = out_latest();      break;
    case 'blog':        $content = out_blog();        break;
    case 'indicator':   $content = out_indicator();   break;
  }

  return $content;
}

#------------------------------------------------------------------------------------------------------------
?>
