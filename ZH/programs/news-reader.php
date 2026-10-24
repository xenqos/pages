<?php
#---------------------------------------------------------------------------------------------------

include("./global-objects.php");
include("./simple-html-dom.php");

#---------------------------------------------------------------------------------------------------

$func_id        = $_GET['varFuncId' ] ?? "";
$conf_id        = $_GET['varConfId' ] ?? "";
$media_url      = $_GET['varUrl'    ] ?? "";

#---------------------------------------------------------------------------------------------------

$app_title      = "News";
$data_area      = "ln";

$dir_zones       = "zones";
$dir_area       = "ln";
$dir_name       = "news_reader";
$dir_config     = "../{$dir_zones}/{$dir_area}/{$dir_name}";

#---------------------------------------------------------------------------------------------------

0 ? $debug_flag = true : $debug_flag = false;

#---------------------------------------------------------------------------------------------------

function get_index()
{
  global $dir_templates, $dir_config, $app_title;

  $media_name_encoded = "";
  $media_url_encoded  = "";

  $file_template = "../{$dir_templates}/news-reader-index.html";

  $config_files_array = scandir($dir_config);

  $page_title = $app_title;
  $page_content = "<h1>{$page_title}</h1>\n";

  $config_theme_counter = 1;
  $config_media_counter = 1;

  foreach ($config_files_array as &$config_file)
  {
    if ($config_file == '.' || $config_file == '..') { continue; }

    $conf_id = pathinfo($config_file, PATHINFO_FILENAME);

    unset($config_array);
    include("{$dir_config}/{$config_file}");

    $config_enabled = $config_array["config_enabled"];
    $config_type    = $config_array["config_type"];
    $media_name     = $config_array["media_name"];

    if ($config_enabled == "false")
    {
      continue;
    }

    if ($config_type == "theme")
    {
      if ($config_theme_counter > 1)
      {
        $page_content .= "</div>\n";
        $page_content .= "</div>\n";
      }

      $theme_id_number = sprintf('%02d', $config_theme_counter);
      $page_content .= "\n<p class='clMediaName'><a href='javascript:fncShowHideWithMemory(&quot;idDivTheme{$theme_id_number}&quot;)'>{$media_name}</a></p>\n";
      $page_content .= "<div id='idDivTheme{$theme_id_number}'>\n";
      $config_theme_counter++;
    }
    elseif ($config_type == "media")
    {
      if ($config_media_counter > 1)
      {
        $page_content .= "</div>\n";
      }

      $media_id_number = sprintf('%02d', $config_media_counter);
      $page_content .= "\n<p class='clMediaName'><a href='javascript:fncShowHideWithMemory(&quot;idDivMedia{$media_id_number}&quot;)'>{$media_name}</a></p>\n";
      $page_content .= "<div id='idDivMedia{$media_id_number}'>\n";
      $config_media_counter++;
    }
    elseif ($config_type == "link")
    {
      $page_content .= "<p class='clMediaName'><a href='./news-reader.php?varFuncId=headlines&varConfId={$conf_id}'>{$media_name}</a></p>\n";
    }
  }

  $page_content = preg_replace("/<div id='idDivTheme(\d+?)'>\n<\/div>/m", "<div id='idDivTheme$1'>", $page_content);

  $page_content .= "</div>\n";
  $page_content .= "</div>\n";

  $page_html = get_file_template($file_template);

  eval("\$page_html = \"{$page_html}\";");
  echo $page_html;
}

#---------------------------------------------------------------------------------------------------

