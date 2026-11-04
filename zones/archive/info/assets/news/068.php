<?php
$config_enabled  = "true";
$config_type     = "link";

$media_name      = "Тechnews.bg - Page 5";
$media_url       = "https://technews.bg/article-category/news/page/5";
$media_encode    = "false";
$media_encoding  = "";

$module_body     = "div[id=content]";
$module_article  = "article";
$module_headline = "header h2 a";

$article_body    = "article";
$article_title   = "h1";
$article_date    = "span[class*=date time published]";
$article_author  = "";

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
  ["\t", "  "]
, ["<header(.*?)header>", ""]
, [" (alt|title|width|height|itemprop)=\"(.*?)\"", ""]
, ["class=\"size-full wp-image-(\d*?)\"", ""]
, ["<\!--(.*?)-->", ""]
, ["<div style=\"clear:both;\">(.*?)</div>", ""]
, ["<footer(.*?)>(.*?)</footer>", ""]
, ["<script(.*?)script>", ""]
, ["<aside id=\"custom_(.*)", ""]
, ["class=\"wp-caption-text\">", ""]
, ["<div id=\"attachment_(.*?)\"(.*?)>(.*?)</div>", "$3"]
, ["<div id=\"related-posts-(.*?)\">(.*?)</div>", ""]
, ["<div class=\"related-posts\">(.*?)</div>", ""]
, ["<div class=\"entry-content\">", ""]
, ["<ins(.*?)ins>", ""]
, ["<br />(\s*?)<br />", "<br>"]
, ["<p>(\s*?)<br>(\s*?)</p>", ""]
, ["<aside(.*?)aside>", ""]
, ["<div class=\"widget-wrap\">(.*)$", ""]
, ["<a(.*?)>", ""]
, [" (src|srcset)=\"(.*?)\"", ""]
, [" data-lazy-src=", "src="]
, ["<img(.*?)src=\"(.*?)\"(.*?)>", "<a target='_blank' href='$2'><img class='clImageThumb' src='$2'></a><br>"]
];
?>
