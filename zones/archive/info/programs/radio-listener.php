<?php
#!/bin/php
#---------------------------------------------------------------------------------------------------

include("./global-objects.php");
include("./simple-html-dom.php");

#---------------------------------------------------------------------------------------------------

$app_title      = "Radio";
$data_area      = "tc";

$dir_zones       = "zones";
$dir_area       = "tc";
$app_name       = "radio-listener";

$page_title     = $app_title;
$page_content   = "<h1>{$page_title}</h1>\n\n<h2>News</h2>\n\n";

#---------------------------------------------------------------------------------------------------

$url_bnt         = 'https://binar.bg/bnr-novini/';
$url_bnt_media   = 'https://bnr.bg/files/uploads/13/';

#---------------------------------------------------------------------------------------------------

# https://mytuner-radio.com/podcast/
# https://www.radio.net/s/msnbc
# https://radiostationusa.fm/online/cnbc

$array_news_en =
[
    ['NBC'               , 'https://stream.revma.ihrhls.com/zc6043'                                ]
  , ['AP'                , 'https://apnews.streamguys1.com/apnews.aac'                             ]
  , ['npr'               , 'https://npr-ice.streamguys1.com/live.mp3'                              ]
  , ['Voice of America'  , 'https://www.voanews.com/mp3/voa/english/nnow/NNOW_HEADLINES.mp3'       ]
  , ['Bloomberg'         , 'https://tunein.streamguys1.com/bloomberg991'                           ]
];

#    ['CNBC'              , 'https://tunein.streamguys1.com/cnbc'                                   ]
#    ['MSNBC'             , 'https://tunein.streamguys1.com/msnbc-free'                             ]

#---------------------------------------------------------------------------------------------------

# https://www.radio-en-ligne.fr/

$array_news_fr =
[
    ['Europe 1'           , 'https://stream.europe1.fr/europe1.mp3'                                ]
  , ['France Inter'       , 'http://icecast.radiofrance.fr/franceinter-midfi.mp3'                  ]
  , ['RFI Monde'          , 'https://rfimonde64k.ice.infomaniak.ch/rfimonde-64.mp3'                ]
  , ['BFM Business'       , 'https://audio.bfmtv.com/bfmbusiness_128.mp3?aw_0_1st.playerId=AudioPlayer_Web_Next'       ]
];

#---------------------------------------------------------------------------------------------------

$array_podcasts =
[
    ['Morning Joe'        , 'P1', 'https://mytuner-radio.com/podcast/morning-joe-joe-scarborough-and-mika-brzezinski-msnbc-974299441' ]
  , ['11th Hour'          , 'P2', 'https://mytuner-radio.com/podcast/the-11th-hour-with-brian-williams-msnbc-1314368109'              ]
  , ['Suze Orman'         , 'P3', 'https://mytuner-radio.com/podcast/suze-ormans-women-and-money-suze-orman-media-1439621652'                          ]
];

#---------------------------------------------------------------------------------------------------

$template_html    = "../{$dir_templates}/{$app_name}.html";

#---------------------------------------------------------------------------------------------------

function set_bnt()
{
  global $dir_templates, $app_title, $page_content, $url_bnt, $url_bnt_media;

  $div_title  = 'Български';
  $div_number = 'Nbg';

  $url_content = get_url("{$url_bnt}");
  $html_objects = str_get_html($url_content);

  $page_content .= "<p class='clMediaName'><a href='javascript:fncShowHideWithMemory(&quot;idDiv{$div_number}&quot;)'>{$div_title}</a></p>\n";
  $page_content .= "<div id='idDiv{$div_number}'>";

  $counter = 0;

  foreach($html_objects->find('option') as $audio_source)
  {
    $audio_source_name  = $audio_source->innertext;
    $audio_source_media = $audio_source->value;

    if ($counter++ > 10) { break; }

    $page_content .= "<p class='clMediaName'><a href='{$url_bnt_media}{$audio_source_media}'>{$audio_source_name}</a></p>\n";
  }

  $page_content = str_replace("Емисия от ", "", $page_content);
  $page_content = str_replace("часа на ", "&ensp;", $page_content);

  $page_content .= "</div>\n";
}

