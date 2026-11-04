<?php
#--------------------------------------------------------------------------------------------------
# Get Markup
#--------------------------------------------------------------------------------------------------

function get_markup($text)
{
  #------------------------------------------------------------------------------------------------
  # Add LF at ^ and $
  #------------------------------------------------------------------------------------------------

  $text =  "\n" . $text . "\n";

  #------------------------------------------------------------------------------------------------
  # Quotes
  #------------------------------------------------------------------------------------------------

  $text = preg_replace("~\"~sU", "&quot;", $text);
#  $text = preg_replace("~\'~sU", "&apos;", $text);
#  $text = preg_replace("~\`~sU", "&grave;", $text);

  #------------------------------------------------------------------------------------------------
  # Unordered List
  #------------------------------------------------------------------------------------------------

  $text = preg_replace_callback(
    "~\[\-\n(.*?)\n\-\]~s",
    function($matches)
    {
      $matched = $matches[1];
      $matched = preg_replace("~^(.*?)$~m", "<li>$1</li>", $matched);
      return "<ul>\n{$matched}\n</ul>";
    }, $text);

  #------------------------------------------------------------------------------------------------
  # Ordered List
  #------------------------------------------------------------------------------------------------

  $text = preg_replace_callback(
    "/\[\+\n(.*?)\n\+\]/s",
    function($matches)
    {
      $matched = $matches[1];
      $matched = preg_replace("~^(.*?)$~m", "<li>$1</li>", $matched);
      return "<ol>\n{$matched}\n</ol>";
    }, $text);

  #------------------------------------------------------------------------------------------------
  # Pre
  #------------------------------------------------------------------------------------------------

  $text = preg_replace_callback(
    "/\[\*\n(.*?)\n\*\]/s",
    function($matches)
    {
      $matched = $matches[1];
      $matched = preg_replace("~\n~s", "REMOVE_PRECODE\n", $matched);
      return "<pre>{$matched}</pre>";
    }, $text);

  #------------------------------------------------------------------------------------------------
  # Pre Code
  #------------------------------------------------------------------------------------------------

  $text = preg_replace_callback(
    "/\[\?\n(.*?)\n\?\]/s",
    function($matches)
    {
      $matched = $matches[1];
      $matched = preg_replace("~\n~s", "REMOVE_PRECODE\n", $matched);
      return "<pre><code>{$matched}</code></pre>";
    }, $text);

  #------------------------------------------------------------------------------------------------
  # Blockquote
  #------------------------------------------------------------------------------------------------

  $text = preg_replace_callback(
    "~\[\!\n(.*?)\n\!\]~s",
    function($matches)
    {
      $matched = $matches[1];
      return "<blockquote>\n{$matched}\n</blockquote>";
    }, $text);

  #------------------------------------------------------------------------------------------------
  # Details
  #------------------------------------------------------------------------------------------------

  $text = preg_replace_callback(
    "~\[\@ \((.*?)\)\n(.*?)\n\@\]~s",
    function($matches)
    {
      $matched_1 = $matches[1];
      $matched_2 = $matches[2];
#      $matched_2 = preg_replace("/\n/s", "", $matched_2);
      return "<details><summary>{$matched_1}</summary>{$matched_2}</details>";
    }, $text);

  #------------------------------------------------------------------------------------------------
  # Links
  #------------------------------------------------------------------------------------------------

  $text = preg_replace("~\!\[(.*?)\|(.*?)\]~" , "<a target='_blank' rel='noreferrer' class='clLinkBlue' href='$2'>$1</a>", $text);
  $text = preg_replace("~\^\[(.*?)\]~"        , "<a target='_blank' href='../images/$1'><img class='clImageThumb' src='../images/$1'></a>", $text);
  $text = preg_replace("~\@\[(.*?)\]~"        , "<img src='../images/$1'>", $text);

  $text = preg_replace("~\&\[(.*?)\|(.*?)\]~", "<q class='$1'>$2</q>", $text);
  $text = preg_replace("~\%\[(.*?)\|(.*?)\]~", "<span class='$1'>$2</span>", $text);

  #------------------------------------------------------------------------------------------------
  # Audio
  #------------------------------------------------------------------------------------------------

  $text = preg_replace_callback(
    "~\*\[(.*?)\]~s",
    function($matches)
    {
      $matched = $matches[1];
      $strTagAudio = basename($matched);
      $strReturn  = "<audio id='{$strTagAudio}' src='../sounds/{$matched}' preload='auto'></audio>\n";
      $strReturn .= "<span class='clAudio'><span class='clNavRewind' onclick='fncRewindTrack(&quot;{$strTagAudio}&quot;)'></span><span class='clNavPlay' onclick='fncPlayTrack(&quot;{$strTagAudio}&quot;)'></span></span>";
      return $strReturn;
    }, $text);

  #------------------------------------------------------------------------------------------------
  # Video
  #------------------------------------------------------------------------------------------------

  $text = preg_replace_callback(
    "~=\[(.*?),(.*?)\]~s",
    function($matches)
    {
      $matched_1 = $matches[1];
      $matched_2 = $matches[2];
      $strTagVideo = basename($matched_1);

      $strReturn  = "<video id='{$strTagVideo}' src='../videos/{$matched_1}' poster='../images/{$matched_2}' loop preload='auto'></video>\n";

      $strReturn .= "<div class='clVideo'><span class='clNavRewind' onclick='fncRewindTrack(&quot;{$strTagVideo}&quot;)'></span><span class='clNavPlay' onclick='fncPlayTrack(&quot;{$strTagVideo}&quot;)'></span></div>";

      return $strReturn;
    }, $text);

  #------------------------------------------------------------------------------------------------
  # Table
  #------------------------------------------------------------------------------------------------

  $text = preg_replace_callback(
    "~\[\|\n(.*?)\n\|\]~s",
    function($matches)
    {
      $matched = $matches[1];
      $matched = preg_replace("~^\^(.*?)\^$~m" , "<tr><th>$1</th></tr>", $matched);
      $matched = preg_replace("~^\|>(.*?)\|$~m" , "<tr><td class='tar'>$1</td></tr>", $matched);
      $matched = preg_replace("~^\|(.*?)\|$~m" , "<tr><td>$1</td></tr>", $matched);
      $matched = preg_replace("~\^~sU"         , "</th><th>", $matched);
      $matched = preg_replace("~\|~sU"         , "</td><td>", $matched);
      return "<div class='clOverflow'><table>{$matched}</table></div>";
    }, $text);

  $text = preg_replace_callback(
    "~\[\|\-\n(.*?)\n\|\]~s",
    function($matches)
    {
      $matched = $matches[1];
      $matched = preg_replace("~^\^(.*?)\^$~m" , "<tr><th>$1</th></tr>", $matched);
      $matched = preg_replace("~^\|>(.*?)\|$~m" , "<tr><td class='tar'>$1</td></tr>", $matched);
      $matched = preg_replace("~^\|(.*?)\|$~m" , "<tr><td>$1</td></tr>", $matched);
      $matched = preg_replace("~\^~sU"         , "</th><th>", $matched);
      $matched = preg_replace("~\|~sU"         , "</td><td>", $matched);
      return "<div class='clOverflow'><table class='clNoBorder'>{$matched}</table></div>";
    }, $text);

  #------------------------------------------------------------------------------------------------
  # Bold and Italic
  #------------------------------------------------------------------------------------------------

  $text = preg_replace("~\*{2,2}(.*?)\*{2,2}~" , "<b>$1</b>", $text);
  $text = preg_replace("~\_{2,2}(.*?)\_{2,2}~" , "<i>$1</i>", $text);

  #------------------------------------------------------------------------------------------------
  # Horizontal Line
  #------------------------------------------------------------------------------------------------

  $text = preg_replace("~\n-{3,}?\n~" , "\n<hr class='clHr'>\n", $text);

  #------------------------------------------------------------------------------------------------
  # Headers
  #------------------------------------------------------------------------------------------------

  $text = preg_replace("~^###### (.*) ######\n~m" , "", $text);
  $text = preg_replace("~^##### (.*) #####\n~m"   , "", $text);
  $text = preg_replace("~^#### (.*) ####\n~m"     , "", $text);
  $text = preg_replace("~^### (.*) ###\n~m"       , "", $text);
  $text = preg_replace("~^## (.*) ##\n~m"         , "", $text);
  $text = preg_replace("~^# (.*) #\n~m"           , "", $text);

  $text = preg_replace("~^###### (.*)$~m" , "<h6>$1</h6>", $text);
  $text = preg_replace("~^##### (.*)$~m"  , "<h5>$1</h5>", $text);
  $text = preg_replace("~^#### (.*)$~m"   , "<h4>$1</h4>", $text);
  $text = preg_replace("~^### (.*)$~m"    , "<h3>$1</h3>", $text);
  $text = preg_replace("~^## (.*)$~m"     , "<h2>$1</h2>", $text);
  $text = preg_replace("~^# (.*)$~m"      , "<h1>$1</h1>", $text);

  #------------------------------------------------------------------------------------------------
  # Padding
  #------------------------------------------------------------------------------------------------

  $text = preg_replace("~^>>> (.*)$~m" , "&ensp;&ensp;&ensp;$1", $text);
  $text = preg_replace("~^>> (.*)$~m"  , "&ensp;&ensp;$1", $text);
  $text = preg_replace("~^> (.*)$~m"   , "&ensp;$1", $text);

  #------------------------------------------------------------------------------------------------
  # Linguistics Styles
  #------------------------------------------------------------------------------------------------

  $text = preg_replace("~^\|\|(.*?)\|(.*?)\|(.*?)$~m" , "<p class='m0000-18'>$1</p><p class='g0500'>$2</p><p class='b1000'>$3</p>\n", $text);
  $text = preg_replace("~^\|(.*?)\|(.*?)\|(.*?)$~m"   , "<p class='m0000'>$1</p><p class='g0500'>$2</p><p class='b1000'>$3</p>\n", $text);
  $text = preg_replace("~\|\|(.*?)\n(.*?)\n~s"        , "<p class='m0000'>$1</p><p class='b1000'>$2</p>\n", $text);

  #------------------------------------------------------------------------------------------------
  # Cleaning
  #------------------------------------------------------------------------------------------------

  $text = preg_replace("~^\n(.*?)\n$~s"               , "$1", $text);
  $text = preg_replace("~\n~s"                        , "<br>\n", $text);

  $text = preg_replace("~<br>\n<ul>~s"                , "\n<ul>", $text);
  $text = preg_replace("~<br>\n<ol>~s"                , "\n<ol>", $text);

  $text = preg_replace("~<ul><br>~s"                  , "<ul>", $text);
  $text = preg_replace("~<ol><br>~s"                  , "<ol>", $text);

  $text = preg_replace("~</li><br>~s"                 , "</li>", $text);

  $text = preg_replace("~</ul><br>\n<br>~s"           , "</ul>\n", $text);
  $text = preg_replace("~</ul><br>~s"                 , "</ul>\n", $text);
  $text = preg_replace("~</ol><br>\n<br>~s"           , "</ol>\n", $text);
  $text = preg_replace("~</ol><br>~s"                 , "</ol>\n", $text);

  $text = preg_replace("~</pre><br>~s"                , "</pre>\n", $text);

  $text = preg_replace("~<br>\n<div class='clOver~s"  , "\n<div class='clOver", $text);
  $text = preg_replace("~<br>\n<div class='clOver~s"  , "\n<div class='clOver", $text);
  $text = preg_replace("~</tr><br>~s"                 , "</tr>", $text);
  $text = preg_replace("~<table><tr>~s"               , "\n<table>\n<tr>\n", $text);
  $text = preg_replace("~</table></div><br>~s"        , "\n</table>\n</div>\n", $text);

  $text = preg_replace("~<br>\n<h~s"                  , "\n<h", $text);
  $text = preg_replace("~([1-6])><br>\n<br>~s"        , "$1>\n", $text);
  $text = preg_replace("~([1-6])><br>~s"              , "$1>", $text);
  $text = preg_replace("~clHr\'><br>~s"               , "clHr'>\n", $text);
  $text = preg_replace("~REMOVE_PRECODE<br>~s"        , "", $text);
  $text = preg_replace("~REMOVE_BR<br>~s"             , "", $text);

  $text = preg_replace("~</details><br>~s"            , "</details>\n", $text);

  $text = preg_replace("~</div><br>\n<br>~s"          , "</div>\n", $text);
  $text = preg_replace("~</div>\n\n<br>~s"            , "</div>\n", $text);
  $text = preg_replace("~</div><br>\n~s"              , "</div>\n", $text);
  $text = preg_replace("~</blockquote><br>\n<br>~s"   , "</blockquote>\n", $text);
  $text = preg_replace("~</blockquote><br>~s"         , "</blockquote>", $text);
  $text = preg_replace("~<br>\n<blockquote>~s"        , "\n<blockquote>", $text);
  $text = preg_replace("~<blockquote><br>~s"          , "<blockquote>", $text);
  $text = preg_replace("~<br>\n<pre>~s"               , "\n<pre>", $text);
  $text = preg_replace("~</pre>\n\n<br>~s"            , "</pre>\n", $text);
  $text = preg_replace("~</p><br>\n<br>~s"            , "</p>", $text);
  $text = preg_replace("~</p><br>~s"                  , "</p>", $text);
  $text = preg_replace("~--><br>~s"                   , "-->", $text);

  #------------------------------------------------------------------------------------------------
  # Remove Index Break
  #------------------------------------------------------------------------------------------------

  $text = preg_replace("/#~~#<br>/s" , "", $text);

  #------------------------------------------------------------------------------------------------
  # Hard Break
  #------------------------------------------------------------------------------------------------

  $text = preg_replace("/~~/sU" , "<br>", $text);

#--------------------------------------------------------------------------------------------------

  return $text;
}

#--------------------------------------------------------------------------------------------------
?>
