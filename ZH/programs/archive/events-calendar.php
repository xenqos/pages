<?php
#------------------------------------------------------------------------------------------------------------

include("./global-objects.php");
include("./simple-html-dom.php");

#------------------------------------------------------------------------------------------------------------

$page_title     = "Events Calendar";
$data_area      = "fn";

0 ? $time_zone = 3 : $time_zone = 2;

#---------------------------------------------------------------------------------------------------

# TimeZone
# 55 - UTC
# 8  - EST
# 68 - EET

# Countries
# 4 - UK
# 5 - US
# 6 - Canada
#12 - Suiss
#17 - Germany
#22 - France
#72 - EU

$request_importance        ='2,3';
$request_countries         ='5,17,22,72';
$request_timezone          ='55';

#-------------------------------------------------------------------------------------------------------------

$url_events_day = "https://sslecal2.forexprostools.com/?columns=exc_flags,exc_currency,exc_importance,exc_actual,exc_forecast,exc_previous&category=_employment,_economicActivity,_inflation,_credit,_centralBanks,_confidenceIndex,_balance,_Bonds&importance={$request_importance}&countries={$request_countries}&calType=day&timeZone={$request_timezone}&lang=1";
$url_events_week = "https://sslecal2.forexprostools.com/?columns=exc_flags,exc_currency,exc_importance,exc_actual,exc_forecast,exc_previous&category=_employment,_economicActivity,_inflation,_credit,_centralBanks,_confidenceIndex,_balance,_Bonds&importance={$request_importance}&countries={$request_countries}&calType=week&timeZone={$request_timezone}&lang=1";

#-------------------------------------------------------------------------------------------------------------

$array_cbrates =
[
    ['US', 'https://tradingeconomics.com/united-states/interest-rate']
  , ['EU', 'https://tradingeconomics.com/euro-area/interest-rate']
#  , ['UK', 'https://tradingeconomics.com/united-kingdom/interest-rate']
];

#-------------------------------------------------------------------------------------------------------------

$page_content = '';

#-------------------------------------------------------------------------------------------------------------

$template_html    = "../{$dir_templates}/events-calendar.html";

#-------------------------------------------------------------------------------------------------------------

function get_cbrates()
{
  global $array_cbrates;

  $output_content  = '';
  $output_content .= "<h2>Central Banks</h2>";

  foreach($array_cbrates as $item_entry)
  {
    $url_cbrates = $item_entry[1];
    $url_content = get_url($url_cbrates);
    $html_objects = str_get_html($url_content);

    $item_name = $html_objects->find("table[id=calendar]", 0);
    $item_name = preg_replace("/\"/im", "'", $item_name);
    $item_name = preg_replace("/(\s+)/im", " ", $item_name);
    $item_name = preg_replace("/(\s+)</im", "<", $item_name);
    $item_name = preg_replace("/>(\s+)/im", ">", $item_name);
    $item_name = preg_replace("/ style='(.*?)'/im", "", $item_name);
    $item_name = preg_replace("/<th>Actual<\/th>/im", "<th>Act.</th>", $item_name);
    $item_name = preg_replace("/<th>Previous<\/th>/im", "<th>Pre.</th>", $item_name);
    $item_name = preg_replace("/<th>Consensus<\/th>/im", "<th>Con.</th>", $item_name);
    $item_name = preg_replace("/<th><span(.*?)>TEForecast<\/span><\/th>/im", "<th>For.</th>", $item_name);
    $item_name = preg_replace("/<td><\/span><\/td>/im", "", $item_name);
    $item_name = preg_replace("/<th colspan='2'>/im", "<th>", $item_name);
    $item_name = preg_replace("/<\/span><\/th><\/th>/im", "</span></th>", $item_name);
    $item_name = preg_replace("/<span class='hidden-xs'>Reference<\/span>/im", "Reference", $item_name);
    $item_name = preg_replace("/ data-id='(.*?)'/im", "", $item_name);
    $item_name = preg_replace("/ data-country='(.*?)'/im", "", $item_name);
    $item_name = preg_replace("/ data-category='(.*?)'/im", "", $item_name);
    $item_name = preg_replace("/datatable-item /im", "", $item_name);
    $item_name = preg_replace("/<td>(\d\d\d\d)-(\d\d)-(\d\d)<\/td>/im", "<td>$2/$3/$1</td>", $item_name);
    $item_name = preg_replace("/<th>GMT<\/th>/im", "<th>UTC</th>", $item_name);

    $item_name = preg_replace_callback(
    "/<td>(\d\d)\:(\d\d) (AM|PM)<\/td>/im",
    function($matches_array)
    {
      $date_string = $matches_array[1] . ":" . $matches_array[2] . " " . $matches_array[3];
      return "<td>" . date("H:i", strtotime($date_string)) . "</td>";
    }, $item_name);

    $output_content .= "<h4>" . $item_entry[0] . "</h4>";
    $output_content .= "<div class='clOverflow'>";
    $output_content .= $item_name;
    $output_content .= "</div>";
  }

  return $output_content;
}

