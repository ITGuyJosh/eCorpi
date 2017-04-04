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

    // check if file is plain text
    // if (!mime_content_type($target_file)) == "text/plain") {
    //     echo "Sorry, please use a plain text file.";
    //     $uploadOk = 0;
    // }

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

          $fileArray = file($target_file);

          $dom = new DOMDocument("1.0", "UTF-8");

          //$dom->encoding("UTF-8");

          $data = $dom->createElement('literarywork');

          $dom->appendChild($data);

          $data->setAttributeNode(new DOMAttr('Author', $metaAuthor));
          $data->setAttributeNode(new DOMAttr('Title', $metaTitle));
          $data->setAttributeNode(new DOMAttr('Type', $metaType));

          error_reporting(0);

          foreach($fileArray as $line) {
             //$text = $dom->createTextNode(ConvertToUTF8($line));
             $text = $dom->createTextNode(html_entity_decode($line, ENT_COMPAT | ENT_HTML_401, "ISO-8859-1"));
             //$text = $dom->createTextNode($line);
             $data->appendChild($text);
          }

          $xmlfile = basename($_FILES["file-selector"]["name"], ".txt") . ".xml";

          //$xmlfile = html_entity_decode($xmlfile, ENT_COMPAT | ENT_HTML_401, "ISO-8859-1");

          file_put_contents("../UserFiles/Files/" . $xmlfile, $dom->saveXML());
          unlink($target_file);

          error_reporting(-1);

          return "File Uploaded Successfully";
          die();

        } else {
            echo "Sorry, there was an error uploading your file.</br>";
        }
    }

}

// function ConvertToUTF8($text){
//
//     // $encoding = mb_detect_encoding($text, mb_detect_order(), false);
//     //
//     // echo $encoding;
//     //
//     // if($encoding == "UTF-8"){
//     //     $out = mb_convert_encoding($text, 'UTF-8', 'UTF-8');
//     // } else {
//     //     $out = iconv($encoding, "UTF-8", $text);
//     // }
//
//     $text = utf8_encode($text);
//     $text = iconv("ASCII", "UTF-8//TRANSLIT" , $text);
//
//     //$out = html_entity_decode($out);
//     //echo $out;
//
//     $out = $text;
//     return $out;
// }

?>
