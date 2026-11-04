<?php
$config_enabled  = "true";
$config_type     = "link";

$media_name      = "Moreto.net - Page 5";
$media_url       = "http://www.moreto.net/novini.php?p=4";
$media_encode    = "true";
$media_encoding  = "Windows-1251";

$module_body     = "table[id=module]";
$module_article  = "td[class=t2]";
$module_headline = "div[class=t3] b";

$article_body    = "table[id=article]";
$article_title   = "h1 b";
$article_date    = "div[style=float: left; width: 300px;] i";
$article_author  = "";

$clean_module    =
[
  ["<table width=\"470\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">", "<table id=\"module\">"]
, ["href=\"\?n=", "href=\"/novini.php?n="]
];

$clean_article_pre  =
[
  ["<table width=100% border=0 cellspacing=0 cellpadding=0 align=center>", "<table id=\"article\">"]
];

$clean_article_post =
[
  ["</pp>(.*)", "</pp>"]
, ["<span id=VoteAjax(N|Y)>(.*?)</span>", ""]
, ["(.*)</h1>", ""]
, ["<div class=\"fb-like\"(.*?)div>", ""]
, ["<a href=\"javascript(.*?)a>", ""]
, ["<div align=left>(.*?)div>", ""]
, ["<div style=\"height(.*?)div>", ""]
, ["<div style=\"float(.*?)div>", ""]
, ["<div class=t3(.*?)div>", ""]
, ["<div>(.*?)</div>", "$1"]
, ["<iframe(.*?)iframe>", ""]
, ["<pp>(.*?)</pp>", "$1"]
, ["<h2>(.*?)</h2>", "$1"]
, ["<i>(.*?)</i>", "$1"]
, ["<img(.*?)>(.*?)</div>", "<img$1>"]
, ["<p class=t3 align=justify>", ""]
, ["href=\"novini\.php(.*?)\"", "href=\"./news.php?varAction=article&varId={$id}&varName=&varUrl=http://www.moreto.net/novini.php$1\""]
, ["src=\"", "src=\"http://www.moreto.net/"]
, ["http://www\.moreto\.net/http", "http"]
, ["</div>", ""]
, ["<img(.*?)src=\"(.*?)\"(.*?)>", "<a target='_blank' href='$2'><img class='clImageThumb' src='$2'></a><br>"]
];
?>
