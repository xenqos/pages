<?php
$config_enabled  = "true";
$config_type     = "link";

$media_name      = "Boursorama - Actualité";
$media_url       = "https://www.boursorama.com/actualite-economique/";
$media_encode    = "false";

$module_body     = "div[class=c-list-details-news]";
$module_article  = "li[class*=c-list-details-news__line]";
$module_headline = "a[class*=c-list-details-news__subject]";

$article_body    = "div[class*=c-news-detail]";
$article_title   = "h1";
$article_date    = "span[class*=c-source__time]";
$article_author  = "strong[class*=c-source__name]";

$clean_module    =
[
  ["", ""]
];

$clean_article_pre  =
[
  ["<h1(.*?)>(.*?)<div(.*?)>(.*?)</div>", "<h1>$2</h1><div$3>$4</div>"]
];

$clean_article_post =
[
  ["(.*?)h1>", ""]
, ["<ul class=\"c-toolbar-sharing__list(.*?)</ul>", ""]
, ["<div class=\"o-vertical-interval-bottom\"></div>", ""]
, ["<picture(.*?)>(.*?)</picture>", "$2"]
, ["<div class=\"c-image-news\">(.*?)</div>", "$1"]
, ["<source(.*?)>", ""]
, ["<div(.*?)>", ""]
, ["</div>", ""]
, ["<img(.*?)src=\"(.*?)\"(.*?)>", "<a target='_blank' href='./image-server.php?varImageUrl=$2'><img class='clImageThumb' src='./image-server.php?varImageUrl=$2'></a><br>"]
, ["<h2(.*?)>(.*?)</h2>", "<p><b>$2</b></p>"]
, ["<p class=\"c-image-news__legend\">(.*?)</p>", "<p><i>$1</i></p>"]
];
?>
