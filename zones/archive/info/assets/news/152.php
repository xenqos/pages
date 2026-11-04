<?php
$config_enabled  = "true";
$config_type     = "link";

$media_name      = "Dreuz.info - Amérique";
$media_url       = "https://www.dreuz.info/category/etats-unis/";
$media_encode    = "false";
$media_encoding  = "";

$module_body     = "div[class=post_area]";
$module_article  = "div[class=post]";
$module_headline = "h2 a";

$article_body    = "div[class=main]";
$article_title   = "div[class=singlepage-title] a";
$article_date    = "div[class=author]";
$article_author  = "div[class=date]";

$clean_module    =
[
  ["", ""]
];

$clean_article_pre  =
[
  ["<div class=\"author\">(.*?)<a(.*?)>(.*?)</a>(.*?)</div>", "<div class=\"author\">$3</div><div class=\"date\">$4</div>"]
];

$clean_article_post =
[
  ["<div class=\"wp-container(.*?)>(.*?)</div>", ""]
, ["<form(.*?)>(.*?)</form>", ""]
, ["<div class=\"wp-block-image\">(.*?)</div>", ""]
, ["<div class=\"wp-block-media-text__content\">(.*?)</div>", ""]
, ["<div class=\"wp-block-media-text(.*?)>(.*?)</div>", ""]
, ["<aside(.*?)>(.*?)</aside>", ""]
, ["<div class=\"mailpoet_form_popup_overlay\">(.*)$", ""]
, ["^(.*?)<div class=\"content-single\">", "<div class=\"content-single\">"]
, ["<div class=\"tags\">(.*)$", ""]
, ["<em>Parce que Dreuz est(.*?)</em>", ""]
, ["<p class=\"has-vivid-red-color has-text-color has-medium-font-size\">(.*?)</p>", ""]
, ["<span class=\"has-inline-color has-vivid-red-color\">(.*?)</span>", ""]
, ["<h(2|3) class=\"has-text-align-left\">(.*?)</h(2|3)>", "$2"]
, ["<strong>(.*?)</strong>", "$1"]
, ["<figure(.*?)>(.*?)</figure>", "$2"]
, [" (loading|width|height|alt|srcset|sizes|class)=\"(.*?)\"", ""]
, ["<a(.*?)>(.*?)</a>", "$2"]
, ["<img(.*?)src=\"(.*?)\"(.*?)>", "<a target='_blank' href='$2'><img class='clImageThumb' src='$2'></a><br>"]
, ["<div(.*?)>", ""]
, ["</div>", ""]
, ["<!-- Composite Start -->(.*?)<!-- Composite End -->", ""]
];
?>
