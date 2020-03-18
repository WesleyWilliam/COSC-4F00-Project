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
    <?php include 'navbar.php' ?>

    <!--Title-->
    <div class="border-bottom mr-5 ml-5">
        <h1 class="display-4 text-center pb-3">Hello: Eduardo</h1>
    </div>


    <!-- Nav -->
    <div class="row">
        <div class="col-3">
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link active" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="true">Profile</a>
                <a class="nav-link" id="v-pills-privacy-tab" data-toggle="pill" href="#v-pills-privacy" role="tab" aria-controls="v-pills-privacy" aria-selected="false">Privacy</a>
                <a class="nav-link" id="v-pills-payment-tab" data-toggle="pill" href="#v-pills-payment" role="tab" aria-controls="v-pills-payment" aria-selected="false">Payment Method</a>
                <a class="nav-link" id="v-pills-subscriptions-tab" data-toggle="pill" href="#v-pills-subscriptions" role="tab" aria-controls="v-pills-subscriptions" aria-selected="false">Subscriptions</a>
                <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Settings</a>
            </div>
        </div>
        <div class="col-9">
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                    <div class ="containter">
                        <div class="row">
                            <div class="col">

                                <p>First Name: </p>
                                <p>Last Name: </p>
                                <p>Date Of Birth: </p>
                                <p>Phone Number: </p>
                                <p>Email: </p>
                            </div>
                            <div class="col">
                                <p>Eddy</p>
                                <p>Gee</p>
                                <p>July 20/1994</p>
                                <p>(905) 359-3007</p>
                                <p>eduardosemail@gmail.com</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="v-pills-privacy" role="tabpanel" aria-labelledby="v-pills-privacy-tab">
                <div class ="containter">
                        <div class="row">
                            <div class="col">
                                <p>Blocked Users: </p>
                            </div>
                            <div class="col">
                                <p>No-one</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <p>Permissions to view account:</p>
                            </div>
                            <div class="col">
                                <p>No-one</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="v-pills-payment" role="tabpanel" aria-labelledby="v-pills-payment-tab">
                <div class ="containter">
                        <div class="row">
                            <div class="col">
                                <p>Credit card number: </p>
                                <p>Experation Date: </p>
                                <p>CVV: </p>
                                <p>Type: </p>
                            </div>
                            <div class="col">
                                <p>8223 2012 2302 9291</p>
                                <p>12/22</p>
                                <p>029</p>
                                <p>Master Card</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="v-pills-subscriptions" role="tabpanel" aria-labelledby="v-pills-subscriptions-tab">
                <div class ="containter">
                        <div class="row">
                            <div class="col">
                                <p>Subscriptions:</p>
                            </div>
                            <div class="col">
                                <p>None</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                <div class ="containter">
                        <div class="row">
                            <div class="col">
                                <p>Delete Account: </p>
                                <p>Metadata: </p>
                            </div>
                            <div class="col">
                                <p>Button to delete</p>
                                <p>Button to show data</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Footer-->
    <footer id="sticky-footer" class="py-4 bg-dark text-white-50 fixed-bottom">
        <div class="container text-center">
        <small>Copyright &copy; Brix.ca</small>
        </div>
    </footer>
  
  

  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>


</body>
</html>
