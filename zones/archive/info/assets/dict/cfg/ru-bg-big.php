<?php
$media_name     = 'Большой Ру-Бг';
$media_url      = 'http://www.learn-bulgarian.ru';
$media_post     = ['langdir' => 'rus_lang', 'search'  => ''];
$media_word     = ["", ""];
$media_encode   = 'false';

$article_body   = 'div[class=lexemeshldr]';

$clean_article  =
[
  ["<script(.*?)script>", ""]
, ["<ins(.*?)ins>", ""]
, ["<div id=\"vk_comments\">(.*?)</div>", ""]
, ["<\!--(.*?)-->", ""]
, ["<div style=\"padding(.*?)div>", ""]
, ["<div style=\"margin-top(.*?)div>", ""]
, ["\[ref\]", ""]
, ["\[/ref\]", ""]
];

?>
