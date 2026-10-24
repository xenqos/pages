<?php
#---------------------------------------------------------------------------------------------------

include("./global-objects.php");

#---------------------------------------------------------------------------------------------------


if      ($_SERVER['REQUEST_METHOD'] === 'GET')
{
  $func_id              = $_GET['varFuncId'       ] ?? "";
  $dir_current          = $_GET['varDirCurrent'   ] ?? "";
}
elseif  ($_SERVER['REQUEST_METHOD'] === 'POST')
{
  $func_id              = $_POST['varFuncId'      ] ?? "";
  $dir_current          = $_POST['varDirCurrent'  ] ?? "";
  $text_area            = $_POST['varTextarea'    ] ?? "";
  $node_name            = $_POST['varNodeName'    ] ?? "";
  $node_type            = $_POST['varNodeType'    ] ?? "";
}

#---------------------------------------------------------------------------------------------------

$app_title              = 'Notes';
# $dir_start_name         = "../notes";
$dir_start_name         = "../zones/nt";

#---------------------------------------------------------------------------------------------------

function get_index()
{
  global $server_docroot, $dir_templates, $dir_current;
  global $ext_text, $dir_start_name, $app_title;

  $file_template = "{$server_docroot}/{$dir_templates}/notes-keeper-index.html";

#file_put_contents("/home/lux/mnt/data/Temp/debug.txt", $file_template);

  $dir_decoded = rawurldecode($dir_current);
  $dir_basename = basename($dir_decoded);
  $dir_dirname  = dirname($dir_current);
  $note_name = preg_replace("/^(.*)\/(.*?)$/s", "$2", $dir_current);

  $current_dirs_array = [];
  $current_files_array = [];
  $links_dirs = '';
  $links_files = '';
  $file_ext = '';

  $files_array = scandir($dir_current);

  foreach ($files_array as &$file_item)
  {
    if ($file_item === '.' || $file_item === '..')  { continue; }
    if (substr($file_item, 0, 1) === '.')           { continue; }

    if (is_dir("$dir_current/{$file_item}"))
    {
      $current_dirs_array[]  = $file_item;
    }
    else if (is_file("$dir_current/{$file_item}"))
    {
      $current_files_array[] = $file_item;
    }
  }

  foreach ($current_dirs_array as &$current_dirs_item)
  {
    $links_dirs .= "<div><a href='./notes-keeper.php?varFuncId=index&varDirCurrent={$dir_current}/" . rawurlencode($current_dirs_item) . "'><span class='clIconDir'></span><span class='link_text'>{$current_dirs_item}</span></a></div>\n";
  }

  foreach ($current_files_array as &$current_files_item)
  {
    $file_ext = pathinfo($current_files_item, PATHINFO_EXTENSION);
    $file_noext = pathinfo($current_files_item, PATHINFO_FILENAME);

    if ($file_ext == $ext_text)
    {
      $links_files .= "<div><a href='./notes-keeper.php?varFuncId=view&varDirCurrent={$dir_current}/" . rawurlencode($current_files_item) . "'><span class='clIconTxt'></span><span class='link_text'>{$file_noext}</span></a></div>\n";
    }
    elseif ($file_ext == 'jpg' || $file_ext == 'png' || $file_ext == 'gif' || $file_ext == 'webp')
    {
      $links_files .= "<div><a href='{$dir_current}/" . rawurlencode($current_files_item) . "'><span class='clIconImg'></span><span class='link_text'>{$file_noext}</span></a></div>\n";
    }
    elseif ($file_ext == 'pdf')
    {
      $links_files .= "<div><a href='{$dir_current}/" . rawurlencode($current_files_item) . "'><span class='clIconPdf'></span><span class='link_text'>{$file_noext}</span></a></div>\n";
    }
    elseif ($file_ext == 'mp3')
    {
      $links_files .= "<div><a href='{$dir_current}/" . rawurlencode($current_files_item) . "'><span class='clIconMp3'></span><span class='link_text'>{$file_noext}</span></a></div>\n";
    }
    else
    {
      $links_files .= "<div><a href='{$dir_current}/" . rawurlencode($current_files_item) . "'><span class='clIconFil'></span><span class='link_text'>{$file_noext}</span></a></div>\n";
    }
  }

  if ($note_name == basename($dir_start_name) || $note_name == '..')
  {
    $note_name  = $app_title;
    $nav_index  = '';
    $nav_up     = '';
    $nav_add    = "    <a href='./notes-keeper.php?varFuncId=add&varDirCurrent={$dir_current}'><span class='clNavAdd'><span></a>";
    $nav_rename = "";
    $nav_upload = "";
  }
  else
  {
    $nav_index  = "    <a href='./notes-keeper.php?varFuncId=index&varDirCurrent={$dir_start_name}'><span class='clNavIndex'><span></a>";
    $nav_up     = "    <a href='./notes-keeper.php?varFuncId=index&varDirCurrent={$dir_dirname}'><span class='clNavUp'><span></a>";
    $nav_add    = "    <a href='./notes-keeper.php?varFuncId=add&varDirCurrent={$dir_current}'><span class='clNavAdd'><span></a>";
    $nav_rename = "    <a href='./notes-keeper.php?varFuncId=rename&varDirCurrent={$dir_current}'><span class='clNavRename'><span></a>";
    $nav_upload = "    <a href='./notes-keeper.php?varFuncId=upload&varDirCurrent={$dir_current}'><span class='clNavUpload'><span></a>";
  }

  if ($note_name == "notes")
  {
    $note_name = $app_title;
  }

  $page_title = $app_title;
  $page_content  = "<span class='clIndex'>\n";
  $page_content .= "<h1>{$note_name}</h1>\n";
  $page_content .= $links_dirs . "\n";
  $page_content .= "\n";
  $page_content .= $links_files . "\n";
  $page_content .= "</span>\n";

  $page_html = get_file_template($file_template);

  eval("\$page_html = \"{$page_html}\";");
  echo $page_html;
}

