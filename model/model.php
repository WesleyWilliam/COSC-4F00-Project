<?php

class SessionNotFound extends Exception { }

class Model {

    
    private $config;

    public function __construct() {
        require_once '../lib/rb-postgres.php';
		require_once '../lib/password.php';
        if (!isset($_SESSION)) {
            session_start();
        }
        $this->config = require('../config/config.php');
        $cfg = $this->config;
        R::setup('pgsql:host=localhost;dbname=' . $cfg['dbname'],$cfg['db-user'],$cfg['db-pwd']);
    }


    public function loginAccount($username,$password) {
        $user = NULL;
        try {
            $user = $this->getUser();
            return "SUCCESS";
        } catch(SessionNotFound $e) {
            //Do nothing
        }
        // How you query stuff, mostly just normal sql
        $user = R::findOne('users',' username LIKE ?',[$username]);
        $hash = $user -> password;
        if (isset($user) && password_verify($password, $hash)) {
            $user -> session = session_id();
            R::store($user);
            $_SESSION["loggedinvar"] = "true";
            return "SUCCESS";
        } else {
            return 'NOTFOUND';
        }
    }
    
    public function createAccount($username,$email,$password) {
        //Check if user exists first
        $query = R::findOne('users',' username LIKE ? OR email LIKE ? ', [$username,$email]);
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
            $user->session = '';
            R::store($user);
            //Store it in the database, Redbean sets up everything
            return "SUCCESS";
        }
    }

    public function storeImage($filename) {
        $imagebean = R::dispense('image');
        $imagebean -> old_filename = $filename;
        $id =R::store($imagebean);
        $new_filename = strval($id) . '.' . pathinfo(basename($_FILES["file"]["name"]),PATHINFO_EXTENSION);
        $imagebean -> filename = $new_filename;
        R::store($imagebean);
        return $new_filename;
    }

    public function getUser() {
        //Good query to index
        $res = R::findOne('users', ' session Like ? ', [session_id()]);
        if (!isset($res)) {
            throw new SessionNotFound();
        }
        return $res;
    }
  
    public function addWebsite($name) {
        $user = $this -> getUser();
        if (R::findOne('websites',' name like ? AND user_id = ? ',[$name,$user->id])) {
            return "ALREADYEXISTS";
        } else {
            $website = R::dispense('websites');
            $website -> user = $user;
            $website -> name = $name;
            $website -> components = '[]';
            return R::store($website);
        }
    }

    public function logout () {
        $user = $this->getUser();
        $user -> session = '';
        R::store($user);
        $_SESSION["loggedinvar"] = "";
        return "SUCCESS";
    }

    public function getComponents($website) {
        $user = $this -> getUser();
        $site = R::load('websites',$website);
        if ($user->id === $site->user_id) {
            return $site->components;
        } else {
            return "WRONGUSER";
        }
    }

    public function saveComponents($website, $components) {
        $website = R::load('websites',$website);
        if ($website->user_id === $this->getUser()->id) {
            $website -> components = $components;
            R::store($website);
            return "SUCCESS";
        } else {
            return "WRONGUSER";
        }
    }

    public function log($msg) {
        $log = R::dispense('logs');
        $log -> message = $msg;
        R::store($log);
    }

    public function listWebsites() {
        $user = $this -> getUser();
        $websites = R::findAll('websites',' user_id = ? ',[$user->id]);
        return $websites;
    }

    public function listAllWebsites() {
        $user = $this -> getUser();
        $websites = R::findAll('websites');
        return $websites;
    }

    public function listAllUsers() {
        $user = $this -> getUser();
        $users = R::findAll('users');
        return $users;
    }

    //To send to someone if they forget their password
    public function recoverCode($email) {
        $user = R::findOne('users',' email Like ? ',[$email]);
        if (!isset($user)) {
            return "EMAILDNE";
        } else {
            $recover = R::dispense('recover');
            $recover -> user = $user;
            R::store($recover);
            $code = 0;
            do {
                $code = rand();
            } while (R::findOne('recover',' code = ? ',[$code]));
            $recover -> code = $code;
            $recover -> time = time();
            R::store($recover);
            return $code;
        }   
    }
    
    public function recoverPassword($code, $password) {
        $recover = R::findOne('recover',' code = ? ',[$code]);
        if (!isset($recover)) {
            return "CODEWRONG";
        } elseif ((time() - $recover -> time) > (30 * 60)) {
            //Code won't work after 30 minutes
            return "TIMEDOUT";
        } else {
            $user = R::load('users',$recover->user_id);
            $user->password = password_hash($password, PASSWORD_BCRYPT);
            R::store($user);
            return "SUCCESS";
        }
    }
    public function updateAccountPreferences($fName, $lName, $dob, $phone, $email) {
        $user = $this -> getUser();
        $query = R::findOne('users',' email LIKE ?', [$email]);
        if (empty($query) || $query == $user) {
            $user -> firstname = $fName;
            $user -> lastname = $lName;
            $user -> dob = $dob;
            $user -> phonenumber = $phone;
            $user -> email = $email;
            r::store($user);
            return "SUCCESS";
        } else {
            return 'EMAILEXISTS';
        }
    }
    public function deleteAccount() {
        $user = $this -> getUser();
        R::trash( $user );
        return "SUCCESS";
    }

    public function sendContact($email,$name,$msg) {
        $contact = R::dispense('contact');
        $contact -> email = $email;
        $contact -> name = $name;
        $contact -> msg = $msg;
        R::store($contact);
    }
    
    
}
