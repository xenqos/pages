<?php
$config_enabled  = "true";
$config_type     = "link";

$media_name      = "Slate.fr - Sciences";
$media_url       = "http://www.slate.fr/sciences/";
$media_encode    = "false";
$media_encoding  = "";

$module_body     = "div[class=articles-wrapper]";
$module_article  = "div[class^=article-list__content]";
$module_headline = "p a";

$article_body    = "article";
$article_title   = "h1";
$article_date    = "time";
$article_author  = "a[class=author]";

$clean_module    =
[
  ["", ""]
];

$clean_article_pre  =
[
  ["", ""]
];

$clean_article_post =
[
  ["^(.*?)article-content-wrapper(.*?)>", ""]
, ["<div class=\"tags-container(.*)$", ""]
, ["<form(.*)form>", ""]
, ["<p class=\"article-infos(.*?)p>", ""]
, ["<span class=\"caption-picture\">(.*?)</span>", "$1<br><br>"]
, ["<figure(.*?)>(.*?)</figure>", "$2"]
, ["<figcaption(.*?)>(.*?)</figcaption>", "$2"]
, ["<div class=\"element clearfix\">(.*?)</div>", ""]
, ["</div>", ""]
, ["<div(.*?)>", ""]
, ["<a(.*?)>(.*?)</a>", "$2"]
, ["src=\"data:(.*?)\"", ""]
, ["<img draggable=\"true\"(.*?)>", ""]
, ["<img(.*?)src=\"(.*?)\"(.*?)>", "<a target='_blank' href='$2'><img class='clImageThumb' src='$2'></a><br>"]
];
?>
