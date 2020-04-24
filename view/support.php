#!/usr/bin/php-cgi
<!DOCTYPE html>
<html>

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Including bootstrap CSS files -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/support.css">


    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script>
    
        $(document).ready(function(){
        // Add smooth scrolling to all links
        $("a").on('click', function(event) {

            // Make sure this.hash has a value before overriding default behavior
            if (this.hash !== "") {
            // Prevent default anchor click behavior
            event.preventDefault();

            // Store hash
            var hash = this.hash;

            // Using jQuery's animate() method to add smooth page scroll
            // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
            $('html, body').animate({
                scrollTop: $(hash).offset().top
            }, 800, function(){
        
                // Add hash (#) to URL when done scrolling (default click behavior)
                window.location.hash = hash;
            });
            } // End if
        });
        });

    </script>
    
</head>

<body>
    <!--Requirements -->
    <?php require_once '../utilities/requirements.php' ?>

    <?php
    $page = 'support';
    include "navbar.php";
    ?>

    <!-- Banner -->
    <div class="jumbotron jumbotron-fluid mb-0" id="top">
        <div class="container" id="banner-text">
            <h1 class="display-4">Help Center</h1>
            <p class="lead">All the answers in one place.</p>
        </div>
    </div>

    <?php
    if (!empty($_SESSION['CONTACT_MSG'])) {
    echo "<div class=\"alert alert-warning\" role=\"alert\">";
    echo $_SESSION['CONTACT_MSG'];
    echo "</div>";
    $_SESSION['CONTACT_MSG'] = '';
    }
    ?>

    <!-- Page Content -->
    <div class="container mt-5">
        <h1 class="display-4 text-muted font-weight-light">FAQ<small class="text-muted font-weight-light">s</small></h1>
        <hr class="mb-5">      
    </div>
    
    <div class= "container">
        <ul>
            <li class="mb-3"><a href="#how-to-start">How do I get started?</a></li>
            <li class="mb-3"><a href="#how-to-editor">How do I use the editor?</a></li>
            <li class="mb-3"><a href="#how-to-plan">How do I change my plan?</a></li>
            <li class="mb-3"><a href="#how-to-manage">How do I use the website manager?</a></li>
            <li class="mb-3"><a href="#how-to-contact">How do I contact support?</a></li>
        </ul>
        <hr class="mb-5 mt-5">      
    </div>
    
    <div class="container">
        <h1 class="display-5 text-muted font-weight-light mb-4" id="how-to-start">How do I get started?</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin a nunc viverra, ullamcorper odio ut, luctus ante. Aliquam at ipsum sem. Donec accumsan vel odio eu tristique. Curabitur dignissim eleifend est vitae gravida. Donec placerat a tellus ut ultricies. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed in dui faucibus, iaculis diam nec, tincidunt mauris. Integer vel dui vitae ligula ullamcorper venenatis ut sit amet magna. Ut ut lacinia risus. Pellentesque iaculis libero sapien. Aliquam volutpat, odio ut hendrerit tristique, nulla ex lobortis ante, eleifend mollis quam massa vitae leo. Morbi egestas bibendum diam at commodo. Phasellus dignissim dolor et eleifend facilisis. Phasellus eu laoreet odio. </p>
        <div class="text-right">
            <a class ="align-right btn btn-outline-primary" href="#top">Back to Top</a>
        </div>        
        <hr class="mb-5 mt-5">      
    </div>
    <div class="container">
        <h1 class="display-5 text-muted font-weight-light mb-4" id="how-to-editor">How do I use the editor?</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin a nunc viverra, ullamcorper odio ut, luctus ante. Aliquam at ipsum sem. Donec accumsan vel odio eu tristique. Curabitur dignissim eleifend est vitae gravida. Donec placerat a tellus ut ultricies. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed in dui faucibus, iaculis diam nec, tincidunt mauris. Integer vel dui vitae ligula ullamcorper venenatis ut sit amet magna. Ut ut lacinia risus. Pellentesque iaculis libero sapien. Aliquam volutpat, odio ut hendrerit tristique, nulla ex lobortis ante, eleifend mollis quam massa vitae leo. Morbi egestas bibendum diam at commodo. Phasellus dignissim dolor et eleifend facilisis. Phasellus eu laoreet odio. </p>
        <div class="text-right">
            <a class ="align-right btn btn-outline-primary" href="#top">Back to Top</a>
        </div>        
        <hr class="mb-5 mt-5">      
    </div>
    <div class="container">
        <h1 class="display-5 text-muted font-weight-light mb-4" id="how-to-plan">How do I change my plan?</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin a nunc viverra, ullamcorper odio ut, luctus ante. Aliquam at ipsum sem. Donec accumsan vel odio eu tristique. Curabitur dignissim eleifend est vitae gravida. Donec placerat a tellus ut ultricies. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed in dui faucibus, iaculis diam nec, tincidunt mauris. Integer vel dui vitae ligula ullamcorper venenatis ut sit amet magna. Ut ut lacinia risus. Pellentesque iaculis libero sapien. Aliquam volutpat, odio ut hendrerit tristique, nulla ex lobortis ante, eleifend mollis quam massa vitae leo. Morbi egestas bibendum diam at commodo. Phasellus dignissim dolor et eleifend facilisis. Phasellus eu laoreet odio. </p>
        <div class="text-right">
            <a class ="align-right btn btn-outline-primary" href="#top">Back to Top</a>
        </div>        
        <hr class="mb-5 mt-5">      
    </div>
    <div class="container">
        <h1 class="display-5 text-muted font-weight-light mb-4" id="how-to-manage">How do I use the website manager?</h1>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin a nunc viverra, ullamcorper odio ut, luctus ante. Aliquam at ipsum sem. Donec accumsan vel odio eu tristique. Curabitur dignissim eleifend est vitae gravida. Donec placerat a tellus ut ultricies. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed in dui faucibus, iaculis diam nec, tincidunt mauris. Integer vel dui vitae ligula ullamcorper venenatis ut sit amet magna. Ut ut lacinia risus. Pellentesque iaculis libero sapien. Aliquam volutpat, odio ut hendrerit tristique, nulla ex lobortis ante, eleifend mollis quam massa vitae leo. Morbi egestas bibendum diam at commodo. Phasellus dignissim dolor et eleifend facilisis. Phasellus eu laoreet odio. </p>
        <div class="text-right">
            <a class ="align-right btn btn-outline-primary" href="#top">Back to Top</a>
        </div>
        <hr class="mb-5 mt-5">      
    </div>
    <div class="container mb-5">
        <h1 class="display-5 text-muted font-weight-light mb-4" id="how-to-contact">How do I contact support?</h1>
        <p>Our experts are here to help 24/7.</p>
        <p>You can reach us by phone at: 1-800-555-5555</p>
        <p><a href="" data-toggle="modal" data-target="#email">Click here to send message</a></p>

        <div class="text-right">
            <a class ="align-right btn btn-outline-primary" href="#top">Back to Top</a>
        </div>
    </div>
       
    <!-- Modal -->
    <div class="modal fade" id="email" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" style="border:none;">
                <div class="modal-header bg-primary">
                    <img src="img/contact-us.png" style="width: 25%;" alt="contact-us">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" style="color:white;">&times;</span>
                </div>
            <div class="modal-body">
                <div class="container mt-3">
                    <?php
                        include "contact.php";
                    ?>  
                </div>
            </div>  
        </div>
    </div>
    
    
    
    
    <!-- Page Content End -->
    <!-- Footer -->
    <footer id="sticky-footer" class="py-4 bg-dark text-white-50 fixed-bottom">
        <div class="container text-center">
            <small>Copyright &copy; Brix.ca</small>
        </div>
    </footer>

    
</body>

</html>