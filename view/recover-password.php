#!/usr/bin/php-cgi
<!-- This is the page you get redirected to when you click on the reset password link in your email -->
<!DOCTYPE html>
<html>

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Including bootstrap CSS files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
  <!--Requirements -->
  <?php require_once '../utilities/requirements.php' ?>

  <!-- If there is a message, show message to user -->
  <?php
  if (!empty($_SESSION['RECOVERPWD_MSG'])) {
    echo "<div class=\"alert alert-warning\" role=\"alert\">";
    echo $_SESSION['RECOVERPWD_MSG'];
    echo "</div>";
  }
  ?>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-8">
        <h2 class="mt-2">Enter new password</h2>
        <form action="<?php echo $config['home-file-path'] . '/controller/controller.php' ?>" method="POST">
          <div class="form-group">
            <label for="password1">Password</label>
            <input type="password" class="form-control" id="password1" name="PWD">
          </div>
          <div class="form-group">
            <label for="password2">Confirm Password</label>
            <input type="password" class="form-control" id="password2" name="PWD2">
          </div>
          <input type="hidden" name="COMMAND" value="RECOVERPWD">
          <input type="hidden" name="CODE" value="<?php echo $_GET['code']; ?>">
          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>

  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>