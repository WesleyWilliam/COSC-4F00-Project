#!/usr/bin/php-cgi
<!-- Enter your email here and it'll send a reset link to you -->
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

  <!--NavBar-->
  <?php include 'navbar.php' ?>

  <!-- If there is a message, show message to user -->
  <?php
  if (!empty($_SESSION['RECOVEREMAIL_MSG'])) {
    echo "<div class=\"alert alert-warning\" role=\"alert\">";
    echo $_SESSION['RECOVEREMAIL_MSG'];
    echo "</div>";
  }
  ?>

  <div class="container">
    <div class="row justify-content-center">
      <div class="col-8">
        <h2 class="mt-2">Enter your email</h2>
        <form action="<?php echo $config['home-file-path'] . '/controller/controller.php' ?>" method="POST">
          <div class="form-group">
            <label for="email1">Email</label>
            <input type="email" class="form-control" id="email1" name="EMAIL" required>
          </div>
          <input type="hidden" name="COMMAND" value="RECOVEREMAIL">
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