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

<?php
require_once('../model/model.php');
include ('../utilities/utilities.php');
$config = require('../config/config.php');
$model = new Model();
if (!isset($_SESSION)) {
    session_start();
}


try {
    $component = NULL;
    if (isset($_GET['website'])) {
        $component = $model -> getComponents($_GET['website']);
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

var str = <?php echo json_encode($component); ?> ;
var components = JSON.parse(str) ;



      $('#editor-user-page').hide();

$(document).ready(function() {
    showChanges();
});

      components
      // When sidebar item is clicked
      // $('#sidebarList li').on('click', function (e) {
      //   $( "#sidebarList li" ).removeClass("active")
      //   $(this).addClass("active")
      // )

      $(document).on('click', '.text-enter-button', function(){
        let text =  $('#userText').val();
        $('#textModal').modal('hide')
        components.push(text)
        showChanges();
      });


      $(document).on('click','.save-editor-changes',function() {
        // $.post("../controller/controller.php",
        // {COMMAND: "SAVE-EDITOR", WEBPAGE: "<?php echo $_GET['website'] ?>", COMPONENTS: JSON.stringify(components)}, function(data,status) {
        //   alert(data);
        // }
        // )
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          console.log(this.responseText);
        }
          };
        var url = "<?php echo $config['home-file-path']; ?>/controller/controller.php"
        console.log(url);
        xhttp.open("POST",url,true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        var webpage_id = "<?php echo $_GET['website']; ?> ";
        if(!isNaN(webpage_id)) {
          xhttp.send("COMMAND=SAVE-EDITOR&WEBPAGE=" + webpage_id + "&COMPONENTS=" + encodeURI(JSON.stringify(components)));
        } 
        
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
	  
	  //drag and drop stuff
	  
function allowDrop(ev) {
  ev.preventDefault();
}

function drag(ev) {
  ev.dataTransfer.setData("text", ev.target.id);
}

function drop(ev) {
  //ev.preventDefault();
  //var data = ev.dataTransfer.getData("text");
  //ev.target.appendChild(document.getElementById(data));
  
          $('#textModal').modal('show')

  
}
	  
	  
	  
	  

    </script>
</head>
<body>

<!-- Nav Bar -->
<?php include 'navbar.php' ?>



<!-- Editor -->
<div class="row">
    <!-- Side bar -->
    <div class="col" id="sidebar">
      <ul class="list-group" id="sidebarList">
        <li class="list-group-item list-group-item-action" id="text-sidebar-button" data-toggle="modal" data-target="#textModal" draggable="true" ondragstart=drag(event)">
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
          <button type="button" class="btn btn-outline-success mr-2 save-editor-changes">Save</button>
          <button type="button" class="btn btn-outline-info">Preview</button>
        </div>
        
      </div>

      <div class="jumbotron mt-3 mr-4 visible" id="editor-user-page" ondrop="drop(event)" ondragover="allowDrop(event)">
      
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
