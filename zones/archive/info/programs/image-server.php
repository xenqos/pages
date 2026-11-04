<?php
#---------------------------------------------------------------------------------------------------

$image_url      = $_GET['varImageUrl'    ] ?? "";

#---------------------------------------------------------------------------------------------------

$file_name = basename($image_url);
$file_ext = strtolower(substr(strrchr($file_name,"."),1));

switch($file_ext)
{
  case "gif" : $file_type="image/gif";     break;
  case "png" : $file_type="image/png";     break;
  case "jpeg": $file_type="image/jpeg";    break;
  case "jpg" : $file_type="image/jpeg";    break;
  case "svg" : $file_type="image/svg+xml"; break;
  default:
}

$image = file_get_contents($image_url);
header('Content-type: ' . $file_type);
echo $image;

#---------------------------------------------------------------------------------------------------
?>
