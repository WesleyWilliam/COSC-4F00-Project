#!/usr/bin/php-cgi
<!DOCTYPE html>
<html>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Including bootstrap CSS files -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    

</body>
    <!--CSS files -->
    <link rel="stylesheet" href="css/features.css">

</head>

<body>
    <!--Requirements -->
    <?php require_once '../utilities/requirements.php' ?>

    <?php
    $page = 'features';
    include "navbar.php";
    ?>

    <!-- Banner -->
    <div class="jumbotron jumbotron-fluid">
        <div class="container" id="banner-text">
            <h1 class="display-4">Features</h1>
            <p class="lead">Checkout all the features you can use to build your very own website.</p>
            <a class="btn btn-primary btn-lg" href="<?php echo $config['home-file-path'] . '/view/signup.php' ?>">Lets Get Started</a>
        </div>
    </div>

    <!-- Page Content -->
    <div class="container" style="padding-bottom:100px;" >

        <div class="container pb-30">            
            <div class= "container">
                <img class="d-block w-100" src="img/templates-and-styles-banner.png" alt="templates-and-styles-banner">
            </div>
            <hr class="mt-5">
        </div>
        <div class="container pb-30">            
            <div class= "container">
                <img class="d-block w-100" src="img/drag-banner.png" alt="drag-and-drop">
            </div>
            <hr class="mt-5">
        </div>

        <div class="container pb-30">            
            <div class= "container">
                <img class="d-block w-100" src="img/host-free-banner.png" alt="free-web-hosting">
            </div>
            <hr class="mt-5">
        </div>

        <div class="container pb-30">            
            <div class= "container">
                <img class="d-block w-100" src="img/web-management-banner.png" alt="multiple-web-management">
            </div>
            <hr class="mt-5">
        </div>
        
        <div class="container pb-30">            
            <div class= "container">
                <img class="d-block w-100" src="img/plus-more-banner.png" alt="multiple-web-management">
            </div>
            <div class= "container text-center">
                <a class="btn btn-outline-primary btn-lg" href="<?php echo $config['home-file-path'] . '/view/signup.php' ?>">Start Today!</a>
            </div>

        </div>
        
    </div>
    
    <!-- Page Content -->

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

</html>