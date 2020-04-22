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
  <link rel="stylesheet" href="css/welcome.css">

</head>

<body>
  <?php
  require_once '../utilities/requirements.php';
  $page = 'welcome';
  include "navbar.php";
  ?>

  <!-- Full Page Image Header with Vertically Centered Content -->
  <header class="masthead">
    <div class="container h-75">
      <div class="row h-100 align-items-center">
        <div class="col-12 text-center">
          <h1 class="font-weight-light" style="padding-bottom: 25px;">Simple Tools You'll Love.</h1>
          <a class="btn btn-primary btn-lg" href="<?php echo $config['home-file-path'] . '/view/signup.php' ?>" style="border-radius: 50px;">Build Your Website Today!</a>
        </div>
      </div>
    </div>
  </header>

  <!-- Page Content -->
  <div class="container-fluid ">
    <div class="row info-banner-1">
      <div class="container col text-center">
        <h1>
          <span class="align-middle font-weight-bold">Crafted by You. Loved by Everyone!</span>
        </h1>
      </div>
      <div class="container col">
        <h3 style="padding-bottom: 25px;"> From online stores, to blogs, to albums and more - if you need a website, it's all possible with our Brix website builder.</h3>
        <a class="btn btn-success btn-lg" href="<?php echo $config['home-file-path'] . '/view/signup.php' ?>">Lets Get Started</a>
      </div>
    </div>

    <div class="row">
      <div class="container col">
        <div class="row info-column-2a text-center">
          <h1 class="display-3 align-middle font-weight-bold" style="padding-bottom: 25px;"> Anyone Can Build With <span>
              <img src="img/brix-logo.png" style="width: 300px;" alt="brix-logo">
            </span></h1>
          <h1 class="display-5 align-middle"> Simply drag, drop, and build your very own websites!</h1>
          <div class="mx-auto " style="padding-top: 25px;">
            <a class="btn btn-primary btn-lg" href="<?php echo $config['home-file-path'] . '/view/signup.php' ?>">Start Now</a>
          </div>
        </div>


        <div class="row info-column-2b">
          <div class="container">
            <h1 class="font-weight-light text-center text-lg-left mt-4 mb-0">Build Yours Today</h1>
            <hr class="mb-5">
            <div class="row text-center text-lg-left">
              <div class="col-lg-3 col-md-4 col-6">
                <a href="#" class="d-block mb-4 h-100">
                  <img class="img-fluid img-thumbnail" src="https://source.unsplash.com/pWkk7iiCoDM/400x300" alt="">
                </a>
              </div>
              <div class="col-lg-3 col-md-4 col-6">
                <a href="#" class="d-block mb-4 h-100">
                  <img class="img-fluid img-thumbnail" src="https://source.unsplash.com/aob0ukAYfuI/400x300" alt="">
                </a>
              </div>
              <div class="col-lg-3 col-md-4 col-6">
                <a href="#" class="d-block mb-4 h-100">
                  <img class="img-fluid img-thumbnail" src="https://source.unsplash.com/EUfxH-pze7s/400x300" alt="">
                </a>
              </div>
              <div class="col-lg-3 col-md-4 col-6">
                <a href="#" class="d-block mb-4 h-100">
                  <img class="img-fluid img-thumbnail" src="https://source.unsplash.com/M185_qYH8vg/400x300" alt="">
                </a>
              </div>
              <div class="col-lg-3 col-md-4 col-6">
                <a href="#" class="d-block mb-4 h-100">
                  <img class="img-fluid img-thumbnail" src="https://source.unsplash.com/sesveuG_rNo/400x300" alt="">
                </a>
              </div>
              <div class="col-lg-3 col-md-4 col-6">
                <a href="#" class="d-block mb-4 h-100">
                  <img class="img-fluid img-thumbnail" src="https://source.unsplash.com/AvhMzHwiE_0/400x300" alt="">
                </a>
              </div>
              <div class="col-lg-3 col-md-4 col-6">
                <a href="#" class="d-block mb-4 h-100">
                  <img class="img-fluid img-thumbnail" src="https://source.unsplash.com/2gYsZUmockw/400x300" alt="">
                </a>
              </div>
              <div class="col-lg-3 col-md-4 col-6">
                <a href="#" class="d-block mb-4 h-100">
                  <img class="img-fluid img-thumbnail" src="https://source.unsplash.com/EMSDtjVHdQ8/400x300" alt="">
                </a>
              </div>
              <div class="col-lg-3 col-md-4 col-6">
                <a href="#" class="d-block mb-4 h-100">
                  <img class="img-fluid img-thumbnail" src="https://source.unsplash.com/8mUEy0ABdNE/400x300" alt="">
                </a>
              </div>
              <div class="col-lg-3 col-md-4 col-6">
                <a href="#" class="d-block mb-4 h-100">
                  <img class="img-fluid img-thumbnail" src="https://source.unsplash.com/G9Rfc1qccH4/400x300" alt="">
                </a>
              </div>
              <div class="col-lg-3 col-md-4 col-6">
                <a href="#" class="d-block mb-4 h-100">
                  <img class="img-fluid img-thumbnail" src="https://source.unsplash.com/aJeH0KcFkuc/400x300" alt="">
                </a>
              </div>
              <div class="col-lg-3 col-md-4 col-6">
                <a href="#" class="d-block mb-4 h-100">
                  <img class="img-fluid img-thumbnail" src="https://source.unsplash.com/p2TQ-3Bh3Oo/400x300" alt="">
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!--preview img -->
      <div class="container col info-column-1">
        <div class="container info-column-img">
        </div>
        <h1 class="display-3 align-middle text-center" style="padding-top: 50px;"> Drag, Drop, Build.</h1>
        <div class="text-center mx-auto " style="padding-top: 50px;">
          <a class="btn btn-success btn-lg" href="<?php echo $config['home-file-path'] . '/view/signup.php' ?>">Start Today for Free</a>
        </div>
      </div>
    </div>
  </div>
  <div class="container-fluid test">
  </div>

  <footer id="sticky-footer" class="py-4 bg-dark text-white-50">
    <div class="container text-center">
      <small>Copyright &copy; Brix.ca</small>
    </div>
  </footer>

  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>
