<?php
$config_enabled  = "true";
$config_type     = "link";

$media_name      = "Reuters - News Europe";
$media_url       = "https://www.reuters.com/world/europe/";
$media_encode    = "false";
$media_encoding  = "";

$module_body     = "main";
$module_article  = "h3";
$module_headline = "a";

$article_body    = "main";
$article_title   = "h1";
$article_date    = "time";
$article_author  = "a[class^=author-name]";

$clean_module    =
[
  ["^(.*)</head>", "<html><head></head>"]
, ["<path(.*?)</path>", ""]
, ["<svg(.*?)</svg>", ""]
, ["<script(.*?)</script>", ""]
, ["<noscript(.*?)</noscript>", ""]
, [" data-testid=\"(.*?)\"", ""]
];

$clean_article_pre  =
[
  ["<script(.*?)script>", ""]
, ["<!--(.*?)-->", ""]
, ["<script(.*?)script>", ""]
, ["Last Updated(.*?)ago", ""]
, ["(\d+) minute read", ""]
, ["<span(.*?)>(.*?)</span>", "<span>$2</span>"]
, ["<span></span>", ""]
, ["<span>(.*?)</span>", "$1&emsp;"]
];

$clean_article_post =
[
  ["<noscript(.*?)>(.*?)</noscript>", "$2"]
, ["<svg(.*?)>(.*?)</svg>", ""]
, ["<path(.*?)>(.*?)</path>", ""]
, ["<button(.*?)>(.*?)</button>", ""]
, ["^(.*?)</header>", ""]
, ["<div class=\"context-widget(.*?)\"(.*?)>(.*?)</div>", ""]
, ["<li class=\"toolbar-item(.*?)\"(.*?)>(.*?)</li>", ""]
, ["<ul class=\"toolbar-item(.*?)\"(.*?)>(.*?)</ul>", ""]
, ["<p(.*?)>(.*?)</p>", "<p>$2</p>"]
, ["<h2(.*?)>(.*?)</h2>", "<h2>$2</h2>"]
, ["<h3(.*?)>(.*?)</h3>", "<h3>$2</h3>"]
, ["<h2>Read Next(.*)$", ""]
, ["read more", ""]
, ["<p>Our Standards(.*)$", ""]
, ["<span(.*?)>Reporting(.*?)</span>", ""]
, [">Reporting by(.*?)</div>", "></div"]
, ["</div>", ""]
, ["<div(.*?)>", ""]
, ["<b>\[(.*?)</b>", ""]
, ["<figcaption(.*?)>(.*?)</figcaption>", "$2<br><br>"]
, ["<figure(.*?)>(.*?)</figure>", "$2"]
, ["<a(.*?)>(.*?)</a>", "$2"]
, ["<img(.*?)src=\"(.*?)\"(.*?)>", "<a target='_blank' href='$2'><img class='clImageThumb' src='$2'></a><br>"]
];
?>
