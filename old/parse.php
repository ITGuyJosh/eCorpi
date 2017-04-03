<?php

if (isset($_SERVER["QUERY_STRING"])){
  $url = urldecode($_SERVER["QUERY_STRING"]);
  $dir = "../UserFiles/Files/";
  $stringfile = strip_tags(file_get_contents($dir . $url));
  echo $stringfile;
}else{
     //do stuff that doesn't need 's'
  echo "File not found.";
}


?>
