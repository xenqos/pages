<?php
$config_enabled  = "true";
$config_type     = "link";

$media_name      = "The Conversation - Science";
$media_url       = "https://theconversation.com/fr/technologie";
$media_encode    = "false";
$media_encoding  = "";

$module_body     = "div[class=wrapper]";
$module_article  = "article";
$module_headline = "h2 a";

$article_body    = "div[class=grid-twelve large-grid-eleven]";
$article_title   = "h1 strong";
$article_date    = "time";
$article_author  = "span[class*=author-name]";

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
  ["topic-list\">(.*)$", "\">"]
, ["<aside(.*?)aside>", ""]
, ["<figure(.*?)>(.*?)</figure>", "$2"]
, ["<figcaption(.*?)>(.*?)</figcaption>", "$2"]
, ["<a(.*?)>(.*?)</a>", "$2"]
, ["data-srcset=\"(.*?)\"", ""]
, ["data-src=", "src="]
, [";w=(.*?)&amp;", ";w=600&amp;"]
, ["<img(.*?)src=\"(.*?)\"(.*?)>", "<a target='_blank' href='$2'><img class='clImageThumb' src='$2'></a><br>"]
, ["<span class=\"source\">(.*?)</span>", ""]
, ["<div(.*?)>", ""]
, ["</div>", ""]
, ["<span(.*?)>", ""]
, ["</span>", ""]
, ["<li><p>(.*?)</p></li>", "<li>$1</li>"]
];
?>
