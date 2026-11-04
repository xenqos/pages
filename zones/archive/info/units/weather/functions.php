<?php
#--------------------------------------------------------------------------------------------------

require_once('../units/commons/simplehtmldom.php');

#--------------------------------------------------------------------------------------------------

function get_weather()
{
  $url = $GLOBALS['url'];
  $date_today = $GLOBALS['date_today'];

  $image_prefix_medium = $GLOBALS['image_prefix_medium'];
  $image_prefix_small  = $GLOBALS['image_prefix_small'];

  $text = get_url($url);
  $dom = str_get_html($text);

  $now_temp_c = $dom->find("div[class=wfCurrentContent]", 0)->find("span[class=wfCurrentTemp]", 0)->innertext ?? "";
  $now_temp_c = trim(preg_replace("~&deg;C~s", "", $now_temp_c));
  $now_temp_f = (float)sprintf("%d", (int)round($now_temp_c * 9/5 + 32, 0, PHP_ROUND_HALF_EVEN));

  $now_image = $dom->find("div[class=wfCurrentContent]", 0)->find("img[class=wfCurrentImg]", 0)->src ?? "";
  $now_image = $image_prefix_medium . basename($now_image);

  $now_condition = $dom->find("div[class=wfCurrentContent]", 0)->find("strong", 0)->innertext ?? "";

  $now_wind = $dom->find("div[class^=wfCurrentBottom]", 0)->find("div[class=wfCurrentWindWrapper]", 0)->innertext ?? "";
  $matches = [];
  $matched = preg_match("~title=\"(.*?)\">(\s+)(.*?)<br~s", $now_wind, $matches);
  $now_wind = trim($matches[1]) . ' ' . trim($matches[3]);
  unset($matches);

  $matches = [];
  $matched = preg_match("~<span class=\"wfCurrentHeading\">Атмосферно налягане:<\/span>(\s+)<span class=\"wfCurrentValue\">(.*?)<\/span>~s", $text, $matches);
  $now_pressure = trim($matches[2]);
  unset($matches);

  $matches = [];
  $matched = preg_match("~<span class=\"wfCurrentHeading\">Влажност:<\/span>(\s+)<span class=\"wfCurrentValue\">(.*?)<\/span>~s", $text, $matches);
  $now_humidity = trim($matches[2]);
  unset($matches);

  $matches = [];
  $matched = preg_match("~<span class=\"wfCurrentHeading\">Видимост:<\/span>(\s+)<span class=\"wfCurrentValue\">(.*)<\/span>~iU", $text, $matches);
  $now_visibility = trim($matches[2]);
  unset($matches);

  $matches = [];
  $matched = preg_match("~<span class=\"wfCurrentHeading\">Продължителност на деня:<\/span>(\s+)<span class=\"wfCurrentValue\">(.*?)<\/span>~s", $text, $matches);
  $now_duration = trim($matches[2]);
  unset($matches);

  $now_range_temp = $dom->find("a[class^=wfTodayContent]", 0)->find("span[class^=wfNonCurrentTemp]", 0)->innertext ?? "";
  $now_range_temp = preg_replace("~&deg;~s", "", $now_range_temp);
  $now_range_temp = preg_replace("~<span(.*?)>(.*?)</span>~s", "$2", $now_range_temp);
  $now_range_temp = preg_replace("~(\s+)~s", " ", $now_range_temp);
  $now_range_temp = preg_replace("~(\s+)\|(\s+)~s", "|", $now_range_temp);
  $now_range_temp = trim($now_range_temp);

  $matches = [];
  $matches = explode("|", $now_range_temp);
  $now_range_min_c = $matches[0];
  $now_range_max_c = $matches[1];
  unset($matches);

  $now_range_min_f = (float)sprintf("%d", (int)round($now_range_min_c * 9/5 + 32, 0, PHP_ROUND_HALF_EVEN));
  $now_range_max_f = (float)sprintf("%d", (int)round($now_range_max_c * 9/5 + 32, 0, PHP_ROUND_HALF_EVEN));

  $today_image = $dom->find("a[class^=wfTodayContent]", 0)->find("img[class=wfNonCurrentImg]", 0)->src ?? "";
  $today_image = $image_prefix_small . basename($today_image);

  $today_condition = $dom->find("a[class^=wfTodayContent]", 0)->find("strong[class=wfNonCurrentCond]", 0)->innertext ?? "";

  $now_precipitation = $dom->find("a[class^=wfTodayContent]", 0)->find("span[class^=wfNonCurrentValue]", 0)->innertext ?? "";
  $now_quantity = $dom->find("a[class^=wfTodayContent]", 0)->find("span[class^=wfNonCurrentValue]", 1)->innertext ?? "";
  $now_cloudiness = $dom->find("a[class^=wfTodayContent]", 0)->find("span[class^=wfNonCurrentValue]", 3)->innertext ?? "";
  $now_uv = $dom->find("a[class^=wfTodayContent]", 0)->find("span[class^=wfNonCurrentValue]", 4)->innertext ?? "";
  $now_sunrise = $dom->find("a[class^=wfTodayContent]", 0)->find("span[class^=wfNonCurrentValue]", 8)->innertext ?? "";
  $now_sunset = $dom->find("a[class^=wfTodayContent]", 0)->find("span[class^=wfNonCurrentValue]", 9)->innertext ?? "";

  $now_sunrise = preg_replace("~изгрев в~s", "", $now_sunrise);
  $now_sunset = preg_replace("~залез в~s", "", $now_sunset);

  $content = get_template("content");
  eval("\$content = \"{$content}\";");
  return $content;
}

#--------------------------------------------------------------------------------------------------
?>
