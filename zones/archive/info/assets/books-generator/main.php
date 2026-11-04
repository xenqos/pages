#!/bin/php

<?php
#-------------------------------------------------------------------------------

$unit = basename($_SERVER['PHP_SELF'], '.php');
require_once('./modules/variables.php');
require_once('./modules/functions.php');
require_once('./modules/markup.php');

#-------------------------------------------------------------------------------

$books = array(
  '1|gm-reference|Texas Holdem Reference'
, '0|bg-berlitz|Berlitz'
, '0|bg-conversations|Разговори'
, '0|bg-frequent-words|Честотен речник'
, '0|bg-grammar|Граматика'
, '0|bg-phrases|Фрази'
, '0|bg-verbs|Глаголи'
, '0|bg-words|Думи'
, '1|de-grammatik|Grammatik'
, '0|de-gespräche-en|Gespräche DE-EN'
, '0|de-gespräche-ru|Gespräche DE-RU'
, '1|de-wörter|Wörter'
, '0|de-starke-verben|Starke Verben'
, '0|en-conversations|Conversations'
, '0|en-frequent-words|Frequent Words'
, '0|en-from-sound-to-letter|From Sound to Letter'
, '0|en-grammar|Grammar'
, '0|en-ielts-words|IELTS Words'
, '0|en-phonetics|Phonetics'
, '0|en-phrases|Phrases'
, '0|en-verbs-irregular|Irregular Verbs'
, '0|en-verbs-phrasal|Phrasal Verbs'
, '0|en-words|Words'
, '0|en-bible-en|King James Bible'
);

#-------------------------------------------------------------------------------

$dir_books = '/home/lux/mnt/data/Webpages/zones';
$GLOBALS['dir_books'] = $dir_books;

#-------------------------------------------------------------------------------

foreach ($books as &$line)
{
  list( $status, $book, $title ) = explode( '|', $line );

  if ( $status == 0 ) { continue; }

  echo "{$book} - {$title}\n";

  $dir_book         = "{$dir_books}/${book}";
  $dir_book_pages   = "{$dir_book}/pages";
  $dir_book_texts   = "{$dir_book}/texts";
  $dir_book_sounds  = "{$dir_book}/sounds";

  $dir_templates    = './templates';
  $file_index       = "{$dir_book}/index.html";

  $GLOBALS['book']            = $book;
  $GLOBALS['title']           = $title;
  $GLOBALS['dir_book_pages']  = $dir_book_pages;
  $GLOBALS['dir_book_texts']  = $dir_book_texts;
  $GLOBALS['dir_book_sounds'] = $dir_book_sounds;
  $GLOBALS['dir_templates']   = $dir_templates;
  $GLOBALS['file_index']      = $file_index;

  get_index();
  get_pages();
}

#-------------------------------------------------------------------------------
?>
