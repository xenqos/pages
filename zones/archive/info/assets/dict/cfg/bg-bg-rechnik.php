<?php
$media_name     = 'Речник Бг-Бг';
$media_url      = 'https://rechnik.chitanka.info';
$media_post     = null;
$media_word     = ["^(.*?)$", "$1/w/{$word_encoded}"];
$media_encode   = 'false';

$article_body   = 'div[id=content]';

$clean_article  =
[
  ["\(<span title=\"Разширена класификация на БГ Офис\"><a href=\"(.*?)\">(.*?)</a></span>\)", "<z href='https://rechnik.chitanka.info$1'>$2</z>"]
, ["<a href=\"/faq/edit/rights\" class=\"edit-fake\">(.*?)</a>", ""]
, ["<div class=\"links box\"(.*?)</div>", ""]
, ["<a(.*?)>", "$2"]
, ["</a>", ""]
, ["<z", "<a"]
, ["</z>", "</a>"]
, ["<p>С дефиси \(къси тирета\)(.*?)p>", ""]
, ["<table(.*?)table>", "<div class='clOverflow'><table$1table></div>"]
, ["<th(.*?)>единствено число</th>", "<th$1>ед.ч.</th>"]
, ["<th(.*?)>множествено число</th>", "<th$1>мн.ч.</th>"]
, ["<th(.*?)>мъжки род</th>", "<th$1>м.р.</th>"]
, ["<th(.*?)>женски род</th>", "<th$1>ж.р.</th>"]
, ["<th(.*?)>среден род</th>", "<th$1>с.р.</th>"]
, ["<th(.*?)>1 лице</th>", "<th$1>1 л.</th>"]
, ["<th(.*?)>2 лице</th>", "<th$1>2 л.</th>"]
, ["<th(.*?)>3 лице</th>", "<th$1>3 л.</th>"]
, ["<th(.*?)>членувано</th>", "<th$1>чл.</th>"]
, ["<th(.*?)>непълен член</th>", "<th$1>чл.н.</th>"]
, ["<th(.*?)>пълен член</th>", "<th$1>чл.п.</th>"]
, ["<th(.*?)>звателна форма</th>", "<th$1>зв.ф.</th>"]
, ["<td>(.*?)<ul>(.*?)</td>", "<td>$1$2</td>"]
, ["<td>(.*?)</ul>(.*?)</td>", "<td>$1$2</td>"]
, ["<td>(.*?)</li><li>(.*?)</td>", "<td>$1<br>$2</td>"]
, ["<td>(.*?)</li>(.*?)</td>", "<td>$1$2</td>"]
, ["<td>(.*?)<li>(.*?)</td>", "<td>$1$2</td>"]
];

?>
