<?php
$media_name     = 'БКРС Zh-Ru';
$media_url      = 'https://bkrs.info';
$media_post     =  null;
$media_word     = ["^(.*?)$", "$1/slovo.php?ch=$word_encoded"];
$media_encode   = 'false';

$article_body   = 'div[class=margin_left]';

$clean_article  =
[
  ["^(.*?)<div id='ch'>", "<div id='ch'>"]
, ["<div id='backlinks'>(.*?)$", ""]
, ["<div class='pt10(.*?)$", ""]
, ["<img(.*?)>", ""]
, ["(\s+)<div", "\n<div"]
];
?>
