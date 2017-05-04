<?php

$target_dir = "../UserFiles/Files/";
$filename = $_POST["filename"];
$target_file = $target_dir . $filename . ".xml";
$updatedXML = $_POST["updatedXML"];

if(isset($_POST["submit"])) {

  if (!file_exists($target_file)) {
    echo "Original file missing.";
  } else {
      file_put_contents($target_file, $updatedXML);
  }

} else {
  echo "No file submitted";
}

?>
