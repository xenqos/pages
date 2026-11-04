<?php
$media_name     = 'Webster En-En';
$media_url      = 'https://www.merriam-webster.com/dictionary';
$media_post     = null;
$media_word     = ["^(.*?)$", "$1/{$word_encoded}"];
$media_encode   = 'false';

$article_body   = 'div[id=left-content]';

$clean_article  =
[
  ["<\!--(.*?)-->", ""]
, ["<h1(.*?)>(.*?)</h1>", ""]
, ["<span class=\"badge(.*?)>(.*?)</span>", ""]
, ["<div id=\"more-from-mw(.*)", ""]
, ["<div id=\"kidsdictionary(.*)", ""]
, ["<div id=\"social-links(.*)", ""]
, ["<div id=\"citations(.*)", ""]
, ["<div id=\"related-articles(.*)", ""]
, ["<div id=\"podcast(.*)", ""]
, ["<div id=\"nearby-entries(.*)", ""]
, ["<img src=\"/dist-cross-dungarees/images/svg/content-section-header-border\.svg\"(.*?)>", ""]
, ["<img class=\"svg(.*?)>", ""]
, ["<img class=\"pb-0 pe-2\"(.*?)>", ""]
, ["<img class=\"pe-2\"(.*?)>", ""]
, ["<img src=\"/dist-cross-dungarees(.*?)\"(.*?)>", ""]
, ["<span class=\"word-syllables-entry\">(.*?)</span>", ""]
, ["<span class=\"prons-entries-list-inline mb-1\">(.*?)</span>", "$1"]
, ["<div class=\"prons-entry-list-item d-inline\">(.*?)</div>", ""]
, ["(\s*?)(data-url|data-lang|data-title|alt|title|href)=\"(.*?)\"", ""]
, ["(\s*?)(text-decoration-none|prons-entry-list-item|d-inline|badge|mw-badge-gray-300)", ""]
, ["(\s*?)(d-flex|align-items-center|justify-content-center)", ""]
, ["<a class=\"play-pron-v2\" data-file=\"(.*?)\" data-dir=\"(.*?)\">(.*?)</a>", "<span class='clPrn'>$3</span><span class='clNavAudio' onclick='fncPlayLink(&quot;https://media.merriam-webster.com/audio/prons/en/us/mp3/$2/$1.mp3&quot;)'></span>"]
, ["<ul class=\"mw-grid-table-list synonyms-antonyms-grid-list\">(.*?)</ul>", ""]
, ["<a class=\"btn mw-btn-outline-orange\"(.*?)>(.*?)</a>", ""]
, ["<p class=\"function-label\">(.*?)</p>", ""]
, [">(\s+?)<h2>Synonyms</h2>(\s+?)", ">"]
, ["<img class=\"svg\"(.*?)>", ""]
, ["<span class=\"word-syllables-entry\">(.*?)</span>", ""]
, ["<div id=\"save-word-login-html\"></div>", ""]
, ["<a(.*?)>(.*?)</a>", "$2"]
, ["<span class=\"ex-header function-label content-section-sub-header\">Recent Examples on the Web</span>", "<h2>Recent Examples</h2>"]
, ["<p class=\"disclaimer\">(.*?)</p>", ""]
, ["<a class=\"read-more-content-hint-toggler\">(.*?)</a>", ""]
, ["<span class=\"read-more-content-hint-toggler-btn\">See More</span>", ""]
, ["<span class=\"read-more-content-hint-toggler-btn\">See More</span>", ""]
];

?>
