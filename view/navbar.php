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
        <li class="nav-item <?php if ($page == 'welcome') echo ' active'; ?>" style="padding-left: 35px;">
          <a class="nav-link" href="<?php echo $config['home-file-path'] . '/view/welcome.php' ?>">Home
            <span class="sr-only">(current)</span>
          </a>
        </li>
        <li class="nav-item <?php if ($page == 'features') echo ' active'; ?>" style="padding-left: 35px;">
          <a class="nav-link" href="<?php echo $config['home-file-path'] . '/view/features.php' ?>">Features</a>
        </li>
        <li class="nav-item <?php if ($page == 'styles') echo ' active'; ?>" style="padding-left: 35px;">
          <a class="nav-link" href="<?php echo $config['home-file-path'] . '/view/styles.php' ?>">Styles</a>
        </li>
        <li class="nav-item <?php if ($page == 'subscriptions') echo ' active'; ?>" style="padding-left: 35px;">
          <a class="nav-link" href="<?php echo $config['home-file-path'] . '/view/subscriptions.php' ?>">Subscriptions</a>
        </li>
        <li class="nav-item <?php if ($page == 'templates') echo ' active'; ?>" style="padding-left: 35px;">
          <a class="nav-link" href="<?php echo $config['home-file-path'] . '/view/templates.php' ?>">Templates</a>
        </li>
        <li class="nav-item <?php if ($page == 'support') echo ' active'; ?>" style="padding-left: 35px;">
          <a class="nav-link" href="<?php echo $config['home-file-path'] . '/view/support.php' ?>">Support</a>
        </li>
      </ul>

      <ul class="navbar-nav ml-auto nav-links">


        <!-- See whether user is logged in or not -->
        <?php
          if (!empty($_SESSION['USER_ID'])) {
            echo "<div style=\"padding-left: 30px;\">";
            echo "<li class=\"nav-item";
            if ($page == 'websites') echo ' active';
            echo "\"><a class=\"nav-link\" href=\"";
            echo  $config['home-file-path'];
            echo "/view/website-name.php\">My Webpages</a></li>";
            echo "</div>";

            echo "<div style=\"padding-left: 30px;\">";
            echo "<li class=\"nav-item";
            if ($page == 'account') echo ' active';
            echo "\"><a class=\"nav-link\" href=\"";
            echo  $config['home-file-path'];
            echo "/view/account.php\">Account</a></li>";
            echo "</div>";

            echo "<div style=\"padding-left: 30px;\">";
            echo "<a class=\"btn btn-outline-danger my-2 my-sm-0\" href=\"";
            echo  $config['home-file-path'];
            echo "/controller/controller.php?COMMAND=LOGOUT\">Logout</a>";
            echo "</div>";
          } else {
            echo "<div style=\"padding-left: 30px;\">";
            echo "<a class=\"btn btn-outline-success my-2 my-sm-0\" href=\"";
            echo  $config['home-file-path'];
            echo "/view/login.php\">Login</a>";
            echo "</div>";
          }
        ?>
      </ul>
    </div>
  </div>
</nav>