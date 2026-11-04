<?php
$config_enabled  = "true";
$config_type     = "link";

$media_name      = "Sciences et technologies";
$media_url       = "https://www.contrepoints.org/category/sciences-et-technologies";
$media_encode    = "false";
$media_encoding  = "";

$module_body     = "div[class*=article_ctn]";
$module_article  = "div[class=cp_mp_ctn]";
$module_headline = "div[class=cp_mp_info_ctn] h3 a";

$article_body    = "article";
$article_title   = "h1";
$article_date    = "div[class=cp_small_date]";
$article_author  = "div[class=author]";

$clean_module    =
[
  ["", ""]
];

$clean_article_pre  =
[
  ["Publié le ", ""]
, ["header>(.*?)<div class=\"author\">(.*?)</div>", "header><div class=\"author\">$2</div>$1"]
, ["<div class=\"author\">(.*?)<span>(.*?)</span>(.*?)</div>", "<div class=\"author\">$2</div>"]
, ["<div class=\"author\">(.*?)<a(.*?)>(.*?)</a(.*?)</div>", "<div class=\"author\">$3</div>"]
];

$clean_article_post =
[
  ["^(.*?)header>", ""]
, ["<div class=\"author\">(.*?)</div>", ""]
, ["<div class=\"cp_opinion_info\">(.*?)</div>", ""]
, ["<footer(.*?)$", ""]
, ["<span class=\"cesis(.*?)span>", ""]
, ["<span class=\"cp_(.*?)span>", ""]
, ["<div class=\"cp_small_date\">(.*?)</div>", ""]
, ["<p>&nbsp;(\s*?)</p>", ""]
, ["<div(.*?)>", ""]
, ["</div>", ""]
, ["<i class=\"cp_print fa-print\">(.*?)</i>", ""]
, ["<!--(.*?)-->", ""]
, ["<a(.*?)>(.*?)</a>", "$2"]
, ["<h2><b>(.*?)</b></h2>", "<h2>$1</h2>"]
];
?>
