<?php
#----------------------------------------------------------------------------------------------------------------------

function get_password()
{
  $adjectives = file($GLOBALS['adjectives']);
  $nouns = file($GLOBALS['nouns']);

  $delimeter = $GLOBALS['delimeter'];
  $password = '';

  for ($i = 0; $i < $GLOBALS['counter']; $i++)
  {
    $adjective = trim($adjectives[array_rand($adjectives)]);
    $noun = trim($nouns[array_rand($nouns)]);
    $password .= "{$adjective}{$delimeter }{$noun}{$delimeter}";
  }

  $size = count(array_unique(str_split($password))) + 1;
  $length = strlen($password);
  $entropy = log((float)$size, 2.0) * $length;

  $GLOBALS['password'] = rtrim($password, $delimeter);
  $GLOBALS['length'] = (string)($length);
  $GLOBALS['entropy'] = (string)((int)($entropy));
}

#----------------------------------------------------------------------------------------------------------------------
?>
