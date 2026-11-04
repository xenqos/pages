<?php
#--------------------------------------------------------------------------------------------------

require_once('../units/commons/simplehtmldom.php');

#--------------------------------------------------------------------------------------------------
# Get Index
#--------------------------------------------------------------------------------------------------

function get_index()
{
  $title      = $GLOBALS['title'];
  $unit       = $GLOBALS['unit'];
  $id         = $GLOBALS['id'];
  $directory  = $GLOBALS['directory'];

  $configs = array_slice(scandir($directory), 2);

  $content = "<h1>{$title}</h1>\n";
  $config_theme_counter = 1;
  $config_media_counter = 1;

  foreach ($configs as &$config)
  {
    $filename = pathinfo($config, PATHINFO_FILENAME);
    require_once("{$directory}/{$filename}.php");

    if ($config_enabled == "false") { continue; }

    if ($config_type == "theme")
    {
      if ($config_theme_counter > 1)
      {
        $content .= <<<DOC
          </div>\n
          </div>\n
        DOC;
      }

      $theme_id_number = sprintf('%02d', $config_theme_counter);

      $content .= <<<DOC
        \n<p class='clMediaName'>
          <a href='javascript:fncShowHideWithMemory(&quot;idDivTheme{$theme_id_number}&quot;)'>{$media_name}</a>
        </p>\n
        <div id='idDivTheme{$theme_id_number}'>\n
      DOC;

      $config_theme_counter++;
    }
    elseif ($config_type == "media")
    {
      if ($config_media_counter > 1)
      {
        $content .= "</div>\n";
      }

      $media_id_number = sprintf('%02d', $config_media_counter);

      $content .= <<<DOC
        \n<p class='clMediaName'>
          <a href='javascript:fncShowHideWithMemory(&quot;idDivMedia{$media_id_number}&quot;)'>{$media_name}</a>
        </p>\n
        <div id='idDivMedia{$media_id_number}'>\n
      DOC;

      $config_media_counter++;
    }
    elseif ($config_type == "link")
    {
      $content .= <<<DOC
        <p class='clMediaName'>
          <a href='./news.php?varAction=headlines&varId={$filename}'>{$media_name}</a>
        </p>\n
      DOC;
    }
  }

  $content = preg_replace("~<div id='idDivTheme(\d+?)'>\n</div>~m", "<div id='idDivTheme$1'>", $content);

  $content .= <<<DOC
    </div>\n
    </div>\n
  DOC;

  $html = get_template('index');
  eval("\$html = \"{$html}\";");
  echo $html;
}

#--------------------------------------------------------------------------------------------------
# Get Headlines
#--------------------------------------------------------------------------------------------------

function get_headlines()
{
  $title      = $GLOBALS['title'];
  $unit       = $GLOBALS['unit'];
  $id         = $GLOBALS['id'];
  $directory  = $GLOBALS['directory'];

  require_once("{$directory}/{$id}.php");

  $media_url_scheme = parse_url($media_url, PHP_URL_SCHEME);
  $media_url_host   = parse_url($media_url, PHP_URL_HOST);
  $media_url_path   = parse_url($media_url, PHP_URL_PATH);

  $title = $media_name;
  $content = "<h1>{$title}</h1>\n";

  $media_content = get_url($media_url);

  if ($media_encode == 'true') $media_content = mb_convert_encoding($media_content, 'utf-8', $media_encoding);
  $media_content = preg_replace("~\r\n~s", "\n", $media_content);

  foreach($clean_module as $regex)
  {
    if ($regex[0] == "") continue;
    $media_content = preg_replace("~$regex[0]~s", "$regex[1]", $media_content);
  }

  # debug($media_content);

  $htmldom = str_get_html($media_content);
  $module = $htmldom->find($module_body , 0);

  $articles = $module->find($module_article);

  foreach ($articles as $article)
  {

    $found = $article->find($module_headline, 0)->innertext ?? '';
    $headline_name = trim($found);

    $found = $article->find('a', 0)->href ?? '';
    $headline_url = trim($found);

    if (substr($headline_url, 0, 4) != 'http')
    {
      if (substr($headline_url, 0, 3) == '../')
      {
        $headline_url = preg_replace("~\.\./~m", "/", $headline_url);
        $headline_url = $media_url_scheme . '://' . $media_url_host . $headline_url;
      }
      elseif (substr($headline_url, 0, 1) == '/')
      {
        $headline_url = $media_url_scheme . '://' . $media_url_host . $headline_url;
      }
      else
      {
        $headline_url = $media_url_scheme . '://' . $media_url_host . $media_url_path . '/' . $headline_url;
      }
    }

    $headline_url = rawurlencode($headline_url);

    # $content .= "{$headline_url}<br>";

    $content .= <<<DOC
      <p class='clMediaHeadline'>
        <a href='./news.php?varAction=article&varId={$id}&varUrl={$headline_url}'>{$headline_name}</a>
      </p>\n
    DOC;
  }

  $html = get_template('headlines');
  eval("\$html = \"{$html}\";");
  echo $html;
}

