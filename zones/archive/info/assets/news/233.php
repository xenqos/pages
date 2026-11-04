<?php
$config_enabled  = "true";
$config_type     = "link";

$media_name      = "Zonebourse - Devises & Forex";
$media_url       = "https://www.zonebourse.com/actualite-bourse/devises-eco/devises/";
$media_encode    = "true";

$module_body     = "table[id=newsScreener]";
$module_article  = "td[class=w-100]";
$module_headline = "a";

$article_body    = "article";
$article_title   = "div[data-io-article-url^=http] h1";
$article_date    = "datetime";
$article_author  = "";

$clean_module    =
[
  ["Ђ/", "€"]
];

$clean_article_pre  =
[
  ["<meta itemprop=\"datePublished\"(.*?)>(.*?)</div>", "<datetime>$2</datetime></div>"]
, ["Й", "É"]
, ["й", "é"]
, ["В", "Â"]
, ["в", "â"]
, ["А", "À"]
, ["а", "à"]
, ["И", "È"]
, ["и", "è"]
, ["К", "Ê"]
, ["к", "ê"]
, ["Ф", "Ô"]
, ["ф", "ô"]
, ["Ы", "Û"]
, ["ы", "û"]
];

$clean_article_post =
[
  ["\t", " "]
, ["^(.*?)<div id='grantexto'(.*?)>(.*?)</div>(.*)$", "$3"]
, ["<br/><br/><br/>", "<br><br>"]
, ["<pre>(.*?)</pre>", ""]
, ["Й", "É"]
, ["й", "é"]
, ["В", "Â"]
, ["в", "â"]
, ["А", "À"]
, ["а", "à"]
, ["И", "È"]
, ["и", "è"]
, ["К", "Ê"]
, ["к", "ê"]
, ["Ф", "Ô"]
, ["ф", "ô"]
, ["Ы", "Û"]
, ["ы", "û"]
];
?>
