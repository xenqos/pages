#!/usr/bin/perl
#-----------------------------------------------------------

use strict;
use warnings;
use feature 'state';

#-----------------------------------------------------------

my @books =
(
  '1|dharma/principles|Принципы'
, '0|dharma/questions|Вопросы'
, '0|dharma/kriya|Крия'
, '1|dharma/yoga|Йога-сутры'
, '0|dharma/sankhya|Санкхья-карика'
, '0|dharma/mantra|Мантры'
, '1|dharma/samhita|Самхиты'
, '0|dharma/upanishad|Упанишады'

, '0|dao/daodejing|Дао Дэ Цзин'
, '0|dao/stratagems|Стратагемы'
, '0|dao/taiji-fuzhongwen|Тай Чи - Fu Zhong Wen'
, '0|dao/taiji-moylinshin|Тай Чи - Moy Lin Shin'

, '0|linguistics/bg-grammar|Граматика'
, '0|linguistics/bg-words|Думи'
, '0|linguistics/bg-phrases|Фрази'
, '0|linguistics/bg-verbs|Глаголи'
, '0|linguistics/bg-frequent-words|Честотен речник'
, '0|linguistics/bg-berlitz|Berlitz'
, '0|linguistics/bg-conversations|Разговори'

, '0|linguistics/en-phonetics|Phonetics'
, '0|linguistics/en-orthography|Orthography'
, '0|linguistics/en-grammar|Grammar'
, '0|linguistics/en-grammar-outline|Grammar Outline'
, '0|linguistics/en-frequent-words|Frequent Words'
, '0|linguistics/en-ielts-words|IELTS Words'
, '0|linguistics/en-phrases|Phrases'
, '0|linguistics/en-words|Words'
, '0|linguistics/en-conversations|Conversations'
, '0|linguistics/en-verbs-irregular|Irregular Verbs'
, '0|linguistics/en-verbs-phrasal|Phrasal Verbs'

, '0|linguistics/de-phonetics|Phonetik'
, '1|linguistics/de-grammar|Grammatik'
, '0|linguistics/de-words|Слова'
, '0|linguistics/de-nouns|Существительные'
, '0|linguistics/de-adverbs|Наречия'
, '0|linguistics/de-verbs|Глаголы'
, '0|linguistics/de-strong-verbs|Сильные глаголы'
, '0|linguistics/de-conversations|Разговоры'

, '0|linguistics/sa-outline|Outline'

, '0|linguistics/mystic-rhymes|Мистические рифмы'

, '0|toolbox/mn-banknotes-eur|Banknotes EUR'
, '1|toolbox/eu-standards|EU Standards'

, '0|games/principles|Texas Holdem Principles'
, '0|games/mathresources|Resources'
);

#-----------------------------------------------------------

my $dir_prefix       = '../zones';
my $dir_templates    = './templates';
my $dir_name_pages   = 'pages';
my $dir_name_texts   = 'texts';
my $dir_name_sounds  = 'sounds';
my $file_name_index  = 'index.html';
my $file_name_page   = 'page.html';

my $ext_html         = 'html';
my $ext_text         = 'txt';
my $ext_sound        = '';
my @ext_codecs       = ('opus', 'aac', 'm4a', 'mp3');
my $ext_image        = 'jpg';

#-----------------------------------------------------------

sub get_template
{
  my ($template_name) = @_;

  state %cache;

  return $cache{$template_name} if exists $cache{$template_name};

  my $file_name = "${dir_templates}/${template_name}";
  open my $file_handle, '<', $file_name or die ">>> No File '$file_name' $!";
  my $file_content = do { local $/; <$file_handle> };
  close $file_handle;

  $file_content =~ s/"/'/g;

  $cache{$template_name} = $file_content;
  return $file_content;
}

#-----------------------------------------------------------

