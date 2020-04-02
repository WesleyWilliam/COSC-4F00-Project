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
    <link rel="stylesheet" href="css/subscriptions.css">

</head>

<body>
    <!--Requirements -->
    <?php require_once '../utilities/requirements.php' ?>

    <?php
    $page = 'subscriptions';
    include "navbar.php";
    ?>

    <!-- Banner -->
    <div class="jumbotron jumbotron-fluid">
        <div class="container" id="banner-text">
            <h1 class="display-4">Get more for your site with these premium plans:</h1>
            <p class="lead"></p>
        </div>
    </div>

    <!-- Page Content -->

    <div class="container" style="padding-top:65px">
        <div class="card-deck mb-3 text-center">
            <div class="card mb-4 shadow mb-5 bg-white rounded">
                <div class="card-header" id="starter">
                    <h4 class="my-0 font-weight-normal">Starter Plan</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">$0 <small class="text-muted">/ mo</small></h1>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>Free Web Hosting</li>
                        <li>Free Domain Name</li>
                        <li>Free Styles</li>
                        <li>Free Templates</li>
                        <li class="font-weight-bold">Single Site Managment</li>
                        <li>Email support</li>
                        <li>Help center access</li>
                        <li><br> </li>

                    </ul>
                    <a type="button" class="btn btn-lg btn-block btn-outline-primary" href="<?php echo $config['home-file-path'] . '/view/signup.php' ?>">Sign up for free</a>
                </div>
            </div>
            <div class="card mb-4 shadow mb-5 bg-white rounded">
                <div class="card-header" id="basic">
                    <h4 class="my-0 font-weight-normal">Basic Plan</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">$9 <small class="text-muted">/ mo</small></h1>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>Free Web Hosting</li>
                        <li>Free Domain Name</li>
                        <li>Free Styles</li>
                        <li>Free Templates</li>
                        <li class="font-weight-bold">Multi-Site Managment for up to 3 Websites</li>
                        <li>Email support</li>
                        <li>Help center access</li>
                    </ul>
                    <a type="button" class="btn btn-lg btn-block btn-primary" href="<?php echo $config['home-file-path'] . '/view/signup.php' ?>">Sign up for free</a>
                </div>
            </div>
            <div class="card mb-4 shadow mb-5 bg-white rounded">
                <div class="card-header" id="pro">
                    <h4 class="my-0 font-weight-normal">Pro</h4>
                </div>
                <div class="card-body">
                    <h1 class="card-title pricing-card-title">$16 <small class="text-muted">/ mo</small></h1>
                    <ul class="list-unstyled mt-3 mb-4">
                        <li>Free Web Hosting</li>
                        <li>Free Domain Name</li>
                        <li>Free Styles</li>
                        <li>Free Templates</li>
                        <li class="font-weight-bold">Multi-Site Managment for up to 5 Websites</li>
                        <li>Email support</li>
                        <li>Help center access</li>
                    </ul>
                    <a type="button" class="btn btn-lg btn-block btn-outline-primary" href="<?php echo $config['home-file-path'] . '/view/signup.php' ?>">Sign up for free</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container" style="padding-bottom:150px;">
        <div class="container pb-30">      
            <hr class="mt-5">      
            <div class= "container">
                <img class="d-block w-100" src="img/all-plans-include.png" alt="templates-and-styles-banner">
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
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</body>

</html>