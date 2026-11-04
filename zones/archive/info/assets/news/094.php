<?php
$config_enabled  = "true";
$config_type     = "link";

$media_name      = "LiveScience - Planet Earth";
$media_url       = "https://www.livescience.com/planet-earth";
$media_encode    = "false";
$media_encoding  = "";

$module_body     = "div[id=content]";
#$module_article  = "div[class=article-link]";
$module_article  = "div[class^=listingResult small result]";
$module_headline = "header h3";

$article_body    = "article";
$article_title   = "h1";
$article_date    = "time";
$article_author  = "span[class=author-byline__author-name] a";

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
  ["^(.*?)<p class=\"strapline\">", "<p class='strapline'>"]
, ["<meta(.*?)>", ""]
, ["<svg(.*?)svg>", ""]
, ["<path(.*?)path>", ""]
, ["<nav(.*?)nav>", ""]
, ["<script(.*?)script>", ""]
, ["<source(.*?)source>", ""]
, ["<aside(.*?)aside>", ""]
, ["<footer(.*)$", ""]
, ["<figcaption(.*?)>(.*?)</figcaption>", "$2<br><br>"]
, ["<figure(.*?)>(.*?)</figure>", "$2"]
, ["<picture(.*?)>(.*?)</picture>", "$2"]
, ["<div id=\"slice-container-authorBio\"(.*)$", ""]
, ["<section(.*?)>", ""]
, ["</header>", ""]
, ["</div>", ""]
, ["<div(.*?)>", ""]
, ["</span>", ""]
, ["<span(.*?)>", ""]
, ["<a(.*?)>(.*?)</a>", "$2"]
, ["</u>", ""]
, ["<u>", ""]
, ["<button(.*?)button>", ""]
, ["\"navigate right\">", ""]
, [" (src|class|style|alt|onerror|data-normal|data-sizes|sizes)=\"(.*?)\"", ""]
, [" (data-original-mos|data-pin-media|)=\"(.*?)\"", ""]
, ["data-srcset=", "srcset="]
, ["srcset=", "src="]
, ["src=\"https(.*?)\.jpg(.*?)\"", "src=\"https$1.jpg\""]
, [" src=\"(.*?)jpg(.*?)\"", " src=\"$1jpg\""]
, [" src=\"(.*?)jpeg(.*?)\"", " src=\"$1jpeg\""]
, [" src=\"(.*?) (.*?)\"", " src=\"$1\""]
, ["src=\"https(.*?)-(\d+)-(\d+)\.jpg(.*?)\"", "src=\"https$1.jpg\""]
, ["<img(.*?)src=\"(.*?)\"(.*?)>", "<a target='_blank' href='$2'><img class='clImageThumb' src='$2'></a><br>"]
];
?>
