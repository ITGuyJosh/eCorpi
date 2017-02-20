<?php
$target_dir = "../UserFiles/Files/";
$target_file = $target_dir . basename($_FILES["file-selector"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {

    // check if file is plain text

    // check if file already exists
    if (file_exists($target_file)) {
        echo "Sorry, file already exists.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["file-selector"]["size"] > 300000) {
        echo "Sorry, your file is larger than 3MB";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";

    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["file-selector"]["tmp_name"], $target_file)) {

          header("Location: ../index.html");          
          die();

        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>
