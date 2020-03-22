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
  <!--Requirements -->
  <?php require_once '../utilities/requirements.php' ?>

  <!-- Nav Bar -->
  <?php include 'navbar.php' ?>

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
  if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
  }
</script>