#--------------------------------------------------------------------------------------------------
# Get Article
#--------------------------------------------------------------------------------------------------

function get_article()
{
  $title      = $GLOBALS['title'];
  $unit       = $GLOBALS['unit'];
  $id         = $GLOBALS['id'];
  $url        = $GLOBALS['url'];
  $directory  = $GLOBALS['directory'];

  require_once("{$directory}/{$id}.php");

  $url = rawurldecode($url);

  $media_scheme  = parse_url($url, PHP_URL_SCHEME);
  $media_prefix  = parse_url($url, PHP_URL_SCHEME);
  $media_prefix .= '://';
  $media_prefix .= parse_url($url, PHP_URL_HOST);

  $media_name_encoded = rawurlencode($media_name);
  $media_url_encoded = rawurlencode($url);

  $media_content = get_url($url);

  # debug($media_content);

  if ($media_encode == 'true') $media_content = mb_convert_encoding($media_content, "utf-8", $media_encoding);
  $media_content = preg_replace("~\r\n~s", "\n", $media_content);

  $media_content = preg_replace("~src=\"//~s", "src=\"{$media_scheme}://", $media_content);
  $media_content = preg_replace("~href=\"//~s", "href=\"{$media_scheme}://", $media_content);

  $media_content = preg_replace("~href=\"/~s", "href=\"{$media_prefix}/", $media_content);
  $media_content = preg_replace("~src=\"/~s", "src=\"{$media_prefix}/", $media_content);

  foreach($clean_article_pre as $regex)
  {
    if ($regex[0] == '') continue;
    $media_content = preg_replace("~$regex[0]~s", "$regex[1]", $media_content);
  }

  $htmldom = str_get_html($media_content);

  $article_content_title  = $htmldom->find($article_title, 0)->innertext  ?? '';
  $article_content_date   = $htmldom->find($article_date, 0)->innertext   ?? '';
  $article_content_author = $htmldom->find($article_author, 0)->innertext ?? '';
  $article_content_body   = $htmldom->find($article_body, 0)->innertext   ?? '';

  $content = '';

  foreach($clean_article_post as $regex)
  {
    if ($regex[0] == '') continue;
    $article_content_body = preg_replace("~$regex[0]~s", "$regex[1]", $article_content_body);
  }

#$article_content_body = preg_replace("~>~s", ">\n", $article_content_body);
#debug($article_content_body);

  $article_content_body = preg_replace("~src=\"(.*?)\"~s", "src='$1'", $article_content_body);
  $article_content_body = preg_replace("~src='http:(.*?)'~s", "src='./image.php?varUrl=http:$1'", $article_content_body);

  $article_content_body = preg_replace("~<iframe(.*?)iframe>~s", "", $article_content_body);
  $article_content_body = preg_replace("~<video(.*?)video>~s", "", $article_content_body);

  $article_content_body = preg_replace("~<li><p>~s", "<li>", $article_content_body);
  $article_content_body = preg_replace("~</p></li>~s", "</li>", $article_content_body);

  $title = $article_content_title;

  $content = <<<DOC
    <h1 class='clMediaArticleTitle'>{$title}</h1>\n
    <div class='clMediaArticleInfo'>{$article_content_date}&emsp;{$article_content_author}</div>
    $article_content_body
  DOC;

  $html = get_template('article');
  eval("\$html = \"{$html}\";");
  echo $html;
}

#--------------------------------------------------------------------------------------------------
?>
