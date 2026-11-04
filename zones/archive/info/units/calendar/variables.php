<?php
#--------------------------------------------------------------------------------------------------

$title = 'Calendar';
$zone = 'fn';

#--------------------------------------------------------------------------------------------------

# TimeZone
# 55 - UTC
# 8  - EST
# 68 - EET

# Countries
#  4 - UK
#  5 - US
# 17 - Germany
# 22 - France
# 72 - EU

#--------------------------------------------------------------------------------------------------

$url_ev = 'https://sslecal2.forexprostools.com/';

$query_ev =
[
  'calType'     => 'week'
, 'importance'  => '2,3'
, 'countries'   => '5,17,22,72'
, 'timeZone'    => '55'
, 'columns'     => 'exc_flags,exc_currency,exc_importance,exc_actual,exc_forecast,exc_previous'
, 'category'    => '_employment,_economicActivity,_inflation,_credit,_centralBanks,_confidenceIndex,_balance,_Bonds'
, 'lang'        => '1'
];

$selector_ev = 'table[id=ecEventsTable]';

$params_ev =
[
  ["\"", "'"]
, ["\s\s+", " "]
, ["\s\s+>", ">"]
, ["\s\s+<", "<"]
, ["<thead>(.*?)</thead>(.*?)", ""]
, ["(<tbody(.*?)>|</tbody>)", ""]
, ["<tr", "\n<tr"]
, ["</tr>", "\n</tr>"]
, ["<td", "\n<td"]
, ["<tr id='eventInfo(.*?)>(.*?)</tr>", ""]
, ["<tr id='eventRowId(.*?)>", "<tr id='eventRowId'>"]
, ["<td class='diamond'(.*?)>(.*?)</td>", ""]
, ["<i(.*?)i>", ""]
, [" Volatility Expected", ""]
, ["title='Low'>", "><span class='event_star'></span>"]
, ["title='Moderate'>", "><span class='event_star'></span><span class='event_star'></span>"]
, ["title='High'>", "><span class='event_star'></span><span class='event_star'></span><span class='event_star'></span>"]
, [" event-(\d+)-(actual|forecast|previous)", ""]
, [" id='event(Actual|Forecast|Previous)_(\d+)'", ""]
, [" class='flagCur'", ""]
, ["ceFlags(.*?)'>&nbsp;<\/span>(\s+)(.*?)</td>", "country_flags$1'>&nbsp;</span><span class='currency_code'>$3</span></td>"]
, ["class='first left time'(\s+)", "class='event_time' "]
, ["class='event_time'(.*?)>", "class='event_time'>"]
, [" title='(.*?)'", ""]
, ["<table(.*?)>|</table>", ""]
, [" colspan='(.*?)'", ""]
, [" class='theDay'", ""]
, [" id='theDay(\d+)'", " id='theDay'"]
, ["\s+\n", "\n"]
, ["<tr>\n<td id='theDay'>(.*?)</td>\n</tr>", "<summary>$1</summary>"]
, ["<tr(.*?)>", "<div id='id1'>"]
, ["</tr>", "</div>"]
, ["<td class='event_time'>(.*?)</td>", "<span class='event_time'>$1</span>"]
, ["<td><span class='country_flags(.*?)</td>", "<span class='country_flags$1"]
, ["<td class='sentiment'(\s+)>(.*?)</td>", "$2"]
, ["class='left event'", "class='event_name'"]
, ["<td class='event_name'>(.*?)</td>", "</div>\n<div id='id2'>\n<span class='event_name'>$1</span>\n</div>\n<div id='id3'>"]
, ["class='bold act (.*?)'", "class='bold data_actual $1'"]
, ["class='(.*?)fore(.*?)'", "class='$1data_forecast$2'"]
, ["class='(.*?)prev(.*?)'", "class='$1data_previous$2'"]
, ["class='(.*?)bold(.*?)'", "class='$1font_bold$2'"]
, ["class='(.*?)greenFont(.*?)'", "class='$1color_green$2'"]
, ["class='(.*?)redFont(.*?)'", "class='$1color_red$2'"]
, ["class='(.*?)blackFont(.*?)'", "class='$1color_black$2'"]
, ["<td", "<span"]
, ["</td>", "</span>"]
, ["<summary>(.*?)</summary>", "</details>\n<details><summary>$1</summary>"]
, ["^(.*?)</details>", ""]
, ["(.*$)$", "$1\n</details>"]
];

#--------------------------------------------------------------------------------------------------

$collection_cb =
[
  ['US', 'https://tradingeconomics.com/united-states/interest-rate']
#, ['EU', 'https://tradingeconomics.com/euro-area/interest-rate']
];

$selector_cb = 'table[id=calendar]';

$params_cb =
[
  ["\"", "'"]
, ["(\s+)", " "]
, ["(\s+)<", "<"]
, [">(\s+)", ">"]
, [" style='(.*?)'", ""]
, ["<th>Actual</th>", "<th>Act.</th>"]
, ["<th>Previous</th>", "<th>Pre.</th>"]
, ["<th>Consensus</th>", "<th>Con.</th>"]
, ["<th><span(.*?)>TEForecast</span></th>", "<th>For.</th>"]
, ["<td></span></td>", ""]
, ["<th colspan='2'>", "<th>"]
, ["</span></th></th>", "</span></th>"]
, ["<span class='hidden-xs'>Reference</span>", "Reference"]
, [" data-id='(.*?)'", ""]
, [" data-country='(.*?)'", ""]
, [" data-category='(.*?)'", ""]
, ["datatable-item ", ""]
, ["<td>(\d\d)(\d\d)-(\d\d)-(\d\d)<\/td>", "<td>$3/$4/$2</td>"]
, ["<th>GMT</th>", "<th>UTC</th>"]
];

#--------------------------------------------------------------------------------------------------
?>
