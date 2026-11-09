<?php
#----------------------------------------------------------------------------------------------------
# https://simplehtmldom.sourceforge.io/manual.htm
#----------------------------------------------------------------------------------------------------

setlocale( LC_ALL, 'en_US.UTF-8' );
isset( $_SERVER['HTTPS'] ) ? $server_protocol = "https" : $server_protocol = "http";

$server_root            = $server_protocol . '://' . $_SERVER['SERVER_NAME'];
$server_port            = $_SERVER['SERVER_PORT'];
$server_docroot         = $_SERVER['DOCUMENT_ROOT'];

$dir_zones              = "zones";
$dir_templates          = "templates/hypers";
$ext_sound              = "mp3";
$ext_image              = "jpg";
$ext_html               = "html";
$ext_text               = "txt";
$dir_texts              = "texts";
$dir_sounds             = "sounds";
$dir_images             = "images";
$file_index             = "index";
$items_number           = 0;

$data_area              = '';

$user_agent             = 'Mozilla/5.0 (X11; Linux x86_64; rv:111.0) Gecko/20100101 Firefox/111.0';

#----------------------------------------------------------------------------------------------------

function get_url_shellexec($url_link)
{
  global $user_agent;

  $curl_content = shell_exec("curl -s -A \"{$user_agent}\" {$url_link}");

  return $curl_content;
}

#----------------------------------------------------------------------------------------------------

function get_url($url_link, $post_fields = null)
{
  global $user_agent;

  $curl_handle = curl_init();

  curl_setopt($curl_handle, CURLOPT_URL, $url_link);
  curl_setopt($curl_handle, CURLOPT_USERAGENT, $user_agent);
  curl_setopt($curl_handle, CURLOPT_HEADER, false);
  curl_setopt($curl_handle, CURLOPT_COOKIESESSION, true);
#  curl_setopt($curl_handle, CURLOPT_COOKIE, $cookie_header');
  curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($curl_handle, CURLOPT_FOLLOWLOCATION, true);
  curl_setopt($curl_handle, CURLOPT_SSL_VERIFYHOST, false);
  curl_setopt($curl_handle, CURLOPT_SSL_VERIFYPEER, false);
#  curl_setopt($curl_handle, CURLOPT_ENCODING, 'gzip, deflate');
#  curl_setopt($curl_handle, CURLOPT_FAILONERROR, true);
  curl_setopt($curl_handle, CURLOPT_AUTOREFERER, true);
#  curl_setopt($curl_handle, CURLOPT_REFERER, '');
  curl_setopt($curl_handle, CURLOPT_CONNECTTIMEOUT, 20);
  curl_setopt($curl_handle, CURLOPT_TIMEOUT, 60);
  curl_setopt($curl_handle, CURLOPT_FORBID_REUSE, false);
  curl_setopt($curl_handle, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

  if (! is_null($post_fields))
  {
    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $post_fields);
#    file_put_contents('/tmp/php_test.txt', $post_fields['langdir'] . " " . $post_fields['search']);
  }

  curl_setopt($curl_handle, CURLOPT_HTTPHEADER,
    array(
        'accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9',
        'accept-language: en-US,en',
        'cache-control: no-cache',
        'connection: keep-alive',
        'dnt: 1',
        'pragma: no-cache',
        'sec-fetch-dest: document',
        'sec-fetch-mode: navigate',
        'sec-fetch-site: none',
        'sec-fetch-user: ?1',
        'upgrade-insecure-requests: 1',
      )
  );

  $curl_content = curl_exec($curl_handle);
  $http_status = curl_getinfo($curl_handle, CURLINFO_HTTP_CODE);

#  file_put_contents('/tmp/php_test.txt', $url_link);

  if (curl_errno($curl_handle)) { print 'Error: [' . curl_error($curl_handle) . ']'; }

  curl_close($curl_handle);

  return $curl_content;
}

#----------------------------------------------------------------------------------------------------

function get_file_template($file_name)
{
  $file_content = "";
  $file_content = file_get_contents($file_name);
  $file_content = preg_replace("/\"/", "'", $file_content);
  return $file_content;
}

#----------------------------------------------------------------------------------------------------

