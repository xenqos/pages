<?php
$config_enabled  = "true";
$config_type     = "link";

$media_name      = "Investing.com - Actualités";
$media_url       = "https://fr.investing.com/news/latest-news";
$media_encode    = "false";

$module_body     = "div[class*=largeTitle]";
$module_article  = "article";
$module_headline = "div a";

$article_body    = "div[class*=articlePage]";
$article_title   = "h1";
$article_date    = "div[class=contentSectionDetails] span";
$article_author  = "div[class=contentSectionDetails] a";

$clean_module    =
[
  ["<article class=\"js-article-item articleItem sponsoredArticle  \"  >", ""]
];

$clean_article_pre  =
[
  ["<span class(.*?)span>", ""]
, ["<span id(.*?)span>", ""]
, ["<span style(.*?)span>", ""]
];

$clean_article_post =
[
  ["<aside(.*?)aside>", ""]
, ["<video(.*?)video>", ""]
, ["<div class=\"align_center\">(.*?)</div>", "$1"]
, ["<div class=\"contentMediaBoxBottom(.*?)\">(.*?)</div>", ""]
, ["<div class=\"contentMediaBox(.*?)\"(.*?)>(.*?)</div>", "$3"]
, ["<h(.*?)>(.*?)</h(.*?)>", "<em>$2</em>"]
, ["<p data-id=\"(.*?)\"(.*?)>(.*?)</p>", ""]
, [" dir=\"ltr\"", ""]
, ["<a href=\"javascript(.*?)a>", ""]
, ["<div id=\"imgCarousel\"(.*?)>(.*?)</div>", "$2"]
, ["<img(.*?)src=\"(.*?)\"(.*?)>", "<a target='_blank' href='$2'><img class='clImageThumb' src='$2'></a><br>"]
];
?>
