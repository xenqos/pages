<?php
#---------------------------------------------------------------------------------------------------

include("./global-objects.php");

#---------------------------------------------------------------------------------------------------

if      ($_SERVER['REQUEST_METHOD'] === 'GET')
{
  $func_id        = $_GET['varFuncId'       ] ?? "";
  $app_title      = $_GET['varTitle'     ] ?? "";
  $app_area       = $_GET['varZone'      ] ?? "";
  $app_dir        = $_GET['varAppDir'       ] ?? "";
  $file_name      = $_GET['varFileName'     ] ?? "";
}

elseif  ($_SERVER['REQUEST_METHOD'] === 'POST')
{
  $func_id        = $_POST['varFuncId'      ] ?? "";
  $app_title      = $_POST['varTitle'    ] ?? "";
  $app_area       = $_POST['varZone'     ] ?? "";
  $app_dir        = $_POST['varAppDir'      ] ?? "";
  $file_name      = $_POST['varFileName'    ] ?? "";
  $text_area      = $_POST['varTextarea'    ] ?? "";
}

#---------------------------------------------------------------------------------------------------

function get_index()
{
  global $dir_templates, $dir_config, $app_title, $server_docroot, $dir_texts, $file_index;
  global $ext_html, $ext_text;
  global $dir_zones, $app_dir, $app_area;

  $file_template = "../{$dir_templates}/book-reader-index.html";

  $page_title = rawurldecode($app_title);
  $path_file_index_text = "{$server_docroot}/{$dir_zones}/{$app_area}/{$app_dir}/{$file_index}.{$ext_text}";
  $path_file_index_html = "{$server_docroot}/{$dir_zones}/{$app_area}/{$app_dir}/{$file_index}.{$ext_html}";
  $path_dir_text = "{$server_docroot}/{$dir_zones}/{$app_area}/{$app_dir}/{$dir_texts}";

  $link_text = "";
  $matches_array = array();
  $page_content = "<span class='clIndex'>\n";

  $time_texts_modified = date("F d Y H:i:s.", filemtime($path_dir_text));

  if (file_exists($path_file_index_text))
  {
    $time_index_modified = date("F d Y H:i:s.", filemtime($path_file_index_text));
  }

  $files_array = scandir($path_dir_text);
  $items_count = count($files_array) - 2;

  if (file_exists($path_file_index_html))
  {
    $path_file_index = $path_file_index_html;
  }
  elseif (! file_exists("{$app_dir}/{$path_file_index_text}") || ($time_texts_modified > $time_index_modified))
  {
    foreach ($files_array as &$file_name)
    {
      if (substr($file_name, 0, 1) === '.')
      {
        continue;
      }

      $file_content = file_get_contents("{$path_dir_text}/{$file_name}");
      $file_content =  "\n" . $file_content;

      unset($matches_array);
      $match_result = preg_match("/#~~#\n/sU", $file_content, $matches_array);
      if ($match_result == 1) { $page_content .= "<br>\n"; }

      unset($matches_array);
      $match_result = preg_match("/###### (.*) ######\n/sU", $file_content, $matches_array);
      if ($match_result == 1) { $page_content .= "<h6>" . $matches_array[1] . "</h6>\n"; }

      unset($matches_array);
      $match_result = preg_match("/##### (.*) #####\n/sU", $file_content, $matches_array);
      if ($match_result == 1) { $page_content .= "<h5>" . $matches_array[1] . "</h5>\n"; }

      unset($matches_array);
      $match_result = preg_match("/#### (.*) ####\n/sU", $file_content, $matches_array);
      if ($match_result == 1) { $page_content .= "<h4>" . $matches_array[1] . "</h4>\n"; }

      unset($matches_array);
      $match_result = preg_match("/### (.*) ###\n/sU", $file_content, $matches_array);
      if ($match_result == 1) { $page_content .= "<h3>" . $matches_array[1] . "</h3>\n"; }

      unset($matches_array);
      $match_result = preg_match("/## (.*) ##\n/sU", $file_content, $matches_array);
      if ($match_result == 1) { $page_content .= "<h2>" . $matches_array[1] . "</h2>\n"; }

      unset($matches_array);
      $match_result = preg_match("/# (.*) #\n/sU", $file_content, $matches_array);
      if ($match_result == 1) { $page_content .= "<h1>" . $matches_array[1] . "</h1>\n"; }

      unset($matches_array);
      $match_result = preg_match("/\n# (.*)\n/sU", $file_content, $matches_array);
      if ($match_result == 1)
      {
        $link_text = $matches_array[1];
      }
      else
      {
        $link_text = $file_name;
      }

      $page_content .= "<a href='./book-reader.php?varFuncId=view&varTitle={$app_title}&varZone={$app_area}&varAppDir={$app_dir}&varFileName={$file_name}'>{$link_text}</a><br>\n";
    }

    $page_content .= "</span>\n";

    file_put_contents("{$path_file_index_text}", $page_content);
    $path_file_index = $path_file_index_text;
  }

  $local_css = "<link rel='stylesheet' type='text/css' media='screen' href='../{$dir_zones}/{$app_area}/{$app_dir}/styles/local.css'>";

  $page_content = file_get_contents($path_file_index);

  $page_html = get_file_template($file_template);

  eval("\$page_html = \"{$page_html}\";");
  echo $page_html;
}

