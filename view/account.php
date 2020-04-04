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
    <?php 
    $page = 'account';
    include 'navbar.php' 
    ?>

    <?php
    try {
        $user = $model->getUser();
        if (empty($user->firstname)) {
            $name = $user->username;
        } else {
            $name = $user->firstname;
        }
    } catch (SessionNotFound $e) {
        redirect('view/login.php');
        die();
    }
    ?>

    <!--Title-->
    <div class="border-bottom mr-5 ml-5">
        <h1 class="display-4 text-center pb-3">Hello <?php echo $name; ?>!</h1>
        <p class="text-center">Here you can change your account infomation</p>
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
                    <div class="row">
                        <div class="col">
                            <!-- If there is a message, show message to user -->
                            <?php
                            if (!empty($_SESSION['UPDATEACCOUNT_MSG'])) {
                                echo "<div class=\"alert alert-warning\" role=\"alert\">";
                                echo $_SESSION['UPDATEACCOUNT'];
                                echo "</div>";
                                $_SESSION['UPDATEACCOUNT_MSG'] = '';
                            } else {
                                echo "<div><p> </p></div>";
                            }
                            ?>
                        </div>
                    </div>
                    <form action="<?php echo $config['home-file-path'] . '/controller/controller.php' ?>" method="POST">
                        <div class="row">
                            <div class="col-2">
                                <p>First Name: </p>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="firstname" name="FNAME" placeholder="Enter first name" value="<?php echo $user->firstname; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <p>Last Name:</p>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="lastname" name="LNAME" placeholder="Enter last name" value="<?php echo $user->lastname; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <p>Date Of Birth:</p>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <input type="date" class="form-control" id="dob" name="DOB" placeholder="Enter date of birth" value="<?php echo $user->dob; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <p>Phone Number: </p>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <input type="tel" class="form-control" id="phone" name="PHONE" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" placeholder="xxx-xxx-xxxx" value="<?php echo $user->phonenumber; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <p>Email*: </p>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <input type="email" class="form-control" id="email" name="EMAIL" required placeholder="Enter your Email address" value="<?php echo $user->email; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                            </div>
                            <div class="col-3">
                                <input type="hidden" name="COMMAND" value="UPDATEPROFILE">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="v-pills-privacy" role="tabpanel" aria-labelledby="v-pills-privacy-tab">
                    <div class="row">
                        <div class="col">
                            <!-- If there is a message, show message to user -->
                            <?php
                            if (!empty($_SESSION['UPDATEACCOUNT_MSG'])) {
                                echo "<div class=\"alert alert-warning\" role=\"alert\">";
                                echo $_SESSION['UPDATEACCOUNT_MSG'];
                                echo "</div>";
                                $_SESSION['UPDATEACCOUNT_MSG'] = '';
                            } else {
                                echo "<div><p> </p></div>";
                            }
                            ?>
                        </div>
                    </div>
                    <form action="<?php echo $config['home-file-path'] . '/controller/controller.php' ?>" method="POST">
                        <div class="row">
                            <div class="col-2">
                                <p>Permissions to view account: </p>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <input type="hidden" name="COMMAND" value="UPDATEPRIVACY">
                                    <select id="permisson" class="form-control" name="VPERM" onchange="this.form.submit()" value="<?php echo $user->view_permissions; ?>">
                                        <option value="ALL">Everyone</option>
                                        <option value="FRIENDS">Friends</option>
                                        <option value="ME">Only Me</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <p>Blocked Users:</p>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <p>No-One</p>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="v-pills-payment" role="tabpanel" aria-labelledby="v-pills-payment-tab">
                    <div class="row">
                        <div class="col">
                            <!-- If there is a message, show message to user -->
                            <?php
                            if (!empty($_SESSION['UPDATEACCOUNT_MSG'])) {
                                echo "<div class=\"alert alert-warning\" role=\"alert\">";
                                echo $_SESSION['UPDATEACCOUNT_MSG'];
                                echo "</div>";
                                $_SESSION['UPDATEACCOUNT_MSG'] = '';
                            } else {
                                echo "<div><p> </p></div>";
                            }
                            ?>
                        </div>
                    </div>
                    <form action="<?php echo $config['home-file-path'] . '/controller/controller.php' ?>" method="POST">
                        <div class="row">
                            <div class="col-2">
                                <p>Credit card number: </p>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <input type="tel" inputmode="numeric" class="form-control" pattern="[0-9\s]{13,19}" autocomplete="cc-number" maxlength="19" id="ccn" name="CNUM" placeholder="xxxx xxxx xxxx xxxx" value="<?php echo $user->cardnumber; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <p>Experation Date:</p>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <input type="month" class="form-control" id="experation" name="EDATE" value="<?php echo $user->expdate; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <p>CVV:</p>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <input type="tel" inputmode="numeric" class="form-control" pattern="[0-9]{3}" autocomplete="cvv-number" maxlength="3" id="cvv" name="CVVNUM" placeholder="xxx" value="<?php echo $user->cvvnum; ?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                                <p>Type: </p>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <select class="form-control" name="TYPE" value="<?php echo $user->type; ?>">
                                        <option value="MC">Master Card</option>
                                        <option value="VISA">Visa</option>
                                        <option value="PP">Pay Pal</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-2">
                            </div>
                            <div class="col-3">
                                <input type="hidden" name="COMMAND" value="UPDATEPAYMENT">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="tab-pane fade" id="v-pills-subscriptions" role="tabpanel" aria-labelledby="v-pills-subscriptions-tab">
                    <div class="row">
                        <div class="col">
                            <!-- If there is a message, show message to user -->
                            <?php
                            if (!empty($_SESSION['UPDATEACCOUNT_MSG'])) {
                                echo "<div class=\"alert alert-warning\" role=\"alert\">";
                                echo $_SESSION['UPDATEACCOUNT_MSG'];
                                echo "</div>";
                                $_SESSION['UPDATEACCOUNT_MSG'] = '';
                            } else {
                                echo "<div><p> </p></div>";
                            }
                            ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-2">
                            <p>Subscriptions: </p>
                        </div>
                        <form action="<?php echo $config['home-file-path'] . '/controller/controller.php' ?>" method="POST">
                            <div class="col-3">
                                <div class="form-group">
                                    <input type="hidden" name="COMMAND" value="UPDATESUBSCRIPTIONS">
                                    <select class="form-control" onchange="this.form.submit()" name="SUB">
                                        <option value="PREM">Premium</option>
                                        <option value="BASIC">Basic</option>
                                        <option value="FREE">Free</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                    <div class="row">
                        <div class="col">
                            <!-- If there is a message, show message to user -->
                            <?php
                            if (!empty($_SESSION['UPDATEACCOUNT_MSG'])) {
                                echo "<div class=\"alert alert-warning\" role=\"alert\">";
                                echo $_SESSION['UPDATEACCOUNT_MSG'];
                                echo "</div>";
                                $_SESSION['UPDATEACCOUNT_MSG'] = '';
                            } else {
                                echo "<div><p> </p></div>";
                            }
                            ?>
                        </div>
                    </div>
                    <form action="<?php echo $config['home-file-path'] . '/controller/controller.php' ?>" method="POST" >
                        <div class="row">
                            <div class="col-2">
                                <p>Delete Account: </p>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <input type="hidden" name="COMMAND" value="DELETEACCOUNT">
                                    <button type="submit" class="btn btn-primary">Delete Permanently</button>
                                </div>
                            </div>
                        </div>
                    </form>
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
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>

</html>