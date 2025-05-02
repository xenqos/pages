<?php
#--------------------------------------------------------------------------------------------------

function get_strokes()
{

  $grid_s2 = sprintf("%3d", (int) $grid_s1 / 2);

  $file_template = "../{$dir_templates}/{$app_name}.html";

  $hanzi_info = json_decode(file_get_contents("{$app_dir}/infos/{$hanzi}.json"));

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

    $hanzi_pictophonetic .= <<<DOC
      <div class='clHanziInfoHeader'>semantic:</div>
      <div class='clHanziInfoText'>{$hanzi_etymology_semantic}</div>
      <div class='clHanziInfoHeader'>phonetic:</div>
      <div class='clHanziInfoText'>{$hanzi_etymology_phonetic}</div>
    DOC;
  }

  $stroke_color  = $stroke_colors[(int) $hanzi_tone];
  $radical_color = $stroke_colors[(int) $hanzi_tone];

  $html = get_template('default');
  eval("\$html = \"{$html}\";");
  echo $html;
}

#---------------------------------------------------------------------------------------------------
?>
