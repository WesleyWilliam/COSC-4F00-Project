#!/usr/bin/php-cgi
<!DOCTYPE html>
<html>
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Local CSS -->
    <style>

    </style>

    <!-- Including bootstrap CSS files -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <!-- Icons -->
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script> 
    <!-- Jquery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

    <!-- Javascript code -->
    <script>

      var components = [];

      $('#editor-user-page').hide();

      components
      // When sidebar item is clicked
      // $('#sidebarList li').on('click', function (e) {
      //   $( "#sidebarList li" ).removeClass("active")
      //   $(this).addClass("active")
      // })

      $(document).on('click', '.text-enter-button', function(){
        let text =  $('#userText').val();
        $('#textModal').modal('hide')
        components.push(text)
        showChanges();
      })



      // Function to render changes
      function showChanges() {
        $('#editor-user-page').empty()
        if (components.length == 1) {
          $('#editor-user-page').removeClass("invisible").addClass("visible");
        }
        for (let i = 0; i < components.length; i++) {
          $('#editor-user-page').append("<h2>" + components[i] + "</h2>")
        }
      }

    </script>
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
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">
  <img src=".\cms_logo.svg" width="30" height="30" alt="">
  CMS
  </a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
        <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Features</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Subscriptions
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Premium Plans</a>
          <a class="dropdown-item" href="#">Standard Plans</a>
          <a class="dropdown-item" href="#">Free Content</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Domains</a>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#">Editor</a>
      </li>
    </ul>
  </div>
</nav>



<!-- Editor -->
<div class="row">
    <!-- Side bar -->
    <div class="col" id="sidebar">
      <ul class="list-group" id="sidebarList">
        <li class="list-group-item list-group-item-action" id="text-sidebar-button" data-toggle="modal" data-target="#textModal">
          <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
          <span>Text</span>
          
          <i data-feather="align-justify"></i>
          </div>
        </li>
        <li class="list-group-item list-group-item-action">
          <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
          <span>Image</span>
          
          <i data-feather="image"></i>
          </div>
        </li>
        <li class="list-group-item list-group-item-action">
          <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
          <span>Link</span>
          
          <i data-feather="link"></i>
          </div>
        </li>
        <li class="list-group-item list-group-item-action">
          <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
          <span>List</span>
          
          <i data-feather="list"></i>
          </div>
        </li>
        <li class="list-group-item list-group-item-action">
          <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
          <span>Media</span>
          
          <i data-feather="film"></i>
          </div>
        </li>
        <li class="list-group-item list-group-item-action">
          <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
          <span>Layout</span>
          
          <i data-feather="layout"></i>
          </div>
        </li>
        <li class="list-group-item list-group-item-action">
          <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
          <span>Grid</span>
          
          <i data-feather="grid"></i>
          </div>
        </li>
        <li class="list-group-item list-group-item-action">
          <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
          <span>Size</span>
          
          <i data-feather="maximize"></i>
          </div>
        </li>
        <li class="list-group-item list-group-item-action">
          <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
            <span>Snippets</span>
            <i data-feather="plus"></i>
          </div>
        </li>
      </ul>
    </div>

    <!-- Editor -->
    <div class="col-10">

      <div class="d-flex justify-content-between mt-2 mr-4 pb-2 border-bottom"> 
        <div>
          <button type="button" class="btn btn-outline-info mr-2">Themes</button>
          <button type="button" class="btn btn-outline-info mr-2">Help</button>
          <button type="button" class="btn btn-outline-info">Edit</button>
        </div>
        <div>
          <button type="button" class="btn btn-outline-warning mr-2">Undo</button>
          <button type="button" class="btn btn-outline-success mr-2">Save</button>
          <button type="button" class="btn btn-outline-info">Preview</button>
        </div>
        
      </div>

      <div class="jumbotron mt-3 mr-4 invisible" id="editor-user-page">
      
      </div>
    </div>



    <div class="modal fade" id="textModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Please enter text content</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group">
                <label for="userText">Text:</label>
                <input type="text" class="form-control" id="userText">
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary text-enter-button">Save</button>
          </div>
        </div>
      </div>
    </div>

  </div>


  <script>
      feather.replace() // For icons
  </script>



<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
