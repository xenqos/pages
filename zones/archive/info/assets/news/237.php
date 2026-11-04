<?php
$config_enabled  = "true";
$config_type     = "link";

$media_name      = "Cryptonews - Latest";
$media_url       = "https://cryptonews.com/news/";
$media_encode    = "false";
$media_encoding  = "";

$module_body     = "main";
$module_article  = "article";
$module_headline = "h4";

$article_body    = "div[class=article-single__content category_contents_details]";
$article_title   = "h1";
$article_date    = "time";
$article_author  = "div[class=post-meta__author-name]";

$clean_module    =
[
  ["<script(.*?)script>", ""]
, ["<style(.*?)style>", ""]
, ["<a class=\"article__image\"(.*?)>(.*?)</a>", ""]
, ["<img(.*?)>", ""]
, ["class=\"article__title article__title--lg article__title--featured  mb-20\">(.*?)</a>", "></a><h4>$1</h4>"]
];

$clean_article_pre  =
[
  ["<script(.*?)script>", ""]
, ["<style(.*?)style>", ""]
, ["<span data-utctimelocale=\"(.*?)\"", "<time>$1</time><span"]
];

$clean_article_post =
[
  ["<h1(.*?)h1>", ""]
, ["<figcaption(.*?)>(.*?)</figcaption>", "$2<br><br>"]
, ["<figure(.*?)>(.*?)</figure>", "$2"]
, [" (alt|class|data-srcset|src|width)=\"(.*?)\"", ""]
, [" data-src=", " src="]
, [" srcset=\"(.*?)jpg(.*?)\"", " src='$1jpg'"]
, [" srcset=\"(.*?)jpeg(.*?)\"", " src='$1jpeg'"]
, [" src='(.*?) (.*?)'", " src='$1'"]
, [" src=\"(.*?)\"", " src='$1'"]
, ["<strong>Related Articles:(.*)$", ""]
, ["<div(.*?)>", ""]
, ["</div>", ""]
, ["<a(.*?)>(.*?)</a>", "$2"]
, ["<img(.*?)src='(.*?)'(.*?)>", "<a target='_blank' href='$2'><img class='clImageThumb' src='$2'></a><br>"]
];
?>
