<?php
#--------------------------------------------------------------------------------------------------

require_once('../units/commons/simplehtmldom.php');

#--------------------------------------------------------------------------------------------------

function get_word()
{
  $dict = $GLOBALS['dict'];
  $word = $GLOBALS['word'];

  $cfg = $GLOBALS['cfg'];
  $css = $GLOBALS['css'];

  $title = $GLOBALS['title'];
  $unit = $GLOBALS['unit'];
  $zones = $GLOBALS['zones'];
  $zone = $GLOBALS['zone'];
  $prog = $GLOBALS['prog'];

  $word = mb_strtolower($word);
  $word_encoded = rawurlencode($word);

  require_once("{$cfg}/{$dict}.php");

  $media_url_word = '';
  $content = '';

  $media_css = "<link rel='stylesheet' type='text/css' media='screen' href='{$css}/{$dict}.css'>";

  if (is_null($media_post))
  {
    $media_url_word = preg_replace("~$media_word[0]~s", "$media_word[1]", $media_url);
  }
  else
  {
    $media_url_word = $media_url;
    $media_post['search'] = $word;
  }

  if (! empty($word))
  {
    $media_content = get_url($media_url_word, post: $media_post);

    if ($media_encode == 'true') $media_content = mb_convert_encoding($media_content, 'utf-8', 'windows-1251');

    $htmldom = str_get_html($media_content);

    if ( $htmldom == false )
    {
      $content = '';
    }
    else
    {
      $content = $htmldom->find($article_body, 0)->innertext ?? '';

      foreach($clean_article as $regex)
      {
        if ($regex[0] == '') continue;
        $content = preg_replace("~{$regex[0]}~s", "{$regex[1]}", $content);
      }
    }
  }

  $html = get_template('default');
  eval("\$html = \"{$html}\";");
  echo $html;
}

#--------------------------------------------------------------------------------------------------
?>
