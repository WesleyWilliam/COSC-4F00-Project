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
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">
  <img src=".\cms_logo.svg" width="30" height="30" alt="">
  CMS
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Features</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Subscriptions
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Premium Plans</a>
          <a class="dropdown-item" href="#">Standard Plans</a>
          <a class="dropdown-item" href="#">Free Content</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Domains</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Editor</a>
      </li>
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form>
  </div>
</nav>


<h1 class="display-4 text-center">Contact Us</h1>

<!-- If there is a message, show message to user -->
<?php 
if (!empty($_POST['CONTACT_MSG'])) {
  echo "<div class=\"alert alert-success alert-dismissible\" role=\"alert\">";
  echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
  echo $_POST['CONTACT_MSG'];
  echo "</div>";
}
?>

<!-- Contact form -->
<form class="ml-4" action="#" method="POST">
  <div class="w-25 p-3">
    <label for="emailInput">Email address</label>
    <input type="email" class="form-control" id="emailInput" placeholder="Enter email">
  </div>
  <div class="w-25 p-3">
    <label for="nameInput">Name</label>
    <input type="text" class="form-control" id="nameInput" placeholder="Enter your full name">
  </div>
  <div class="w-50 p-3">
    <label for="messageInput">Message</label>
    <textarea type="text" class="form-control" id="messageInput" placeholder="Enter message" rows="5"></textarea>
  </div>
  <div class="w-100 p-3">
    <button type="submit" class="btn btn-primary mb-2">Send</button>
  </div>
  <input type="hidden" name="CONTACT_MSG" value="Message sent!">
</form>


<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
<!-- Avoid form resubmission -->
<script>
if ( window.history.replaceState ) {
  window.history.replaceState( null, null, window.location.href );
}
</script>
