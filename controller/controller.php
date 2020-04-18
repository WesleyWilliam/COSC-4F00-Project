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
            $user = $model->getUser();
            if ($user->level === "Admin") {
                redirect("view/admin-portal.php");
                die();
            } else {
                redirect("view/website-name.php");
                die();
            }
        }
    } elseif (isset($_POST['COMMAND']) && $_POST['COMMAND'] == 'SIGNUP') {
        if (empty($_POST['UNAME']) || strlen($_POST['UNAME']) < 4 || strpos($_POST['UNAME'], ' ') !== false) {
            $_SESSION['SIGNUP_MSG'] = "Username must be at least 4 characters, no spaces";
            redirect("view/signup.php");
            die();
        } elseif (empty($_POST['PWD']) || strlen($_POST['PWD']) < 8) {
            $_SESSION['SIGNUP_MSG'] = "Password must be at least 8 characters";
            redirect("view/signup.php");
            die();
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
                die();
            } elseif ($res == "ERR") {
                $_SESSOIN['SIGNUP_MSG'] = "Error creating account";
                redirect("view/signup.php");
                die();
            } else {
                redirect("view/signup.php");
                die();
            }
        }
        //Uploads an image
    } elseif (isset($_POST['COMMAND']) && $_POST['COMMAND'] == 'WEBSITE_WIZARD') {
        if (strlen($_POST['WEBSITE']) < 3) {
            $_SESSION['WEBSITENAME'] = "The name of the website needs to have more than three characters";
            redirect("view/website-name.php");
            die();
        } else {
            $id = $model->addWebsite($_POST['WEBSITE']);
            if ($id == "ALREADYEXISTS") {
                $_SESSION['WEBSITENAME'] = "This website already exists!";
                redirect("view/website-name.php");
                die();
            } elseif ($id == "ERR") {
                $_SESSION['WEBSITENAME'] = "There was a problem creating a website";
                redirect("view/website-name.php");
                die();
            } else {
                redirect("view/editor.php?website=" . strval($id));
                die();
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
        if (empty($_POST['CODE']) || empty($_POST['PWD'])) {
            $_SESSION['RECOVERPWD_MSG'] = "Make sure you entered the password and that the code is correct";
            redirect('view/recover-password.php');
            die();
        } elseif ($_POST['PWD'] != $_POST['PWD2']) {
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
                $_SESSION['RECOVEREMAIL_MSG'] = 'Something went wrong, try again';
                redirect('view/recover-email.php');
                die();
            } elseif ($res == "TIMEOUT") {
                $_SESSION['RECOVEREMAIL_MSG'] = 'Password timed out, try again';
                redirect('view/recover-email.php');
                die();
            } elseif ($res == "CODEWRONG") {
                $_SESSION['RECOVEREMAIL_MSG'] = "Something went wrong, try again";
                redirect('view/recover-email.php');
                die();
            } elseif ($res == "SUCCESS") {
                $_SESSION['LOGIN_MSG'] = 'Enter new password';
                redirect('view/login.php');
                die();
            } elseif ($res == "ERR") {
                $_SESSION['RECOVEREMAIL_MSG'] = "Something went wrong, try again";
                redirect('view/recover-email.php');
                die();
            }
        }
    } elseif (isset($_POST['COMMAND']) && $_POST['COMMAND'] == 'RECOVEREMAIL') {
        $res = $model->recoverCode($_POST['EMAIL']);
        if ($res == "EMAILDNE") {
            $_SESSION['RECOVEREMAIL_MSG'] = "Email does not exist";
            redirect("view/recover-email.php");
            die();
        } elseif ($res == "ERR") {
            $_SESSION['RECOVEREMAIL_MSG'] = "Error, please try again";
            redirect("view/recover-email.php");
            die();
        } else {
            $msg = "Click on this link to reset your password\n www.cosc.brocku.ca" . $config['home-file-path'] . '/view/recover-password.php?code=' . strval($res);
            mail($_POST['EMAIL'], "Recovery email for Brix", $msg);
            $_SESSION['RECOVEREMAIL_MSG'] = 'Message sent, check your email and junk folder';
            redirect("view/recover-email.php");
            die();
        }
    } elseif (isset($_POST['COMMAND']) && $_POST['COMMAND'] == 'UPDATEPROFILE') {
        if (!empty($_POST['EMAIL'])) {
            $res = $model->updateAccountPreferences($_POST['FNAME'], $_POST['LNAME'], $_POST['DOB'], $_POST['PHONE'], $_POST['EMAIL']);
            if ($res == "SUCCESS") {
                $_SESSION['UPDATEACCOUNT'] = 'Account has been updated';
                redirect("view/account.php");
                die();
            } else {
                $_SESSION['UPDATEACCOUNT'] = 'Email Unavailable';
                redirect("view/account.php");
                die();
            }
        }
    } elseif (isset($_POST['COMMAND']) && $_POST['COMMAND'] == 'UPDATEPRIVACY') {
        $res = $model->updateAccountPrivacy($_POST['VPERM'], $_POST['BLOCKED']);
        if ($res == "SUCCESS") {
            $_SESSION['UPDATEACCOUNT'] = 'Account has been updated';
            redirect("view/account.php");
            die();
        } else {
            $_SESSION['UPDATEACCOUNT'] = 'Update Failed';
            redirect("view/account.php");
            die();
        }
    } elseif (isset($_POST['COMMAND']) && $_POST['COMMAND'] == 'UPDATEPAYMENT') {
        $res = $model->updateAccountPayment($_POST['CNUM'], $_POST['EDATE'], $_POST['CVVNUM'], $_POST['TYPE']);
        if ($res == "SUCCESS") {
            $_SESSION['UPDATEACCOUNT'] = 'Account has been updated';
            redirect("view/account.php");
            die();
        } else {
            $_SESSION['UPDATEACCOUNT'] = 'Update Failed';
            redirect("view/account.php");
            die();
        }
    } elseif (isset($_POST['COMMAND']) && $_POST['COMMAND'] == 'UPDATESUBSCRIPTIONS') {
        $res = $model->updateAccountSubscription($_POST['SUB']);
        if ($res == "SUCCESS") {
            $_SESSION['UPDATEACCOUNT'] = 'Account has been updated';
            redirect("view/account.php");
            die();
        } else {
            $_SESSION['UPDATEACCOUNT'] = 'Update Failed';
            redirect("view/account.php");
            die();
        }
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
        die();
    } elseif (isset($_POST['COMMAND']) && $_POST['COMMAND'] == 'SAVE-EDITOR') {
        echo $model->saveWebsites($_POST['WEBPAGE'], $_POST['COMPONENTS']);
    } elseif (isset($_POST['COMMAND']) && $_POST['COMMAND'] == 'CONTACT') {
        if (empty($_POST['EMAIL'])) {
            $_SESSION['CONTACT_MSG'] = "Enter email address";
            redirect('view/support.php');
            die();
        } else {
            $model->sendContact($_POST['EMAIL'], $_POST['FULLNAME'], $_POST['MSG']);
            $_SESSION['CONTACT_MSG'] = 'Message sent';
            redirect('view/support.php');
            die();
        }
    } elseif (isset($_REQUEST['COMMAND']) && $_REQUEST['COMMAND'] == 'UNIQUE') {
        $model->setUniques();
        echo "Unique set in tables";
    } elseif (isset($_POST['COMMAND']) && $_POST['COMMAND'] == 'WEBSITE_DELETE') {
        $res = $model->deleteWebsite($_POST['SITE']);
        $_SESSION['WEBSITENAME'] = "Website was succesfully deleted";
        redirect("view/website-name.php");
        die();
    } elseif (isset($_POST['COMMAND']) && $_POST['COMMAND'] == 'WEBSITE_DELETE_ADMIN') {
        $res = $model->deleteWebsiteAdmin($_POST['SITE']);
        $_SESSION['WEBSITENAME'] = "Website was succesfully deleted";
        redirect("view/admin-portal.php");
        die();
    } elseif (isset($_POST['COMMAND']) && $_POST['COMMAND'] == 'USER_DELETE_ADMIN') {
        if (isset($_POST['SITE'])) {
            $res = $model->deleteUserAdmin($_POST['SITE']);
            if ($res == "SUCCESS") {
                $_SESSION['WEBSITENAME'] = "User was succesfully deleted";
            } else {
                $_SESSION['WEBSITENAME'] = "Sorry you cannot delete yourself";
            }
        } elseif (isset($_POST['ADD'])) {
            $res = $model->addUserAsAdmin($_POST['ADD']);
            if ($res == "SUCCESS") {
                $_SESSION['WEBSITENAME'] = "User was succesfully made into admin";
            } else {
                $_SESSION['WEBSITENAME'] = "Error setting user as admin";
            }
        } elseif (isset($_POST['REMOVE'])) {
            $res = $model->removeUserAsAdmin($_POST['REMOVE']);
            if ($res == "SUCCESS") {
                $_SESSION['WEBSITENAME'] = "User was succesfully removed as admin";
            } else {
                $_SESSION['WEBSITENAME'] = "Error changing user back to standard user";
            }
        } elseif (isset($_POST['TOGGLE'])) {
            $res = $model->toggleUserAsAdmin($_POST['TOGGLE']);
            if ($res == "SUCCESS") {
                $_SESSION['WEBSITENAME'] = "User permissons has succesfully changed";
            } else {
                $_SESSION['WEBSITENAME'] = "Error changing user permissons user";
            }
        } else {
            $_SESSION['WEBSITENAME'] = "Error! that did not save";
        }
        redirect("view/admin-portal.php");
        die();
    } elseif (isset($_POST['COMMAND']) && $_POST['COMMAND'] == 'CONTACT_DELETE_ADMIN') {
        $res = $model->deleteContact($_POST['SITE']);
        $_SESSION['WEBSITENAME'] = "Contact was succesfully deleted";
        redirect("view/admin-portal.php");
        die();
    } elseif (isset($_POST['COMMAND']) && $_POST['COMMAND'] == 'DELETE_DATABASE') {
        if (isset($_POST['DATABASE']) && $_POST['DATABASE'] == 'website') {
            $_POST['DATABASE'] = '';
            $websitelst = null;
            try {
                $websitelst = $model->listAllWebsites();
            } catch (Exception $e) {
                redirect('view/admin-portal.php');
                die();
            }
            $error = false;
            foreach ($websitelst as $website) {
                $res = $model->deleteWebsiteAdmin($website->id);
                if ($res != "SUCCESS") {
                    $error = true;
                }
            }
            if ($error == "True") {
                $_SESSION['WEBSITENAME'] = "Error deleting website did not occur!";
                redirect("view/admin-portal.php");
                die();
            }
            $res = $model->deleteAllWebsites();
            if ($res == "SUCCESS") {
                $_SESSION['WEBSITENAME'] = "All websites have been successfully deleted";
                redirect("view/admin-portal.php");
                die();
            }
            #delete website
            die();
        } elseif (isset($_POST['DATABASE']) && $_POST['DATABASE'] == 'user') {
            $_POST['DATABASE'] = '';
            $res = $model->deleteAllUsers();
            if ($res == "SUCCESS") {
                $model->logout();
                $model->createAccount("Admin", "Admin@Admin.com", "Admin");
                $id = $model->getUserID("Admin");
                $model->addUserAdAdmin($id);
                $_SESSION['LOGIN_MSG'] = "All Users have been deleted, recreated generic admin account";
                redirect("view/login.php");
                die();
            }
            #delete user
            die();
        } elseif (isset($_POST['DATABASE']) && $_POST['DATABASE'] == 'ticket') {
            $_POST['DATABASE'] = '';
            $res = $model->deleteAllContacts();
            if ($res == "SUCCESS") {
                $_SESSION['WEBSITENAME'] = "All tickets have been successfully deleted";
                redirect("view/admin-portal.php");
                die();
            }
            $_SESSION['WEBSITENAME'] = "Error: Tickets did not delete properly";
            redirect("view/admin-portal.php");
            die();
            #delete ticket
            die();
        } elseif (isset($_POST['DATABASE']) && $_POST['DATABASE'] == 'wipe') {
            $_POST['DATABASE'] = '';
            $error = false;
            $res = $model->deleteAllContacts();
            if ($res != "SUCCESS") {
                $error = true;
                $_SESSION['WEBSITENAME'] = "Error: deleting entire contacts from database failed!";
                redirect("view/admin-portal.php");
                die();
            }
            $res = $model->deleteAllWebsites();
            if ($res != "SUCCESS") {
                $error = true;
                $_SESSION['WEBSITENAME'] = "Error: deleting entire websites from database failed!";
                redirect("view/admin-portal.php");
                die();
            }
            $res = $model->deleteAllUsers();
            if ($res != "SUCCESS") {
                $error = true;
                $_SESSION['WEBSITENAME'] = "Error: deleting entire Users from database failed!";
                $_SESSION['WEBSITENAME'] = "Error: deleting entire database failed!";
                $_SESSION['LOGIN_MSG'] = "Error: deleting entire database failed!";
                redirect("view/admin-portal.php");
                die();
            }
            if ($error == false) {
                $model->logout();
                $model->createAccount("Admin", "Admin@Admin.com", "Admin");
                $id = $model->getUserID("Admin");
                $model->addUserAdAdmin($id);
                $_SESSION['LOGIN_MSG'] = "All Databases have been deleted, recreated generic admin account";
                redirect("view/login.php");
                die();
            } else {
                $_SESSION['WEBSITENAME'] = "Error: deleting entire database failed!";
                $_SESSION['LOGIN_MSG'] = "Error: deleting entire database failed!";
                redirect("view/admin-portal.php");
            }
            #delete database
            die();
        }
        $_SESSION['WEBSITENAME'] = "Error delete did not occur!";
        redirect("view/admin-portal.php");
        die();
    } elseif (isset($_POST['COMMAND']) && $_POST['COMMAND'] == 'TOGGLE_PUBLISH') {
        echo $model->togglePublish($_POST['WEBSITE']);
        die();
    } else {
        redirect('view/login.php');
        die();
    }
} catch (Exception $e) {
    redirect('view/login.php');
    die();
}
?>