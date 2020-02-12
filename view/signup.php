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
<h2> Sign up </h2>
<h3> <?php echo $_SESSION['SIGNUP_MSG']; ?> </h3>
<form action="/~c4f00g05/controller/controller.php" method="POST">
Username: <input type="text" name="UNAME"> <br>
Password: <input type="password" name="PWD"> <br>
<input type="hidden" name="COMMAND" value="SIGNUP">
<input type="submit">
</form>

</body>
</html>
