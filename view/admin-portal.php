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
  <?php include_once 'navbar.php' ?>

  <!-- If there is a message, show message to user -->
  <?php
  if (!empty($_SESSION['WEBSITENAME'])) {
    echo "<div class=\"alert alert-warning\" role=\"alert\">";
    echo $_SESSION['WEBSITENAME'];
    echo "</div>";
    $_SESSION['WEBSITENAME'] = '';
  }
  ?>

  <!-- Check if Admin -->
  <?php
    $admin = $model->isAdmin();
    if ($admin == true){
      redirect('view/website-name.php');
    }
  ?>

  <div class="container">
    <h1 class="text-center mt-5 text-muted">Admin Portal</h1>

    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="pills-webpage-tab" data-toggle="pill" href="#pills-webpage" role="tab" aria-controls="pills-webpage" aria-selected="true">Webpages</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="pills-users-tab" data-toggle="pill" href="#pills-users" role="tab" aria-controls="pills-users" aria-selected="false">Users</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Contact</a>
      </li>
    </ul>
    <div class="tab-content" id="pills-tabContent">
      <div class="tab-pane fade show active" id="pills-webpage" role="tabpanel" aria-labelledby="pills-webpage-tab">
        <h4 class="mt-5 text-muted text-left">All CMS Webpages</h4>
        <div class="list-group">
        <form action="<?php echo $config['home-file-path'] . '/controller/controller.php' ?>" method="POST">
          <?php
          $websitelst = null;
          try {
            $websitelst = $model->listAllWebsites();
          } catch (Exception $e) {
            redirect('view/login.php');
            die();
          }
          foreach ($websitelst as $website) {
            echo '<button type="button" class="list-group-item list-group-item-action" name="web" value="' . $website->id . '" onclick="StoreID(' . $website->id . ');$(\'#webpageOptionsModal\').modal(\'show\')">' . $website->name . ' - ' . $website->users_id . '</button>';
          } ?>
        </form>
        </div>

        <!-- Admin webpage options -->
        <form action="<?php echo $config['home-file-path'] . '/controller/controller.php' ?>" method="POST">
        <div class="modal fade" id="webpageOptionsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Webpage Options</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <button name = "SITE" type="Submit" id="deleteID" class="btn btn-danger btn-lg btn-block">Delete</button>
                <button type="button" class="btn btn-secondary btn-lg btn-block">Other option</button>
                <input type="hidden" name="COMMAND" value="WEBSITE_DELETE_ADMIN">
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="tab-pane fade" id="pills-users" role="tabpanel" aria-labelledby="pills-users-tab">
        <h4 class="mt-5 text-muted text-left">All CMS Users</h4>
        <div class="list-group">
          <?php
          $userlst = null;
          try {
            $userlst = $model->listAllUsers();
          } catch (Exception $e) {
            redirect('view/login.php');
            die();
          }
          foreach ($userlst as $user) {
            echo '<button type="button" class="list-group-item list-group-item-action" name="web" value="' . $user->id . '" onclick="StoreID(' . $user->id . ');$(\'#userOptionsModal\').modal(\'show\')">' . $user->username . ' - '. $user->id .'</button>';
          } ?>
        </div>
        </form>

        <!-- Admin user options -->
        <form action="<?php echo $config['home-file-path'] . '/controller/controller.php' ?>" method="POST">
        <div class="modal fade" id="userOptionsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">User Options</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <button name="SITE" type="Submit" id="deleteID" class="btn btn-danger btn-lg btn-block">Delete User</button>
                <button type="button" class="btn btn-secondary btn-lg btn-block">Other option</button>
                <input type="hidden" name="COMMAND" value="USER_DELETE_ADMIN">
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
        <h4 class="mt-5 text-muted text-left">All Submitted Contact</h4>
        <div class="list-group">
        <form action="<?php echo $config['home-file-path'] . '/controller/controller.php' ?>" method="POST">
          <?php
          $contactlst = null;
          try {
            $contactlst = $model->getAllContact();
          } catch (Exception $e) {
            redirect('view/login.php');
            die();
          }
          foreach ($contactlst as $contact) {
            echo '<button type="button" class="list-group-item list-group-item-action" name="web" value="' . $contact->id . '" onclick="StoreID(' . $contact->id . ');$(\'#contactOptionsModal\').modal(\'show\')"><b>ID:</b> ' . $contact->id . ' <b>Time:</b> ' . $contact->time . ' <b>Name:</b> ' . $contact->name . ' <b>Email:</b> ' . $contact->email . ' <b>Message:</b> ' . $contact->msg .'</button>';
          } ?>
        </form>
        </div>
      </div>

      <!-- Admin contact options -->
      <form action="<?php echo $config['home-file-path'] . '/controller/controller.php' ?>" method="POST">
        <div class="modal fade" id="contactOptionsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Contact Options</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <button name="SITE" type="Submit" id="deleteID" class="btn btn-danger btn-lg btn-block">Delete Message</button>
                <button type="button" class="btn btn-secondary btn-lg btn-block">Other option</button>
                <input type="hidden" name="COMMAND" value="CONTACT_DELETE_ADMIN">
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
  </form>

  <script>
    function StoreID(f) {
      $("#deleteID").val(f);
    }
  </script>

  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>