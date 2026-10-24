<?php
#--------------------------------------------------------------------------------------------------
# Server
#--------------------------------------------------------------------------------------------------

$moz_version = '120.0.0.0';
$user_agent  = "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/{$moz_version} Safari/537.36";

$server_name = $_SERVER['SERVER_NAME'] ??   '';
$server_port = $_SERVER['SERVER_PORT'] ??   '';
$server_docroot    = $_SERVER['DOCUMENT_ROOT'] ?? '';

isset( $_SERVER['HTTPS'] ) ? $server_protocol = 'https' : $server_protocol = 'http';
$server_root = "{$server_protocol}://{$server_name}";

#--------------------------------------------------------------------------------------------------

$http_setopt =
[
  CURLOPT_AUTOREFERER     => true
, CURLOPT_CONNECTTIMEOUT  => 20
, CURLOPT_COOKIESESSION   => true
, CURLOPT_HEADER          => false
, CURLOPT_ENCODING        => 'gzip, deflate'
, CURLOPT_FAILONERROR     => true
, CURLOPT_FOLLOWLOCATION  => true
, CURLOPT_FORBID_REUSE    => false
, CURLOPT_RETURNTRANSFER  => true
, CURLOPT_SSL_VERIFYHOST  => false
, CURLOPT_SSL_VERIFYPEER  => false
, CURLOPT_TIMEOUT         => 60
, CURLOPT_USERAGENT       => $user_agent
];

#--------------------------------------------------------------------------------------------------
# https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers
#--------------------------------------------------------------------------------------------------

$http_header =
[
  'Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8,application/signed-exchange;v=b3;q=0.9'
, 'Accept-Language: en,en-US,bg-BG'
, 'Cache-Controll: no-cache'
, 'Connection: keep-alive'
, 'Sec-Fetch-Dest: document'
, 'Sec-Fetch-Mode: navigate'
, 'Sec-Fetch-Site: same-origin'
, 'Sec-Fetch-User: ?1'
, 'Upgrade-Insecure-Requests: 1'
];

#--------------------------------------------------------------------------------------------------
# Global Variables
#--------------------------------------------------------------------------------------------------

$assets    = '../assets';
$images    = '../images';
$logs      = '../logs';
$templates = '../templates';
$zones     = '../zones';

$progs     = '/programs';
$prog      = "{$progs}/{$unit}.php";

#--------------------------------------------------------------------------------------------------
# Locale
#--------------------------------------------------------------------------------------------------

setlocale( LC_ALL, 'en_US.UTF-8' );

#--------------------------------------------------------------------------------------------------
# Time & Date
# https://www.php.net/manual/en/datetime.format.php
#--------------------------------------------------------------------------------------------------

$time_fmt = 'H:i';
$date_fmt_full = 'l, M j, Y H:i:s';
$date_fmt_short = 'm/d/Y H:i:s';

date_default_timezone_set('UTC');
$time_utc = date($time_fmt);

date_default_timezone_set('Europe/Sofia');
$time_local = date($time_fmt);

$time_zone = date('Z') / 3600;

$date_today = date($date_fmt_full);
$date_short = date($date_fmt_short);

#--------------------------------------------------------------------------------------------------
?>
