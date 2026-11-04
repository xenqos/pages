<?php
$config_enabled  = "true";
$config_type     = "link";

$media_name      = "Cointelegraph - Regulation";
$media_url       = "https://cointelegraph.com/tags/regulation";
$media_encode    = "false";
$media_encoding  = "";

$module_body     = "ul[class=posts-listing__list]";
$module_article  = "li[class=posts-listing__item]";
$module_headline = "span[class=post-card-inline__title]";

$article_body    = "article";
$article_title   = "h1";
$article_date    = "time";
$article_author  = "div[class=post-meta__author-name]";

$clean_module    =
[
  ["<script(.*?)script>", ""]
, ["<style(.*?)style>", ""]
];

$clean_article_pre  =
[
  ["<script(.*?)script>", ""]
, ["<style(.*?)style>", ""]
];

$clean_article_post =
[
  ["^(.*?)</h1>", ""]
, ["<p class=\"post-content__disclaimer\">(.*)$", ""]
, [" data-v-.{8}", ""]
, ["<div class=\"post-actions__item post-actions__item_stat\">(.*?)</div>", ""]
, [" post-id=\"(.*?)\"", ""]
, ["<div class=\"post-audio-player\">(.*?)</div>", ""]
, ["<audio(.*?)audio>", ""]
, ["<div class=\"post-actions__item post-actions__item_audio\">(.*?)</div>", ""]
, ["<div class=\"post-actions post__block post__block_post-actions\">(.*?)</div>", ""]
, ["<source(.*?)>", ""]
, ["<svg(.*?)svg>", ""]
, ["<path(.*?)path>", ""]
, ["<img src=\"data(.*?)\">", ""]
, ["<div class=\"(mint_nft__icon|mint_nft__text|mint_nft__button)\">(.*?)</div>", ""]
, ["<span hidden=\"hidden\"(.*?)span>", ""]
, ["<span class=\"pending__runner\">(.*?)</span>", ""]
, ["<span class=\"pending lazy-image__pending pending_dark\">(.*?)</span>", ""]
, ["(<|</)picture>", ""]
, ["<\!--(.*?)-->", ""]
, [" srcset=\"(.*?)\"", ""]
, ["<a(.*?)>(.*?)</a>", "$2"]
, ["<figcaption(.*?)>(.*?)</figcaption>", "$2<br><br>"]
, ["<figure(.*?)>(.*?)</figure>", "$2"]
, ["<strong>follow this link(.*?)strong>", ""]
, ["<strong>Click “Collect(.*?)strong>", ""]
, ["<strong>Related:(.*?)strong>", ""]
, ["<blockquote class=\"twitter-tweet\">(.*?)</blockquote>", ""]
, ["<script(.*?)script>", ""]
, ["<ul class=\"tags-list__list\">(.*?)</ul>", ""]
, ["<div class=\"related-list__title\">(.*?)</div>", ""]
, ["<ul class=\"related-list__list\">(.*?)</ul>", ""]
, ["<p>Disclaimer(.*?)p>", ""]
, ["</span>", ""]
, ["<span(.*?)>", ""]
, ["<div(.*?)>", "<div>"]
, ["<div>Learn more about(.*?)div>", ""]
, ["</div>", ""]
, ["<div(.*?)>", ""]
, ["<img(.*?)src=\"(.*?)\"(.*?)>", "<a target='_blank' href='$2'><img class='clImageThumb' src='$2'></a><br>"]
];
?>