function get_markdown($page_html)
{
  global $dir_zones, $app_area, $app_dir;

  if ($app_area != "")
  {
    $page_url = "../{$dir_zones}/{$app_area}/{$app_dir}";
  }
  else
  {
    $page_url = ".." . dirname($_SERVER['REQUEST_URI']);
    $page_url = preg_replace("/\.\.\/hypers\/notes-keeper\.php\?varFuncId=view\&varDirCurrent=/sU", "", $page_url);
  }

#----------------------------------------------------------------------------------------------------
# Add LF at ^ and $
#----------------------------------------------------------------------------------------------------

  $page_html =  "\n" . $page_html . "\n";

#----------------------------------------------------------------------------------------------------
# Quotes
#----------------------------------------------------------------------------------------------------

  $page_html = preg_replace("/\"/sU",                         "&quot;", $page_html);
#  $page_html = preg_replace("/\'/sU",                         "&apos;", $page_html);
#  $page_html = preg_replace("/\`/sU",                         "&grave;", $page_html);

#----------------------------------------------------------------------------------------------------
# Unordered List
#----------------------------------------------------------------------------------------------------

  $page_html = preg_replace_callback(
    "/\[\-\n(.*?)\n\-\]/s",
    function($matches_array)
    {
      $string_matched = $matches_array[1];
      $string_matched = preg_replace("/^(.*?)$/m",            "<li>$1</li>", $string_matched);
      return "<ul>\n{$string_matched}\n</ul>";
    }, $page_html);

#----------------------------------------------------------------------------------------------------
# Ordered List
#----------------------------------------------------------------------------------------------------

  $page_html = preg_replace_callback(
    "/\[\+\n(.*?)\n\+\]/s",
    function($matches_array)
    {
      $string_matched = $matches_array[1];
      $string_matched = preg_replace("/^(.*?)$/m",            "<li>$1</li>", $string_matched);
      return "<ol>\n{$string_matched}\n</ol>";
    }, $page_html);

#----------------------------------------------------------------------------------------------------
# Pre
#----------------------------------------------------------------------------------------------------

  $page_html = preg_replace_callback(
    "/\[\*\n(.*?)\n\*\]/s",
    function($matches_array)
    {
      $string_matched = $matches_array[1];
      $string_matched = preg_replace("/\n/s",                 "REMOVE_PRECODE\n", $string_matched);
      return "<pre>{$string_matched}</pre>";
    }, $page_html);

#----------------------------------------------------------------------------------------------------
# Pre Code
#----------------------------------------------------------------------------------------------------

  $page_html = preg_replace_callback(
    "/\[\?\n(.*?)\n\?\]/s",
    function($matches_array)
    {
      $string_matched = $matches_array[1];
      $string_matched = preg_replace("/\n/s",                 "REMOVE_PRECODE\n", $string_matched);
      return "<pre><code>{$string_matched}</code></pre>";
    }, $page_html);

#----------------------------------------------------------------------------------------------------
# Blockquote
#----------------------------------------------------------------------------------------------------

  $page_html = preg_replace_callback(
    "/\[\!\n(.*?)\n\!\]/s",
    function($matches_array)
    {
      $string_matched = $matches_array[1];
      return "<blockquote>\n{$string_matched}\n</blockquote>";
    }, $page_html);

#----------------------------------------------------------------------------------------------------
# Details
#----------------------------------------------------------------------------------------------------

  $page_html = preg_replace_callback(
    "/\[\@ \((.*?)\)\n(.*?)\n\@\]/s",
    function($matches_array)
    {
      $string_matched_1 = $matches_array[1];
      $string_matched_2 = $matches_array[2];
#      $string_matched_2 = preg_replace("/\n/s", "", $string_matched_2);
      return "<details><summary>{$string_matched_1}</summary>{$string_matched_2}</details>";
    }, $page_html);



#----------------------------------------------------------------------------------------------------
# Links
#----------------------------------------------------------------------------------------------------

#  $page_html = preg_replace("/\!\[(.*?)\|(.*?)\]/",           "<a target='_blank' referrerpolicy='no-referrer' class='clLinkBlue' href='$2'>$1</a>", $page_html);
  $page_html = preg_replace("/\!\[(.*?)\|(.*?)\]/",           "<a target='_blank' rel='noreferrer' class='clLinkBlue' href='$2'>$1</a>", $page_html);
  $page_html = preg_replace("/\^\[(.*?)\]/",                  "<a target='_blank' href='{$page_url}/$1'><img class='clImageThumb' src='{$page_url}/$1'></a>", $page_html);
  $page_html = preg_replace("/\@\[(.*?)\]/",                  "<img src='{$page_url}/$1'>", $page_html);

  $page_html = preg_replace("/\%\[t1\|(.*?)\]/",              "<a href='../../hypers/hanzi-strokes.php?varHanziId=$1'><span class='t1'>$1</span></a>", $page_html);
  $page_html = preg_replace("/\%\[t2\|(.*?)\]/",              "<a href='../../hypers/hanzi-strokes.php?varHanziId=$1'><span class='t2'>$1</span></a>", $page_html);
  $page_html = preg_replace("/\%\[t3\|(.*?)\]/",              "<a href='../../hypers/hanzi-strokes.php?varHanziId=$1'><span class='t3'>$1</span></a>", $page_html);
  $page_html = preg_replace("/\%\[t4\|(.*?)\]/",              "<a href='../../hypers/hanzi-strokes.php?varHanziId=$1'><span class='t4'>$1</span></a>", $page_html);
  $page_html = preg_replace("/\%\[t5\|(.*?)\]/",              "<a href='../../hypers/hanzi-strokes.php?varHanziId=$1'><span class='t5'>$1</span></a>", $page_html);
  $page_html = preg_replace("/\%\[zhm\|(.*?)\]/",             "<a href='../../hypers/hanzi-strokes.php?varHanziId=$1'><span class='zhm'>$1</span></a>", $page_html);
  $page_html = preg_replace("/\%\[(.*?)\|(.*?)\]/",           "<span class='$1'>$2</span>", $page_html);

#----------------------------------------------------------------------------------------------------
# Audio
#----------------------------------------------------------------------------------------------------

  $page_html = preg_replace_callback(
    "/\*\[(.*?)\]/s",
    function($matches_array)
    {
      $string_matched = $matches_array[1];
      $strTagAudio = basename($string_matched);
      $strReturn  = "<audio id='{$strTagAudio}' src='MediaURI/{$string_matched}' preload='auto'></audio>\n";
      $strReturn .= "<span class='clAudio'><span class='clNavRewind' onclick='fncRewindTrack(&quot;{$strTagAudio}&quot;)'></span><span class='clNavPlay' onclick='fncPlayTrack(&quot;{$strTagAudio}&quot;)'></span></span>";
      return $strReturn;
    }, $page_html);

  $page_html = preg_replace("/MediaURI/",                     "{$page_url}", $page_html);

#----------------------------------------------------------------------------------------------------
# Video
#----------------------------------------------------------------------------------------------------

  $page_html = preg_replace_callback(
    "/=\[(.*?),(.*?)\]/s",
    function($matches_array)
    {
      $string_matched_1 = $matches_array[1];
      $string_matched_2 = $matches_array[2];
      $strTagVideo = basename($string_matched_1);

      $strReturn  = "<video id='{$strTagVideo}' src='MediaURI/{$string_matched_1}' poster='MediaURI/{$string_matched_2}' loop preload='auto'></video>\n";

      $strReturn .= "<div class='clVideo'><span class='clNavRewind' onclick='fncRewindTrack(&quot;{$strTagVideo}&quot;)'></span><span class='clNavPlay' onclick='fncPlayTrack(&quot;{$strTagVideo}&quot;)'></span></div>";

      return $strReturn;
    }, $page_html);

  $page_html = preg_replace("/MediaURI/",                     "{$page_url}", $page_html);

#----------------------------------------------------------------------------------------------------
# Table
#----------------------------------------------------------------------------------------------------

  $page_html = preg_replace_callback(
    "/\[\|\n(.*?)\n\|\]/s",
    function($matches_array)
    {
      $string_matched = $matches_array[1];
      $string_matched = preg_replace("/^\^(.*?)\^$/m" ,       "<tr><th>$1</th></tr>", $string_matched);
      $string_matched = preg_replace("/^\|(.*?)\|$/m" ,       "<tr><td>$1</td></tr>", $string_matched);
      $string_matched = preg_replace("/\^/sU",                "</th><th>", $string_matched);
      $string_matched = preg_replace("/\|/sU",                "</td><td>", $string_matched);
      return "<div class='clOverflow'><table>{$string_matched}</table></div>";
    }, $page_html);

  $page_html = preg_replace_callback(
    "/\[\|\-\n(.*?)\n\|\]/s",
    function($matches_array)
    {
      $string_matched = $matches_array[1];
      $string_matched = preg_replace("/^\^(.*?)\^$/m" ,       "<tr><th>$1</th></tr>", $string_matched);
      $string_matched = preg_replace("/^\|(.*?)\|$/m" ,       "<tr><td>$1</td></tr>", $string_matched);
      $string_matched = preg_replace("/\^/sU",                "</th><th>", $string_matched);
      $string_matched = preg_replace("/\|/sU",                "</td><td>", $string_matched);
      return "<div class='clOverflow'><table class='clNoBorder'>{$string_matched}</table></div>";
    }, $page_html);

#----------------------------------------------------------------------------------------------------
# Bold and Italic
#----------------------------------------------------------------------------------------------------

  $page_html = preg_replace("/\*{2,2}(.*?)\*{2,2}/",          "<b>$1</b>", $page_html);
  $page_html = preg_replace("/\_{2,2}(.*?)\_{2,2}/",          "<i>$1</i>", $page_html);

#----------------------------------------------------------------------------------------------------
# Horizontal Line
#----------------------------------------------------------------------------------------------------

  $page_html = preg_replace("/\n-{3,}?\n/",                   "\n<hr class='clHr'>\n", $page_html);

#----------------------------------------------------------------------------------------------------
# Headers
#----------------------------------------------------------------------------------------------------

  $page_html = preg_replace("/^###### (.*) ######\n/m",       "", $page_html);
  $page_html = preg_replace("/^##### (.*) #####\n/m",         "", $page_html);
  $page_html = preg_replace("/^#### (.*) ####\n/m",           "", $page_html);
  $page_html = preg_replace("/^### (.*) ###\n/m",             "", $page_html);
  $page_html = preg_replace("/^## (.*) ##\n/m",               "", $page_html);
  $page_html = preg_replace("/^# (.*) #\n/m",                 "", $page_html);

  $page_html = preg_replace("/^###### (.*)$/m",               "<h6>$1</h6>", $page_html);
  $page_html = preg_replace("/^##### (.*)$/m",                "<h5>$1</h5>", $page_html);
  $page_html = preg_replace("/^#### (.*)$/m",                 "<h4>$1</h4>", $page_html);
  $page_html = preg_replace("/^### (.*)$/m",                  "<h3>$1</h3>", $page_html);
  $page_html = preg_replace("/^## (.*)$/m",                   "<h2>$1</h2>", $page_html);
  $page_html = preg_replace("/^# (.*)$/m",                    "<h1>$1</h1>", $page_html);

#----------------------------------------------------------------------------------------------------
# Padding
#----------------------------------------------------------------------------------------------------

  $page_html = preg_replace("/^>>> (.*)$/m",                  "&ensp;&ensp;&ensp;$1", $page_html);
  $page_html = preg_replace("/^>> (.*)$/m",                   "&ensp;&ensp;$1", $page_html);
  $page_html = preg_replace("/^> (.*)$/m",                    "&ensp;$1", $page_html);

#----------------------------------------------------------------------------------------------------
# Linguistics Styles
#----------------------------------------------------------------------------------------------------

  $page_html = preg_replace("/^\|\|(.*?)\|(.*?)\|(.*?)$/m",   "<p class='m0000-18'>$1</p><p class='g0500'>$2</p><p class='b1000'>$3</p>\n", $page_html);
  $page_html = preg_replace("/^\|(.*?)\|(.*?)\|(.*?)$/m",     "<p class='m0000'>$1</p><p class='g0500'>$2</p><p class='b1000'>$3</p>\n", $page_html);
  $page_html = preg_replace("/\|\|(.*?)\n(.*?)\n/s",          "<p class='m0000'>$1</p><p class='b1000'>$2</p>\n", $page_html);

#----------------------------------------------------------------------------------------------------
# Cleaning
#----------------------------------------------------------------------------------------------------

  $page_html = preg_replace("/^\n(.*?)\n$/s",                 "$1", $page_html);
  $page_html = preg_replace("/\n/s",                          "<br>\n", $page_html);

  $page_html = preg_replace("/<br>\n<ul>/s",                  "\n<ul>", $page_html);
  $page_html = preg_replace("/<br>\n<ol>/s",                  "\n<ol>", $page_html);

  $page_html = preg_replace("/<ul><br>/s",                    "<ul>", $page_html);
  $page_html = preg_replace("/<ol><br>/s",                    "<ol>", $page_html);

  $page_html = preg_replace("/<\/li><br>/s",                  "</li>", $page_html);

  $page_html = preg_replace("/<\/ul><br>\n<br>/s",            "</ul>\n", $page_html);
  $page_html = preg_replace("/<\/ul><br>/s",                  "</ul>\n", $page_html);
  $page_html = preg_replace("/<\/ol><br>\n<br>/s",            "</ol>\n", $page_html);
  $page_html = preg_replace("/<\/ol><br>/s",                  "</ol>\n", $page_html);

  $page_html = preg_replace("/<\/pre><br>/s",                 "</pre>\n", $page_html);

  $page_html = preg_replace("/<br>\n<div class='clOver/s",    "\n<div class='clOver", $page_html);
  $page_html = preg_replace("/<br>\n<div class='clOver/s",    "\n<div class='clOver", $page_html);
  $page_html = preg_replace("/<\/tr><br>/s",                  "</tr>", $page_html);
  $page_html = preg_replace("/<table><tr>/s",                 "\n<table>\n<tr>\n", $page_html);
  $page_html = preg_replace("/<\/table><\/div><br>/s",        "\n</table>\n</div>\n", $page_html);

  $page_html = preg_replace("/<br>\n<h/s",                    "\n<h", $page_html);
  $page_html = preg_replace("/([1-6])><br>\n<br>/s",          "$1>\n", $page_html);
  $page_html = preg_replace("/([1-6])><br>/s",                "$1>", $page_html);
  $page_html = preg_replace("/clHr\'><br>/s",                 "clHr'>\n", $page_html);
  $page_html = preg_replace("/REMOVE_PRECODE<br>/s",          "", $page_html);
  $page_html = preg_replace("/REMOVE_BR<br>/s",               "", $page_html);

  $page_html = preg_replace("/<\/details><br>/s",           "</details>\n", $page_html);

  $page_html = preg_replace("/<\/div><br>\n<br>/s",           "</div>\n", $page_html);
  $page_html = preg_replace("/<\/div>\n\n<br>/s",             "</div>\n", $page_html);
  $page_html = preg_replace("/<\/div><br>\n/s",               "</div>\n", $page_html);
  $page_html = preg_replace("/<\/blockquote><br>\n<br>/s",    "</blockquote>\n", $page_html);
  $page_html = preg_replace("/<\/blockquote><br>/s",          "</blockquote>", $page_html);
  $page_html = preg_replace("/<br>\n<blockquote>/s",          "\n<blockquote>", $page_html);
  $page_html = preg_replace("/<blockquote><br>/s",            "<blockquote>", $page_html);
  $page_html = preg_replace("/<br>\n<pre>/s",                 "\n<pre>", $page_html);
  $page_html = preg_replace("/<\/pre>\n\n<br>/s",             "</pre>\n", $page_html);
  $page_html = preg_replace("/<\/p><br>\n<br>/s",             "</p>", $page_html);
  $page_html = preg_replace("/<\/p><br>/s",                   "</p>", $page_html);
  $page_html = preg_replace("/--><br>/s",                     "-->", $page_html);

#----------------------------------------------------------------------------------------------------
# Remove Index Break
#----------------------------------------------------------------------------------------------------

  $page_html = preg_replace("/#~~#<br>/s",                    "", $page_html);

#----------------------------------------------------------------------------------------------------
# Hard Break
#----------------------------------------------------------------------------------------------------

  $page_html = preg_replace("/~~/sU",                         "<br>", $page_html);

#----------------------------------------------------------------------------------------------------

  return $page_html;
}

#----------------------------------------------------------------------------------------------------
?>
