<?php
#--------------------------------------------------------------------------------------------------

require_once('../units/commons/markup.php');

#--------------------------------------------------------------------------------------------------
# Get Index
#--------------------------------------------------------------------------------------------------

function get_index()
{
  $zone       = $GLOBALS['zone'];
  $title      = $GLOBALS['title'];

  $unit       = $GLOBALS['unit'];
  $zones      = $GLOBALS['zones'];

  $path       = $GLOBALS['path'];
  $path_start = $GLOBALS['path_start'];

  $ext_text   = $GLOBALS['ext_text'];

  $path_name  = dirname($path);
  $note_name = preg_replace("~^(.*)/(.*?)$~s", "$2", $path);

  $current_dirs_array = [];
  $current_files_array = [];
  $links_dirs = '';
  $links_files = '';
  $file_ext = '';

  $files = scandir($path);

  foreach ($files as &$file_item)
  {
    if ($file_item === '.' || $file_item === '..')  { continue; }
    if (substr($file_item, 0, 1) === '.')           { continue; }

    if (is_dir("$path/{$file_item}"))
    {
      $current_dirs_array[]  = $file_item;
    }
    else if (is_file("$path/{$file_item}"))
    {
      $current_files_array[] = $file_item;
    }
  }

  foreach ($current_dirs_array as &$current_dirs_item)
  {
    $links_dirs .= "<div><a href='./notes.php?varAction=index&varPath={$path}/" . rawurlencode($current_dirs_item) . "'><span class='clIconDir'></span><span class='link_text'>{$current_dirs_item}</span></a></div>\n";
  }

  foreach ($current_files_array as &$current_files_item)
  {
    $file_ext = pathinfo($current_files_item, PATHINFO_EXTENSION);
    $file_noext = pathinfo($current_files_item, PATHINFO_FILENAME);

    if ($file_ext == $ext_text)
    {
      $links_files .= "<div><a href='./notes.php?varAction=view&varPath={$path}/" . rawurlencode($current_files_item) . "'><span class='clIconTxt'></span><span class='link_text'>{$file_noext}</span></a></div>\n";
    }
    elseif ($file_ext == 'jpg' || $file_ext == 'png' || $file_ext == 'gif' || $file_ext == 'webp')
    {
      $links_files .= "<div><a href='{$path}/" . rawurlencode($current_files_item) . "'><span class='clIconImg'></span><span class='link_text'>{$file_noext}</span></a></div>\n";
    }
    elseif ($file_ext == 'pdf')
    {
      $links_files .= "<div><a href='{$path}/" . rawurlencode($current_files_item) . "'><span class='clIconPdf'></span><span class='link_text'>{$file_noext}</span></a></div>\n";
    }
    elseif ($file_ext == 'mp3')
    {
      $links_files .= "<div><a href='{$path}/" . rawurlencode($current_files_item) . "'><span class='clIconMp3'></span><span class='link_text'>{$file_noext}</span></a></div>\n";
    }
    else
    {
      $links_files .= "<div><a href='{$path}/" . rawurlencode($current_files_item) . "'><span class='clIconFil'></span><span class='link_text'>{$file_noext}</span></a></div>\n";
    }
  }

  if ($note_name == basename($path_start) || $note_name == '..')
  {
    $note_name  = $title;
    $nav_index  = '';
    $nav_up     = '';
    $nav_add    = "    <a href='./notes.php?varAction=add&varPath={$path_start}'><span class='clNavAdd'><span></a>";
    $nav_rename = "";
    $nav_upload = "";
  }
  else
  {
    $nav_index  = "<a href='./notes.php?varAction=index&varPath={$path_start}'><span class='clNavIndex'><span></a>";
    $nav_up     = "<a href='./notes.php?varAction=index&varPath={$path_name}'><span class='clNavUp'><span></a>";
    $nav_add    = "    <a href='./notes.php?varAction=add&varPath={$path}'><span class='clNavAdd'><span></a>";
    $nav_rename = "    <a href='./notes.php?varAction=rename&varPath={$path}'><span class='clNavRename'><span></a>";
    $nav_upload = "    <a href='./notes.php?varAction=upload&varPath={$path}'><span class='clNavUpload'><span></a>";
  }

  if ($note_name == "notes")
  {
    $note_name = $title;
  }

  $content = <<<DOC
    <span class='clIndex'>\n
      <h1>{$note_name}</h1>\n
      {$links_dirs}\n\n
      {$links_files}\n
    </span>\n
  DOC;

  $html = get_template('index');
  eval("\$html = \"{$html}\";");
  echo $html;
}

#--------------------------------------------------------------------------------------------------
# Get View
#--------------------------------------------------------------------------------------------------

