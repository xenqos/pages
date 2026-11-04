<?php
#--------------------------------------------------------------------------------------------------

require_once('../units/commons/simplehtmldom.php');

#--------------------------------------------------------------------------------------------------

function get_events()
{
  $url = $GLOBALS['url_ev'];
  $query = $GLOBALS['query_ev'];
  $selector = $GLOBALS['selector_ev'];

  $content = get_url($url, query: $query);
  $htmldom = str_get_html($content);

  $text = $htmldom->find($selector, 0);

  $params = $GLOBALS['params_ev'];
  $text = get_clean($text, $params);

  $text = preg_replace_callback(
    "~<span class='event_time'>(.*?)</span>~s",
      function($matches)
      {
        $time_zone = $GLOBALS['time_zone'];
        $time_utc = $matches[1];
        $time_local = date('H:i', strtotime($time_utc) + 60 * 60 * $time_zone);
        return "<span class='event_time'>{$time_local}&emsp;{$time_utc}</span>";
      },
    $text);

  return $text;
}

#--------------------------------------------------------------------------------------------------

function get_events_url()
{
  $query = $GLOBALS['query_ev'];
  $url = $GLOBALS['url_ev'];

  $url = $url . '?' . http_build_query($query, '', '&', PHP_QUERY_RFC3986);

  return $url;
}

#--------------------------------------------------------------------------------------------------
?>
