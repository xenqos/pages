<?php
$config_enabled  = "true";
$config_type     = "link";

$media_name      = "Webcafé - Politics";
$media_url       = "https://webcafe.bg/politika";
$media_encode    = "false";
$media_encoding  = "";

$module_body     = "div[class=skeleton-left]";
$module_article  = "div[class=article]";
$module_headline = "h2 a";

$article_body    = "div[class=global-inside-article]";
$article_title   = "h1";
$article_date    = "time";
$article_author  = "";

$clean_module    =
[
  ["<source(.*?)>", ""]
, ["<picture>(.*?)</picture>", ""]
, ["<h1>(.*?)></h1>", "<h2>$1</h2>"]
, ["class=\"global-leading-article-left\"", "class=\"article\""]
, ["<div class=\"image\">(.*?)</div>", ""]
, ["<div class=\"category\">(.*?)</div>", ""]
, ["\"article(.*?)\"", "\"article\""]
, ["<script(.*?)script>", ""]
, ["<a(.*?)a>", "<h2><a$1a></h2>"]
];

$clean_article_pre  =
[
  ["", ""]
];

$clean_article_post =
[
  ["^(.*?)time>", ""]
, ["<source(.*?)>", ""]
, ["^(.*?)</span>", ""]
, ["^(.*?)</div>", ""]
, ["^(.*?)</div>", ""]
, ["<meta(.*?)>", ""]
, ["<script(.*?)script>", ""]
, [" (alt|title|width|height|itemprop|itemscope|itemtype)=\"(.*?)\"", ""]
, ["<strong(.*?)>(.*?)</strong>", "$2"]
, ["<b>(.*?)</b>", "$2"]
, ["<div id=\"gpt-banner-incontent\" >(.*?)</div>", ""]
, ["<span class=\"copyright\">(.*?)</span>", ""]
, ["<span class=\"description\"(.*?)>(.*?)</span>", "$2<br><br>"]
, ["<picture>(.*?)</picture>", "$1"]
, ["<div class=\"image\">(.*?)</div>", "$1"]
, ["<div class=\"photo\"   >(.*?)</div>", "$1"]
, ["<div(.*?)>", ""]
, ["</div>", ""]
, [" (alt|title|width|height|itemprop)=\"(.*?)\"", ""]
, ["class=\"(.*?)\"", ""]
, ["<video(.*?)video>", ""]
, ["<a(.*?)>(.*?)<img(.*?)>(.*?)</a>", "<img$3>"]
, ["<a(.*?)>(.*?)</a>", "$2"]
, ["<img(.*?)src=\"(.*?)\"(.*?)>", "<br><a target='_blank' href='$2'><img class='clImageThumb' src='$2'></a><br>"]
, ["^(\s*?)<br>", ""]
];
?>
