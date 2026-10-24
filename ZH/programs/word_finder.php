<?php
#!/bin/php
#---------------------------------------------------------------------------------------------------

include("./global-objects.php");
include("./simple-html-dom.php");

#---------------------------------------------------------------------------------------------------

$dict_id        = $_GET['varDictId' ] ?? "";
$word_id        = $_GET['varWordId' ] ?? "";

#$dict_id        = 'en_en_webster';
#$word_id        = 'result';

#$dict_id        = 'bg_ru_big';
#$word_id        = 'дума';

#---------------------------------------------------------------------------------------------------

$app_title      = "Word Finder";
$app_area       = "ln";

$dir_zones       = "zones";
$dir_area       = "ln";
$dir_name       = "word_finder";
$dir_config     = "../{$dir_zones}/{$dir_area}/{$dir_name}";

#---------------------------------------------------------------------------------------------------

0 ? $debug_flag = true : $debug_flag = false;

#---------------------------------------------------------------------------------------------------

function get_word()
{
  global $dict_id, $word_id, $dir_templates, $dir_config, $dir_zones, $app_title, $app_area;
  global $debug_flag;

  $media_url_word = '';
  $article_body_content = '';

  $file_template = "../{$dir_templates}/word_finder.html";
  $debug_file = "/home/" . get_current_user() . "/mnt/data/Temp/debug_word_finder.txt";

  if ($debug_flag)
  {
    file_put_contents($debug_file, '');
  }

#echo "{$dict_id}\n";
#echo "{$word_id}\n";
#echo "{$debug_file}\n";
#exit;

  $page_title = $app_title;

  $word_id = mb_strtolower($word_id);
  $word_encoded = rawurlencode($word_id);
  $word_first_char = strtoupper($word_encoded[0]);

  unset($config_array);
  include("{$dir_config}/{$dict_id}.php");


  $media_css        = "{$dir_config}/{$dict_id}.css";

  $media_name       = $config_array["media_name"];
  $media_url        = $config_array["media_url"];
  $media_post       = $config_array["media_post"];
  $media_word       = $config_array["media_word"];
  $media_encode     = $config_array["media_encode"];
  $article_body     = $config_array["article_body"];
  $clean_article    = $config_array["clean_article"];

  if (is_null($media_post))
  {
    $media_url_word = preg_replace("$media_word[0]", "$media_word[1]", $media_url);
  }
  else
  {
    $media_url_word = $media_url;
    $media_post['search'] = $word_id;
  }

  if (! empty($word_id))
  {
    $media_content = get_url($media_url_word, $media_post);

    if ($media_encode == "true") $media_content = mb_convert_encoding($media_content, "utf-8", "windows-1251");

    $html_object = str_get_html($media_content);
    $article_body_content = $html_object->find($article_body, 0)->innertext   ?? "";

    foreach($clean_article as $regex_array)
    {
      if ($regex_array[0] == "") continue;
      $article_body_content = preg_replace("$regex_array[0]", "$regex_array[1]", $article_body_content);
    }
  }

  if ($debug_flag)
  {
     file_put_contents($debug_file, $article_body_content, FILE_APPEND);
##    file_put_contents($debug_file, count($module_array), FILE_APPEND);
##    file_put_contents($debug_file, "\n\n----------\n\n", FILE_APPEND);
##    file_put_contents($debug_file, $module_array[0], FILE_APPEND);
##    file_put_contents($debug_file, "\n\n----------\n\n", FILE_APPEND);
#    $debug_content = $article_body_content;
#    $debug_content = preg_replace("/</s", "\n<", $debug_content);
#    $debug_content = preg_replace("/\n<\//s", "</", $debug_content);
#    file_put_contents($debug_file, $debug_content, FILE_APPEND);
#    exit;
  }

  $page_content = $article_body_content;

  $page_html = get_file_template($file_template);

  eval("\$page_html = \"{$page_html}\";");
  echo $page_html;
}

#---------------------------------------------------------------------------------------------------

get_word();

#---------------------------------------------------------------------------------------------------
?>
