#!/usr/bin/php-cgi
<!DOCTYPE html>
<html>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Including bootstrap CSS files -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!--CSS files -->
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
<?php

?>

<!-- Nav Bar -->
<?php 
$page = 'signup';
include 'navbar.php'; 
?>




<!-- Sign Up -->

<!-- If there is a message, show message to user -->
<?php 
if (!empty($_SESSION['SIGNUP_MSG'])) {
  echo "<div class=\"alert alert-warning\" role=\"alert\">";
  echo $_SESSION['SIGNUP_MSG'];
  echo "</div>";
}
?>

<div class="container-fluid">
  <div class="row no-gutter">
    <div class="d-none d-md-flex col-md-4 col-lg-6 bg-image"></div>
    <div class="col-md-8 col-lg-6" style="background-color: #aad0ad54">
      <div class="login d-flex align-items-center py-5">

        <div class="container" style="padding-top: 100px;" >
          <div class="row justify-content-center">
            <div class="col-8">
              <img src="img/sign-up.png" style="width: 300px; padding-bottom:30px;" alt="brix-colours"></span>
              <form action="<?php echo $config['home-file-path'] . '/controller/controller.php' ?>" method="POST">
              <div class="form-group">
                <label for="username1">Username</label>
                <input type="text" class="form-control" id="username1" name="UNAME">
            </div>
            <div class="form-group">
                <label for="email1">Email Address</label>
                <input type="email" class="form-control" id="email1" name="EMAIL" required>
            </div>
            <div class="form-group">
                <label for="password1">Password</label>
                <input type="password" class="form-control" id="password1" name="PWD">
            </div>

                <input type="hidden" name="COMMAND" value="SIGNUP">
                <button type="submit" class="btn btn-lg btn-primary">Submit</button>
                <br>
                <a type="button" class="btn btn-link mt-1 pl-0" href="<?php echo $config['home-file-path'] . '/view/login.php' ?>">Already have an account? Sign in</a>
                </form> 
            </div>
          </div>    
        </div>
      </div>
    </div>
  </div>
</div>

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>

<?php 
$_SESSION['LOGIN_MSG'] = ""; 

?>