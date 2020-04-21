<?php

class SessionNotFound extends Exception
{
}

class Model
{


    private $config;

    //Setup Database
    public function __construct()
    {
        require_once '../lib/rb-postgres.php';
        require_once '../lib/password.php';
        if (!isset($_SESSION)) {
            session_start();
        }
        $this->config = require('../config/config.php');
        $cfg = $this->config;
        R::setup('pgsql:host=localhost;dbname=' . $cfg['dbname'], $cfg['db-user'], $cfg['db-pwd']);
    }

    //Login to account
    public function loginAccount($username, $password)
    {
        if (!isset($username) || !isset($password)) {
            return 'NOTFOUND';
        }
        $user = NULL;
        try {
            $user = $this->getUser();
            return "SUCCESS";
        } catch (Exception $e) {
            //Do nothing
        }
        // How you query stuff, mostly just normal sql
        $user = R::findOne('users', ' username LIKE ?', [$username]);
        $hash = $user->password;
        if (isset($user) && password_verify($password, $hash)) {
            $_SESSION["USER_ID"] = $user->id;
            return "SUCCESS";
        } else {
            return 'NOTFOUND';
        }
    }

    //Create an account
    public function createAccount($username, $email, $password)
    {
        if (!isset($username) || !isset($email) || !isset($password)) {
            return "ERR";
        }
        //Check if user exists first
        $query = R::findOne('users', ' username LIKE ? OR email LIKE ? ', [$username, $email]);
        if (!empty($query) && $query->username == $username) {
            return "ACCEXISTS";
        } elseif (!empty($query) && $query->email == $email) {
            return "EMAILEXISTS";
        } else {
            // Create a Redbean object called "bean"
            $user = R::dispense('users');
            // Add fields to it
            $user->username = $username;
            $user->password = password_hash($password, PASSWORD_BCRYPT);
            $user->email = $email;
            $user->level = "Member";
            $user->subcription = "Starter";
            R::store($user);
            //Store it in the database, Redbean sets up everything
            return "SUCCESS";
        }
    }

    //returns the user id when a unique username is passed
    public function getUserID($username)
    {
        $user = R::findOne('users', ' username LIKE ? ', [$username]);
        return $user->id;
    }

    //returns username of a user when a unique user ID is passed
    public function getUsername($usernameID)
    {
        $user = R::load('users', $usernameID);
        return $user->username;
    }

    //Store images to database
    public function storeImage($filename)
    {
        $imagebean = R::dispense('image');
        $imagebean->old_filename = $filename;
        $id = R::store($imagebean);
        $new_filename = strval($id) . '.' . pathinfo(basename($_FILES["file"]["name"]), PATHINFO_EXTENSION);
        $imagebean->filename = $new_filename;
        R::store($imagebean);
        return $new_filename;
    }

    //Return a user row
    public function getUser()
    {
        //Good query to index
        if (!isset($_SESSION['USER_ID'])) {
            throw new SessionNotFound();
        }
        return R::load('users', $_SESSION['USER_ID']);
    }

    //Add a new website to user
    public function addWebsite($name)
    {
        if (!isset($name)) {
            return "ERR";
        }
        $user = $this->getUser();
        if (R::findOne('websites', ' name like ? AND users_id = ? ', [$name, $user->id])) {
            return "ALREADYEXISTS";
        } else {
            $website = R::dispense('websites');
            $website->name = $name;
            $website->published = '';
            $website->webpages = '{"webpages":{"homepage": []},"footer":[]}';
            $user->xownWebsitesList[] = $website;
            R::store($user);
            return $website->id;
        }
    }

    //logout of account
    public function logout()
    {
        unset($_SESSION['USER_ID']);
        return "SUCCESS";
    }

    //Returns the list of websites
    public function getWebsites($website)
    {
        if (!isset($website)) {
            return "ERR";
        }
        $site = R::load('websites', $website);
        if ($site->published === 'TRUE') {
            return $site->webpages;
        }
        $user = $this->getUser();
        if ($user->id === $site->users_id) {
            return $site->webpages;
        } else {
            return "WRONGUSER";
        }
    }
    