#---------------------------------------------------------------------------------------------------

function get_view()
{
  global $server_docroot, $dir_templates, $dir_current;
  global $dir_start_name, $app_area, $app_dir;

  $file_template = "{$server_docroot}/{$dir_templates}/notes-keeper-view.html";

  $dir_decoded = rawurldecode($dir_current);
  $dir_basename = basename($dir_decoded);
  $dir_dirname  = dirname($dir_current);
  $file_noext = pathinfo($dir_current, PATHINFO_FILENAME);

  $nav_index    = "<a href='./notes-keeper.php?varFuncId=index&varDirCurrent={$dir_start_name}'><span class='clNavIndex'><span></a>";
  $nav_up       = "<a href='./notes-keeper.php?varFuncId=index&varDirCurrent={$dir_dirname}'><span class='clNavUp'><span></a>";
  $nav_rename   = "<a href='./notes-keeper.php?varFuncId=rename&varDirCurrent={$dir_current}'><span class='clNavRename'><span></a>";
  $nav_edit     = "<a href='./notes-keeper.php?varFuncId=edit&varDirCurrent={$dir_current}'><span class='clNavEdit'><span></a>";

  $page_content = file_get_contents($dir_decoded);
  $page_content = get_markdown($page_content);

  $page_html = get_file_template($file_template);

  eval("\$page_html = \"{$page_html}\";");
  echo $page_html;
}

#---------------------------------------------------------------------------------------------------

function get_edit()
{
  global $server_docroot, $dir_templates, $dir_current;
  global $dir_start_name;

  $file_template = "{$server_docroot}/{$dir_templates}/notes-keeper-edit.html";

  $dir_decoded = rawurldecode($dir_current);
  $dir_basename = basename($dir_decoded);
  $dir_dirname  = dirname($dir_current);
  $note_name = preg_replace("/^(.*)\/(.*?)$/s", "$2", $dir_current);
  $file_noext = pathinfo($dir_current, PATHINFO_FILENAME);

  if ($note_name == basename($dir_start_name) || $note_name == '..')
  {
    $nav_index  = "<a href='./notes-keeper.php?varFuncId=index&varDirCurrent={$dir_start_name}'><span class='clNavIndex'><span></a>";
    $nav_up     = "<a href='./notes-keeper.php?varFuncId=view&varDirCurrent={$dir_current}'><span class='clNavUp'><span></a>";
  }
  else
  {
    $nav_index  = "<a href='./notes-keeper.php?varFuncId=index&varDirCurrent={$dir_start_name}'><span class='clNavIndex'><span></a>";
    $nav_up     = "<a href='./notes-keeper.php?varFuncId=view&varDirCurrent={$dir_current}'><span class='clNavUp'><span></a>";
  }

  $page_content = file_get_contents($dir_current);
  $page_content = preg_replace("/\"/sU", "&quot;", $page_content);
  $page_content = preg_replace("/\'/sU", "&apos;", $page_content);

  $page_html = get_file_template($file_template);

  eval("\$page_html = \"{$page_html}\";");
  echo $page_html;
}

