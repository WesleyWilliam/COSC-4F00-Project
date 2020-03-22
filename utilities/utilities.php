<?php
function redirect($url) {
    Global $config;
    header("Location: " . $config['home-file-path'] . "/" . $url);
}
?>
