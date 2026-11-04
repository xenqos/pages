<?php
$config_enabled  = "true";
$config_type     = "link";

$media_name      = "БTA - Икономика";
$media_url       = "https://bta.bg/bg/news/economy";
$media_encode    = "false";
$media_encoding  = "";

$module_body     = "div[class=post-list row]";
$module_article  = "article";
$module_headline = "h3 a";

$article_body    = "div[class=post a11y-content]";
$article_title   = "h1";
$article_date    = "div[class=post__post]";
$article_author  = "div[class=post__author]";

$clean_module    =
[
  ["<small(.*?)>(.*?)</small>", "$2"]
];

$clean_article_pre  =
[
  ["<span class=\"visually-hidden\">(.*?)</span>", ""]
];

$clean_article_post =
[
  ["<h1(.*?)</h1>", ""]
, ["<div class=\"share-widget(.*?)$", ""]
, ["<div class=\"post__meta-tags(.*?)</div>", ""]
, ["<div class=\"post__meta-panel(.*?)</div>", ""]
, ["<div class=\"post__sources(.*?)</div>", ""]
, ["<div class=\"post__post(.*?)</div>", ""]
, ["<div class=\"post__place(.*?)</div>", ""]
, ["<div class=\"post__author(.*?)</div>", ""]
, ["<div class=\"u-image-blur\">(.*?)</div>", ""]
, ["<div(.*?)>", ""]
, ["</div>", ""]
#, ["<small(.*?)>(.*?)</small>", "$2"]
#, ["<small class=\"text-muted(.*?)</small>", ""]
, ["<small class=\"text-muted d-block my-2\">(.*?)</small>", "$1<br><br>"]
, ["<a(.*?)>(.*?)</a>", "$2"]
, ["data-src=", "src="]
, ["<img(.*?)src=\"(.*?)\"(.*?)>", "<a target='_blank' href='$2'><img class='clImageThumb' src='$2'></a><br>"]
];
?>
