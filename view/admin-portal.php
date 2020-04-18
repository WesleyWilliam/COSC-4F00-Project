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

  <!-- Check if Admin -->
  <?php
  $admin = $model->isAdmin();
  if ($admin == false) {
    redirect('view/website-name.php');
  }
  try {
    $user = $model->getUser();
    if (empty($user->firstname)) {
      $name = $user->username;
    } else {
      $name = $user->firstname;
    }
  } catch (Exception $e) {
    redirect('view/login.php');
    die();
  }
  ?>

  <!-- Banner -->
  <div class="jumbotron jumbotron-fluid text-white mb-0" style="background-color: #2a4b7e;">
    <div class="container" id="banner-text">
      <h1 class="display-4">Admin Portal</h1>
      <p><?php echo $name; ?></p>
    </div>
  </div>

  <!-- If there is a message, show message to user -->
  <?php
  if (!empty($_SESSION['WEBSITENAME'])) {
    echo "<div class=\"alert alert-warning\" role=\"alert\">";
    echo $_SESSION['WEBSITENAME'];
    echo "</div>";
    $_SESSION['WEBSITENAME'] = '';
  }
  ?>

  <div class="container mt-4">
    <ul class="nav nav-tabs mb-4">
      <li class="nav-item">
        <a class="nav-link active" id="pills-webpage-tab" data-toggle="pill" href="#pills-webpage" role="tab" aria-controls="pills-webpage" aria-selected="true">Websites</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="pills-users-tab" data-toggle="pill" href="#pills-users" role="tab" aria-controls="pills-users" aria-selected="false">Users</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">Pending Tickets</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="pills-database-tab" data-toggle="pill" href="#pills-database" role="tab" aria-controls="pills-database" aria-selected="false">**Database clearing**</a>
      </li>
    </ul>

    <div class="container">
      <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-webpage" role="tabpanel" aria-labelledby="pills-webpage-tab">
          <h4 class="mt-4 mb-3 text-muted text-left"> Currently Hosting:</h4>
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
                $UID = $website->users_id;
                $name = $model->getUsername($UID);
                echo '<button type="button" class="list-group-item list-group-item-action" name="web" value="' . $UID . '" onclick="StoreID(' . $UID . ');$(\'#webpageOptionsModal\').modal(\'show\')"><strong>Website Name:</strong> ' . $website->name . ' <br /><strong>Username:</strong> ' . $name . '</button>';
              } ?>
            </form>
          </div>

          <!-- Admin webpage options -->
          <form action="<?php echo $config['home-file-path'] . '/controller/controller.php' ?>" method="POST">
            <div class="modal fade" id="webpageOptionsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Website Options</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <button name="SITE" type="Submit" id="deleteID" class="btn btn-danger btn-lg btn-block">Delete</button>
                    <input type="hidden" name="COMMAND" value="WEBSITE_DELETE_ADMIN">
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>

        <div class="tab-pane fade" id="pills-users" role="tabpanel" aria-labelledby="pills-users-tab">
          <h4 class="mt-4 mb-3 text-muted text-left">Account Names:</h4>
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
              echo '<button type="button" class="list-group-item list-group-item-action" name="web" value="' . $user->id . '" onclick="StoreUserID(' . $user->id . ');$(\'#userOptionsModal\').modal(\'show\')"><strong>Username:</strong> ' . $user->username . '<br /><strong>User ID:</strong> ' . $user->id . '<br /><strong>Subscription Type:</strong> ' . $user->subscription . '<br /><strong>User Level:</strong> ' . $user->level .'</button>';
            }
            ?>
          </div>

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
                    <button name="TOOGLE" type="Submit" id="checkUserID" class="btn btn-secondary btn-lg btn-block">Add/Remove Admin</button>
                    <button name="SITE" type="Submit" id="deleteUserID" class="btn btn-danger btn-lg btn-block">Delete User</button>
                    <input type="hidden" name="COMMAND" value="USER_DELETE_ADMIN">
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>

        <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
          <h4 class="mt-4 mb-3 text-muted text-left">Recieved: </h4>
          <div class="list-group">
            <?php
            $contactlst = null;
            try {
              $contactlst = $model->getAllContact();
            } catch (Exception $e) {
              redirect('view/login.php');
              die();
            }
            foreach ($contactlst as $contact) {
              echo "<div class= 'card mb-4'>";
              echo "<div class= 'card-header'>";
              echo "<div class= 'row'>";
              echo "<div class= 'col'>";
              echo "From: ";
              echo $contact->email;
              echo "</div>";
              echo "<div class= 'col text-right'>";
              echo "ID: ";
              echo $contact->id;
              echo "</div>";
              echo "</div>";
              echo "</div>";
              echo "<div class= 'card-body'>";
              echo "Message: <br>";
              echo $contact->msg;
              echo "</div>";
              echo "<div class= 'card-footer' style='background-color:white;'>";
              echo "<div class= 'row'>";
              echo "<div class= 'col text-muted'>";
              echo "Time: ";
              echo $contact->time;
              echo "</div>";
              echo "<div class= 'col text-right'>";
              echo '<button type="button" class="btn btn-outline-info"  name="web" value="' . $contact->id . '" onclick="StoreContactID(' . $contact->id . ');$(\'#contactOptionsModal\').modal(\'show\')">Done</button>';
              echo "</div>";
              echo "</div>";
              echo "</div>";
              echo "</div>";
            } ?>
          </div>

          <!-- Admin Ticket options -->
          <form action="<?php echo $config['home-file-path'] . '/controller/controller.php' ?>" method="POST">
            <div class="modal fade" id="contactOptionsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Are you sure this is completed?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <button name="SITE" type="Submit" id="deleteContactID" class="btn btn-success btn-lg btn-block">Mark as Complete</button>
                    <input type="hidden" name="COMMAND" value="CONTACT_DELETE_ADMIN">
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>


        <div class="tab-pane fade" id="pills-database" role="tabpanel" aria-labelledby="pills-database-tab">
          <h4 class="mt-4 mb-4 text-muted text-left"><strong>Warning!</strong> This is permanent! This transaction cannot be undone</h4>
          <div class="list-group">
            <?php
            echo '<button type="button" class="btn btn-danger mt-4 mb-2"  name="web" value="Website" onclick="$(\'#databaseWebOptionsModal\').modal(\'show\')">Delete All Websites (Permanently)</button>';
            echo '<button type="button" class="btn btn-danger mb-2"  name="web" value="Users" onclick="$(\'#databaseUserOptionsModal\').modal(\'show\')">Delete All Users (Permanently)</button>';
            echo '<button type="button" class="btn btn-danger mb-4"  name="web" value="Tickets" onclick="$(\'#databaseTicketOptionsModal\').modal(\'show\')">Delete All Tickets (Permanently)</button>';
            echo '<button type="button" class="btn btn-danger mt-4"  name="web" value="Database" onclick="$(\'#databaseOptionsModal\').modal(\'show\')">Delete Entire Database (Permanently)</button>';
            ?>
          </div>

          <!-- Admin Website Delete options -->
          <form action="<?php echo $config['home-file-path'] . '/controller/controller.php' ?>" method="POST">
            <div class="modal fade" id="databaseWebOptionsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to permanently delete the websites table?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <button name="DATABASE" type="Submit" value="website" class="btn btn-danger btn-lg btn-block">Delete Anyways</button>
                    <input type="hidden" name="COMMAND" value="DELETE_DATABASE">
                  </div>
                </div>
              </div>
            </div>
          </form>

          <!-- Admin User Delete options -->
          <form action="<?php echo $config['home-file-path'] . '/controller/controller.php' ?>" method="POST">
            <div class="modal fade" id="databaseUserOptionsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to permanently delete the Users table?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <button name="DATABASE" type="Submit" value="user" class="btn btn-danger btn-lg btn-block">Delete Anyways</button>
                    <input type="hidden" name="COMMAND" value="DELETE_DATABASE">
                  </div>
                </div>
              </div>
            </div>
          </form>

          <!-- Admin Ticket Delete options -->
          <form action="<?php echo $config['home-file-path'] . '/controller/controller.php' ?>" method="POST">
            <div class="modal fade" id="databaseTicketOptionsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to permanently delete all tickets?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <button name="DATABASE" type="Submit" value="ticket" class="btn btn-danger btn-lg btn-block">Delete Anyways</button>
                    <input type="hidden" name="COMMAND" value="DELETE_DATABASE">
                  </div>
                </div>
              </div>
            </div>
          </form>

          <!-- Admin Wipe options -->
          <form action="<?php echo $config['home-file-path'] . '/controller/controller.php' ?>" method="POST">
            <div class="modal fade" id="databaseOptionsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Are you sure you want to permanently wipe the entire database?</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <div class="modal-body">
                    <button name="DATABASE" type="Submit" value="wipe" class="btn btn-danger btn-lg btn-block">Delete Anyways</button>
                    <input type="hidden" name="COMMAND" value="DELETE_DATABASE">
                  </div>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script>
    function StoreID(f) {
      $("#deleteID").val(f);
      $("#blockID").val(f);
    }

    function StoreUserID(f) {
      $("#deleteUserID").val(f);
      $("#checkUserID").val(f);
    }

    function StoreContactID(f) {
      $("#deleteContactID").val(f);
    }
  </script>

  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>