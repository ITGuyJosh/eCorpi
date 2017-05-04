<?php
$target_dir = "../UserFiles/Files/";
$target_file = $target_dir . basename($_FILES["file-selector"]["name"]);
$uploadOk = 1;
$fileType = pathinfo($target_file,PATHINFO_EXTENSION);
$metaAuthor = $_POST["file-meta-author"];
$metaTitle = $_POST["file-meta-title"];
$metaType = $_POST["file-meta-genre"];

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {

    // check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.</br>";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["file-selector"]["size"] > 300000) {
        echo "Sorry, your file is larger than 3MB.</br>";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded. Please try again or contact the systems administrator.</br>";

    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["file-selector"]["tmp_name"], $target_file)) {

          //get file
          $fileArray = file($target_file);

          //create xml dom structure
          $dom = new DOMDocument("1.0", "UTF-8");
          $data = $dom->createElement('literarywork');
          $dom->appendChild($data);
          $data->setAttributeNode(new DOMAttr('Author', $metaAuthor));
          $data->setAttributeNode(new DOMAttr('Title', $metaTitle));
          $data->setAttributeNode(new DOMAttr('Type', $metaType));

          error_reporting(0);

          //decode and set text to ISO-8859-1
          foreach($fileArray as $line) {
             $text = $dom->createTextNode(html_entity_decode($line, ENT_COMPAT | ENT_HTML_401, "ISO-8859-1"));
             $data->appendChild($text);
          }

          //set file title and save xml file
          $xmlfile = basename($_FILES["file-selector"]["name"], ".txt") . ".xml";
          file_put_contents("../UserFiles/Files/" . $xmlfile, $dom->saveXML());
          //delete text file
          unlink($target_file);

          error_reporting(-1);

          return "File Uploaded Successfully";
          die();

        } else {
            echo "Sorry, there was an error uploading your file.</br>";
        }
    }
}

?>