sub get_markup
{
  my ($text_content) = @_;

  #---------------------------------------------------------
  # Debugging
  #---------------------------------------------------------

  # my $file_debug = "/home/lux/mnt/data/Temp/debug.txt";
  # open(my $file_handle_debug, '>', $file_debug) or die ">>> No File '$file_debug': $!";
  # print $file_handle_debug $text_content;
  # close($file_handle_debug);

  #---------------------------------------------------------

  #---------------------------------------------------------
  # Add LF at ^ and $
  #---------------------------------------------------------

  $text_content = "\n${text_content}\n";

  #---------------------------------------------------------
  # Quotes
  #---------------------------------------------------------

  $text_content =~ s/"/&quot;/g;
#  $text_content =~ s/'/&apos;/g;
#  $text_content =~ s/`/&grave;/g;

  #---------------------------------------------------------
  # Unordered List
  #---------------------------------------------------------

  my $callback_01 = sub
  {
    my ($matched) = @_;
    $matched =~ s/^(.*?)$/<li>$1<\/li>/mg;
    my $callback_return = "<ul>\n${matched}\n</ul>";
    return $callback_return;
  };
  $text_content =~ s/\[\-\n(.*?)\n\-\]/$callback_01->($1)/esg;

  #---------------------------------------------------------
  # Ordered List
  #---------------------------------------------------------

  my $callback_02 = sub
  {
    my ($matched) = @_;
    $matched =~ s/^(.*?)$/<li>$1<\/li>/mg;
    my $callback_return = "<ol>\n${matched}\n</ol>";
    return $callback_return;
  };
  $text_content =~ s/\[\+\n(.*?)\n\+\]/$callback_02->($1)/esg;

  #---------------------------------------------------------
  # Pre
  #---------------------------------------------------------

  my $callback_03 = sub
  {
    my ($matched) = @_;
    $matched =~ s/\n/REMOVE_PRECODE\n/sg;
    my $callback_return = "<pre>${matched}</pre>";
    return $callback_return;
  };
  $text_content =~ s/\[\*\n(.*?)\n\*\]/$callback_03->($1)/esg;

  #---------------------------------------------------------
  # Pre Code
  #---------------------------------------------------------

  my $callback_04 = sub
  {
    my ($matched) = @_;
    $matched =~ s/\n/REMOVE_PRECODE\n/sg;
    my $callback_return = "<pre><code>${matched}</code></pre>";
    return $callback_return;
  };
  $text_content =~ s/\[\?\n(.*?)\n\?\]/$callback_04->($1)/esg;

  #---------------------------------------------------------
  # Blockquote
  #---------------------------------------------------------

  my $callback_05 = sub
  {
    my ($matched) = @_;
    my $callback_return = "<blockquote>\n${matched}\n</blockquote>";
    return $callback_return;
  };
  $text_content =~ s/\[\!\n(.*?)\n\!\]/$callback_05->($1)/esg;

  #---------------------------------------------------------
  # Details
  #---------------------------------------------------------

  my $callback_06 = sub
  {
    my ($matched_1, $matched_2) = @_;
    my $callback_return = "<details><summary>${matched_1}</summary>${matched_2}</details>";
    return $callback_return;
  };
  $text_content =~ s/\[\@ \((.*?)\)\n(.*?)\n\@\]/$callback_06->($1, $2)/esg;

  #---------------------------------------------------------
  # Styles
  #---------------------------------------------------------

  $text_content =~ s/&\[(.*?)\|(.*?)\]/<q class='$1'>$2<\/q>/g;
  $text_content =~ s/%\[(.*?)\|(.*?)\]/<span class='$1'>$2<\/span>/g;
  $text_content =~ s/s\[(.*?)\]/<small>$1<\/small>/g;

  #---------------------------------------------------------
  # Pseudo Anki
  #---------------------------------------------------------

  $text_content =~ s/\# (.*?)\na\[(.*?)\]\n/<div id='idQuestion'>$1<\/div>\n<div id='idAnswer' onclick='fncRevealAnswer();'>$2<\/div>\n<script>fncHideHeading();<\/script>/g;

  #---------------------------------------------------------
  # Images
  #---------------------------------------------------------

  $text_content =~ s/\!\[(.*?)\|(.*?)\]/<a target='_blank' rel='noreferrer' class='clLinkBlue' href='$2'>$1<\/a>/g;
  $text_content =~ s/\^\[(.*?)\]/<a target='_blank' href='\.\.\/images\/$1'><img class='clImageThumb' src='\.\.\/images\/$1'><\/a>/g;
  $text_content =~ s/\@\[(.*?)\]/<img src='\.\.\/images\/$1'>/g;

  #---------------------------------------------------------
  # Audio
  #---------------------------------------------------------

  my $callback_07 = sub
  {
    my ($matched) = @_;
    my $callback_return = "<audio id='${matched}' src='../sounds/${matched}' preload='auto'></audio>\n";
    $callback_return .= "<span class='clAudio'><span class='clNavRewind' onclick='fncRewindTrack(&quot;${matched}&quot;)'></span><span class='clNavPlay' onclick='fncPlayTrack(&quot;${matched}&quot;)'></span></span>";
    return $callback_return;
  };
  $text_content =~ s/\*\[(.*?)\]/$callback_07->($1)/esg;

  #---------------------------------------------------------
  # Video
  #---------------------------------------------------------

  my $callback_08 = sub
  {
    my ($matched_1, $matched_2) = @_;
    my $callback_return = "<video id='${matched_1}' src='../videos/${matched_1}' poster='../images/${matched_2}' loop preload='auto'></video>\n";
    $callback_return .= "<div class='clVideo'><span class='clNavRewind' onclick='fncRewindTrack(&quot;${matched_1}&quot;)'></span><span class='clNavPlay' onclick='fncPlayTrack(&quot;${matched_1}&quot;)'></span></div>";
    return $callback_return;
  };
  $text_content =~ s/=\[(.*?),(.*?)\]/$callback_08->($1, $2)/esg;

  #---------------------------------------------------------
  # Table ¦ U00A6
  #---------------------------------------------------------

  my $callback_09 = sub
  {
    my ($matched) = @_;
    $matched =~ s/^\¦(.*?)\¦$/<tr><th>$1<\/th><\/tr>/mg;
    $matched =~ s/^\|>(.*?)\|$/<tr><td class='tar'>$1<\/td><\/tr>/mg;
    $matched =~ s/^\|(.*?)\|$/<tr><td>$1<\/td><\/tr>/mg;
    $matched =~ s/\¦/<\/th><th>/sg;
    $matched =~ s/\|/<\/td><td>/sg;
    my $callback_return = "<div class='clOverflow'><table>${matched}</table></div>";
    return $callback_return;
  };
  $text_content =~ s/\[\|\n(.*?)\n\|\]/$callback_09->($1)/esg;

  my $callback_10 = sub
  {
    my ($matched) = @_;
    $matched =~ s/^\^(.*?)\^$/<tr><th>$1<\/th><\/tr>/mg;
    $matched =~ s/^\|>(.*?)\|$/<tr><td class='tar'>$1<\/td><\/tr>/mg;
    $matched =~ s/^\|(.*?)\|$/<tr><td>$1<\/td><\/tr>/mg;
    $matched =~ s/\^/<\/th><th>/sg;
    $matched =~ s/\|/<\/td><td>/sg;
    my $callback_return = "<div class='clOverflow'><table class='clNoBorder'>${matched}</table></div>";
    return $callback_return;
  };
  $text_content =~ s/\[\|\-\n(.*?)\n\|\]/$callback_10->($1)/esg;

  #---------------------------------------------------------
  # If Then Elsif Else
  #---------------------------------------------------------

  $text_content =~ s/^if\n(.*?)\n/<span class='b'>IF<\/span>\n<div class='if-then-else'>$1<\/div>\n/mg;
  $text_content =~ s/^then\n(.*?)\n/<span class='b'>THEN<\/span>\n<div class='if-then-else'>$1<\/div>\n/mg;
  $text_content =~ s/^elseif\n(.*?)\n/<span class='b'>ELSE IF<\/span>\n<div class='if-then-else'>$1<\/div>\n/mg;
  $text_content =~ s/^else\n(.*?)\n/<span class='b'>ELSE<\/span>\n<div class='if-then-else'>$1<\/div>\n/mg;
  $text_content =~ s/^endif\n/<div class='b'>ENDIF<\/div>\n\n\n/mg;

  #---------------------------------------------------------
  # Bold and Italic
  #---------------------------------------------------------

  $text_content =~ s/\*{2}(.*?)\*{2}/<b>$1<\/b>/g;
  $text_content =~ s/\_{2}(.*?)\_{2}/<i>$1<\/i>/g;

  #---------------------------------------------------------
  # Horizontal Line
  #---------------------------------------------------------

  $text_content =~ s/\n-{3,}?\n/\n<hr class='clHr'>\n/g;

  #---------------------------------------------------------
  # Headers
  #---------------------------------------------------------

  $text_content =~ s/^###### (.*?) ######\n//mg;
  $text_content =~ s/^##### (.*?) #####\n//mg;
  $text_content =~ s/^#### (.*?) ####\n//mg;
  $text_content =~ s/^### (.*?) ###\n//mg;
  $text_content =~ s/^## (.*?) ##\n//mg;
  $text_content =~ s/^# (.*?) #\n//mg;

  $text_content =~ s/^###### (.*?)$/<h6>$1<\/h6>/mg;
  $text_content =~ s/^##### (.*?)$/<h5>$1<\/h5>/mg;
  $text_content =~ s/^#### (.*?)$/<h4>$1<\/h4>/mg;
  $text_content =~ s/^### (.*?)$/<h3>$1<\/h3>/mg;
  $text_content =~ s/^## (.*?)$/<h2>$1<\/h2>/mg;
  $text_content =~ s/^# (.*?)$/<h1>$1<\/h1>/mg;

  #---------------------------------------------------------
  # Padding
  #---------------------------------------------------------

  $text_content =~ s/^>>> (.*)$/&ensp;&ensp;&ensp;$1/mg;
  $text_content =~ s/^>> (.*)$/&ensp;&ensp;$1/mg;
  $text_content =~ s/^> (.*)$/&ensp;$1/mg;

  #---------------------------------------------------------
  # Linguistics Styles
  #---------------------------------------------------------

  $text_content =~ s/^\|(.*?)\|(.*?)\|(.*?)$/<p class='r'>$1<\/p><p class='x'>$2<\/p><p class='y'>$3<\/p>\n/mg;
  $text_content =~ s/^\|\|(.*?)\|(.*?)\|(.*?)$/<p class='r'>$1<\/p><p class='x'>$2<\/p><p class='y'>$3<\/p>\n/mg;
  $text_content =~ s/\|\|(.*?)\n(.*?)\n/<p class='r'>$1<\/p><p class='y'>$2<\/p>\n/mg;
  $text_content =~ s/^\|(.*?)\/(.*?)\/(\s*)\|(.*?)\|(.*?)$/<p class='r'>$1 <span class='f'>$2<\/span><\/p><p class='x'>$4<\/p><p class='y'>$5<\/p>\n/mg;

  #---------------------------------------------------------
  # Mathjax
  #---------------------------------------------------------

  $text_content =~ s/\[\$(.*?)\$\]/<div class='clOverflow'>\n\$\$$1\$\$\n<\/div>/sg;
  $text_content =~ s/\n\$<br>\n<br>/\n\$\n/sg;
  $text_content =~ s/\n\$<br>/\n\$/sg;
  $text_content =~ s/\n<\/div><br>\n<br>/\n<\/div>\n/sg;
  $text_content =~ s/\n<\/div><br>/\n<\/div>\n/sg;

  #---------------------------------------------------------
  # Cleaning
  #---------------------------------------------------------

  $text_content =~ s/^\n(.*?)\n$/$1/s;
  $text_content =~ s/\n/<br>\n/g;

  $text_content =~ s/<br>\n<ul>/\n<ul>/sg;
  $text_content =~ s/<br>\n<ol>/\n<ol>/sg;

  $text_content =~ s/<ul><br>/<ul>/sg;
  $text_content =~ s/<ol><br>/<ol>/sg;

  $text_content =~ s/<\/li><br>/<\/li>/sg;

  $text_content =~ s/<\/ul><br>\n<br>/<\/ul>\n/g;
  $text_content =~ s/<\/ul><br>/<\/ul>\n/g;
  $text_content =~ s/<\/ol><br>\n<br>/<\/ol>\n/g;
  $text_content =~ s/<\/ol><br>/<\/ol>\n/g;

  $text_content =~ s/<\/pre><br>/<\/pre>\n/g;

  $text_content =~ s/<br>\n<div class=\'clOver/<br>\n<div class=\'clOver/g;
  $text_content =~ s/<\/tr><br>/<\/tr>/g;
  $text_content =~ s/<table><tr>/\n<table>\n<tr>\n/g;
  $text_content =~ s/<\/table><\/div><br>/\n<\/table>\n<\/div>\n/g;

  $text_content =~ s/<br>\n<h/\n<h/g;
  $text_content =~ s/([1-6])><br>\n<br>/$1>\n/g;
  $text_content =~ s/([1-6])><br>/$1>/g;

  $text_content =~ s/clHr\'>(\n+)<br>/clHr'>\n/g;
  $text_content =~ s/clHr\'><br>/clHr'>\n/g;

  $text_content =~ s/REMOVE_PRECODE<br>//g;
  $text_content =~ s/REMOVE_BR<br>//g;

  $text_content =~ s/<\/details><br>/<\/details>\n/g;

  $text_content =~ s/<\/div><br>\n<br>/<\/div>\n/g;
  $text_content =~ s/<\/div>\n\n<br>/<\/div>\n/g;
  $text_content =~ s/<\/div><br>\n/<\/div>\n/g;
  $text_content =~ s/<\/blockquote><br>\n<br>/<\/blockquote>\n/g;
  $text_content =~ s/<\/blockquote><br>/<\/blockquote>/g;
  $text_content =~ s/<br>\n<blockquote>/\n<blockquote>/g;
  $text_content =~ s/<blockquote><br>/<blockquote>/g;
  $text_content =~ s/<br>\n<pre>/\n<pre>/g;
  $text_content =~ s/<\/pre>\n\n<br>/<\/pre>\n/g;
  $text_content =~ s/<\/p><br>\n<br>/<\/p>/g;
  $text_content =~ s/<\/p><br>/<\/p>/g;
  $text_content =~ s/<\/a><br>\n<br>/<\/a><br>\n/g;
#  $text_content =~ s/<br>\n<br>/<br>\n/g;
  $text_content =~ s/--><br>/-->/g;
  $text_content =~ s/-->\n<br>/-->/g;
  $text_content =~ s/\$\$<br>/\$\$/g;
  $text_content =~ s/<div class='clOverflow'><br>/<div class='clOverflow'>/g;

  #---------------------------------------------------------
  # Remove Index Break
  #---------------------------------------------------------

  $text_content =~ s/#~~#<br>//sg;

  #---------------------------------------------------------
  # Hard Break
  #---------------------------------------------------------

  $text_content =~ s/~~/<br>/sg;

  #---------------------------------------------------------

  return $text_content;
}

