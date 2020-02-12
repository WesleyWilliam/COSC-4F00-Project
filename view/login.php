#!/usr/bin/php-cgi
<!DOCTYPE html>
<html>
<body>
<?php
include('../model/model.php');
$config = require('../config/config.php');
$model = new Model();
if (!isset($_SESSION)) {
    session_start();
}
?>

<h3> <?php echo $_SESSION['LOGIN_MSG']; ?> <br> <h3>
<h2>Login </h2>
<form action="/~c4f00g05/controller/controller.php" method="POST">
Username: <input type="text" name="UNAME"> <br>
Password: <input type="password" name="PWD"> <br>
<input type="hidden" name="COMMAND" value="LOGIN">
<input type="submit">
</form>
<a href="<?php echo $config['home-file-path'] . '/view/signup.php' ?>">Sign up</a>
</body>
</html>
