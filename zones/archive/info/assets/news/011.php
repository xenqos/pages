<?php
$config_enabled  = "true";
$config_type     = "link";

$media_name      = "Mediapool - България ";
$media_url       = "https://www.mediapool.bg/bulgaria-cat2.html";
$media_encode    = "false";
$media_encoding  = "";

$module_body     = "main[id=anchor-main-content]";
$module_article  = "article";
$module_headline = "h2";

$article_body    = "article";
$article_title   = "h1";
$article_date    = "time";
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
  ["^(.*?)<figure class=\"c-figure\">", "<figure class=\"c-figure\">"]
, ["<div class=\"c-share-widget(.*)$", ""]
, ["<script(.*?)script>", ""]
, ["<button(.*?)>(.*?)</button>", ""]
, ["<figcaption(.*?)>(.*?)</figcaption>", "$2<br><br>"]
, ["<figure(.*?)>(.*?)</figure>", "$2"]
, ["<!--(.*?)-->", ""]
, ["<div(.*?)>", ""]
, ["</div>", ""]
, ["<a(.*?)>(.*?)</a>", "$2"]
, ["<img(.*?)src=\"(.*?)\"(.*?)>", "<a target='_blank' href='$2'><img class='clImageThumb' src='$2'></a><br>"]
];
?>
