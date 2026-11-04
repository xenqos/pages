<?php
$config_enabled  = "true";
$config_type     = "link";

$media_name      = "Infostock - Финанси";
$media_url       = "http://www.infostock.bg/infostock/control/finance";
$media_encode    = "true";
$media_encoding  = "Windows-1251";

$module_body     = "div[class=news-list]";
$module_article  = "article";
$module_headline = "a";

$article_body    = "div[class*=msgbody]";
$article_title   = "h2";
$article_date    = "span[class*=news_date]";
$article_author  = "";

$clean_module    =
[
  ["^(.*?)<div class=\"news-list\">", "<html><head></head><body><div class=\"news-list\">"]
, ["<c\:choose>(.*?)</c\:choose>(.*?)$", "</div></body></html>"]
, ["<div>(.*?)</div>", "<article>$1</article>"]
];

$clean_article_pre  =
[
  ["", ""]
];

$clean_article_post =
[
  ["<p class=\"snimka_comment\">(.*?)</p>", ""]
, ["<script(.*?)script>", ""]
, ["<div style=\"(.*?)\"(.*?)>(.*?)</div>", "$3"]
, ["<div id=\"httpool_contextualads\"(.*?)>(.*?)</div>", "$2"]
, [" (alt|typeof|height|width)=\"(.*?)\"", ""]
, ["<a(.*?)>(.*?)</a>", "$2"]
, ["<img(.*?)src=\"(.*?)\"(.*?)>", "<a target='_blank' href='$2'><img class='clImageThumb' src='$2'></a><br>"]
];
?>
