<?php
$config_enabled  = "true";
$config_type     = "link";

$media_name      = "AltEco - Monnaie";
$media_url       = "https://www.alternatives-economiques.fr/thematiques/monnaie";
$media_encode    = "false";
$media_encoding  = "";

$module_body     = "main";
$module_article  = "article[class=o-teaser c-article]";
$module_headline = "header h3 span";

$article_body    = "body";
$article_title   = "h1";
$article_date    = "time span";
$article_author  = "div[class=o-page__content__who]";

$clean_module    =
[
  ["<!--(.*?)-->", ""]
, ["<script(.*?)script>", ""]
, ["<noscript(.*?)noscript>", ""]
, ["<meta(.*?)>", ""]
, ["<link(.*?)>", ""]
, ["<span class=\"o-teaser__sticker\">(.*?)</span>", ""]
, ["<source(.*?)>", ""]
];

$clean_article_pre  =
[
  ["<!--(.*?)-->", ""]
, ["<script(.*?)script>", ""]
, ["<noscript(.*?)noscript>", ""]
];

$clean_article_post =
[
  ["^(.*?)<div class=\"o-page__content__body\">", ""]
, ["<div class=\"o-page__footer\">(.*)$", ""]
, ["<li class=\"c-social__item\">(.*?)</li>", ""]
, ["<ul class=\"c-social\">(.*?)</ul>", ""]
, ["<div id=\"social-share\"(.*?)>(.*?)</div>", ""]
, ["<div class=\"o-page__content__who\">(.*?)</div>", ""]
, ["<span class=\"o-page__figure__sticker\">(.*?)</span>", ""]
, ["<span class=\"o-page__spacer\">(.*?)</span>", ""]
, ["<article class=\"c-kiosk--single\">(.*?)</article>", ""]
, ["<source(.*?)>", ""]
, ["<figcaption(.*?)>(.*?)</figcaption>", ""]
, ["<figure(.*?)>(.*?)</figure>", "$2"]
, ["<picture(.*?)>(.*?)</picture>", "$2"]
, ["<strong>Retrouvez les articles(.*)$", ""]
, ["</div>", ""]
, ["<div(.*?)>", ""]
, ["<a(.*?)>(.*?)</a>", "$2"]
, ["<img(.*?)src=\"(.*?)\"(.*?)>", "<a target='_blank' href='$2'><img class='clImageThumb' src='$2'></a><br>"]
];
?>
