<?php
$config_enabled  = "true";
$config_type     = "link";

$media_name      = "The Telegraph - Defence";
$media_url       = "https://www.telegraph.co.uk/news/defence/";
$media_encode    = "false";
$media_encoding  = "";

$module_body     = "main";
$module_article  = "article";
$module_headline = "h2 a";

$article_body    = "article";
$article_title   = "h1";
$article_date    = "time";
$article_author  = "span[class=e-byline__author]";

$clean_module    =
[
  ["", ""]
];

$clean_article_pre  =
[
  [", </span>", "</span>"]
];

$clean_article_post =
[
  ["<div class=\"tpl-article__end-meta\">(.*)$", ""]
, ["<meta(.*?)>", ""]
, ["<source(.*?)>", ""]
, ["<svg(.*?)svg>", ""]
, ["<button(.*?)button>", ""]
, ["<h1(.*?)h1>", ""]
, ["<time(.*?)time>", ""]
, ["<header(.*?)>(.*?)</header>", "$2"]
, ["<span class=\"e-byline__bytext\">(.*?)</span>", ""]
, ["<span(.*?)e-byline__author(.*?)</span>", ""]
, ["<span(.*?)jobTitle(.*?)</span>", ""]
, ["<span(.*?)>(.*?)</span>", "$2"]
, ["<span(.*?)>(.*?)</span>", "$2"]
, ["<figcaption(.*?)>(.*?)</figcaption>", "$2<br><br>"]
, ["<figure(.*?)>(.*?)</figure>", "$2"]
, ["<picture(.*?)>(.*?)</picture>", "$2"]
, ["<script(.*?)script>", "$2"]
, ["</span>", ""]
, ["<span(.*?)>", ""]
, ["<a(.*?)>(.*?)</a>", "$2"]
, ["</div>", ""]
, ["<div(.*?)>", ""]
, ["<noscript>(.*?)</noscript>", "$1"]
, [" (class|itemprop|data-test)=\"(.*?)\"", ""]
, ["<aside(.*?)>", ""]
, ["</aside>", ""]
, ["<a(.*?)>", ""]
, ["</a>", ""]
, ["<img(.*?)src=\"(.*?)\"(.*?)>", "<br><a target='_blank' href='$2'><img class='clImageThumb' src='$2'></a><br>"]
, ["\?imwidth(.*?)'", "'"]
];
?>