function get_headlines()
{
  global $dir_templates, $dir_config, $conf_id, $debug_flag;

  $debug_file     = "/home/" . get_current_user() . "/mnt/data/Temp/debug-get-headlines";
  $file_template = "../{$dir_templates}/news-reader-headlines.html";

  unset($config_array);
  include("{$dir_config}/{$conf_id}.php");

  $media_name       = $config_array["media_name"];
  $media_url        = $config_array["media_url"];
  $media_encode     = $config_array["media_encode"];
  $media_encoding   = $config_array["media_encoding"];

  $module_body      = $config_array["module_body"];
  $module_article   = $config_array["module_article"];
  $module_headline  = $config_array["module_headline"];

  $clean_module     = $config_array["clean_module"];

  $media_url_scheme = parse_url($config_array["media_url"], PHP_URL_SCHEME);
  $media_url_host   = parse_url($config_array["media_url"], PHP_URL_HOST);
  $media_url_path   = parse_url($config_array["media_url"], PHP_URL_PATH);

  $page_title = $media_name;
  $page_content = "<h1>{$page_title}</h1>\n";

  $media_content = get_url($media_url);

  if ($media_encode == "true") $media_content = mb_convert_encoding($media_content, "utf-8", $media_encoding);
  $media_content = preg_replace("/\r\n/s", "\n", $media_content);

  if ($debug_flag)
  {
    file_put_contents($debug_file . "-01.log", '');
    file_put_contents($debug_file . "-01.log", $media_content, FILE_APPEND);
  }

  foreach($clean_module as $regex_array)
  {
    if ($regex_array[0] == "") continue;
    $media_content = preg_replace("$regex_array[0]", "$regex_array[1]", $media_content);
  }

  if ($debug_flag)
  {
    $media_content = preg_replace("/</s", "\n<", $media_content);
    file_put_contents($debug_file . "-02.log", '');
    file_put_contents($debug_file . "-02.log", $media_content, FILE_APPEND);
  }

  $html_object = str_get_html($media_content);
  $module_array = $html_object->find($module_body , 0);

#print_r($html_object, true);
#var_dump($html_object);
#var_dump($module_array);
#var_export($html_object);
#exit;

  $articles_array = $module_array->find($module_article);

  if ($debug_flag)
  {
    file_put_contents($debug_file . "-03.log", '');
  }

  foreach ($articles_array as $article_block)
  {
    $headline_name = trim($article_block->find($module_headline, 0)->innertext) ?? "";
    $headline_url = trim($article_block->find('a', 0)->href);

    if ($debug_flag)
    {
      file_put_contents($debug_file . "-03.log", "<<<\n" . $article_block . "\n>>>\n\n\n", FILE_APPEND);
    }

    if (substr($headline_url, 0, 4) != "http")
    {
      if (substr($headline_url, 0, 3) == "../")
      {
        $headline_url = preg_replace("/\.\.\//m", "/", $headline_url);
        $headline_url = $media_url_scheme . '://' . $media_url_host . $headline_url;
      }
      elseif (substr($headline_url, 0, 1) == "/")
      {
        $headline_url = $media_url_scheme . '://' . $media_url_host . $headline_url;
      }
      else
      {
        $headline_url = $media_url_scheme . '://' . $media_url_host . $media_url_path . '/' . $headline_url;
      }
    }

    $headline_url = rawurlencode($headline_url);

    $page_content .= "<p class='clMediaHeadline'>";
    $page_content .= "<a href='./news-reader.php?varFuncId=article&varConfId={$conf_id}&varUrl={$headline_url}'>{$headline_name}</a>";
    $page_content .= "</p>\n";
  }

  $page_html = get_file_template($file_template);

  eval("\$page_html = \"{$page_html}\";");
  echo $page_html;
}

#---------------------------------------------------------------------------------------------------