function get_view()
{
  $zone       = $GLOBALS['zone'];
  $title      = $GLOBALS['title'];

  $unit       = $GLOBALS['unit'];
  $zones      = $GLOBALS['zones'];

  $path       = $GLOBALS['path'];
  $path_start = $GLOBALS['path_start'];

  $ext_text   = $GLOBALS['ext_text'];

  $path_name  = dirname($path);
  $file_noext = pathinfo($path, PATHINFO_FILENAME);

  $nav_index  = "<a href='./notes.php?varAction=index&varPath={$path_start}'><span class='clNavIndex'><span></a>";
  $nav_up     = "<a href='./notes.php?varAction=index&varPath={$path_name}'><span class='clNavUp'><span></a>";
  $nav_rename = "<a href='./notes.php?varAction=rename&varPath={$path}'><span class='clNavRename'><span></a>";
  $nav_edit   = "<a href='./notes.php?varAction=edit&varPath={$path}'><span class='clNavEdit'><span></a>";

  $content = file_get_contents($path);
  $content = get_markup($content);

  $html = get_template('view');
  eval("\$html = \"{$html}\";");
  echo $html;
}

#--------------------------------------------------------------------------------------------------
# Get Add
#--------------------------------------------------------------------------------------------------

function get_add()
{
  $zone       = $GLOBALS['zone'];
  $title      = $GLOBALS['title'];

  $unit       = $GLOBALS['unit'];
  $zones      = $GLOBALS['zones'];

  $path       = $GLOBALS['path'];
  $path_start = $GLOBALS['path_start'];

  $ext_text   = $GLOBALS['ext_text'];

  $note_name = preg_replace("/^(.*)\/(.*?)$/s", "$2", $path);

  if ($note_name == basename($path_start) || $note_name == '..')
  {
    $nav_index  = "<a href='./notes.php?varAction=index&varPath={$path_start}'><span class='clNavIndex'><span></a>";
    $nav_up     = "<a href='./notes.php?varAction=index&varPath={$path_start}'><span class='clNavUp'><span></a>";
  }
  else
  {
    $nav_index  = "<a href='./notes.php?varAction=index&varPath={$path_start}'><span class='clNavIndex'><span></a>";
    $nav_up     = "<a href='./notes.php?varAction=index&varPath={$path}'><span class='clNavUp'><span></a>";
  }

  $html = get_template('add');
  eval("\$html = \"{$html}\";");
  echo $html;
}

#--------------------------------------------------------------------------------------------------
# Get Add Post
#--------------------------------------------------------------------------------------------------

function get_add_post()
{
  $zone       = $GLOBALS['zone'];
  $title      = $GLOBALS['title'];

  $unit       = $GLOBALS['unit'];
  $zones      = $GLOBALS['zones'];

  $path       = $GLOBALS['path'];
  $path_start = $GLOBALS['path_start'];

  $ext_text   = $GLOBALS['ext_text'];

  $node_name  = $GLOBALS['node_name'];
  $node_type  = $GLOBALS['node_type'];

  if ($node_type == 'directory')
  {
    if (! file_exists("{$path}/{$node_name}"))
    {
      mkdir("{$path}/{$node_name}");
    }
  }
  else if ($node_type == 'file')
  {
    if (! file_exists("{$path}/{$node_name}.{$ext_text}"))
    {
      touch("{$path}/{$node_name}.{$ext_text}");
    }
  }

  header("Location: ./notes.php?varAction=index&varPath={$path}");
}

#--------------------------------------------------------------------------------------------------
# Get Rename
#--------------------------------------------------------------------------------------------------

function get_rename()
{
  $zone  =      $GLOBALS['zone'];
  $title =      $GLOBALS['title'];

  $unit       = $GLOBALS['unit'];
  $zones      = $GLOBALS['zones'];

  $path       = $GLOBALS['path'];
  $path_start = $GLOBALS['path_start'];

  $ext_text   = $GLOBALS['ext_text'];

  $node_name = preg_replace("/^(.*)\/(.*?)$/s", "$2", $path);
  $file_noext = pathinfo($path, PATHINFO_FILENAME);

  if (is_file("$path"))
  {
    $node_type = 'file';
  }
  else
  {
    $node_type = 'directory';
  }

  $nav_index  = "<a href='./notes.php?varAction=index&varPath={$path_start}'><span class='clNavIndex'><span></a>";
  $nav_up     = "<a href='./notes.php?varAction=index&varPath={$path}'><span class='clNavUp'><span></a>";

  $html = get_template('rename');
  eval("\$html = \"{$html}\";");
  echo $html;
}

#--------------------------------------------------------------------------------------------------
# Get Rename Post
#--------------------------------------------------------------------------------------------------

