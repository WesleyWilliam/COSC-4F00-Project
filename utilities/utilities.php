<?php
$conf = require('../config/config.php');

$conf;

function redirect($url) {
    global $conf;
    header("Location: " . $conf['home-file-path'] . "/" . $url);
}
?>
