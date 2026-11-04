<?php
$media_name     = 'Longman En-En';
$media_url      = 'https://www.ldoceonline.com/dictionary';
$media_post     = null;
$media_word     = ["^(.*?)$", "$1/{$word_encoded}"];
$media_encode   = 'false';

$article_body   = 'div[class=entry_content]';

$clean_article  =
[
  ["<iframe(.*?)</iframe>", ""]
, ["<script(.*?)</script>", ""]
, ["<\!--(.*?)-->", ""]
, ["<h1 class=\"pagetitle\">(.*?)</h1>", ""]
, ["<div class=\"wordfams\">(.*?)</div>", ""]
, ["<span class=\"PICCAL\">(.*?)</span>", ""]
, ["<span class=\"dictionary_intro span\">(.*?)</span>", ""]
, ["<span class=\"related_topics\">(.*?)</span>", ""]
, ["<span class=\"HYPHENATION\">(.*?)</span>", ""]
, ["<a class=\"topic\"(.*?)>(.*?)</a>", ""]
, ["</span><span class=\"HOMNUM\">(.*?)</span>", "<sup class='clSup'>$1</sup></span>"]
, ["<span class=\"FIELD\">(.*?)</span>", ""]
, ["<span class=\"ACTIV\">(.*?)</span>", ""]
, ["<span data-src-mp3=\"(.*?)\"(.*?)>", "<span class='clNavAudio' onclick='fncPlayLink(&quot;$1&quot;)'>"]
, ["<a(.*?)>(.*?)</a>", "$2"]
];

?>