function get_rename_post()
{
  $zone  =      $GLOBALS['zone'];
  $title =      $GLOBALS['title'];

  $unit       = $GLOBALS['unit'];
  $zones      = $GLOBALS['zones'];

  $path       = $GLOBALS['path'];
  $path_start = $GLOBALS['path_start'];

  $node_name  = $GLOBALS['node_name'];
  $node_type  = $GLOBALS['node_type'];

  $ext_text   = $GLOBALS['ext_text'];

  $path_name  = dirname($path);
  $path_basename = basename($path);

  if ($node_type == 'file' &&  $node_name != '')
  {
    $node_name .= ".{$ext_text}";
  }

  if ($node_name != $path_basename)
  {
    if ($node_name == '')
    {
      if (is_file("{$path}"))
      {
        unlink("{$path}");
      }
      elseif (is_dir("{$path}"))
      {
        rmdir("{$path}");
      }
    }
    else
    {
      rename("{$path}", "{$path_name}/{$node_name}");
    }
  }

  header("Location: ./notes.php?varAction=index&varPath={$path_name}");
}

#--------------------------------------------------------------------------------------------------
# Get Edit
#--------------------------------------------------------------------------------------------------

function get_edit()
{
  $zone  =      $GLOBALS['zone'];
  $title =      $GLOBALS['title'];

  $unit       = $GLOBALS['unit'];
  $zones      = $GLOBALS['zones'];

  $path       = $GLOBALS['path'];
  $path_start = $GLOBALS['path_start'];

  $ext_text   = $GLOBALS['ext_text'];

  $path_decoded = rawurldecode($path);
  $path_basename = basename($path_decoded);
  $path_name  = dirname($path);
  $note_name = preg_replace("/^(.*)\/(.*?)$/s", "$2", $path);
  $file_noext = pathinfo($path, PATHINFO_FILENAME);

  $nav_index  = "<a href='./notes.php?varAction=index&varPath={$path_start}'><span class='clNavIndex'>3<span></a>";
  $nav_up     = "<a href='./notes.php?varAction=view&varPath={$path}'><span class='clNavUp'><span>4</a>";

  $content = file_get_contents($path);
  $content = preg_replace("/\"/sU", "&quot;", $content);
  $content = preg_replace("/\'/sU", "&apos;", $content);

  $html = get_template('edit');
  eval("\$html = \"{$html}\";");
  echo $html;
}

#--------------------------------------------------------------------------------------------------
# Get Edit Post
#--------------------------------------------------------------------------------------------------

function get_edit_post()
{
  $zone  =      $GLOBALS['zone'];
  $title =      $GLOBALS['title'];

  $unit       = $GLOBALS['unit'];
  $zones      = $GLOBALS['zones'];

  $path       = $GLOBALS['path'];
  $path_start = $GLOBALS['path_start'];

  $text_area = $GLOBALS['text_area'];

  $ext_text   = $GLOBALS['ext_text'];

  $strBom = pack('H*','EFBBBF');
  $text_area = preg_replace('/^$strBom/', '', $text_area);
  $text_area = preg_replace('~\r\n?~', "\n", $text_area);

  file_put_contents($path, $text_area);

  header("Location: ./notes.php?varAction=view&varPath={$path}");
}

#--------------------------------------------------------------------------------------------------
# Get Upload
#--------------------------------------------------------------------------------------------------

function get_upload()
{
  $zone  =      $GLOBALS['zone'];
  $title =      $GLOBALS['title'];

  $unit       = $GLOBALS['unit'];
  $zones      = $GLOBALS['zones'];

  $path       = $GLOBALS['path'];
  $path_start = $GLOBALS['path_start'];

  $ext_text   = $GLOBALS['ext_text'];

  $path_decoded = rawurldecode($path);
  $path_basename = basename($path_decoded);
  $path_name  = dirname($path);
  $note_name = preg_replace("/^(.*)\/(.*?)$/s", "$2", $path);

  $nav_index  = "<a href='./notes.php?varAction=index&varPath={$path_start}'><span class='clNavIndex'><span></a>";
  $nav_up     = "<a href='./notes.php?varAction=index&varPath={$path}'><span class='clNavUp'><span></a>";

  $html = get_template('upload');
  eval("\$html = \"{$html}\";");
  echo $html;
}

#--------------------------------------------------------------------------------------------------
# Get Upload Post
#--------------------------------------------------------------------------------------------------

function get_upload_post()
{
  $zone  =      $GLOBALS['zone'];
  $title =      $GLOBALS['title'];

  $unit       = $GLOBALS['unit'];
  $zones      = $GLOBALS['zones'];

  $path       = $GLOBALS['path'];
  $path_start = $GLOBALS['path_start'];

  $ext_text   = $GLOBALS['ext_text'];

  $file_name = $_FILES['varFileName']['name'];

  if (is_file("$path/$file_name"))
  {
    unlink("$path/$file_name");
  }

  $result_upload = $_FILES['varFileName']['error'];
  $result_move = move_uploaded_file($_FILES['varFileName']['tmp_name'], "$path/$file_name");

  header("Location: ./notes.php?varAction=index&varPath={$path}");
}

#--------------------------------------------------------------------------------------------------
?>
