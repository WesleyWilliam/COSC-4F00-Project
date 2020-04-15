#!/usr/bin/php-cgi
<!DOCTYPE html>
<html>

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Including bootstrap CSS files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <script src="https://use.fontawesome.com/6109563882.js"></script>
  <!-- Style Sheets -->
  <link rel="stylesheet" href="css/add-button.css">
  <link rel="stylesheet" href="css/webpage-name.css">


</head>

<body>
  <!--Requirements -->
  <?php require_once '../utilities/requirements.php' ?>

  <!-- Nav Bar -->
  <?php 
  $page = 'websites';
  include 'navbar.php' 
  ?>

  <!-- If there is a message, show message to user -->
  <?php
  if (!empty($_SESSION['WEBSITE_MSG'])) {
    echo "<div class=\"alert alert-warning\" role=\"alert\">";
    echo $_SESSION['WEBSITE_MSG'];
    echo "</div>";
  }
  ?>

  <?php
  try {
    $websitelst = $model->listWebsites();
  } catch (SessionNotFound $e) {
    redirect('view/login.php');
    die();
  }
  ?>

  <!-- Banner -->
  <div class="jumbotron jumbotron-fluid">
      <div class="container" id="banner-text">
          <h1 class="display-4">Your Websites</h1>
      </div>
  </div>


  <div class="mt-4 pb-3">
    <div class="container" style="margin-top:80px; margin-bottom:50px;">
      <table class="table table-hover" >
        <thead>
            <tr>
            <th scope="col">Website Name</th>
            <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
        <?php
            if (!empty($websitelst))
              foreach ($websitelst as $website) {
                echo '<tr style="cursor: pointer;"><td data-href="' . $config['home-file-path'] . '/view/editor.php?website=' . $website->id . ' ">' . $website->name . '</td>';
                echo "<td class='text-right'><a class='btn btn-danger' data-toggle='modal' data-target='#del-feedback' href=''>Delete</a></td></tr>";
              }
            else{ 
              echo "<tr><td data-href=''>You have no websites.</td>";
              echo "<td></td></tr>";
            }

          ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- + button -->
    <div class="container" style="padding-bottom:150px;">
        <div class="text-right mb-3 overlay">
          <button type="button" class="btn btn-light-primary btn-circle btn-xl" data-toggle="modal" data-target="#new-feedback"><i class="fa fa-plus" aria-hidden="true"></i></button>
        </div>
    </div>

  <div class="modal fade" id="del-feedback" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header text-left bg-danger text-white">
          <h5 class="modal-title w-100">Deleting is Permanent!</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color:white;">&times;</span>
        </div>
        <div class="modal-body">
          <div class="container mt-3">
            <p style="text-align:center; margin-bottom:40px;">Are you sure you want to delete your website?</p>
            <div class="modal-footer">
                <a type="button" class="btn btn-outline-danger" href="" action="<?php echo $config['home-file-path']; ?>/controller/controller.php" method="POST" data-dismiss="modal">Delete</a>
                <a type="button" class="btn btn-secondary" href="" data-dismiss="modal">Close</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <div class="modal fade" id="new-feedback" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header text-left bg-info text-white">
          <h5 class="modal-title w-100">Create a New Website!</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="color:white;">&times;</span>
        </div>
        <div class="modal-body" style="margin-bottom:30px;">
          <div class="container">
            <h4 class="text-center mt-5 text-muted">Enter the name of your website:</h4>
            <form action="<?php echo $config['home-file-path'] . '/controller/controller.php' ?>" method="POST">
              <div class="form-group form-group-lg">
                <input name="WEBSITE" type="text" class="form-control mt-5" style="text-align:center" pattern="[A-Za-z_]{3}[A-Za-z_]*$" title="3 characters, only a-z and underline">
              </div>
              <div class="form-group" style="text-align:center; margin-top: 30px;">
                <button class="btn btn-outline-primary" type="Submit">Submit</button>
                <input type="hidden" name="COMMAND" value="WEBSITE_WIZARD">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <footer id="sticky-footer" class="py-4 bg-dark text-white-50 fixed-bottom">
    <div class="container text-center">
        <small>Copyright &copy; Brix.ca</small>
    </div>
  </footer>

  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

  <script>
        document.addEventListener("DOMContentLoaded", () => {
            const rows = document.querySelectorAll("td[data-href]");
            rows.forEach(row => {
                row.addEventListener("click", ()=>{
                    window.location.href = row.dataset.href;

                });
            });
        });
    </script>
</body>

</html>