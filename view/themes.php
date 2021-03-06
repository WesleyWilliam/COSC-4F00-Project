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

  <!-- Title -->
  <div class="border-bottom mr-5 ml-5">
    <h1 class="display-4 text-center pb-3">Select Webpage Theme</h1>
  </div>

  <!-- Theme list -->
  <div class="d-flex justify-content-around pt-5">
    <div class="card" style="width: 18rem;">
      <img src=".\theme_custom.PNG" class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title">Custom</h5>
        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
      </div>
      <ul class="list-group list-group-flush">
      </ul>
      <div class="card-body">
        <a href="#" class="card-link">Select</a>
        <a href="#" class="card-link">Info</a>
      </div>
    </div>

    <div class="card" style="width: 18rem;">
      <img src=".\theme_ararat.PNG" class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title">Ararat</h5>
        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
      </div>
      <ul class="list-group list-group-flush">
      </ul>
      <div class="card-body">
        <a href="#" class="card-link">Select</a>
        <a href="#" class="card-link">Info</a>
      </div>
    </div>

    <div class="card" style="width: 18rem;">
      <img src=".\theme_stack.PNG" class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title">Stack</h5>
        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
      </div>
      <ul class="list-group list-group-flush">
      </ul>
      <div class="card-body">
        <a href="#" class="card-link">Select</a>
        <a href="#" class="card-link">Info</a>
      </div>
    </div>

    <div class="card" style="width: 18rem;">
      <img src=".\theme_mighty.PNG" class="card-img-top" alt="...">
      <div class="card-body">
        <h5 class="card-title">Mighty</h5>
        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
      </div>
      <ul class="list-group list-group-flush">
      </ul>
      <div class="card-body">
        <a href="#" class="card-link">Select</a>
        <a href="#" class="card-link">Info</a>
      </div>
    </div>
  </div>

  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>
