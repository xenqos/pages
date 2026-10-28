<?php
  date_default_timezone_set('Europe/Sofia');

  $time_utc_diff = date('Z') / 3600;

  echo $time_utc_diff . "\n";

  echo date_default_timezone_get();
?>

<?php
phpinfo();
?>
