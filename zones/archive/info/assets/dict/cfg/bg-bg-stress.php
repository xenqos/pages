<?php
$media_name     = 'Ударение Бг-Бг';
$media_url      = 'https://slovored.com/search/accent';
$media_post     =  null;
$media_word     = ["^(.*?)$", "$1/{$word_encoded}"];
$media_encode   = 'true';

$article_body   = 'div[class=result]';

$clean_article  =
[
  ["^(.*?)$", "<div class='clWordStress'>$1</div>"]
];

?>
