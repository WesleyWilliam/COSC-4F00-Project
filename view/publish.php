#!/usr/bin/php-cgi

  <!-- Including bootstrap CSS files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

  <!-- Icons -->
  <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

  <!-- Jquery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

  <!-- jquery ui -->
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

 <!--Requirements -->
 <?php require_once '../utilities/requirements.php' ?>

<?php
try {
  $component = NULL;
  if (isset($_GET['website'])) {
    $component = $model->getWebsites($_GET['website']);
    if ($component == "WRONGUSER") {
      echo '</head><body> <h1> Error, you do not have permission to access this page </h1> </body> </html>';
      die();
    }
  } else {
    //Later on well make this go to the first website for your user
    echo '</head><body> <h1> Error, needs website id provided by get request </h1> </body> </html>';
    die();
  }
} catch (SessionNotFound $e) {
  redirect('view/login.php');
  die();
}
?>




<!-- Javascript code -->
<script>
  <?php include('script.php') ?>
</script>

      <!-- Webpages Navbar -->
      <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Webpages</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto" id="webpages-nav-list">
            <li class="nav-item active">
              <!-- <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a> -->
            </li>
          </ul>
        </div>
      </nav>

<div>
  <!-- Editor space -->
  <div class="visible" id="editor-user-page">
  </div>

  <!-- Footer space -->
  <div class="visible" id="footer-user-page">
  </div>

</div>

<script>

</script>

<!-- Makes spacer transparent  -->
<style>
.spacer-component-grid {
  background: #00000000 !important;
}
#dropdownMenuButton {
  visibility: hidden;
}
</style>