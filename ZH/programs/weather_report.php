<?php
#!/bin/php
#----------------------------------------------------------------------------------------------------

include("./global-objects.php");
include("./simple-html-dom.php");

#---------------------------------------------------------------------------------------------------

0 ? $debug_flag = true : $debug_flag = false;

#---------------------------------------------------------------------------------------------------

$debug_file     = "/home/" . get_current_user() . "/mnt/data/Temp/weather_report.txt";

#---------------------------------------------------------------------------------------------------

$url_string = "https://www.sinoptik.bg/varna-bulgaria-100726050?location";

#---------------------------------------------------------------------------------------------------

$app_title      = "Weather";
$data_area      = "tc";

$dir_zones       = "zones";
$dir_area       = "tc";
$dir_name       = "weather_report";
$dir_config     = "../{$dir_zones}/{$dir_area}/{$dir_name}";

$page_title     = "{$app_title}";
$page_content   = '';

$image_prefix_medium = 'https://m4.netinfo.bg/sinoptik/icons/middle/';
$image_prefix_small = 'https://m4.netinfo.bg/sinoptik/icons/small/';

#---------------------------------------------------------------------------------------------------

$template_content = "../{$dir_templates}/weather-report-content.html";
$template_html    = "../{$dir_templates}/weather-report-html.html";

#----------------------------------------------------------------------------------------------------

$time_current=time();

date_default_timezone_set('Europe/Sofia');
$today_date = date('l, F d, Y');
$time_local = date('H:i T');

date_default_timezone_set('UTC');
$time_utc   = date('H:i T');

#------------------------------------------------------------------------------------------------------------

$input_string = get_url($url_string);
$html_array = str_get_html($input_string);

$now_temp_c = $html_array->find("div[class=wfCurrentContent]", 0)->find("span[class=wfCurrentTemp]", 0)->innertext ?? "";
$now_temp_c = trim(preg_replace("/&deg;C/s", "", $now_temp_c));
$now_temp_f = (float)sprintf("%d", (int)round($now_temp_c * 9/5 + 32, 0, PHP_ROUND_HALF_EVEN));

$now_image = $html_array->find("div[class=wfCurrentContent]", 0)->find("img[class=wfCurrentImg]", 0)->src ?? "";
$now_image = $image_prefix_medium . basename($now_image);

$now_condition = $html_array->find("div[class=wfCurrentContent]", 0)->find("strong", 0)->innertext ?? "";

$now_wind = $html_array->find("div[class^=wfCurrentBottom]", 0)->find("div[class=wfCurrentWindWrapper]", 0)->innertext ?? "";
$match_array = array();
$match_result = preg_match("/title=\"(.*)\">(\s+)(.*)<br/iU", $now_wind, $match_array);
$now_wind = trim($match_array[1]) . ' ' . trim($match_array[3]);
unset($match_array);

$match_array = array();
$match_result = preg_match("/<span class=\"wfCurrentHeading\">Атмосферно налягане:<\/span>(\s+)<span class=\"wfCurrentValue\">(.*)<\/span>/iU", $input_string, $match_array);
$now_pressure = trim($match_array[2]);
unset($match_array);

$match_array = array();
$match_result = preg_match("/<span class=\"wfCurrentHeading\">Влажност:<\/span>(\s+)<span class=\"wfCurrentValue\">(.*)<\/span>/iU", $input_string, $match_array);
$now_humidity = trim($match_array[2]);
unset($match_array);

$match_array = array();
$match_result = preg_match("/<span class=\"wfCurrentHeading\">Видимост:<\/span>(\s+)<span class=\"wfCurrentValue\">(.*)<\/span>/iU", $input_string, $match_array);
$now_visibility = trim($match_array[2]);
unset($match_array);

$match_array = array();
$match_result = preg_match("/<span class=\"wfCurrentHeading\">Продължителност на деня:<\/span>(\s+)<span class=\"wfCurrentValue\">(.*)<\/span>/iU", $input_string, $match_array);
$now_duration = trim($match_array[2]);
unset($match_array);

$now_range_temp = $html_array->find("a[class^=wfTodayContent]", 0)->find("span[class^=wfNonCurrentTemp]", 0)->innertext ?? "";
$now_range_temp = preg_replace("/&deg;/s", "", $now_range_temp);
$now_range_temp = preg_replace("/<span(.*?)>(.*?)<\/span>/s", "$2", $now_range_temp);
$now_range_temp = preg_replace("/(\s+)/s", " ", $now_range_temp);
$now_range_temp = preg_replace("/(\s+)\|(\s+)/s", "|", $now_range_temp);
$now_range_temp = trim($now_range_temp);

$match_array = array();
$match_array = explode("|", $now_range_temp);
$now_range_min_c = $match_array[0];
$now_range_max_c = $match_array[1];
unset($match_array);

$now_range_min_f = (float)sprintf("%d", (int)round($now_range_min_c * 9/5 + 32, 0, PHP_ROUND_HALF_EVEN));
$now_range_max_f = (float)sprintf("%d", (int)round($now_range_max_c * 9/5 + 32, 0, PHP_ROUND_HALF_EVEN));

$today_image = $html_array->find("a[class^=wfTodayContent]", 0)->find("img[class=wfNonCurrentImg]", 0)->src ?? "";
$today_image = $image_prefix_small . basename($today_image);

$today_condition = $html_array->find("a[class^=wfTodayContent]", 0)->find("strong[class=wfNonCurrentCond]", 0)->innertext ?? "";

$now_precipitation = $html_array->find("a[class^=wfTodayContent]", 0)->find("span[class^=wfNonCurrentValue]", 0)->innertext ?? "";
$now_quantity = $html_array->find("a[class^=wfTodayContent]", 0)->find("span[class^=wfNonCurrentValue]", 1)->innertext ?? "";
$now_cloudiness = $html_array->find("a[class^=wfTodayContent]", 0)->find("span[class^=wfNonCurrentValue]", 3)->innertext ?? "";
$now_uv = $html_array->find("a[class^=wfTodayContent]", 0)->find("span[class^=wfNonCurrentValue]", 4)->innertext ?? "";
$now_sunrise = $html_array->find("a[class^=wfTodayContent]", 0)->find("span[class^=wfNonCurrentValue]", 8)->innertext ?? "";
$now_sunset = $html_array->find("a[class^=wfTodayContent]", 0)->find("span[class^=wfNonCurrentValue]", 9)->innertext ?? "";

$now_sunrise = preg_replace("/изгрев в/s", "", $now_sunrise);
$now_sunset = preg_replace("/залез в/s", "", $now_sunset);

#echo "<<<{$match_array[2]}>>>\n";
#echo "<<<{$today_condition}>>>\n";

$html_array->clear();
unset($html_array);

#exit;

#----------------------------------------------------------------------------------------------------

$page_content = get_file_template($template_content);
$page_html    = get_file_template($template_html);

#----------------------------------------------------------------------------------------------------

eval("\$page_content = \"{$page_content}\";");
eval("\$page_html = \"{$page_html}\";");
echo $page_html;

#------------------------------------------------------------------------------------------------------------
?>