#---------------------------------------------------------------------------------------------------

function get_edit_post()
{
  global $dir_current, $text_area;

  $strBom = pack('H*','EFBBBF');
  $text_area = preg_replace('/^$strBom/', '', $text_area);
  $text_area = preg_replace('~\r\n?~', "\n", $text_area);

  file_put_contents($dir_current, $text_area);

  header("Location: ./notes-keeper.php?varFuncId=view&varDirCurrent={$dir_current}");
}

#---------------------------------------------------------------------------------------------------

function get_add()
{
  global $server_docroot, $dir_templates, $dir_current;
  global $dir_start_name;

  $file_template = "{$server_docroot}/{$dir_templates}/notes-keeper-add.html";

  $dir_decoded = rawurldecode($dir_current);
  $dir_basename = basename($dir_decoded);
  $dir_dirname  = dirname($dir_current);
  $note_name = preg_replace("/^(.*)\/(.*?)$/s", "$2", $dir_current);

  if ($note_name == basename($dir_start_name) || $note_name == '..')
  {
    $nav_index  = "<a href='./notes-keeper.php?varFuncId=index&varDirCurrent={$dir_start_name}'><span class='clNavIndex'><span></a>";
    $nav_up     = "<a href='./notes-keeper.php?varFuncId=index&varDirCurrent={$dir_start_name}'><span class='clNavUp'><span></a>";
  }
  else
  {
    $nav_index  = "<a href='./notes-keeper.php?varFuncId=index&varDirCurrent={$dir_start_name}'><span class='clNavIndex'><span></a>";
    $nav_up     = "<a href='./notes-keeper.php?varFuncId=index&varDirCurrent={$dir_current}'><span class='clNavUp'><span></a>";
  }

  $page_html = get_file_template($file_template);

  eval("\$page_html = \"{$page_html}\";");
  echo $page_html;
}

#---------------------------------------------------------------------------------------------------

function get_add_post()
{
  global $dir_current, $node_type, $node_name, $ext_text;

  if ($node_type == 'directory')
  {
    if (! file_exists("{$dir_current}/{$node_name}"))
    {
      mkdir("{$dir_current}/{$node_name}");
    }
  }
  else if ($node_type == 'file')
  {
    if (! file_exists("{$dir_current}/{$node_name}.{$ext_text}"))
    {
      touch("{$dir_current}/{$node_name}.{$ext_text}");
    }
  }

  header("Location: ./notes-keeper.php?varFuncId=index&varDirCurrent={$dir_current}");
}

#---------------------------------------------------------------------------------------------------

function get_rename()
{
  global $server_docroot, $dir_templates, $dir_current;
  global $dir_start_name;

  $file_template = "{$server_docroot}/{$dir_templates}/notes-keeper-rename.html";

  $dir_decoded = rawurldecode($dir_current);
  $dir_basename = basename($dir_decoded);
  $dir_dirname  = dirname($dir_current);
  $note_name = preg_replace("/^(.*)\/(.*?)$/s", "$2", $dir_current);
  $file_noext = pathinfo($dir_current, PATHINFO_FILENAME);

  if (is_file("$dir_current"))
  {
    $node_type = 'file';
  }
  else
  {
    $node_type = 'directory';
  }

  if ($note_name == basename($dir_start_name) || $note_name == '..')
  {
    $nav_index  = "<a href='./notes-keeper.php?varFuncId=index&varDirCurrent={$dir_start_name}'><span class='clNavIndex'><span></a>";
    $nav_up     = "<a href='./notes-keeper.php?varFuncId=index&varDirCurrent={$dir_start_name}'><span class='clNavUp'><span></a>";
  }
  else
  {
    $nav_index  = "<a href='./notes-keeper.php?varFuncId=index&varDirCurrent={$dir_start_name}'><span class='clNavIndex'><span></a>";
    $nav_up     = "<a href='./notes-keeper.php?varFuncId=index&varDirCurrent={$dir_dirname}'><span class='clNavUp'><span></a>";
  }

  $page_html = get_file_template($file_template);

  eval("\$page_html = \"{$page_html}\";");
  echo $page_html;
}