#---------------------------------------------------------------------------------------------------

function get_view()
{
  global $dir_templates, $dir_config, $app_title, $server_docroot, $dir_sounds, $dir_texts, $file_index;
  global $server_root, $server_port, $ext_sound, $ext_html, $ext_text;
  global $dir_zones, $app_dir, $app_area, $file_name;

  $file_template    = "../{$dir_templates}/book-reader-view.html";
  $path_dir_text = "{$server_docroot}/{$dir_zones}/{$app_area}/{$app_dir}/{$dir_texts}";

  $audio_on     = "";
  $local_css    = "";
  $math_scripts = "";
  $audio_tag    = "";
  $button_audio = "";

  $files_array = scandir($path_dir_text);
  $items_count = count($files_array) - 2;

  $page_title = rawurldecode($app_title);
  $file_path = "../{$dir_zones}/{$app_area}/{$app_dir}/{$dir_texts}/{$file_name}";
  $http_sounds = "{$server_root}:{$server_port}/{$dir_zones}/{$app_area}/{$app_dir}/{$dir_sounds}";

  $file_name_noext = pathinfo($file_name, PATHINFO_FILENAME);

  if (file_exists("../{$dir_zones}/{$app_area}/{$app_dir}/{$dir_sounds}/{$file_name_noext}.{$ext_sound}"))
  {
    $audio_on = True;
  }
  else
  {
    $audio_on = False;
  }

  $page_number_curr = (int)$file_name_noext;

#  $items_count < 100 ? $number_format = '02' : $number_format = '03' ;

  if ($items_count > 999)
  {
    $number_format = '04';
  }
  else if ($items_count > 99)
  {
    $number_format = '03';
  }
  else if ($items_count > 9)
  {
    $number_format = '02';
  }
  else
  {
    $number_format = '02';
  }

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

  $page_curr = sprintf("%${number_format}d", $page_number_curr);
  $page_prev = sprintf("%${number_format}d", $page_number_prev);
  $page_next = sprintf("%${number_format}d", $page_number_next);

  $button_editor = "<a href='./book-reader.php?varFuncId=edit&varTitle={$app_title}&varZone={$app_area}&varAppDir={$app_dir}&varFileName={$file_name}'><span class='clNavEdit'><span></a>";

  if ($audio_on)
  {
    $audio_tag = "<audio id='idTrack' src='{$http_sounds}/{$page_curr}.{$ext_sound}' preload='auto'></audio>";
    $button_audio =  "<span class='clNavRewind' onclick='fncRewindTrack(&quot;idTrack&quot;)'></span><span class='clNavPlay' onclick='fncPlayTrack(&quot;idTrack&quot;)'></span>";
  }

  $local_css = "<link rel='stylesheet' type='text/css' media='screen' href='../{$dir_zones}/{$app_area}/{$app_dir}/styles/local.css'>";

  $page_content = file_get_contents($file_path);
  $page_content = get_markdown($page_content);
  $page_html = get_file_template($file_template);

  eval("\$page_html = \"{$page_html}\";");
  echo $page_html;
}

#---------------------------------------------------------------------------------------------------

function get_edit()
{
  global $dir_templates, $dir_config, $app_title, $dir_texts;
  global $dir_zones, $app_dir, $app_area, $file_name, $items_count, $func_id;

  $file_template      = "../{$dir_templates}/book-reader-edit.html";
  $file_content = "../{$dir_zones}/{$app_area}/{$app_dir}/{$dir_texts}/{$file_name}";

  $page_title = rawurldecode($app_title);

  $page_content = file_get_contents($file_content);
  $page_content = preg_replace("/\"/sU", "&quot;", $page_content);
  $page_content = preg_replace("/\'/sU", "&apos;", $page_content);

  $page_html = get_file_template($file_template);

  eval("\$page_content = \"{$page_content}\";");
  eval("\$page_html = \"{$page_html}\";");
  echo $page_html;
}

#---------------------------------------------------------------------------------------------------

function get_edit_post()
{
  global $app_title, $dir_texts;
  global $dir_zones, $app_dir, $app_area, $file_name, $items_count, $text_area;

  $file_template = "../{$dir_zones}/{$app_area}/{$app_dir}/{$dir_texts}/{$file_name}";

  $page_title = rawurldecode($app_title);

  $file_bom = pack('H*','EFBBBF');
  $text_area = preg_replace('/^$file_bom/', "", $text_area);
  $text_area = preg_replace('~\r\n?~', "\n", $text_area);

  file_put_contents($file_template, $text_area);

  header("Location: ./book-reader.php?varFuncId=view&varTitle={$app_title}&varZone={$app_area}&varAppDir={$app_dir}&varFileName={$file_name}");
}

#---------------------------------------------------------------------------------------------------

if      ($func_id == "index")     { get_index();      }
elseif  ($func_id == "view")      { get_view();       }
elseif  ($func_id == "edit")      { get_edit();       }
elseif  ($func_id == "edit_post") { get_edit_post();  }

#---------------------------------------------------------------------------------------------------
?>
