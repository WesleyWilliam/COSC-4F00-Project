<?php

class Model {

    
    private $password_list;
    private $bean; //ORM
    private $config;

    public function __construct() {
        require '../lib/rb-postgres.php';
        if (!isset($_SESSION)) {
            session_start();
        }
        $this->password_list = Array();
        $this->config = require('../config/config.php');
        $cfg = $this->config;
        R::setup('pgsql:host=localhost;dbname=' . $cfg['dbname'],$cfg['db-user'],$cfg['db-pwd']);
    }


    public function loginAccount($username,$password) {
        // How you query stuff, mostly just normal sql
        $user = R::findOne('users',' username LIKE ? AND password LIKE ? ',[$username,$password]);
        if (!isset($user)) {
            $_SESSION['LOGIN_MSG'] = "Username or password is incorrect";
            return 'NOTFOUND';
        } else {
            return "SUCCESS" ;
        }
    }
    
    public function createAccount($username,$password) {
        //Check if user exists first
        $query = R::find('users',' username LIKE ? ', [$username]);
        if (!empty($query)) {
            $_SESSION['SIGNUP_MSG'] = "Account already exists" ;
            return "ACCEXISTS";
        } else {
            // Create a Redbean object called "bean"
            $user = R::dispense('users');
            // Add fields to it
            $user->username = $username;
            $user->password = $password;
            //Store it in the database, Redbean sets up everything
            R::store($user);
            return "SUCCESS";
        }
    }
}
?>
