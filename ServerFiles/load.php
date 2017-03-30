<?php

if (isset($_SERVER["QUERY_STRING"])){
  $url = urldecode($_SERVER["QUERY_STRING"]);
  $dir = "../UserFiles/Files/";
  $stringfile = file_get_contents($dir . $url);
  echo $stringfile;
}else{
  echo "File not found.";
}

?>