#---------------------------------------------------------------------------------------------------

function get_rename_post()
{
  global $dir_current, $node_type, $node_name, $ext_text;

  $dir_dirname  = dirname($dir_current);
  $dir_basename = basename($dir_current);

  if ($node_type == 'file' &&  $node_name != '')
  {
    $node_name .= ".{$ext_text}";
  }

  if ($node_name != $dir_basename)
  {
    if ($node_name == '')
    {
      if (is_file("{$dir_current}"))
      {
        unlink("{$dir_current}");
      }
      elseif (is_dir("{$dir_current}"))
      {
        rmdir("{$dir_current}");
      }
    }
    else
    {
      rename("{$dir_current}", "{$dir_dirname}/{$node_name}");
    }
  }

  header("Location: ./notes-keeper.php?varFuncId=index&varDirCurrent={$dir_dirname}");
}

#---------------------------------------------------------------------------------------------------

function get_upload()
{
  global $server_docroot, $dir_templates, $dir_current;
  global $dir_start_name;

  $file_template = "{$server_docroot}/{$dir_templates}/notes-keeper-upload.html";

  $dir_decoded = rawurldecode($dir_current);
  $dir_basename = basename($dir_decoded);
  $dir_dirname  = dirname($dir_current);
  $note_name = preg_replace("/^(.*)\/(.*?)$/s", "$2", $dir_current);

  if ($note_name == basename($dir_start_name) || $note_name == '..')
  {
    $nav_index  = "<a href='./notes-keeper.php?varFuncId=index&varDirCurrent={$dir_start_name}'><span class='clNavIndex'><span></a>";
    $nav_up     = "<a href='./notes-keeper.php?varFuncId=index&varDirCurrent={$dir_start_name}'><span class='clNavUp'><span></a>";
  }
  else
  {
    $nav_index  = "<a href='./notes-keeper.php?varFuncId=index&varDirCurrent={$dir_start_name}'><span class='clNavIndex'><span></a>";
    $nav_up     = "<a href='./notes-keeper.php?varFuncId=index&varDirCurrent={$dir_current}'><span class='clNavUp'><span></a>";
  }

  $page_html = get_file_template($file_template);

  eval("\$page_html = \"{$page_html}\";");
  echo $page_html;
}

#---------------------------------------------------------------------------------------------------

function get_upload_post()
{
  global $dir_current;

  $file_name = $_FILES['varFileName']['name'];

  if (is_file("$dir_current/$file_name"))
  {
    unlink("$dir_current/$file_name");
  }

  $result_upload = $_FILES['varFileName']['error'];
  $result_move = move_uploaded_file($_FILES['varFileName']['tmp_name'], "$dir_current/$file_name");

  header("Location: ./notes-keeper.php?varFuncId=index&varDirCurrent={$dir_current}");
}

#---------------------------------------------------------------------------------------------------

if      ($func_id == "index")       { get_index();        }
elseif  ($func_id == "view")        { get_view();         }
elseif  ($func_id == "edit")        { get_edit();         }
elseif  ($func_id == "edit_post")   { get_edit_post();    }
elseif  ($func_id == "add")         { get_add();          }
elseif  ($func_id == "add_post")    { get_add_post();     }
elseif  ($func_id == "rename")      { get_rename();       }
elseif  ($func_id == "rename_post") { get_rename_post();  }
elseif  ($func_id == "upload")      { get_upload();       }
elseif  ($func_id == "upload_post") { get_upload_post();  }

#---------------------------------------------------------------------------------------------------
?>
