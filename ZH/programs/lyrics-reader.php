<?php
#---------------------------------------------------------------------------------------------------

include("./global-objects.php");

#---------------------------------------------------------------------------------------------------

$func_id        = $_GET['varFuncId'       ] ?? "";
$app_title      = $_GET['varTitle'     ] ?? "";
$app_area       = $_GET['varZone'      ] ?? "";
$app_dir        = $_GET['varAppDir'       ] ?? "";
$file_name      = $_GET['varFileName'     ] ?? "";

#---------------------------------------------------------------------------------------------------

function get_index()
{
  global $dir_templates, $server_docroot, $dir_texts, $ext_text;
  global $dir_zones, $app_title, $app_area, $app_dir;

  $file_template = "../{$dir_templates}/lyrics-reader-index.html";

  $page_title = rawurldecode($app_title);
  $path_dir_text = "../{$dir_zones}/{$app_area}/{$app_dir}/{$dir_texts}";

  $page_content = "<span class='clIndex'>\n";

  $files_array = scandir($path_dir_text);

  foreach ($files_array as &$file_name)
  {
    if (substr($file_name, 0, 1) === '.')
    {
      continue;
    }

    $file_name_encoded = rawurlencode($file_name);

    $page_content .= "<a href='./lyrics-reader.php?varFuncId=view&varTitle={$app_title}&varZone={$app_area}&varAppDir={$app_dir}&varFileName={$file_name_encoded}'>{$file_name}</a><br>\n";
  }

  $page_content .= "</span>\n";

  $local_css = "<link rel='stylesheet' type='text/css' media='screen' href='../{$dir_zones}/{$app_area}/{$app_dir}/styles/local.css'>";

  $page_html = get_file_template($file_template);

  eval("\$page_html = \"{$page_html}\";");
  echo $page_html;
}

#---------------------------------------------------------------------------------------------------

function get_view()
{
  global $dir_templates, $dir_config, $app_title, $server_docroot, $dir_images, $dir_sounds, $dir_texts;
  global $server_root, $server_port, $ext_image, $ext_sound, $ext_text;
  global $dir_zones, $app_dir, $app_area, $file_name;

  $local_css     = "";
  $titles_index  = '';
  $titles_texts  = '';
  $page_content = '';

  $file_template    = "../{$dir_templates}/lyrics-reader-view.html";

  $file_name = rawurldecode($file_name);
  $page_title = rawurldecode($app_title);
  $path_dir_text = "../{$dir_zones}/{$app_area}/{$app_dir}/{$dir_texts}/{$file_name}";
  $file_image = "../{$dir_zones}/{$app_area}/{$app_dir}/{$dir_images}/{$file_name}.{$ext_image}";
  $dir_sounds = "../{$dir_zones}/{$app_area}/{$app_dir}/{$dir_sounds}/{$file_name}";

  $files_array = scandir($path_dir_text);

  foreach ($files_array as &$title_name)
  {
    if (substr($title_name, 0, 1) === '.')
    {
      continue;
    }

    list($title_number, $title_song, $title_ext) = explode('.', $title_name);

    $song_name = "{$title_number}.{$title_song}.{$ext_sound}";
    $song_name = preg_replace("/'/sU", "&apos;", $song_name);

    $song_text = file_get_contents("{$path_dir_text}/{$title_name}");
    $song_text = preg_replace("/\n/sU", "<br>\n", $song_text);

    $titles_index .= "<a href='#name.{$title_number}'>{$title_song}</a><br>\n";
    $titles_texts .= "<div class='clSong'>\n";
    $titles_texts .= "<a name='name.{$title_number}'>{$title_song}</a><br>\n";
    $titles_texts .= "<audio id='{$song_name}' src='{$dir_sounds}/{$song_name}' preload='auto'></audio>\n";
    $titles_texts .=  "<div class='clAudio'><span class='clNavRewind' onclick='fncRewindTrack(&quot;{$song_name}&quot;)'></span><span class='clNavPlay' onclick='fncPlayTrack(&quot;{$song_name}&quot;)'></div>\n";
    $titles_texts .= "<div class='clText'>\n";
    $titles_texts .= "{$song_text}\n";
    $titles_texts .= "</div>\n";
    $titles_texts .= "<a href='#top'><span class='clNavTop'><span></a><br>\n";
    $titles_texts .= "</div>\n";
  }

  $page_content  = "<h1>{$file_name}</h1>\n";
  $page_content .= "<a name='top'><img class='clImageThumb' src='{$file_image}'></a>\n";
  $page_content .= "<div id='idIndexTitles'>\n";
  $page_content .= "{$titles_index}";
  $page_content .= "</div>\n";
  $page_content .= "<hr class='clHr'>\n";
  $page_content .= "{$titles_texts}";

  $local_css = "<link rel='stylesheet' type='text/css' media='screen' href='../{$dir_zones}/{$app_area}/{$app_dir}/styles/local.css'>";

  $page_html = get_file_template($file_template);

  eval("\$page_html = \"{$page_html}\";");
  echo $page_html;
}

#---------------------------------------------------------------------------------------------------

if      ($func_id == "index")     { get_index();      }
elseif  ($func_id == "view")      { get_view();       }

#---------------------------------------------------------------------------------------------------
?>
