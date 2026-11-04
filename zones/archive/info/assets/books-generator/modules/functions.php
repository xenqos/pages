<?php
#-------------------------------------------------------------------------------
# Get Index
#-------------------------------------------------------------------------------

function get_index()
{
  $book           = $GLOBALS['book'];
  $title          = $GLOBALS['title'];
  $dir_books      = $GLOBALS['dir_books'];
  $dir_book       = $GLOBALS['dir_book'];

  $dir_book_pages = $GLOBALS['dir_book_pages'];
  $dir_book_texts = $GLOBALS['dir_book_texts'];
  $file_index     = $GLOBALS['file_index'];

  if (exec("grep '<!DOCTYPE html>' {$file_index}")) { return; }
  unlink("{$file_index}");

  $title = rawurldecode($title);

  $files = array_slice(scandir($dir_book_texts), 2);
  $items_count = count($files);

  $link_text = '';
  $content = "<span class='clIndex'>\n";

  foreach ($files as &$filename)
  {
    $filename_noext = pathinfo($filename, PATHINFO_FILENAME);
    $file_content = file_get_contents("{$dir_book_texts}/{$filename}");
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
    if ($result == 1) { $link_text = $matched[1]; } else { $link_text = $filename; }

    $content .= "<a href='./pages/{$filename_noext}.html'>{$link_text}</a><br>\n";
  }

  $content .= "</span>\n";

  $html = get_template('index');
  eval("\$html = \"{$html}\";");
  file_put_contents("{$file_index}", $html);
}

#-------------------------------------------------------------------------------
# Get Pages
#-------------------------------------------------------------------------------

function get_pages()
{
  $book             = $GLOBALS['book'];
  $title            = $GLOBALS['title'];
  $dir_books        = $GLOBALS['dir_books'];
  $dir_book         = $GLOBALS['dir_book'];

  $dir_book_pages   = $GLOBALS['dir_book_pages'];
  $dir_book_texts   = $GLOBALS['dir_book_texts'];
  $dir_book_sounds  = $GLOBALS['dir_book_sounds'];

  $ext_html         = $GLOBALS['ext_html'];
  $ext_text         = $GLOBALS['ext_text'];
  $ext_sound        = $GLOBALS['ext_sound'];
  $ext_image        = $GLOBALS['ext_image'];

  $title = rawurldecode($title);

  if (! file_exists("{$dir_book_pages}")) { mkdir("{$dir_book_pages}", 0755); }

  $files = array_slice(scandir($dir_book_texts), 2);
  $items_count = count($files);

  $audio_on     = '';
  $audio_tag    = '';
  $button_audio = '';

  foreach ($files as &$filename)
  {
    $filename_noext = pathinfo($filename, PATHINFO_FILENAME);

    $content = '';

#    echo "{$dir_book_sounds}/{$filename_noext}.{$ext_sound}\n";

    if (file_exists("{$dir_book_sounds}/{$filename_noext}.{$ext_sound}"))
    {
      $audio_on = True;
    }
    else
    {
      $audio_on = False;
    }

    $page_number_curr = (int)$filename_noext;

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
      $audio_tag = "<audio id='idTrack' src='../sounds/{$page_curr}.{$ext_sound}' preload='auto'></audio>";
      $button_audio = "<span class='clNavRewind' onclick='fncRewindTrack(&quot;idTrack&quot;)'></span><span class='clNavPlay' onclick='fncPlayTrack(&quot;idTrack&quot;)'></span>";
    }

    $content = file_get_contents("{$dir_book_texts}/{$filename}");
    $content = get_markup($content);
#    $content .= "</span>\n";

    $html = get_template('page');
    eval("\$html = \"{$html}\";");

    file_put_contents("{$dir_book_pages}/{$filename_noext}.{$ext_html}", $html);

#echo $content;
  }
}

#-------------------------------------------------------------------------------

function get_template($name)
{
  $dir_templates = $GLOBALS['dir_templates'];

  $text = '';

  $text = file_get_contents("{$dir_templates}/{$name}.html");
  $text = preg_replace("/\"/", "'", $text);

  return $text;
}

#-------------------------------------------------------------------------------
?>
