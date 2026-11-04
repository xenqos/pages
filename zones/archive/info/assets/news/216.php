<?php
$config_enabled  = "true";
$config_type     = "link";

$media_name      = "Money.bg - Панорама";
$media_url       = "https://money.bg/panorama";
$media_encode    = "false";
$media_encoding  = "";


$module_body     = "div[class=inner-page]";
$module_article  = "div[class=topic]";
$module_headline = "div[class=topic-information] h2";

$article_body    = "article";
$article_title   = "h1";
$article_date    = "p[class=time]";
$article_author  = "";

$clean_module    =
[
  ["<img(.*?)>", ""]
, ["<p(.*?)>(.*?)</p>", ""]
, ["<div class=\"big-ribbon\">(.*?)</div>", ""]
, ["class=\"main-news\"", "class=\"topic\""]
, ["class=\"news-info\"", "class=\"topic-information\""]
, ["<h2>(\s*?)<a(.*?)>(.*?)</a>(\s*?)</h2>", "<h2>$3</h2>"]
];

$clean_article_pre  =
[
  ["", ""]
];

$clean_article_post =
[
  ["(.*)/header>", ""]
, ["<div class=\"topic-sliders(.*)$", ""]
, ["<meta(.*?)>", ""]
, ["(alt|itemprop)=\"(.*?)\"", ""]
, ["class=\"(thumb|title)\"", ""]
, ["<div class=\"source-ribbon\">(.*?)</div>", ""]
, ["<div class=\"btn\">(.*?)</div>", ""]
, ["<div class=\"btn rate\"(.*?)>(.*?)</div>", ""]
, ["<strong>(.*?)</strong>", "$1"]
, ["<div id=\"gpt-banner-1-tablet\">(.*?)</div>", ""]
, ["<div class=\"banner-1\">(.*?)</div>", ""]
, ["<div class=\"banners tablet-banners\">(.*?)</div>", ""]
, ["<div class=\"social-links\">(.*?)</div>", ""]
, ["<div id=\"gpt-banner-11\">(.*?)</div>", ""]
, ["<div class=\"img\"(.*?)>(.*?)</div>", "$2"]
, ["<div class=\"img-wrapper\">(.*?)</div>", "$1"]
, ["<div class=\"img-or-video img-gallery\">(.*?)</div>", "$1"]
, ["<div class=\"small-ribbon\">(.*?)</div>", ""]
, ["<div class=\"md-thumb\">(.*?)</div>", ""]
, ["<div class=\"reference-article\">(.*?)</div>", ""]
, ["<div class=\"editors-choice\"(.*)", ""]
, ["<ul class=\"tags\"(.*?)> (.*)", ""]
, ["<img(.*?)src=\"(.*?)\"(.*?)>", "<a target='_blank' href='$2'><img class='clImageThumb' src='$2'></a><br>"]
];
?>