    //Returns the publish status of a website
    public function publishStatus($website) {
        if (!isset($website)) {
            return "ERR";
        }
        $website = R::load('websites',$website);
        if (!isset($website)) {
            return "ERR";
        }
        if (isset($website->published) && $website->published == 'TRUE') {
            return "PUBLISHED";
        } else {
            return "UNPUBLISHED";
        }
    }

    //Toggles the publish status of a website and returns the result
    public function togglePublish($website) {
        $website = R::load('websites', $website);
        $user = $this->getUser();
        if ($user->id !== $website->users_id) {
            return "ERR";
        }
        
        if (is_string($website)) {
            return "ERR";
        } else {
            if (isset($website->published) && $website->published == 'TRUE') {
                $website->published = '';
                R::store($website);
                return "UNPUBLISHED";
            } else {
                $website->published = 'TRUE';
                R::store($website);
                return "PUBLISHED";
            }
        }
    }

    //Saves the website to tables
    public function saveWebsites($website, $components) {
        if (!isset($website) || !isset($components)) {
            return "WRONGUSER";
        }
        $website = R::load('websites', $website);
        if ($website->users_id === $this->getUser()->id) {
            $website->webpages = $components;
            R::store($website);
            return "SUCCESS";
        } else {
            return "WRONGUSER";
        }
    }

    //Saves a log with the passed message
    public function log($msg)
    {
        $log = R::dispense('logs');
        $log->message = $msg;
        R::store($log);
    }

    //returns a list of websites from the user
    public function listWebsites()
    {
        $user = $this->getUser();
        return $user->ownWebsitesList;
    }

    public function listAllWebsites()
    {
        $websites = R::findAll('websites');
        return $websites;
    }

    public function listAllUsers()
    {
        $users = R::findAll('users');
        return $users;
    }

    //To send to someone if they forget their password
    public function recoverCode($email)
    {
        if (!isset($email)) {
            return "ERR";
        }
        $user = R::findOne('users', ' email Like ? ', [$email]);
        if (!isset($user)) {
            return "EMAILDNE";
        } else {
            $recover = R::dispense('recover');
            $recover->user = $user;
            R::store($recover);
            $code = 0;
            do {
                $code = rand();
            } while (R::findOne('recover', ' code = ? ', [$code]));
            $recover->code = $code;
            $recover->time = time();
            R::store($recover);
            return $code;
        }
    }

    //Recovers the password by checking the code and time elapsed, if ok it will update the password
    public function recoverPassword($code, $password)
    {
        if (!isset($code) || !isset($password)) {
            return "ERR";
        }
        $recover = R::findOne('recover', ' code = ? ', [$code]);
        if (!isset($recover)) {
            return "CODEWRONG";
        } elseif ((time() - $recover->time) > (30 * 60)) {
            //Code won't work after 30 minutes
            return "TIMEDOUT";
        } else {
            $user = R::load('users', $recover->user_id);
            $user->password = password_hash($password, PASSWORD_BCRYPT);
            R::store($user);
            return "SUCCESS";
        }
    }

    //Updates the users accounts preferences
    public function updateAccountPreferences($fName, $lName, $dob, $phone, $email)
    {
        $user = $this->getUser();
        $query = R::findOne('users', ' email LIKE ?', [$email]);
        if (empty($query) || $query == $user) {
            $user->firstname = $fName;
            $user->lastname = $lName;
            $user->dob = $dob;
            $user->phonenumber = $phone;
            $user->email = $email;
            R::store($user);
            return "SUCCESS";
        } else {
            return 'EMAILEXISTS';
        }
    }

    //Updates the users access level
    public function updateUserAccess($level)
    {
        $user = $this->getUser();
        $user->level = $level;
        R::store($user);
        return "SUCCESS";
    }

    //Updates the users accounts payments
    public function updateAccountPayment($cNum, $eDate, $cvvNum, $Type)
    {
        $user = $this->getUser();
        $user->cardnumber = $cNum;
        $user->expdate = $eDate;
        $user->cvvnum = $cvvNum;
        $user->type = $Type;
        R::store($user);
        return "SUCCESS";
    }

    public function updateAccountSubscription($sub)
    {
        $user = $this->getUser();
        $user->subcription = $sub;
        R::store($user);
        return "SUCCESS";
    }

