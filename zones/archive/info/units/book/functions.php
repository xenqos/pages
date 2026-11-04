<?php
#--------------------------------------------------------------------------------------------------

require_once('../units/commons/markup.php');

#--------------------------------------------------------------------------------------------------
# Get Index
#--------------------------------------------------------------------------------------------------

function get_index()
{
  $zone  = $GLOBALS['zone'];
  $book  = $GLOBALS['book'];
  $title = $GLOBALS['title'];

  $unit  = $GLOBALS['unit'];
  $prog  = $GLOBALS['prog'];
  $zones = $GLOBALS['zones'];

  $file_index = $GLOBALS['file_index'];
  $dir_texts  = $GLOBALS['dir_texts'];
  $ext_html   = $GLOBALS['ext_html'];
  $ext_text   = $GLOBALS['ext_text'];

  $title = rawurldecode($title);

  $path_index_text = "{$zones}/{$zone}/{$book}/{$file_index}.{$ext_text}";
  $path_index_html = "{$zones}/{$zone}/{$book}/{$file_index}.{$ext_html}";
  $path_texts = "{$zones}/{$zone}/{$book}/{$dir_texts}";

  $link_text = '';
  $content = "<span class='clIndex'>\n";

  $time_texts_modified = date("F d Y H:i:s.", filemtime($path_texts));

  if (file_exists($path_index_text))
  {
    $time_index_modified = date("F d Y H:i:s.", filemtime($path_index_text));
  }

  $files = array_slice(scandir($path_texts), 2);
  $items_count = count($files);

  if (file_exists($path_index_html))
  {
    $path_index = $path_index_html;
  }
  elseif (! file_exists("{$book}/{$path_index_text}") || ($time_texts_modified > $time_index_modified))
  {
    foreach ($files as &$page)
    {
      $file_content = file_get_contents("{$path_texts}/{$page}");
      $file_content =  "\n" . $file_content;

      $result = preg_match("~#\~\~#\n~sU", $file_content, $matched);
      if ($result == 1) { $content .= "<br>\n"; }

      $result = preg_match("~###### (.*) ######\n~sU", $file_content, $matched);
      if ($result == 1) { $content .= "<h6>" . $matched[1] . "</h6>\n"; }

      $result = preg_match("~##### (.*) #####\n~sU", $file_content, $matched);
      if ($result == 1) { $content .= "<h5>" . $matched[1] . "</h5>\n"; }

      $result = preg_match("~#### (.*) ####\n~sU", $file_content, $matched);
      if ($result == 1) { $content .= "<h4>" . $matched[1] . "</h4>\n"; }

      $result = preg_match("~### (.*) ###\n~sU", $file_content, $matched);
      if ($result == 1) { $content .= "<h3>" . $matched[1] . "</h3>\n"; }

      $result = preg_match("~## (.*) ##\n~sU", $file_content, $matched);
      if ($result == 1) { $content .= "<h2>" . $matched[1] . "</h2>\n"; }

      $result = preg_match("~# (.*) #\n~sU", $file_content, $matched);
      if ($result == 1) { $content .= "<h1>" . $matched[1] . "</h1>\n"; }

      $result = preg_match("~\n# (.*)\n~sU", $file_content, $matched);

      if ($result == 1) { $link_text = $matched[1]; } else { $link_text = $page; }

      $content .= "<a href='book.php?varAction=view&varTitle={$title}&varZone={$zone}&varBook={$book}&varPage={$page}'>{$link_text}</a><br>\n";
    }

    $content .= "</span>\n";

    file_put_contents("{$path_index_text}", $content);
    $path_index = $path_index_text;
  }

  $local_css = "<link rel='stylesheet' type='text/css' media='screen' href='../{$zones}/{$zone}/{$book}/styles/local.css'>";

  $content = file_get_contents($path_index);

  $html = get_template('index');
  eval("\$html = \"{$html}\";");
  echo $html;
}

#--------------------------------------------------------------------------------------------------
# Get View
#--------------------------------------------------------------------------------------------------

function get_view()
{
  $server_root    = $GLOBALS['server_root'];
  $server_port    = $GLOBALS['server_port'];

  $zone  = $GLOBALS['zone'];
  $book  = $GLOBALS['book'];
  $title = $GLOBALS['title'];
  $page  = $GLOBALS['page'];

  $unit  = $GLOBALS['unit'];
  $prog  = $GLOBALS['prog'];
  $zones = $GLOBALS['zones'];

  $file_index = $GLOBALS['file_index'];
  $dir_sounds = $GLOBALS['dir_sounds'];
  $dir_texts  = $GLOBALS['dir_texts'];
  $ext_html   = $GLOBALS['ext_html'];
  $ext_text   = $GLOBALS['ext_text'];
  $ext_sound  = $GLOBALS['ext_sound'];

  $path_texts = "{$zones}/{$zone}/{$book}/{$dir_texts}";

  $audio_on     = '';
  $local_css    = '';
  $audio_tag    = '';
  $button_audio = '';
  $mathjax_on   = '';

  $files = array_slice(scandir($path_texts), 2);
  $items_count = count($files);

  $title = rawurldecode($title);
  $file_path = "{$zones}/{$zone}/{$book}/{$dir_texts}/{$page}";
  $http_sounds = "{$server_root}:{$server_port}/{$zones}/{$zone}/{$book}/{$dir_sounds}";

  $page_noext = pathinfo($page, PATHINFO_FILENAME);

  if (file_exists("{$zones}/{$zone}/{$book}/{$dir_sounds}/{$page_noext}.{$ext_sound}"))
  {
    $audio_on = True;
  }
  else
  {
    $audio_on = False;
  }

  $page_number_curr = (int)$page_noext;

  if      ($items_count > 999) { $number_format = '04'; }
  else if ($items_count > 99)  { $number_format = '03'; }
  else if ($items_count > 9)   { $number_format = '02'; }
  else                         { $number_format = '02'; }

  if ($page_number_curr == 1)
  {
    $page_number_prev = $items_count;
    $page_number_next = $page_number_curr + 1;
  }
  else if ($page_number_curr == $items_count)
  {
    $page_number_prev = $items_count - 1;
    $page_number_next = 1;
  }
  else
  {
    $page_number_prev = $page_number_curr - 1;
    $page_number_next = $page_number_curr + 1;
  }

  $page_curr = sprintf("%{$number_format}d", $page_number_curr);
  $page_prev = sprintf("%{$number_format}d", $page_number_prev);
  $page_next = sprintf("%{$number_format}d", $page_number_next);

  if ($audio_on)
  {
    $audio_tag = "<audio id='idTrack' src='{$http_sounds}/{$page_curr}.{$ext_sound}' preload='auto'></audio>";
    $button_audio = "<span class='clNavRewind' onclick='fncRewindTrack(&quot;idTrack&quot;)'></span><span class='clNavPlay' onclick='fncPlayTrack(&quot;idTrack&quot;)'></span>";
  }

  $local_css = "<link rel='stylesheet' type='text/css' media='screen' href='/zones/{$zone}/{$book}/styles/local.css'>";

  $content = file_get_contents($file_path);
  $content = get_markup($content);

  $html = get_template('view');
  eval("\$html = \"{$html}\";");
  echo $html;
}

#--------------------------------------------------------------------------------------------------
?>
