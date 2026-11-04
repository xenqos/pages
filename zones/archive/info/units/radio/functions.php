<?php
#--------------------------------------------------------------------------------------------------

require_once('../units/commons/simplehtmldom.php');

#--------------------------------------------------------------------------------------------------

function get_bnt($lang, $title)
{
  $url = $GLOBALS['url'];
  $url_media = $GLOBALS['url_media'];
  $quantity = $GLOBALS['quantity'];
  $content = '';

  $text = get_url($url);
  $htmldom = str_get_html($text);

  $content .= "<p class='clMediaName'><a href='javascript:fncShowHideWithMemory(&quot;idDiv_{$lang}&quot;)'>{$title}</a></p>\n";
  $content .= "<div id='idDiv_{$lang}'>";

  $counter = 0;

  foreach($htmldom->find('option') as $audio_source)
  {
    $audio_source_name  = $audio_source->innertext;
    $audio_source_media = $audio_source->value;

    if ($counter++ >= $quantity) { break; }

    $content .= "<p class='clMediaName'><a href='{$url_media}{$audio_source_media}'>{$audio_source_name}</a></p>\n";
  }

  $content = str_replace("Емисия от ", "", $content);
  $content = str_replace("часа на ", "&ensp;", $content);
  $content .= "</div>\n";

  return $content;
}

#---------------------------------------------------------------------------------------------------

function get_radio($lang, $title)
{
  $stations = $GLOBALS["stations_{$lang}"];
  $content = '';

  $content .= "<p class='clMediaName'><a href='javascript:fncShowHideWithMemory(&quot;idDiv_{$lang}&quot;)'>{$title}</a></p>\n";
  $content .= "<div id='idDiv_{$lang}'>";

  foreach($stations as $station)
  {
    $content .= "<p class='clMediaName'><a href='{$station[1]}'>{$station[0]}</a></p>\n";
  }

  $content .= "</div>\n";

  return $content;
}

#---------------------------------------------------------------------------------------------------
?>
