<?php
$config_enabled  = "true";
$config_type     = "link";

$media_name      = "Real Investment Advice - Page 2";
$media_url       = "https://realinvestmentadvice.com/real-investment-daily/page/2/";
$media_encode    = "false";
$media_encoding  = "";

$module_body     = "div[class*=main-content]";
$module_article  = "article";
$module_headline = "h2 a";

$article_body    = "div[class=content]";
$article_title   = "h1";
$article_date    = "div[class=meta] small";
$article_author  = "";

$clean_module    =
[
  ["<noscript(.*?)noscript>", ""]
, ["<script(.*?)script>", ""]
, ["<style(.*?)style>", ""]
];

$clean_article_pre  =
[
  ["<script(.*?)script>", ""]
, ["<style(.*?)style>", ""]
];

$clean_article_post =
[
  ["<a class=\"icon-pdf\"(.*?)a>", ""]
, ["<a data-site(.*?)a>", ""]
, ["<span class=\"ssba-share-text\">(.*?)</span>", ""]
, ["<h1(.*?)h1>", ""]
, ["<div class=\"meta\">(.*?)</div>", ""]
, ["<div class=\"printfriendly(.*?)</div>", ""]
, ["^(.*?)<div class=\"pf-content\">", "<div class=\"pf-content\">"]
, ["<!--(.*?)-->", ""]
, ["<figure(.*?)>", ""]
, ["</figure>", ""]
, ["<a(.*?)>(.*?)</a>", "$2"]
, ["<div class=\"post-views(.*)$", ""]
, ["<div(.*?)>", ""]
, ["</div>", ""]
, ["(alt|title|width|height|itemprop|srcset|loading|sizes|style|class|target|rel|data-preserver-spaces)=\"(.*?)\"", ""]
, ["(\s*?)>", ">"]
, ["<noscript>(.*?)</noscript>", ""]
, ["<img(\s*?)src", "<img src"]
, ["<img src=\"(.*?)\"", "<img "]
, ["data-lazy-", ""]
, ["<img(\s*?)src=\"https://realinvestmentadvice\.com/wp-content/uploads/2019/01/Newsletter-Banner\.png\">", ""]
, ["<img(\s*?)src=\"https://realinvestmentadvice\.com/wp-content/uploads/2021/08/Newsletter-Banner\.png\">", ""]
, ["<img(\s*?)src=\"https://realinvestmentadvice\.com/wp-content/uploads/2018/11/Need-A-Plan-To-Protect-Your-Savings-1\.png\">", ""]
, ["<img(\s*?)src=\"https://realinvestmentadvice\.com/wp-content/uploads/2021/08/Need-A-Plan-To-Protect-Your-Savings-1\.png\">", ""]
, ["<img(\s*?)src=\"https://realinvestmentadvice\.com/wp-content/uploads/2019/08/Subscribe-YOUTUBE\.jpg\">", ""]
, ["<img(\s*?)src=\"https://realinvestmentadvice\.com/wp-content/uploads/2021/08/Subscribe-YOUTUBE\.jpg\">", ""]
, ["<img(\s*?)src=\"https://realinvestmentadvice\.com/wp-content/uploads/2021/08/760_x_90_RIA_PRO_Ad_Actionable_Intelligence\.jpg\">", ""]
, ["<img(\s*?)src=\"https://realinvestmentadvice\.com/wp-content/uploads/2021/08/760_x_90_RIA_PRO_Ad_Actionable_Intelligence\.jpg\">", ""]
, ["<img(\s*?)src=\"https://realinvestmentadvice\.com/wp-content/uploads/2019/08/RIAPRO-Insights-Banner\.jpg\">", ""]
, ["<img(\s*?)src=\"https://realinvestmentadvice\.com/wp-content/uploads/2019/01/investments-Prepared-For-Next-Bear-Market\.png\">", ""]
, ["<img(\s*?)src=\"https://realinvestmentadvice\.com/wp-content/uploads/2019/01/The-Next-Bear-Market-Is-Coming\.png\">", ""]
, ["<img(\s*?)src=\"https://realinvestmentadvice\.com/wp-content/uploads/2018/11/RIA-Banner-Blog-Post-500k-or-More-1\.png\">", ""]
, ["<img(\s*?)src=\"https://realinvestmentadvice\.com/wp-content/uploads/2019/01/RIA-Banner-Blog-Post-500k-or-More\.png\">", ""]
, ["<img(\s*?)src=\"https://realinvestmentadvice\.com/wp-content/uploads/2019/08/RIAPRO-Dont-Invest-Alone-Banner\.jpg\">", ""]
, ["<img(\s*?)src=\"https://realinvestmentadvice\.com/wp-content/uploads/2021/08/Need-A-Plan-To-Protect-Your-Savings-1\.png\">", ""]
, ["<img(.*?)src=\"(.*?)\"(.*?)>", "<a target='_blank' href='$2'><img class='clImageThumb' src='$2'></a><br>"]
];
?>
