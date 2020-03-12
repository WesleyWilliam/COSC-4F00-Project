<?php

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
        // How you query stuff, mostly just normal sql
        $user = R::findOne('users',' username LIKE ? AND password LIKE ? ',[$username,$password]);
        if (!isset($user)) {
            return 'NOTFOUND';
        } else {
            return "SUCCESS" ;
        }
    }
    
    public function createAccount($username,$password) {
        //Check if user exists first
        $query = R::find('users',' username LIKE ? ', [$username]);
        if (!empty($query)) {
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

    public function storeImage($filename) {
        $imagebean = R::dispense('image');
        $imagebean -> old_filename = $filename;
        $id =R::store($imagebean);
        $new_filename = strval($id) . '.' . pathinfo(basename($_FILES["fileToUpload"]["name"]),PATHINFO_EXTENSION);
        $imagebean -> filename = $new_filename;
        R::store($imagebean);
        return $new_filename;
  
    public function addWebsite($name) {
        $website = R::dispense('websites');
        $website -> user_id = '';
        $website -> name = $name;
        return R::store($website);
    }
}
?>
