#!/usr/bin/php-cgi
<?php
include '../utilities/utilities.php';
include '../model/model.php';
$model = new Model();

if (isset($_POST['COMMAND']) && $_POST['COMMAND'] == 'LOGIN') {
    $_SESSION['LOGIN_MSG']='';
    if (empty($_POST['UNAME']) || empty($_POST['PWD'])) {
        $_SESSION['LOGIN_MSG'] = "Enter both username and password";
        redirect("view/login.php");
        die();
    } 
    $res = $model->loginAccount($_POST['UNAME'],$_POST['PWD']);
    if ($res == 'NOTFOUND') {    
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
            redirect("view/login.php");
            $_SESSION['LOGIN_MSG'] = 'You can log in now';
            die();
        } else {
            redirect("view/signup.php");
        }
    }
}
?>
