<?php
$media_name     = 'Larousse Fr-Fr';
$media_url      = 'https://www.larousse.fr/dictionnaires/francais';
$media_post     = null;
$media_word     = ["^(.*?)$", "$1/$word_encoded"];
$media_encode   = 'false';

$article_body   = 'article[class*=BlocDefinition]';

$clean_article  =
[
  ["\t", " "]
, ["<div class=\"Zone(.*?)\"(.*?)>(.*?)</div>", "$3"]
, ["<h2(.*?)>(.*?)</h2>", "$2"]
, ["<a class=\"lienconj\"(.*?)>Conjugaison</a>", ""]
, ["<span class=\"linkaudio fontello\"(.*?)span>", ""]
, ["</audio>(.*?)<", "</audio><"]
, ["<audio(.*?)src=\"(.*?)\" type=\"audio/mp3\"></audio>", "<span class='clNavAudio' onclick='fncPlayLink(&quot;https://larousse.fr$2&quot;)'></span>"]
, ["<a(.*?)>(.*?)</a>", "$2"]
, ["<li class=\"DivisionDefinition\">(.*?)</li>", "<div class='DivisionDefinition'>$1</div>"]
, ["<ul class=\"Definitions\">(.*?)</ul>", "$1"]
, ["<a(.*?)>(.*?)</a>", "$2"]
];

?>
