<?php
#---------------------------------------------------------------------------------------------------

include("./global-objects.php");

#---------------------------------------------------------------------------------------------------

$entry_id       = $_GET['varEntryId'] ?? "";

#$entry_id       = '有些';
#$entry_id       = '經';
#$entry_id       = '出去';
#$entry_id       = '什';
#$entry_id       = '學学';

#---------------------------------------------------------------------------------------------------

function get_entry()
{
  global $server_root, $entry_id, $dir_apps, $dir_templates;

  $app_title      = "Dictionary";
  $app_area       = "ln";
  $app_name       = "hanyu-dictionary";
  $dict_name      = "hanyu.sqlite";
  $app_dir        = "../{$dir_apps}/{$app_area}/zh-resources";
  $dict_dir       = "../{$dir_apps}/{$app_area}/zh-resources/databases";

  $debug_file     = "/home/lux/mnt/data/Temp/debug.txt";
  $debug_flag     = true;
  $debug_flag     = false;

  $page_title     = $app_title;
  $page_content   = "";

  $file_template = "../{$dir_templates}/{$app_name}.html";

  if ($entry_id !== "")
  {
    $dict_db = new SQLite3("{$dict_dir}/{$dict_name}");

    $sql_statement_prefix = "SELECT DISTINCT * FROM zh_en WHERE ";

    $sql_statement = "{$sql_statement_prefix} hant = '{$entry_id}' OR hans = '{$entry_id}'";
    $page_content .= get_select_result($dict_db, $sql_statement) . "\n";

    $page_content .= "<div id='idHanyuWrapperDiv01'>\n";
    $page_content .= "<a href='javascript:fncShowHide(\"idHanyuDiv01\")'>Bigrams - Fiction</a><br>\n";
    $page_content .= "<div id='idHanyuDiv01' style='display: none;'>\n";
    $sql_statement = "{$sql_statement_prefix}  (hant like '%{$entry_id}%' OR hans like '%{$entry_id}%') AND freqfict IS NOT NULL ORDER BY freqfict ASC";
    $page_content .= get_select_result($dict_db, $sql_statement) . "\n";
    $page_content .= "</div>\n";
    $page_content .= "</div>\n";

    $page_content .= "<div id='idHanyuWrapperDiv02'>\n";
    $page_content .= "<a href='javascript:fncShowHide(\"idHanyuDiv02\")'>Bigrams - News</a><br>\n";
    $page_content .= "<div id='idHanyuDiv02' style='display: none;'>\n";
    $sql_statement = "{$sql_statement_prefix}  (hant like '%{$entry_id}%' OR hans like '%{$entry_id}%') AND freqnews IS NOT NULL ORDER BY freqnews ASC";
    $page_content .= get_select_result($dict_db, $sql_statement) . "\n";
    $page_content .= "</div>\n";
    $page_content .= "</div>\n";

    $page_content .= "<div id='idHanyuWrapperDiv03'>\n";
    $page_content .= "<a href='javascript:fncShowHide(\"idHanyuDiv03\")'>Trigrams</a><br>\n";
    $page_content .= "<div id='idHanyuDiv03' style='display: none;'>\n";
    $sql_statement = "{$sql_statement_prefix}  hant like '{$entry_id}__' OR hant like '_{$entry_id}_' OR hant like '__{$entry_id}' OR hans like '{$entry_id}__' OR hans like '_{$entry_id}_' OR hans like '__{$entry_id}' LIMIT 20";
    $page_content .= get_select_result($dict_db, $sql_statement) . "\n";
    $page_content .= "</div>\n";
    $page_content .= "</div>\n";

    $dict_db->close();
  }

  $page_html = get_file_template($file_template);

  eval("\$page_html = \"{$page_html}\";");
  echo $page_html;
}

#---------------------------------------------------------------------------------------------------

function get_select_result($dict_db, $sql_statement)
{
  $field_hanzi            = '';
  $select_result_content  = '';

  $select_result=$dict_db->query($sql_statement);
  $columns_number=$select_result->numColumns();

  while($selected_row = $select_result->fetchArray(SQLITE3_ASSOC))
  {
    $field_hant         = trim($selected_row['hant']);
    $field_hans         = trim($selected_row['hans']);
    $field_tones        = trim($selected_row['tones']);
    $field_pinyin       = trim($selected_row['pinyin']);
    $field_freqfict     = trim($selected_row['freqfict']);
    $field_freqnews     = trim($selected_row['freqnews']);
    $field_description  = trim($selected_row['description']);

    $field_tones_array = explode(" ", $field_tones);
    $field_hant_array = preg_split('//u', $field_hant, -1, PREG_SPLIT_NO_EMPTY);

    $staging_string = "";

    for ($counter = 0; $counter < count($field_tones_array); $counter++)
    {
      $staging_string .= "<a href='../../../programs/hanzi-strokes.php?varHanziId={$field_hant_array[$counter]}'>";
      $staging_string .= "<span class='clHanziBig clTone{$field_tones_array[$counter]}'>";
      $staging_string .= "{$field_hant_array[$counter]}";
      $staging_string .= "</span>";
      $staging_string .= "</a>";
    }

    $field_hant = $staging_string;

    $staging_string = "";

    if ($field_hans !== "")
    {
      $field_hans_array = preg_split('//u', $field_hans, -1, PREG_SPLIT_NO_EMPTY);

      for ($counter = 0; $counter < count($field_tones_array); $counter++)
      {
        $staging_string .= "<a href='../../../programs/hanzi-strokes.php?varHanziId={$field_hans_array[$counter]}'>";
        $staging_string .= "<span class='clHanziBig clTone{$field_tones_array[$counter]}'>";
        $staging_string .= "{$field_hans_array[$counter]}";
        $staging_string .= "</span>";
        $staging_string .= "</a>";
      }

      $field_hans = $staging_string;

      $field_hanzi = $field_hant . "<span class='clHanziBig clTone5'>&ensp;·&ensp;</span>" . $field_hans;
    }
    else
    {
      $field_hanzi = $field_hant;
    }

    $select_result_content .= "<div class='clHanyuHanzi'>{$field_hanzi}</div>\n";
    $select_result_content .= "<div class='clHanyuPinyin'>{$field_pinyin}</div>\n";
    $select_result_content .= "<div class='clHanyuDescription'>{$field_description}</div>\n";
  }

  return $select_result_content;
}

#---------------------------------------------------------------------------------------------------

get_entry();

#---------------------------------------------------------------------------------------------------
?>
