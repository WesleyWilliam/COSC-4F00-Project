#!/usr/bin/php-cgi
<!DOCTYPE html>
<html>

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Local CSS -->
  <style>

/*components turn yellow on hover. Should be changed to reflect the style of the website, just wanted to add the feature*/
div.component:hover {
  background-color: yellow;
}

/*used for grid*/
.column {
  float: left;
  width: 50%;
}

  </style>

  <!-- Including bootstrap CSS files -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

  <!-- Icons -->
  <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

  <!-- Jquery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<!-- jquery ui -->
  <script src = "https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <!-- CKEditor -->
  <script src="https://cdn.ckeditor.com/ckeditor5/17.0.0/classic/ckeditor.js"></script>

  <!--Requirements -->
  <?php require_once '../utilities/requirements.php' ?>

  <?php
  try {
    $component = NULL;
    if (isset($_GET['website'])) {
      $component = $model->getWebsites($_GET['website']);
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
  <script><?php include 'script.php' ?></script> 
    

</head>

<body>

  <!-- Nav Bar -->
  <?php include 'navbar.php' ?>

  <!-- Editor -->
  <div class="row">

    <!-- Side bar -->
    <div class="col" id="sidebar" >
      <ul class="list-group" id="sidebarList" style="position:fixed; width:15%;">
        <li id="text-sidebar-button" class="list-group-item list-group-item-action">
          <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
            <span>Text</span>

            <i data-feather="align-justify"></i>
          </div>
        </li>

        <li id="image-sidebar-button" class="list-group-item list-group-item-action">
          <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
            <span>Image</span>

            <i data-feather="image"></i>
          </div>
        </li>
        <li id="grid-sidebar-button" class="list-group-item list-group-item-action">

          <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
            <span>Grid</span>

            <i data-feather="grid"></i>
          </div>
        </li>

        <li id="embeddedcontent-sidebar-button" class="list-group-item list-group-item-action">
          <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
            <span>Embedded Content</span>

            <i data-feather="film"></i>
          </div>
        </li>



        <li id="paragraph-sidebar-button" class="list-group-item list-group-item-action paragraph-sidebar" >
          <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
            <span>Rich Text</span>
            <i data-feather="align-left"></i>
          </div>
        </li>

        <li id="html-sidebar-button" li class="list-group-item list-group-item-action html-sidebar" >
          <div class="d-flex justify-content-between align-items-center mt-3 mb-3">
            <span>HTML Block</span>
            <i data-feather="code"></i>
          </div>
        </li>
      </ul>
    </div>


    <!-- Editor -->
    <div class="col-10">
      <div class="d-flex justify-content-between mt-2 mr-4 pb-2 border-bottom">
        <div>
          <a role="button" href="<?php echo $config['home-file-path']; ?>/view/themes.php" class="btn btn-outline-info mr-2 btn-link">Themes</a>
          <button type="button" class="btn btn-outline-info mr-2">Help</button>
          <button type="button" class="btn btn-outline-info">Edit</button>
          <button onclick= type="button" class="btn btn-outline-info add-webpage-button">Add Webpage</button>
        </div>
        <div>
          <button type="button" class="btn btn-outline-warning mr-2">Undo</button>
          <button type="button" class="btn btn-outline-success mr-2 save-editor-changes">Save</button>
          <button type="button" class="btn btn-outline-info preview-editor">Preview</button>
        </div>
      </div>
      <div class="alert alert-success save-webpage-alert mr-4" role="alert">
        Webpage changes saved.
      </div>
      <div class="jumbotron mt-3 mr-4 visible" id="editor-user-page" >
      </div>
    </div>

    <!-- Ensures the link in CKEditor works -->
    <style>
      :root {
        --ck-z-default: 100;
        --ck-z-modal: calc(var(--ck-z-default) + 999);
      }
    </style>

    <!-- Paragraph modal -->
    <div class="modal fade" id="editParagraphModal" role="dialog" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Rich Text</h5>
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
            <button type="button" class="btn btn-primary" onclick="deleteElement()" data-dismiss="modal">Delete</button>
            <button type="button" class="btn btn-primary paragraph-edit-button">Save</button>
          </div>
        </div>
      </div>
    </div>

    <script>
      ClassicEditor
        .create(document.querySelector('#editor'), {
          removePlugins: ['Image', 'EasyImage', 'CKFinder', "ImageCaption", "ImageStyle", "ImageToolbar", "ImageUpload", "MediaEmbed"],
          // toolbar: ['bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote']
        })
        .then(newEditor => {
          editor = newEditor;
        })
        .catch(error => {
          console.log(error);
        });
    </script>

    <!-- EditText modal -->
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
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" onclick="deleteElement()" data-dismiss="modal">Delete</button>
              <button type="button" class="btn btn-primary text-edit-button" data-dismiss="modal" aria-label="Close">Save</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- EditHTML modal -->
    <div class="modal fade" id="editHTMLModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">HTML Block</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group">
                <label for="userText">Code:</label>
                <textarea class="form-control" id="editHTML" rows="4" cols="50">
                "Code goes here"
                 </textarea>
              </div>
            </form>

            <div class="modal-footer">
              <button type="button" class="btn btn-primary" onclick="deleteElement()" data-dismiss="modal">Delete</button>
              <button type="button" class="btn btn-primary html-edit-button" data-dismiss="modal" aria-label="Close">Save</button>
            </div>
          </div>
        </div>
      </div>
    </div>


    <!-- EditImage modal-->
    <div class="modal fade" id="editImageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <label for="addImageURL">Image URL (optional)</label>
                <input type="text" class="form-control" id="addImageURL">
              </div>
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="imageFile" name="file">
                <label class="custom-file-label" for="customFile">Choose file</label>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="deleteElement()" data-dismiss="modal">Delete</button>
            <button type="button" class="btn btn-primary image-edit-button" data-dismiss="modal" aria-label="Close">Save</button>
          </div>
        </div>
      </div>
    </div>

    <!-- EditMedia modal -->
    <div class="modal fade" id="editMediaModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Embedded Content</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
              <div class="form-group">
                <label for="editMediaUrl">URL:</label>
                <input type="text" class="form-control" id="editMediaURL">
                <label for="editMediaHeight">Height:</label>
                <input type="number" class="form-control" id="editMediaHeight">
                <label for="editMediaWidth">Width:</label>
                <input type="number" class="form-control" id="editMediaWidth">

              </div>
            </form>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" onclick="deleteElement()" data-dismiss="modal">Delete</button>
              <button type="button" class="btn btn-primary media-edit-button" data-dismiss="modal" aria-label="Close">Save</button>
            </div>
          </div>
        </div>
      </div>
    </div>

  

    <!-- Edit grid -->
    <div class="modal fade" id="editGridModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Grid</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="editGridCol">Number of columns:</label>
              <select class="form-control" id="editGridCol">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
                <option value="9">9</option>
                <option value="10">10</option>
                <option value="11">11</option>
                <option value="12">12</option>
              </select>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" onclick="deleteElement()" data-dismiss="modal">Delete</button>
              <button type="button" class="btn btn-primary grid-edit-button" data-dismiss="modal" aria-label="Close">Save</button>
            </div>
          </div>
        </div>
      </div>
    </div>


    <!-- Add Webpage Modal -->
    <div class="modal fade" id="addWebpageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Webpage</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form>
            <div class="form-group">
                <label for="userText">Webpage:</label>
                <input type="text" class="form-control" id="webpageText">
              </div>
            </form>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-primary" id="save-webpage-button" data-dismiss="modal" aria-label="Close">Add</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script>
      feather.replace() // For icons
    </script>

    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</html>