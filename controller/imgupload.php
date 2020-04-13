#!/usr/bin/php-cgi
<?php
$config = require_once '../config/config.php';
require_once '../model/model.php';
$model = new Model();
try {
    if (!isset($_FILES['file'])) {
            echo "ERR";
            die();
    }
    $target_dir = "uploads/images/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);
    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["file"]["tmp_name"]);
    if ($check === false) {
        echo "NOTIMG";
        die();
        //Check if file is bigger than 5 MB
    } elseif ($_FILES["file"]["size"] > 5000000) {
        echo "TOOBIG";
        die();
    } else {
        $new_filename = $model->storeImage(basename($_FILES["file"]["name"]));
        echo $target_dir;
        if (move_uploaded_file($_FILES["file"]["tmp_name"], '../' . $target_dir . $new_filename)) {
            echo $new_filename;
            die();
        } else {
            echo "Sorry, there was an error uploading your file.";
            die();
        }
    }
} catch (Exception $e) {
    return "ERR";
}
?>
