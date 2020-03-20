
<?php
  $config = require('../config/config.php');
?>
<!-- Nav Bar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light static-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="welcome.php">
            <img src="img/brix-logo.png" style="width: 100px;" alt="">
          </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav mr-auto nav-links">
          <li class="nav-item active" style="padding-left: 35px;">
            <a class="nav-link" href="<?php echo $config['home-file-path'] . '/view/welcome.php' ?>">Home
                  <span class="sr-only">(current)</span>
                </a>
          </li>
          <li class="nav-item" style="padding-left: 35px;">
            <a class="nav-link" href="#">Features</a>
          </li>
          <li class="nav-item" style="padding-left: 35px;">
            <a class="nav-link" href="#">Styles</a>
          </li>
          <li class="nav-item" style="padding-left: 35px;">
            <a class="nav-link" href="#">Subscriptions</a>
          </li>
          <li class="nav-item" style="padding-left: 35px;">
            <a class="nav-link" href="#">Templates</a>
          </li>
          <li class="nav-item" style="padding-left: 35px;">
            <a class="nav-link" href="#">Support</a>
          </li>
        </ul>
        
        <ul class="navbar-nav ml-auto nav-links">
          

          <!-- See whether user is logged in or not -->
          <?php 
          if (!empty($_SESSION['loggedinvar'])) {
            echo "<li class=\"nav-item\"><a class=\"nav-link\" href=\"";
            echo  $config['home-file-path'];
            echo "/view/website-name.php\">My Webpages</a></li>";
          }
          ?>

          </ul>

          <?php 
            if (!empty($_SESSION['loggedinvar'])) {
              echo "<a class=\"btn btn-outline-warning my-2 my-sm-0\" href=\"";
              echo  $config['home-file-path'];
              echo "/controller/controller.php?COMMAND=LOGOUT\">Logout</a>";
            } else {
              echo "<a class=\"btn btn-outline-success my-2 my-sm-0\" href=\"";
              echo  $config['home-file-path'];
              echo "/view/login.php\">Login</a>";
            }
          ?>


        </ul>
      </div>
  </div>
</nav>
