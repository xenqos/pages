<?php
#---------------------------------------------------------------------------------------------------

include("./global-objects.php");

#---------------------------------------------------------------------------------------------------

$hanzi_id       = $_GET['varHanziId'] ?? "";
# $hanzi_id       = '經';
# https://github.com/skishore/makemeahanzi

#---------------------------------------------------------------------------------------------------

function get_strokes()
{
  global $server_root, $hanzi_id, $dir_apps, $dir_templates;

#  $app_title      = "漢字 中風順序";
  $app_title      = "Strokes";
  $app_area       = "ln";
  $app_name       = "hanzi-strokes";
  $app_dir        = "../{$dir_apps}/{$app_area}/zh-resources";

  $grid_s1                = '320';
  $grid_c1                = '#aaaaaa';
  $grid_c2                = '#dddddd';
  $outline_color          = '#eeeeee';

  $delay_between_strokes  = 500;
  $delay_between_loops    = 1000;
  $stroke_color           = '#000000';
  $radical_color          = '#000000';
  $hanzi_pictophonetic    = '';
  $hanzi_pinyin           = '';

  $debug_file     = "/home/lux/mnt/data/Temp/debug.txt";
  $debug_flag     = true;
  $debug_flag     = false;

  $page_title = $app_title;
  $grid_s2 = sprintf("%3d", (int) $grid_s1 / 2);

  $file_template = "../{$dir_templates}/{$app_name}.html";

  $hanzi_info = json_decode(file_get_contents("{$app_dir}/infos/{$hanzi_id}.json"));

  $hanzi_character = $hanzi_info->{'character'};
  $hanzi_definition = $hanzi_info->{'definition'};
  $hanzi_tone = $hanzi_info->{'tone'};
  $hanzi_sound = $hanzi_info->{'pinyin'}[0];
  $hanzi_radical = $hanzi_info->{'radical'} ?? "";
  $hanzi_decomposition = $hanzi_info->{'decomposition'} ?? "";
  $hanzi_etymology_type = $hanzi_info->{'etymology'}->{'type'} ?? "&nbsp;";
  $hanzi_etymology_hint = $hanzi_info->{'etymology'}->{'hint'} ?? "&nbsp;";

  if (! is_null($hanzi_info->{'pinyin'}))
  {
    foreach ($hanzi_info->{'pinyin'} as &$hanzi_info_pinyin)
    {
      $hanzi_pinyin .= $hanzi_info_pinyin . ', ';
    }
  }

  $hanzi_pinyin = rtrim($hanzi_pinyin, ', ');

  if ($hanzi_etymology_type === 'pictophonetic')
  {
    $hanzi_etymology_semantic = $hanzi_info->{'etymology'}->{'semantic'} ?? "&nbsp;";
    $hanzi_etymology_phonetic = $hanzi_info->{'etymology'}->{'phonetic'} ?? "&nbsp;";
    $hanzi_pictophonetic .= "<div class='clHanziInfoHeader'>semantic:</div>";
    $hanzi_pictophonetic .= "<div class='clHanziInfoText'>{$hanzi_etymology_semantic}</div>";
    $hanzi_pictophonetic .= "<div class='clHanziInfoHeader'>phonetic:</div>";
    $hanzi_pictophonetic .= "<div class='clHanziInfoText'>{$hanzi_etymology_phonetic}</div>";
  }

  switch ($hanzi_tone)
  {
    case '1':
      $stroke_color  = '#64B4FF';
      $radical_color = '#64B4FF';
      break;
    case '2':
      $stroke_color  = '#30B030';
      $radical_color = '#30B030';
      break;
    case '3':
      $stroke_color  = '#F08000';
      $radical_color = '#F08000';
      break;
    case '4':
      $stroke_color  = '#D00020';
      $radical_color = '#D00020';
      break;
    default:
      $stroke_color  = '#A0A0A0';
      $radical_color = '#A0A0A0';
  }

  $page_content = '';

  $page_html = get_file_template($file_template);

  eval("\$page_html = \"{$page_html}\";");
  echo $page_html;
}

#---------------------------------------------------------------------------------------------------

get_strokes();

#---------------------------------------------------------------------------------------------------
?>
