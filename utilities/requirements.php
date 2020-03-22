<?php
if (!isset($_SESSION)) {
    session_start();
}
require '../utilities/utilities.php';
require '../model/model.php';
$config = require('../config/config.php');
$model = new Model();
?>