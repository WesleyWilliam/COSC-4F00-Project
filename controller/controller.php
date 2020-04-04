#!/usr/bin/php-cgi
<?php
require_once '../utilities/requirements.php';

try {

    //_MSG is used for temporary messages, so you want to clear it so any previous messages are cleared
    $_SESSION['LOGIN_MSG'] = '';
    $_SESSION['SIGNUP_MSG'] = '';
    $_SESSION['UPLOAD_MSG'] = '';
    $_SESSION['RECOVEREMAIL_MSG'] = '';
    $_SESSION['RECOVERPWD_MSG'] = '';
    $_SESSION['CONTACT_MSG'] = '';

    //Everytime the front end sends a post request, it requires a 'COMMAND' request to specify what you are asking for
    if (isset($_POST['COMMAND']) && $_POST['COMMAND'] == 'LOGIN') {
        if (empty($_POST['UNAME']) || empty($_POST['PWD'])) {
            //Use this to set temporary messages for login where you don't want to store it in the database
            $_SESSION['LOGIN_MSG'] = "Enter both username and password";
            redirect("view/login.php");
            die();
        }
        //Sends the model the login information, model returns where the account is correct
        $res = $model->loginAccount($_POST['UNAME'], $_POST['PWD']);
        if ($res == 'NOTFOUND') {
            $_SESSION['LOGIN_MSG'] = "Username or password is incorrect";
            redirect("view/login.php");
            die();
        } else {
            redirect("view/website-name.php");
        }
    } elseif (isset($_POST['COMMAND']) && $_POST['COMMAND'] == 'SIGNUP') {

        if (empty($_POST['UNAME']) || strlen($_POST['UNAME']) < 4 || strpos($_POST['UNAME'], ' ') !== false) {
            $_SESSION['SIGNUP_MSG'] = "Username must be at least 4 characters, no spaces";
            redirect("view/signup.php");
            die();
        } elseif (empty($_POST['PWD']) || strlen($_POST['PWD']) < 8) {
            $_SESSION['SIGNUP_MSG'] = "Password must be at least 8 characters";
            redirect("view/signup.php");
        } else {
            $res = $model->createAccount($_POST['UNAME'], $_POST['EMAIL'], $_POST['PWD']);
            if ($res == "SUCCESS") {
                $_SESSION['LOGIN_MSG'] = 'You can log in now';
                redirect("view/login.php");
                die();
            } elseif ($res == "ACCEXISTS") {
                $_SESSION['SIGNUP_MSG'] = "Account already exists";
                redirect("view/signup.php");
                die();
            } elseif ($res == "EMAILEXISTS") {
                $_SESSION['SIGNUP_MSG'] = "Email already exists";
                redirect("view/signup.php");
            } else {
                redirect("view/signup.php");
            }
        }

        //Uploads an image
    } elseif (isset($_POST['COMMAND']) && $_POST['COMMAND'] == 'PIC_UPLOAD') {
        $target_dir = "uploads/images/";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        // Check if image file is a actual image or fake image
        $check = getimagesize($_FILES["file"]["tmp_name"]);
        if ($check === false) {
            echo "Not an image";
            //Check if file is bigger than 5 MB
        } elseif ($_FILES["file"]["size"] > 5000000) {
            echo "File is too big (over 5MB)";
        } else {
            $new_filename = $model->storeImage(basename($_FILES["file"]["name"]));
            echo $target_dir;
            if (move_uploaded_file($_FILES["file"]["tmp_name"], '../' . $target_dir . $new_filename)) {
                echo $new_filename;
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    } elseif (isset($_POST['COMMAND']) && $_POST['COMMAND'] == 'WEBSITE_WIZARD') {
        $_SESSION['WEBSITE_MSG'] = '';
        if (strlen($_POST['WEBSITE']) < 3) {
            redirect("view/website-name.php");
            die();
        } else {
            $id = $model->addWebsite($_POST['WEBSITE']);
            if ($id == "ALREADYEXISTS") {
                redirect("view/website-name.php");
            } else {
                redirect("view/editor.php?website=" . strval($id));
            }
        }
    } elseif (isset($_REQUEST['COMMAND']) && $_REQUEST['COMMAND'] == 'LOGOUT') {
        $model->logout();
        redirect('view/login.php');
        die();
    } elseif (isset($_POST['COMMAND']) && $_POST['COMMAND'] == 'SAVE-EDITOR') {
        echo $model->saveWebsites($_POST['WEBSITE'], $_POST['WEBPAGES']);
    } elseif (isset($_POST['COMMAND']) && $_POST['COMMAND'] == 'RECOVERPWD') {
        $_SESSION['RECOVERPWD_MSG'] = '';
        if ($_POST['PWD'] != $_POST['PWD2']) {
            $_SESSION['RECOVERPWD_MSG'] = "Passwords don't match";
            if (is_numeric($_POST['CODE'])) {
                redirect('view/recover-password.php?code=' . $_POST['CODE']);
                die();
            }
        } elseif (empty($_POST['PWD']) || strlen($_POST['PWD']) < 8) {
            $_SESSION['RECOVERPWD_MSG'] = "Password must be at least 8 characters";
            if (is_numeric($_POST['CODE'])) {
                redirect('view/recover-password.php?code=' . $_POST['CODE']);
                die();
            }
        } else {
            $res = $model->recoverPassword($_POST['CODE'], $_POST['PWD']);
            if ($res == "CODEWRONG") {
                $_SESSION['RECOVERMAIL_MSG'] = 'Something went wrong, try again';
            } elseif ($res == "TIMEOUT") {
                $_SESSION['RECOVERPWD_MSG'] = 'Password timed out, try again';
            } elseif ($res == "SUCCESS") {
                $_SESSION['LOGIN_MSG'] = 'Enter new password';
                redirect('view/login.php');
                die();
            }
            redirect('view/recover-email.php');
            die();
        }
    } elseif (isset($_POST['COMMAND']) && $_POST['COMMAND'] == 'RECOVEREMAIL') {
        $res = $model->recoverCode($_POST['EMAIL']);
        if ($res == "EMAILDNE") {
            $_SESSION['RECOVEREMAIL_MSG'] = "Email does not exist";
        } else {
            $msg = "Click on this link to reset your password\n www.cosc.brocku.ca" . $config['home-file-path'] . '/view/recover-password.php?code=' . strval($res);
            mail($_POST['EMAIL'], "Recovery email for Brix", $msg);
            $_SESSION['RECOVEREMAIL_MSG'] = 'Message sent, check your email and junk folder';
        }
        redirect("view/recover-email.php");
        die();
    } elseif (isset($_POST['COMMAND']) && $_POST['COMMAND'] == 'UPDATEPROFILE') {
        if (!empty($_POST['EMAIL'])) {
            $res = $model->updateAccountPreferences($_POST['FNAME'], $_POST['LNAME'], $_POST['DOB'], $_POST['PHONE'], $_POST['EMAIL']);
            if ($res == "SUCCESS") {
                $_SESSION['UPDATEACCOUNT'] = 'Account has been updated';
            } else {
                $_SESSION['UPDATEACCOUNT'] = 'Email Unavailable';
            }
        }
        redirect("view/account.php");
        die();
    } elseif (isset($_POST['COMMAND']) && $_POST['COMMAND'] == 'UPDATEPRIVACY') {
        $res = $model->updateAccountPrivacy($_POST['VPERM'], $_POST['BLOCKED']);
        if ($res == "SUCCESS") {
            $_SESSION['UPDATEACCOUNT'] = 'Account has been updated';
        } else {
            $_SESSION['UPDATEACCOUNT'] = 'Update Failed';
        }
        redirect("view/account.php");
        die();
    } elseif (isset($_POST['COMMAND']) && $_POST['COMMAND'] == 'UPDATEPAYMENT') {
        $res = $model->updateAccountPayment($_POST['CNUM'], $_POST['EDATE'], $_POST['CVVNUM'], $_POST['TYPE']);
        if ($res == "SUCCESS") {
            $_SESSION['UPDATEACCOUNT'] = 'Account has been updated';
        } else {
            $_SESSION['UPDATEACCOUNT'] = 'Update Failed';
        }
        redirect("view/account.php");
        die();
    } elseif (isset($_POST['COMMAND']) && $_POST['COMMAND'] == 'UPDATESUBSCRIPTIONS') {
        $res = $model->updateAccountSubscription($_POST['SUB']);
        if ($res == "SUCCESS") {
            $_SESSION['UPDATEACCOUNT'] = 'Account has been updated';
        } else {
            $_SESSION['UPDATEACCOUNT'] = 'Update Failed';
        }
        redirect("view/account.php");
        die();
    } elseif (isset($_POST['COMMAND']) && $_POST['COMMAND'] == 'DELETEACCOUNT') {
        $res = $model->deleteAccount();
        $model->logout();
        if ($res == "SUCCESS") {
            $_SESSION['LOGIN_MSG'] = 'Account has been deleted';
            redirect("view/login.php");
            die();
        } else {
            $_SESSION['UPDATEACCOUNT'] = 'Email Unavailable';
            redirect("view/account.php");
            die();
        }
    } elseif (isset($_REQUEST['COMMAND']) && $_REQUEST['COMMAND'] == 'LOGOUT') {
        $model->logout();
        redirect('view/login.php');
    } elseif (isset($_POST['COMMAND']) && $_POST['COMMAND'] == 'SAVE-EDITOR') {
        echo $model->saveWebsites($_POST['WEBPAGE'], $_POST['COMPONENTS']);
    } elseif (isset($_POST['COMMAND']) && $_POST['COMMAND'] == 'CONTACT') {
        if (empty($_POST['EMAIL'])) {
            $_SESSION['CONTACT_MSG'] = "Enter email address";
            redirect('view/contact.php');
            die();
        } else {
            $model->sendContact($_POST['EMAIL'],isset($_POST['FULLNAME'])? $_POST['FULLNAME']:'',isset($_POST['MSG'])?$_POST['MSG']:'');
            $_SESSION['CONTACT_MSG'] = 'Message sent';
            redirect('view/contact.php');
            die();
        }
    } elseif (isset($_REQUEST['COMMAND']) && $_REQUEST['COMMAND']=='UNIQUE') {
        $model->setUniques();
        echo "Unique set in tables";
    }
} catch (SessionNotFound $e) {
    redirect('view/login.php');
}
?>