#-------------------------------------------------------------------------------------------------------------

function get_events()
{
  global $url_events_day, $time_zone;

  $output_content = '';
  $page_module = '';
  $match_array = array();

  $url_content = get_url($url_events_day);
  $url_content = preg_replace("/\n/isU", " ", $url_content);

  $regex_module = "<table id=\"ecEventsTable\"(.*)>(.*)<\/table>";

  $match_result = preg_match("/$regex_module/iU", $url_content, $match_array);
  $page_module = $match_array[0];

  $page_module = preg_replace("/<thead>(.*)<\/thead>(.*)/iU", "", $page_module);
  $page_module = preg_replace("/(<tbody(.*)>|<\/tbody>)/iU", "", $page_module);

  $page_module = preg_replace("/\s\s+/imU", " ", $page_module);
  $page_module = preg_replace("/\s\s+>/imU", ">", $page_module);
  $page_module = preg_replace("/\s\s+</imU", "<", $page_module);

  $page_module = preg_replace("/onclick=\"(.*)\"/imU", "", $page_module);
  $page_module = preg_replace("/\"/imU", "'", $page_module);

  $page_module = preg_replace("/<tr/imU", "\n<tr", $page_module);
  $page_module = preg_replace("/<td/imU", "\n<td", $page_module);

  $page_module = preg_replace("/^<td(.*)theDay(.*)\/td>/imU", "", $page_module);

  $page_module = preg_replace("/event_(.*)='(.*)'/imU", "", $page_module);
  $page_module = preg_replace("/evt(.*)='(.*)'/imU", "", $page_module);
  $page_module = preg_replace("/id='(.*)'/imU", "", $page_module);
  $page_module = preg_replace("/<i(.*)i>/imU", "", $page_module);
  $page_module = preg_replace("/ Volatility Expected/imU", "", $page_module);

  $page_module = preg_replace("/title='Low'>/imU", "<span class='event_star'></span>", $page_module);
  $page_module = preg_replace("/title='Moderate'>/imU", "<span class='event_star'></span><span class='event_star'>", $page_module);
  $page_module = preg_replace("/title='High'>/imU", "<span class='event_star'></span><span class='event_star'></span><span class='event_star'></span>", $page_module);

  $page_module = preg_replace("/title='(.*)'/imU", "", $page_module);
  $page_module = preg_replace("/^<td(.*)colspan='8'(.*)td>/imU", "", $page_module);
  $page_module = preg_replace("/^<td(.*)colspan='6'/imU", "</tr><tr><td ", $page_module);
  $page_module = preg_replace("/class='center time'/imU", "class='event_time'", $page_module);

  $page_module = preg_replace("/ class='flagCur'/imU", "", $page_module);
  $page_module = preg_replace("/ceFlags(.*)'>&nbsp;<\/span>/imU", "country_flags\\1'>&nbsp;</span>", $page_module);
  $page_module = preg_replace("/\n<\/tr>/imU", "</tr>", $page_module);

  $page_module = preg_replace("/\s\s+/imU", " ", $page_module);
  $page_module = preg_replace("/\s\s+>/imU", ">", $page_module);
  $page_module = preg_replace("/\s\s+</imU", "<", $page_module);

  $page_module = preg_replace("/<tr class='noHover displayNone' ><\/tr>/imU", "", $page_module);
  $page_module = preg_replace("/^<td class='diamond(.*)td>/imU", "", $page_module);
  $page_module = preg_replace("/^<tr><\/tr>/imU", "", $page_module);
  $page_module = preg_replace("/<span class='audioIconNew(.*)span>/imU", "", $page_module);
  $page_module = preg_replace("/ class='sentiment' /imU", " ", $page_module);
  $page_module = preg_replace("/<span(.*)Preliminary Release(.*)span>/imU", "", $page_module);
  $page_module = preg_replace("/<table(.*)>/imU", "<table>", $page_module);

  $page_module = preg_replace("/class='(.*)act(.*)'/mU",   "class='\\1data_actual\\2'", $page_module);
  $page_module = preg_replace("/Manufdata_actualuring/mU",   "Manufacturing", $page_module);

  $page_module = preg_replace("/class='(.*)fore(.*)'/mU",  "class='\\1data_forecast\\2'", $page_module);
  $page_module = preg_replace("/class='(.*)prev(.*)'/mU",  "class='\\1data_previous\\2'", $page_module);
  $page_module = preg_replace("/class='(.*)bold(.*)'/mU",  "class='\\1font_bold\\2'", $page_module);
  $page_module = preg_replace("/class='(.*)greenFont(.*)'/mU",  "class='\\1color_green\\2'", $page_module);
  $page_module = preg_replace("/class='(.*)redFont(.*)'/mU",  "class='\\1color_red\\2'", $page_module);
  $page_module = preg_replace("/class='(.*)blackFont(.*)'/mU",  "class='\\1color_black\\2'", $page_module);
  $page_module = preg_replace("/class='first left time'/mU",  "class='event_time'", $page_module);
  $page_module = preg_replace("/class='left event'/mU",  "class='event_name'", $page_module);
  $page_module = preg_replace("/<td class='event_name'>(.*)<\/td>/mU",  "<td class='event_name'>\\1</td></tr><tr>", $page_module);
  $page_module = preg_replace("/<td>&nbsp;<\/td><\/tr><tr>/mU",  "</tr><tr>", $page_module);
  $page_module = preg_replace("/<td class='event_name'>/mU",  "</tr><tr><td class='event_name'>", $page_module);
  $page_module = preg_replace("/\n<\/tr>/imU", "</tr>", $page_module);
  $page_module = preg_replace("/\n\n/imU", "\n", $page_module);
  $page_module = $page_module . "\n";

  $pages_lines = explode("\n", $page_module);

  foreach ($pages_lines as &$event_line)
  {
    $pages_line_time = array();
    $regex_event_time = "event_time'.*?>(.*?)<";

    $match_result = preg_match("/$regex_event_time/imU", $event_line, $pages_line_time);

    if ($match_result)
    {
      $regex_time_local = $pages_line_time[0];
      $event_time_utc = $pages_line_time[1];

      $event_time_local = date('H:i', strtotime($event_time_utc) + 60 * 60 * $time_zone);

      $event_line_modified = preg_replace("/$regex_time_local/imU", "event_time'>$event_time_local&emsp;$event_time_utc<", $event_line);
      $output_content = $output_content . $event_line_modified . "\n";
    }
    else
    {
      $output_content = $output_content . $event_line . "\n";
    }
  }

  $regex_flag = "country_flags(.*?)(...)<";
  $output_content = preg_replace("/$regex_flag/mU",  "country_flags\\1</td><td class='currency_code'>\\2<", $output_content);

  $output_content = preg_replace("/<table>|<\/table>/imU", "", $output_content);
  $output_content = preg_replace("/<tr>|<tr >/imU", "<div>", $output_content);
  $output_content = preg_replace("/<\/tr>/imU", "</div>", $output_content);
  $output_content = preg_replace("/<td/imU", "<span", $output_content);
  $output_content = preg_replace("/<\/td>/imU", "</span>", $output_content);

  $output_content = preg_replace("/<div><\/div>/imU", "", $output_content);
  $output_content = preg_replace("/<\/sp</imU", "</span><", $output_content);
  $output_content = preg_replace("/currency_code'>an>/imU", "currency_code'>&nbsp;", $output_content);
  $output_content = preg_replace("/<span <span /mU",  "<span ", $output_content);
  $output_content = preg_replace("/<span><span /mU",  "<span ", $output_content);
  $output_content = preg_replace("/<span class='event_time'>/mU",  "<span class='event_time'>", $output_content);
  $output_content = preg_replace("/<\/div>/mU",  "</div>\n", $output_content);
  $output_content = preg_replace("/<\/span><\/div>\n\n/mU",  "</span></div>\n<br>\n\n", $output_content);

  return $output_content;
}

#-------------------------------------------------------------------------------------------------------------

date_default_timezone_set('UTC');
$time_utc = date('H:i');

date_default_timezone_set('Europe/Sofia');
$time_local = date('H:i') . '';
$date_current = date('D, M j, Y, H:i:s');

$content_events  = get_events();
$content_cbrates = get_cbrates();

#-------------------------------------------------------------------------------------------------------------

$page_html = get_file_template($template_html);

#-------------------------------------------------------------------------------------------------------------

eval("\$page_content = \"{$page_content}\";");
eval("\$page_html = \"{$page_html}\";");
echo $page_html;

#-------------------------------------------------------------------------------------------------------------
?>