    //Updates the users accounts privacy page
    public function updateAccountPrivacy($vPerm, $blocked)
    {
        $user = $this->getUser();
        $user->view_permissions = $vPerm;
        $user->blocked = $blocked;
        R::store($user);
        return "SUCCESS";
    }

    //deletes this users account
    public function deleteAccount()
    {
        $user = $this->getUser();
        R::trash($user);
        return "SUCCESS";
    }

    //deletes this users website
    public function deleteWebsite($website_id)
    {
        $user = $this->getUser();
        unset($user->xownWebsitesList[$website_id]);
        R::store($user);
        return "SUCCESS";
    }

    //Deletes the passed website
    public function deleteWebsiteAdmin($website_id)
    {
        $website = R::load('websites', $website_id);
        if (isset($website->users_id)) {
            $user = R::load('users', $website->users_id);
            unset($user->xownWebsitesList[$website_id]);
            R::store($user);
        } else {
            R::trash($website);
        }
        return "SUCCESS";
    }

    //Blocks passed website
    public function blockWebsiteAdmin($website_id)
    {
        $website = R::load('websites', $website_id);
        $website->block = true;
        R::store($website);
        return "SUCCESS";
    }

    //enables a blocked website
    public function enableWebsiteAdmin($website_id)
    {
        $website = R::load('websites', $website_id);
        $website->block = false;
        R::store($website);
        return "SUCCESS";
    }

    //deletes a user that was passed
    public function deleteUserAdmin($user_id)
    {
        $user = $this->getUser();
        if ($user->id != $user_id) {
            $userd = R::load('users', $user_id);
            R::trash($userd);
            return "SUCCESS";
        } else {
            return "FAIL";
        }
    }
    
    //Adds admin status to user
    public function addUserAsAdmin($user_id)
    {
        $user = R::load('users', $user_id);
        $user->level = "Admin";
        R::store($user);
        return "SUCCESS";
    }

    //toggles user as admin/member status
    public function toggleUserAsAdmin($user_id)
    {
        $user = R::load('users', $user_id);
        if ($user->level != "Admin") {
            $user->level = "Admin";
        } else {
            $user->level = "Member";
        }
        R::store($user);
        return "SUCCESS";
    }

    //Removes any user passed
    public function removeUserAsAdmin($user_id)
    {
        $user = R::load('users', $user_id);
        $user->level = "Member";
        R::store($user);
        return "SUCCESS";
    }

    //checks if a user in an administrator
    public function isCheckAdmin($user_id)
    {
        $user = R::load('users', $user_id);
        if (isset($user->level) && $user->level == "Admin") {
            return true;
        } else {
            return false;
        }
    }

    //checks if this user is an admin
    public function isAdmin()
    {
        $user = $this->getUser();
        if (isset($user->level) && $user->level == "Admin") {
            return true;
        } else {
            return false;
        }
    }

    //Deletes all websites from this user
    public function deleteAllUserWebsites()
    {
        $user = $this->getUser();
        $user->xownWebsitesList = array();
        R::store($user);
        return "SUCCESS";
    }

    //Deletes all website table
    public function deleteAllWebsites()
    {
        R::wipe('websites');
        return "SUCCESS";
    }

    //Deletes the users table
    public function deleteAllUsers()
    {
        R::wipe('users');
        return "SUCCESS";
    }

    //Deletes the contacts table
    public function deleteAllContacts()
    {
        R::wipe('contact');
        return "SUCCESS";
    }

    //creates a contact row with the passed information
    public function sendContact($email, $name, $msg)
    {
        $contact = R::dispense('contact');
        $contact->email = $email;
        $contact->name = $name;
        $contact->msg = $msg;
        $contact->time = time();
        R::store($contact);
    }

    //returns all contacts
    public function getAllContact()
    {
        return R::findAll('contact');
    }

    //Deletes a contact passed
    public function deleteContact($contactId)
    {
        $contact = R::load('contact', $contactId);
        R::trash($contact);
        return "SUCCESS";
    }

    //sets tables as unique
    public function setUniques()
    {
        R::exec('ALTER TABLE Users ADD UNIQUE (USERNAME);');
        R::exec('ALTER TABLE Users ADD UNIQUE (EMAIL);');
        R::exec('ALTER TABLE Websites ADD UNIQUE (NAME,USERS_ID)');
    }
}