function get_article()
{
  global $dir_templates, $dir_config, $conf_id, $media_url, $debug_flag;

  $debug_file = "/home/" . get_current_user() . "/mnt/data/Temp/debug-get-article";
  $file_template = "../{$dir_templates}/news-reader-article.html";

  unset($config_array);
  include("{$dir_config}/{$conf_id}.php");

  $media_url = rawurldecode($media_url);

  $media_name         = $config_array["media_name"];
  $media_encode       = $config_array["media_encode"];
  $media_encoding     = $config_array["media_encoding"];

  $article_title      = $config_array["article_title"];
  $article_date       = $config_array["article_date"];
  $article_author     = $config_array["article_author"];
  $article_body       = $config_array["article_body"];

  $clean_article_pre  = $config_array["clean_article_pre"];
  $clean_article_post = $config_array["clean_article_post"];

  $media_scheme  = parse_url($config_array["media_url"], PHP_URL_SCHEME);
  $media_prefix  = parse_url($config_array["media_url"], PHP_URL_SCHEME);
  $media_prefix .= '://';
  $media_prefix .= parse_url($config_array["media_url"], PHP_URL_HOST);

  $media_name_encoded = rawurlencode($media_name);
  $media_url_encoded = rawurlencode($media_url);

  $media_content = get_url($media_url);

  if ($media_encode == "true") $media_content = mb_convert_encoding($media_content, "utf-8", $media_encoding);
  $media_content = preg_replace("/\r\n/s", "\n", $media_content);

  if ($debug_flag)
  {
#    $media_content = preg_replace("/</s", "\n<", $media_content);
    file_put_contents($debug_file . "-01.log", $media_content);
  }

  $media_content = preg_replace("/src=\"\/\//s", "src=\"{$media_scheme}://", $media_content);
  $media_content = preg_replace("/href=\"\/\//s", "href=\"{$media_scheme}://", $media_content);

  $media_content = preg_replace("/href=\"\//s", "href=\"{$media_prefix}/", $media_content);
  $media_content = preg_replace("/src=\"\//s", "src=\"{$media_prefix}/", $media_content);

  foreach($clean_article_pre as $regex_array)
  {
    if ($regex_array[0] == "") continue;
    $media_content = preg_replace("$regex_array[0]", "$regex_array[1]", $media_content);
  }

  if ($debug_flag)
  {
#    $media_content = preg_replace("/</s", "\n<", $media_content);
    file_put_contents($debug_file . "-02.log", $media_content);
  }

  $html_object = str_get_html($media_content);

  $article_title_content  = $html_object->find($article_title, 0)->innertext  ?? "";
  $article_date_content   = $html_object->find($article_date, 0)->innertext   ?? "";
  $article_author_content = $html_object->find($article_author, 0)->innertext ?? "";
  $article_body_content   = $html_object->find($article_body, 0)->innertext   ?? "";

  foreach($clean_article_post as $regex_array)
  {
    if ($regex_array[0] == "") continue;
    $article_body_content = preg_replace("$regex_array[0]", "$regex_array[1]", $article_body_content);
  }

  if ($debug_flag)
  {
    $article_body_content = preg_replace("/</s", "\n<", $article_body_content);
    file_put_contents($debug_file . "-03.log", $article_body_content);
  }

  $article_body_content = preg_replace("/src=\"(.*?)\"/s", "src='$1'", $article_body_content);
  $article_body_content = preg_replace("/src='http:(.*?)'/s", "src='./image-server.php?varImageUrl=http:$1'", $article_body_content);

  $article_body_content = preg_replace("/<iframe(.*?)iframe>/s", "", $article_body_content);
  $article_body_content = preg_replace("/<video(.*?)video>/s", "", $article_body_content);

  $article_body_content = preg_replace("/<li><p>/s", "<li>", $article_body_content);
  $article_body_content = preg_replace("/<\/p><\/li>/s", "</li>", $article_body_content);

  $page_title = $article_title_content;
  $page_content  = "<h1 class='clMediaArticleTitle'>{$page_title}</h1>\n";
  $page_content .= "<div class='clMediaArticleInfo'>{$article_date_content}&emsp;{$article_author_content}</div>\n";
  $page_content .= $article_body_content;

  if ($debug_flag)
  {
    $article_body_content = preg_replace("/</s", "\n<", $article_body_content);
    file_put_contents($debug_file . "-04.log", $article_body_content);
  }

  $page_html = get_file_template($file_template);

  eval("\$page_html = \"{$page_html}\";");
  echo $page_html;
}

#---------------------------------------------------------------------------------------------------

if      ($func_id == "index")     { get_index();      }
elseif  ($func_id == "headlines") { get_headlines();  }
elseif  ($func_id == "article")   { get_article();    }

#---------------------------------------------------------------------------------------------------
?>
