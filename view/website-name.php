#!/usr/bin/php-cgi
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
<?php
include('../model/model.php');
$config = require('../config/config.php');
$model = new Model();
if (!isset($_SESSION)) {
    session_start();
}
?>


<!-- Nav Bar -->
<?php include 'navbar.php' ?>


<div class="container">
  <h1 class="text-center mt-5 text-muted">Enter name of your website</h1>

  <form action="<?php echo $config['home-file-path'] . '/controller/controller.php' ?>" method="POST">
    <div class="form-group form-group-lg">
      <input name="WEBSITE" type="text" class="form-control mt-5" style="text-align:center" pattern="[A-Za-z_]{3}[A-Za-z_]*$" title="3 characters, only a-z and underline">
    </div>
    <div class="form-group" style="text-align:center">
      <button class="btn btn-primary" type="Submit">Submit</button>
      <input type="hidden" name="COMMAND" value="WEBSITE_WIZARD">
    </div>
  </form>


  <h4 class="mt-5 text-muted text-left">Your existing webpages</h4>
  <div class="list-group">
    <?php foreach ($model->listWebsites() as $website) {
      echo '<a href="' . $config['home-file-path'] . '" class="list-group-item list-group-item-action">' . $website->name . '</a>' ;
    } ?>

  </div>
</div>




<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
