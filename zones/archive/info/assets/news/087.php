<?php
$config_enabled  = "true";
$config_type     = "link";

$media_name      = "The Spectator - World";
$media_url       = "https://www.spectator.co.uk/category/international";
$media_encode    = "false";
$media_encoding  = "";

$module_body     = "section[class^=entry-container]";
$module_article  = "article";
$module_headline = "h3 a";

$article_body    = "body";
$article_title   = "h1";
$article_date    = "time";
$article_author  = "span[class=writers-link__text]";

$clean_module    =
[
  ["<script(.*?)script>", ""]
, ["<noscript(.*?)noscript>", ""]
, ["<img(.*?)>", ""]
, ["<a class=\"article__author(.*?)>(.*?)</a>", ""]
, ["<a class=\"article__image-link(.*?)>(.*?)</a>", ""]
];

$clean_article_pre  =
[
  ["<script(.*?)script>", ""]
, ["<noscript(.*?)noscript>", ""]
];

$clean_article_post =
[
  ["^(.*?)<main", "<main"]
, ["<footer(.*)$", ""]
, ["<", "\n<"]
, ["\t", " "]
, ["<section(\s+)class=\"subscription-banner(.*?)</section>", ""]
, ["<section id=\"subscribe-ribbon(.*?)</section>", ""]
, ["<div class=\"insert__content(.*?)</div>", ""]
, ["<div id=\"most-popular(.*?)</div>", ""]
, ["<nav(.*?)</nav>", ""]
, ["<div class=\"entry-header__heading container(.*?)</div>", ""]
, ["<ul class=\"tooltip-settings__list(.*?)</ul>", ""]
, ["<ul class=\"entry-meta(.*?)</ul>", ""]
, ["<ul class=\"related-books(.*?)</ul>", ""]
, ["<figcaption>(.*?)</figcaption>", "$1<br><br>"]
, ["<figure(.*?)>(.*?)</figure>", "$2"]
, ["<a(.*?)>(.*?)</a>", "$2"]
, ["<img(.*?)src=\"(.*?)\"(.*?)>", "<a target='_blank' href='$2'><img class='clImageThumb' src='$2'></a><br>"]
];
?>