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
  <!-- CKEditor -->
  <script src="https://cdn.ckeditor.com/ckeditor5/17.0.0/classic/ckeditor.js"></script>
  <?php
  require_once('../model/model.php');
  include('../utilities/utilities.php');
  $config = require('../config/config.php');
  $model = new Model();
  if (!isset($_SESSION)) {
    session_start();
  }


  try {
    $component = NULL;
    if (isset($_GET['website'])) {
      $component = $model->getComponents($_GET['website']);
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
    var str = <?php echo json_encode($component); ?>;
    var components = JSON.parse(str);
    var index; //this index is used to keep track of which element is currently selected on the page

    $('#editor-user-page').hide();

    $(document).ready(function() {
      showChanges();
      $(".save-webpage-alert").hide();
    });


    $(document).on('click', '.text-enter-button', function() { // Save changes of Text component
      let text = $('#userText').val();
      let header = $('#hType').val();

      $('#addTextModal').modal('hide')

      var component = {
        index: components.length,
        type: "text",
        header: header,
        content: text
      };

      components.push(component);
      showChanges();
    });

    $(document).on('click','.paragraph-enter-button', function() {
      let res = editor.getData();
      console.log(res);
      $('#addParagraphModal').modal('hide');
    });

    $(document).on('click','.paragraph-sidebar', function () {
      console.log("Something");
      $('#addParagraphModal').modal('show')
    });


    $(document).on('click', '.save-editor-changes', function() { // Save current state of the editor components
      $(".save-webpage-alert").show();
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          console.log(this.responseText);
        }
      };
    $document.on('click','')

      var url = "<?php echo $config['home-file-path']; ?>/controller/controller.php"
      console.log(url);
      xhttp.open("POST", url, true);
      xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      var webpage_id = "<?php echo $_GET['website']; ?> ";
      if (!isNaN(webpage_id)) {
        xhttp.send("COMMAND=SAVE-EDITOR&WEBPAGE=" + webpage_id + "&COMPONENTS=" + encodeURI(JSON.stringify(components)));
      }
      setTimeout(function() {
        $(".save-webpage-alert").hide();
      }, 5000);
    })

    $(document).on('click', '.image-add-button', function() { // Add image component
      $('#addImageModal').modal('hide')

      var component = {
        index: components.length,
        type: "image",
        header: "img",
        content: "https://imagesvc.meredithcorp.io/v3/mm/image?url=https%3A%2F%2Fstatic.onecms.io%2Fwp-content%2Fuploads%2Fsites%2F12%2F2016%2F11%2FGettyImages-155781839-2000.jpg"
      };

      components.push(component);
      showChanges();

    })

    $(document).on('click', '.text-edit-button', function() { 
      let text = $('#editText').val();
      $('#editTextModal').modal('hide')
      components[index].content = text;
      showChanges();
    })

    $(document).on('click', '.image-edit-button', function() { 
      $('#editTextModal').modal('hide')
      showChanges();
    })
    

    //Function to output text component html code
    function textComponentOutput(component) {
      var res = "";
      //component.head1 + component.index + component.head2 + component.content + components.tail
      res += "<p class=" + component.header + " " + "onclick ='editText(" + component.index + ")'>" + component.content + "</p>";
      return res;
    }

    // Function to output image component html code
    function imageComponentOutput(component) {
      var res = "";
      res += "<img src=\"" + component.content + "\" onclick =\"editImage(" + component.index + ")\" height=\"300\"  alt=\"description\" >";
      return res;
    }


    // Function to render changes
    function showChanges() {
      $('#editor-user-page').empty()
      if (components.length == 1) {
        $('#editor-user-page').removeClass("invisible").addClass("visible");
      }
      for (let i = 0; i < components.length; i++) {
        switch (components[i].type) {
          case 'text':
            $('#editor-user-page').append(textComponentOutput(components[i]));
            break;
          case 'image':
            $('#editor-user-page').append(imageComponentOutput(components[i]));
            break;
            
        }

      }

    }

    //drag and drop stuff
    function allowDrop(ev) {
      ev.preventDefault();
    }

    function dragText(ev) {
      ev.dataTransfer.setData("component", "text");
    }
    function dragImage(ev) {
      ev.dataTransfer.setData("component", "image");
    }

    function drop(ev) {
      ev.preventDefault();
      var component = ev.dataTransfer.getData("component")
      if (component == "text") {
        $('#addTextModal').modal('show')
      } else if (component == "image") {
        $('#addImageModal').modal('show')
      }
    }

    function editText(i) {
      index = i;
      $('#editTextModal').modal('show')
    }

    function editImage(i) {
      index = i;
      $('#editImageModal').modal('show')
    }

    function deleteElement() {
      $('#editor-user-page').empty()
      if (components.length == 1) {
        $('#editor-user-page').removeClass("invisible").addClass("visible");
      }
      components.splice(index, 1);
      showChanges();
      index = components.length;
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
        <li class="list-group-item list-group-item-action" draggable="true" ondragstart="dragText(event)">
          <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
            <span>Text</span>

            <i data-feather="align-justify"></i>
          </div>
        </li>

        <li class="list-group-item list-group-item-action" draggable="true" ondragstart="dragImage(event)">
          <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
            <span>Image</span>

            <i data-feather="image"></i>
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
        <li class="list-group-item list-group-item-action paragraph-sidebar" id="paragraph-sidebar-button" data-toggle="modal" data-target="#textModal" draggable="true" ondragstart="drag(event)">
          <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
            <span>Paragraph</span>
            <i data-feather="align-left"></i>
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
      <div class="alert alert-success save-webpage-alert mr-4" role="alert">
        Webpage changes saved.
      </div>
      <div class="jumbotron mt-3 mr-4 visible" id="editor-user-page" ondrop="drop(event)" ondragover="allowDrop(event)">

      </div>

    </div>

    <!-- Text Modal -->
    <div class="modal fade" id="addTextModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
              <div class="form-group">
                <label for="hType">Select Header:</label>
                <select class="form-control" id="hType">
                  <option class="display-3" value="display-3">Title</option>
                  <option class="h3" value="h3">Subtitle</option>
                  <option class="p" value="p">Body</option>
                  <option class="text-muted" value="text-muted">Muted</option>
                  <option class="text-monospace" value="text-monospace">Monospaced</option>
                </select>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary text-enter-button">Save</button>
          </div>
        </div>
      </div>
    </div>

    <div class="modal fade" id="addParagraphModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Please enter Paragraph content</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div id="editor">
              <p>This is some sample content.</p>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary paragraph-enter-button">Save</button>
          </div>
        </div>
      </div>
    </div>

    <script>
        let editor;
        ClassicEditor
            .create(document.querySelector('#editor'), {
                removePlugins: ['Image', 'EasyImage', 'CKFinder', "ImageCaption", "ImageStyle", "ImageToolbar", "ImageUpload", "MediaEmbed", "Table", "TableToolbar"],
                // toolbar: ['bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote']
            })
            .then(newEditor => {
                editor = newEditor;
            })
            .catch(error => {
                console.log(error);
            });
    </script>

    <div class="modal fade" id="editTextModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Text</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group">
                <label for="userText">Text:</label>
                <input type="text" class="form-control" id="editText">
              </div>
            </form>

            <button type="button" class="btn btn-primary" onclick="deleteElement()" data-dismiss="modal">Delete</button>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary text-edit-button" data-dismiss="modal" aria-label="Close">Save</button>
          </div>
        </div>
      </div>
    </div>

    <!-- Image modal -->
    <div class="modal fade" id="addImageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Image</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group">
                <label for="userText">Image URL (optional)</label>
                <input type="text" class="form-control" id="addImageURL">
              </div>
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="imageFile">
                <label class="custom-file-label" for="customFile">Choose file</label>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary image-add-button" data-dismiss="modal" aria-label="Close">Save</button>
          </div>
        </div>
      </div>
    </div>


    <!-- Edit image modal -->
    <div class="modal fade" id="editImageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Image</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group">
                <label for="userText">Image URL (optional)</label>
                <input type="text" class="form-control" id="addImageURL">
              </div>
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="imageFile">
                <label class="custom-file-label" for="customFile">Choose file</label>
              </div>
            </form>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary image-edit-button" data-dismiss="modal" aria-label="Close">Save</button>
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