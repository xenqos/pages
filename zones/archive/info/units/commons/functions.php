<?php
#----------------------------------------------------------------------------------------------------------------------
# debug($object, type: 'p', mode: 'a', name: 'name');
#----------------------------------------------------------------------------------------------------------------------

function debug($object, $mode = null, $name = null)
{
  $logs = $GLOBALS['logs'];
  $unit = $GLOBALS['unit'];

  if (is_null($name)) { $name = 'debug'; }
  if (is_null($mode)) { $mode = 0; } else { $mode = FILE_APPEND; }

  file_put_contents("{$logs}/{$name}.log", "{$object}\n", $mode);
}

#----------------------------------------------------------------------------------------------------------------------

function get_template($name)
{
  $templates = $GLOBALS['templates'];
  $unit = $GLOBALS['unit'];

  $text = '';

  $text = file_get_contents("{$templates}/{$unit}/{$name}.html");
  $text = preg_replace("/\"/", "'", $text);

  return $text;
}

#----------------------------------------------------------------------------------------------------------------------

function get_clean($text, $parameters, $modifiers = null)
{
  is_null($modifiers) ? $modifiers = 's' : null;

  foreach($parameters as $items)
  {
    $text = preg_replace("~{$items[0]}~{$modifiers}", $items[1], $text);
  }

  return $text;
}

#----------------------------------------------------------------------------------------------------------------------

function get_url($url, $query = null, $post = null)
{
  if (! is_null($query))
  {
    $url .= '?' . http_build_query($query, '', '&', PHP_QUERY_RFC3986);
  }

  if (! is_null($post))
  {
    array_push($GLOBALS['http_header'], 'Content-Type: application/x-www-form-urlencoded');
    $post = http_build_query($post, '', '&', PHP_QUERY_RFC3986);
    $GLOBALS['http_setopt'][CURLOPT_POST] = true;
    $GLOBALS['http_setopt'][CURLOPT_POSTFIELDS] = $post;
  }

  $http_setopt = $GLOBALS['http_setopt'];
  $http_header = $GLOBALS['http_header'];

  $handle = curl_init();

  curl_setopt($handle, CURLOPT_URL, $url);
  curl_setopt_array($handle, $http_setopt);
  curl_setopt($handle, CURLOPT_HTTPHEADER, $http_header);

  $content = curl_exec($handle);
  # $http_status = curl_getinfo($handle, CURLINFO_HTTP_CODE);

  if (curl_errno($handle)) { debug('Error: [' . curl_error($handle) . ']', name: 'curl'); }

  curl_close($handle);

  return $content;
}

#----------------------------------------------------------------------------------------------------------------------
?>
