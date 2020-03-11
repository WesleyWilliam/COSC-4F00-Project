#!/usr/bin/php-cgi
<?php
include '../utilities/utilities.php';
include '../model/model.php';
$model = new Model();

//Everytime the front end sends a post request, it requires a 'COMMAND' request to specify what you are asking for
if (isset($_POST['COMMAND']) && $_POST['COMMAND'] == 'LOGIN') {
    //LOGIN_MSG is used for temporary messages, so you want to clear it so any previous messages are cleared
    $_SESSION['LOGIN_MSG']='';
    if (empty($_POST['UNAME']) || empty($_POST['PWD'])) {
        //Use this to set temporary messages for login where you don't want to store it in the database
        $_SESSION['LOGIN_MSG'] = "Enter both username and password";
        redirect("view/login.php");
        die();
    }
    //Sends the model the login information, model returns where the account is correct
    $res = $model->loginAccount($_POST['UNAME'],$_POST['PWD']);
    if ($res == 'NOTFOUND') {
        $_SESSION['LOGIN_MSG'] = "Username or password is incorrect";
        redirect("view/login.php");
        die();
    } else {
        redirect("view/welcome.php");
    }    
} elseif (isset($_POST['COMMAND']) && $_POST['COMMAND'] == 'SIGNUP') {
    $_SESSION['SIGNUP_MSG'] = '';
    if (empty($_POST['UNAME']) || strlen($_POST['UNAME']) < 4 || strpos($_POST['UNAME'],' ') !== false) {
        $_SESSION['SIGNUP_MSG'] = "Username must be at least 4 characters, no spaces";
        redirect("view/signup.php");
        die();
    } elseif(empty($_POST['PWD']) || strlen($_POST['PWD']) < 8) {
        $_SESSION['SIGNUP_MSG'] = "Password must be at least 8 characters";
        redirect("view/signup.php");
    } else {
        $res = $model->createAccount($_POST['UNAME'],$_POST['PWD']);
        if ($res == "SUCCESS") {
            $_SESSION['LOGIN_MSG'] = 'You can log in now';
            redirect("view/login.php");
            die();
        } elseif ($res=="ACCEXISTS") {
            $_SESSION['SIGNUP_MSG'] = "Account already exists" ;
            redirect("view/signup.php");
            die();
        } else {
            redirect("view/signup.php");
        }
    }
    //Uploads an image
} elseif (isset($_POST['COMMAND']) && $_POST['COMMAND'] == 'PIC_UPLOAD') {
    $_SESSION
    $target_dir = "uploads/images/";
    $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    // Check if image file is a actual image or fake image
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check === false) {
        $_SESSION['UPLOAD_MSG'] = "Not an image";
        redirect("view/file-upload.php");
        die();
    }
    $new_filename = $model->storeImage(basename($_FILES["fileToUpload"]["name"]));
}
?>
