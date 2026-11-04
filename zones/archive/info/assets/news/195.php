<?php
$config_enabled  = "true";
$config_type     = "link";

$media_name      = "Investing.com - News Economy";
$media_url       = "https://www.investing.com/news/economy";
$media_encode    = "false";
$media_encoding  = "";

$module_body     = "div[class=largeTitle]";
$module_article  = "article div[class=textDiv]";
$module_headline = "a[class=title]";

$article_body    = "section[id=leftColumn]";
$article_title   = "h1";
$article_date    = "time";
$article_author  = "a[class^=class=author-name]";

$clean_module    =
[
  ["", ""]
];

$clean_article_pre  =
[
  ["<div class=\"contentSectionDetails\">(.*?)</div>", "<time>$1</time>"]
, ["<time>(\s*)<i>(.*?)</i>(.*?)</time>", "<time>$3</time>"]
, ["<time>(\s*)<a(.*?)</a>(.*?)</time>", "<time>$3</time>"]
];

$clean_article_post =
[
  ["<!--(.*?)-->", ""]
, ["<script(.*?)script>", ""]
, ["<form(.*?)form>", ""]
, ["^(.*?)<div class=\"WYSIWYG articlePage\">", "<div>"]
, ["<div class=\"articleFooter(.*)$", ""]
, ["<div id=\"floatingH1(.*)$", ""]
, [" dir=\"ltr\"", ""]
, ["<a(.*?)>(.*?)</a>", "$2"]
, ["<label(.*?)>(.*?)</label>", ""]
, ["<input(.*?)>", ""]
, ["<i (.*?)>(.*?)</i>", ""]
, ["<span>(\d+)/(\d+)(\s*)</span>", ""]
, ["<u>(\s*)</u>", ""]
, ["<div class=\"name\"(.*?)>(.*?)</div>", ""]
, ["<div class=\"percent(.*?)\"(.*?)>(.*?)</div>", ""]
, ["<div class=\"shortInfo\"(.*?)>(.*?)</div>", ""]
, ["<div class=\"star\"(.*?)>(.*?)</div>", ""]
, ["<div class=\"(clear|header)\"(.*?)>(.*?)</div>", ""]
, ["<div class=\"portfolioIcon(.*?)>(.*?)</div>", ""]
, ["<div class=\"iconContainer(.*?)>(.*?)</div>", ""]
, ["<div class=\"loading-responsive(.*?)>(.*?)</div>", ""]
, ["<div style(.*?)>(.*?)</div>", ""]
, ["<div class=\"content reply(.*?)>(.*?)</div>", ""]
, ["<div class=\"portfolioRows(.*?)>(.*?)</div>", ""]
, ["<div class=\"js-btn(.*?)>(.*?)</div>", ""]
, ["<div class=\"content js-forms(.*?)>(.*?)</div>", ""]
, ["<div class=\"footer\">(.*?)</div>", ""]
, ["<div class=\"tooltipPopup(.*?)>(.*?)</div>", ""]
, ["<div class=\"addToPortWrapper(.*?)>(.*?)</div>", ""]
, ["<div class=\"headBtnWrapper(.*?)>(.*?)</div>", ""]
, ["<div class=\"addToWatchlist\">(.*?)</div>", ""]
, ["<div class=\"instrumentBox(.*?)>(.*?)</div>", ""]
, ["<div class=\"slider(.*?)>(.*?)</div>", ""]
, ["<div class=\"relatedInstruments(.*?)>(.*?)</div>", ""]
, ["<span class=\"aqPopupWrapper(.*?)>(.*?)</span>", "$2"]
, ["<span (itemscope|itemprop)(.*?)>", ""]
, ["</span>", ""]
, ["<span(.*?)>", ""]
, [" (alt|style|onclick)=\"(.*?)\"", ""]
, ["</div>", ""]
, ["<div(.*?)>", ""]
, ["<img(.*?)src=\"(.*?)\"(.*?)>", "<a target='_blank' href='$2'><img class='clImageThumb' src='$2'></a><br>"]
];
?>