#-----------------------------------------------------------

sub get_index
{
  my ($book, $title) = @_;
  my $file_index = "${dir_prefix}/${book}/${file_name_index}";

  return if -e $file_index and system("grep -q '<!DOCTYPE html>' '$file_index'") == 0;

  my $dir_texts = "${dir_prefix}/${book}/${dir_name_texts}";

  opendir(my $dir_handle, $dir_texts) or die ">>> No Directory '$dir_texts': $!";
  my @files = readdir($dir_handle);
  @files = grep { $_ !~ /^\.+$/ } @files;
  closedir($dir_handle);
  @files = sort @files;

  my $content = "<span class='clIndex'>\n";

  foreach my $file (@files)
  {
    my $file_name = "${dir_texts}/${file}";
    open my $file_handle, '<', $file_name or die ">>> No File '$file_name': $!";
    my $file_content = "\n" . do { local $/; <$file_handle> } . "\n";
    close $file_handle;

    if ($file_content =~ /#\~\~#\n/)              { $content .= "<br>\n"; }

    if ($file_content =~ /# (.*?) #\n/)           { $content .= "<h1>" . $1 . "</h1>\n"; }
    if ($file_content =~ /## (.*?) ##\n/)         { $content .= "<h2>" . $1 . "</h2>\n"; }
    if ($file_content =~ /### (.*?) ###\n/)       { $content .= "<h3>" . $1 . "</h3>\n"; }
    if ($file_content =~ /#### (.*?) ####\n/)     { $content .= "<h4>" . $1 . "</h4>\n"; }
    if ($file_content =~ /##### (.*?) #####\n/)   { $content .= "<h5>" . $1 . "</h5>\n"; }
    if ($file_content =~ /###### (.*?) ######\n/) { $content .= "<h6>" . $1 . "</h6>\n"; }

    $file_content =~ s/s\[(.*?)\]/<small>$1<\/small>/g;

    my $file_name_noext = ($file =~ s/\.[^.]+$//r);
    my $link_text = ($file_content =~ /\n# (.*)\n/) ? $1 : $file_name;
    $content .= "<a href='./pages/${file_name_noext}.html'>${link_text}</a><br>\n";
  }

  $content .= "</span>\n";

  my $text = get_template($file_name_index);

  my %variables = (
      title   => $title
    , content => $content
  );

  $text =~ s/\$\{(\w+)\}/exists $variables{$1} ? $variables{$1} : ''/ge;

  open(my $file_handle, '>', $file_index) or die ">>> No File '$file_index': $!";
  print $file_handle $text;
  close($file_handle);
}

#-----------------------------------------------------------

sub get_pages
{
  my ($book, $title) = @_;

  my $dir_texts = "${dir_prefix}/${book}/${dir_name_texts}";
  opendir(my $dir_handle, $dir_texts) or die ">>> No Directory '$dir_texts': $!";
  my @files = readdir($dir_handle);
  closedir($dir_handle);
  @files = grep { $_ !~ /^\.+$/ } @files;
  @files = sort @files;
  my $files_count = scalar(@files);

  my $dir_pages = "${dir_prefix}/${book}/${dir_name_pages}";
  if (! -d $dir_pages) { mkdir($dir_pages); }

  my $page_curr     = '';
  my $page_prev     = '';
  my $page_next     = '';

  foreach my $file (@files)
  {
    my $math_on       = '';
    my $math_tag      = '';
    my $audio_on      = '';
    my $audio_tag     = '';
    my $button_audio  = '';
    my $number_format = '';
    my $content       = '';

    my $file_name_noext = ($file =~ s/\.[^.]+$//r);

    my $file_text = "${dir_texts}/${file}";
    open my $file_handle_text, '<', $file_text or die ">>> No File '$file_text' $!";
    my $text_content = do { local $/; <$file_handle_text> };
    close($file_handle_text);

    my $dir_sounds = "${dir_prefix}/${book}/${dir_name_sounds}";

    foreach my $ext (@ext_codecs)
    {
      if (-e "${dir_sounds}/${file_name_noext}.$ext")
      {
        $audio_on = 1;
        $ext_sound = $ext;
        last;
      }
    }

    ($math_on) = ($text_content =~ /(\[\$|\$\$)/);
    $math_on //= '';

    $page_curr = int($file_name_noext);

    if    ($page_curr == 1)             { $page_prev = $files_count;      $page_next = $page_curr + 1;  }
    elsif ($page_curr == $files_count)  { $page_prev = $files_count - 1;  $page_next = 1;               }
    else                                { $page_prev = $page_curr   - 1;  $page_next = $page_curr + 1;  }

    if    ($files_count > 999) { $number_format = '04'; }
    elsif ($files_count > 99)  { $number_format = '03'; }
    elsif ($files_count > 9)   { $number_format = '02'; }
    elsif ($files_count <= 9)  { $number_format = '1';  }

    $page_curr = sprintf("%${number_format}d", $page_curr);
    $page_prev = sprintf("%${number_format}d", $page_prev);
    $page_next = sprintf("%${number_format}d", $page_next);

    if ($math_on)
    {
      $math_tag  = "<script>MathJax={tex: {inlineMath: [['\$', '\$'], ['\(\(', '\)\)']], processEscapes: true}};</script>\n";
      $math_tag .= "  <script id='MathJax-script' async src='https://cdn.jsdelivr.net/npm/mathjax\@3/es5/tex-mml-chtml.js'></script>";
    }

    if ($audio_on)
    {
      $audio_tag = "<audio id='idTrack' src='../sounds/${page_curr}.${ext_sound}' preload='auto'></audio>";
      $button_audio = "<span class='clNavRewind' onpointerdown='fncRewindTrack(&quot;idTrack&quot;, event)'></span><span class='clNavPlay' onpointerdown='fncPlayTrack(&quot;idTrack&quot;, event)'></span> ";
    }

    $text_content = get_markup $text_content;
    $content .= $text_content;

    my $text = get_template($file_name_page);
    my %variables = (
        title         => $title
      , content       => $content
      , math_tag      => $math_tag
      , audio_tag     => $audio_tag
      , button_audio  => $button_audio
      , page_prev     => $page_prev
      , page_next     => $page_next
      , ext_html      => $ext_html

    );
    $text =~ s/\$\{(\w+)\}/exists $variables{$1} ? $variables{$1} : ''/ge;

    my $file_page = "${dir_pages}/${file_name_noext}.${ext_html}";
    open(my $file_handle_page, '>', $file_page) or die ">>> No File '$file_page': $!";
    print $file_handle_page $text;
    close($file_handle_page);
  }
}

#-----------------------------------------------------------

sub main
{
  foreach my $item (@books)
  {
    my ($status, $book, $title) = split(m/\|/, $item);
    next if $status eq "0";
    print "${book} - ${title}\n";
    get_index $book, $title;
    get_pages $book, $title;
  }
}

#-----------------------------------------------------------

main();

#-----------------------------------------------------------
