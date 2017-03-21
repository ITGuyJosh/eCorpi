<?php

$target_dir = "../UserFiles/Files/";
$target_file = $target_dir . basename($_FILES["file"]["name"]);
$uploadOk = 1;
$fileType = pathinfo($target_file,PATHINFO_EXTENSION);

if ( 0 < $_FILES['file']['error'] ) {
        echo 'Error: ' . $_FILES['file']['error'] . '<br>';
    }

    else {
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
      if ($_FILES["file"]["size"] > 300000) {
          echo "Sorry, your file is larger than 3MB.</br>";
          $uploadOk = 0;
      }

      // Check if $uploadOk is set to 0 by an error
      if ($uploadOk == 0) {
          echo "Sorry, your file was not uploaded. Please try again or contact the systems administrator.</br>";

      // if everything is ok, try to upload file
      } else {
          if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {

            // $str=file_get_contents($target_file);
            // $utf8=html_entity_decode($str);
            $fileArray = file($target_file);

            $dom = new DOMDocument;

            $data = $dom->createElement('document');

            $dom->appendChild($data);



            // $iso8859=utf8_decode($utf8);
            // $manufacturers = file($iso8859);

            error_reporting(0);

            foreach($fileArray as $line) {
               $lineElement = $dom->createElement('l');
               //echo 'IGNORE   : ', iconv("UTF-8", "ISO-8859-1//IGNORE", $text), PHP_EOL;
               //$utfdata = iconv("UTF-8", "ISO-8859-1//",$manufacturer)
               $text = $dom->createTextNode(ConvertToUTF8($line));

               $data->appendChild($lineElement);

               //$str = explode($text);


              //  for ($i=0; $i < ; $i++) {
              //    # code...
              //  }

              //  foreach ($text as $word) {
              //     $wordElement = $dom->createElement('w');
              //     $data->appendChild($wordElement);
              //     $wordElement->appendChild($word);
              //  }

               $lineElement->appendChild($text);

            }

            $xmlfile = basename($_FILES["file"]["name"], ".txt") . ".xml";

            file_put_contents("../UserFiles/Files/" . $xmlfile, $dom->saveXML());


            //header("Location: ../index.php");

            // echo "<script>
            //   $(document).ready(function(){
            //   $('#upload-complete-modal').modal('show');
            //
            //   });
            //   </script>";

              // setTimeout(function(){
              //   $('#upload-complete-modal').hide();
              // }, 3000);
            //die();

            error_reporting(0);

          } else {
              echo "Sorry, there was an error uploading your file.</br>";
          }
      }

}

function ConvertToUTF8($text){

    $encoding = mb_detect_encoding($text, mb_detect_order(), false);

    if($encoding == "UTF-8")
    {
        $text = mb_convert_encoding($text, 'UTF-8', 'UTF-8');
    }


    $out = iconv(mb_detect_encoding($text, mb_detect_order(), false), "UTF-8//IGNORE", $text);


    return $out;
}

?>