#---------------------------------------------------------------------------------------------------

function set_news_en()
{
  global $dir_templates, $app_title, $page_content, $array_news_en;

  $div_title  = 'English';
  $div_number = 'Nen';

  $page_content .= "<p class='clMediaName'><a href='javascript:fncShowHideWithMemory(&quot;idDiv{$div_number}&quot;)'>{$div_title}</a></p>\n";
  $page_content .= "<div id='idDiv{$div_number}'>";

  foreach($array_news_en as $item_entry)
  {
    $page_content .= "<p class='clMediaName'><a href='{$item_entry[1]}'>{$item_entry[0]}</a></p>\n";
  }

  $page_content .= "</div>\n";
}

#---------------------------------------------------------------------------------------------------

function set_news_fr()
{
  global $dir_templates, $app_title, $page_content, $array_news_fr;

  $div_title  = 'Français';
  $div_number = 'Nfr';

  $page_content .= "<p class='clMediaName'><a href='javascript:fncShowHideWithMemory(&quot;idDiv{$div_number}&quot;)'>{$div_title}</a></p>\n";
  $page_content .= "<div id='idDiv{$div_number}'>";

  foreach($array_news_fr as $item_entry)
  {
    $page_content .= "<p class='clMediaName'><a href='{$item_entry[1]}'>{$item_entry[0]}</a></p>\n";
  }

  $page_content .= "</div>\n";
}

#----------------------------------------------------------------------------------------------------

function set_podcats()
{
  global $dir_templates, $app_title, $page_content, $array_podcasts;

  $page_content .= "<h2>Podcasts</h2>";

  foreach($array_podcasts as $item_entry)
  {
    $div_title  = $item_entry[0];
    $div_number = $item_entry[1];
    $url_source = $item_entry[2];
    $url_content = get_url("{$url_source}");
    $html_objects = str_get_html($url_content);

    $page_content .= "<p class='clMediaName'><a href='javascript:fncShowHideWithMemory(&quot;idDiv{$div_number}&quot;)'>{$div_title}</a></p>\n";
    $page_content .= "<div id='idDiv{$div_number}'>";

    $counter = 0;

    foreach($html_objects->find("li[id^=podcast_item_]") as $podcast_item)
    {
      $podcast_episode_name = $podcast_item->find("div[class=left-side]", 0)->find("div[class=title]", 0)->innertext ?? "";
      $podcast_episode_date = $podcast_item->find("div[class=left-side]", 0)->find("div[class=date]", 0)->innertext ?? "";
      $podcast_episode_url  = $podcast_item->find("div[class=right-side]", 0)->find("a[data-url]", 0) ?? "";

      $podcast_episode_name = preg_replace("/<div class=\"red-title\">(.*?)<\/div>/", "$1", $podcast_episode_name);
      $podcast_episode_url  = preg_replace("/(.*?)data-url=\"(.*?)\"(.*)/", "$2", $podcast_episode_url);

      if ($counter++ > 6) { break; }

      $page_content .= "<p class='clMediaName'><a href='{$podcast_episode_url}'>{$podcast_episode_date} - {$podcast_episode_name}</a></p><br>\n";
    }

    $page_content .= "</div>\n";
  }
}

#----------------------------------------------------------------------------------------------------

set_bnt();
set_news_en();
set_news_fr();
set_podcats();

#----------------------------------------------------------------------------------------------------

$page_html = get_file_template($template_html);

#----------------------------------------------------------------------------------------------------

eval("\$page_content = \"{$page_content}\";");
eval("\$page_html = \"{$page_html}\";");
echo $page_html;

#---------------------------------------------------------------------------------------------------
?>
