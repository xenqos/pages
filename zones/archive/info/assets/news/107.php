<?php
$config_enabled  = "true";
$config_type     = "link";

$media_name      = "ScienceAlert - Society";
$media_url       = "https://www.sciencealert.com/society";
$media_encode    = "false";
$media_encoding  = "";

$module_body     = "section[class=col-span-container]";
$module_article  = "article";
$module_headline = "div[class=entry-teaser] a";

$article_body    = "section[class=col-span-container]";
$article_title   = "h1";
$article_date    = "span[class^=article-date]";
$article_author  = "div[class*=author-details] a span";

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
  ["^(.*?)<div class=\"w-full h-auto featured-image\">", "<div>"]
, ["<script(.*?)script>", ""]
, ["<figcaption(.*?)>(.*?)</figcaption>", "$2<br><br>"]
, ["<figure(.*?)>(.*?)</figure>", "$2"]
, ["</article>(.*)$", ""]
, ["</div>", ""]
, ["<div(.*?)>", ""]
, ["<a(.*?)>(.*?)</a>", "$2"]
, ["<span class=\"ccfic-source\">(.*?)</span>", "$1"]
, ["<span class=\"ccfic-text\">(.*?)</span>", "$1"]
, ["</span>", ""]
, ["<span(.*?)>", ""]
, [" (width|height|alt|loading|srcset|sizes|class)=\"(.*?)\"", ""]
, ["src=\"https(.*?)-(\d+)x(\d+)\.jpg\"", "src=\"https$1.jpg\""]
, ["<img(.*?)src=\"(.*?)\"(.*?)>", "<a target='_blank' href='$2'><img class='clImageThumb' src='$2'></a><br>"]
];
?>
