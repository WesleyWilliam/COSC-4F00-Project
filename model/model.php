<?php

class SessionNotFound extends Exception { }

class Model {

    
    private $config;

    public function __construct() {
        require '../lib/rb-postgres.php';
		require '../lib/password.php';
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
            r::store($user);
            $_SESSION["loggedinvar"] = "true";
            return "SUCCESS";
        } else {
            return 'NOTFOUND';
        }
    }
    
    public function createAccount($username,$email,$password) {
        //Check if user exists first
        $query = R::find('users',' username LIKE ? ', [$username]);
        if (!empty($query)) {
            return "ACCEXISTS";
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
        $new_filename = strval($id) . '.' . pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION);
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
    
}
?>
