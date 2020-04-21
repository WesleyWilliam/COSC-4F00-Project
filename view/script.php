var str = <?php echo json_encode($component); ?>;
try {
  var webpages = JSON.parse(str);
} catch (err) {
  alert("Something went wrong with loading the editor");
}

var currentWebpage = 'homepage';
var editorComponents = webpages['webpages'][currentWebpage];
var footerComponents = webpages['footer'];
var componentParent; //when an element is clicked, we need to know which area it was clicked on in order to edit/delete it
var sortedIDs;
var editor = null;
var index; //this index is used to keep track of which element is currently selected on the page
var indexGrid; //this index is used to keep track of which grid element is currently selected on the page
var preventModal = false;
var secGridClicked = false;

$('#editor-user-page').hide();
$(document).ready(function () {
  showChanges();
  $(".save-webpage-alert").hide();
});

$(function () {
  var startingItem;
  var temp;

  $(".editable-area").sortable({

    axis: "y",

    start: function (e, ui) {
      startingItem = ui.item.index();
      var startingParent = ui.item.closest('.editable-area').attr('id');


      if (startingParent === "editor-user-page") {
        temp = editorComponents.splice(startingItem, 1);
      }
      else if (startingParent == "footer-user-page") {
        temp = footerComponents.splice(startingItem, 1);
      }

      // delete from editorComponents array on start
      // put it somewhere temporarily
      //place it wherever its supposed to go on drop


    },

    stop: function (e, ui) {
      var stoppingParent = ui.item.closest('.editable-area').attr('id');

      var stoppingItem = ui.item.index();

      if (stoppingParent === "editor-user-page") {
        editorComponents.splice(stoppingItem, 0, temp[0]);
      }
      else if (stoppingParent == "footer-user-page") {
        footerComponents.splice(stoppingItem, 0, temp[0]);
      }


      showChanges();


    }
  }); //when sorting stops, the sortedIDs are updated


  $("#sidebarList > li").draggable({
    
    helper: 'clone',
    appendTo: '#sidebar',
    scroll: false,
    revert: true,
    revertDuration: 0,


  }); //make sidebar draggable


  $(".editable-area").droppable({



    drop: function (e, ui) {

      var dropped = ui.draggable.attr("id");
      var theParent = $(this).attr('id');
      componentParent = theParent;
      console.log("theparent: " + theParent);

      var component = null;
      switch (dropped) {
        case 'text-sidebar-button':
          component = makeTextComponent();
          break;
        case 'image-sidebar-button':
          component = makeImageComponent();
          break;
        case 'embeddedcontent-sidebar-button':
          component = makeMediaComponent();
          break;
        case 'paragraph-sidebar-button':
          component = makeParagraphComponent();
          break;
        case 'html-sidebar-button':
          component = makeHTMLComponent();
          break;
        case 'grid-sidebar-button':
          component = makeGridComponent();
          break;
        case 'button-sidebar-button':
          component = makeButtonComponent();
          break;
        case 'spacer-sidebar-button':
          component = makeSpacerComponent();
          break;
        case 'divider-sidebar-button':
          component = makeDividerComponent();
          break;
      }
      if (component != null) {

        if (theParent === "editor-user-page") {
          editorComponents.push(component);

        }
        else if (theParent == "footer-user-page") {
          footerComponents.push(component);

        }


        showChanges();
      }
    }

  }); //make editor droppable

  $(document).on("click", "#sidebarMinimize", function () {
    $("#sidebar").toggle();

  });




  $(document).on("click", ".component", function () {

    console.log("Component clicked")
    console.log("Prevent modal: " + preventModal)

    if (preventModal) {
      preventModal = false;
      return;
    } else if (secGridClicked) {
      secGridClicked = false
      return;
    }

    componentParent = $(this).closest('.editable-area').attr('id');
    console.log("componentParent " + componentParent);

    var tempComponents;

    if (componentParent == "editor-user-page") {
      tempComponents = editorComponents;
    }

    if (componentParent == "footer-user-page") {
      tempComponents = footerComponents;
    }

    console.log("id " + $(this).attr("id"));
    var id = $(this).attr("id");
    var type = tempComponents[id].type;

    index = id;
    indexGrid = -1;

    switch (type) {
      case 'text':
        $('#editTextModal').modal('show');
        $('#editText').val(tempComponents[id].content);
        break;

      case 'image':
        $('#editImageModal').modal('show');
        $('#addImageURL').val(tempComponents[id].content);
        break;

      case 'media':
        $('#editMediaModal').modal('show');
        $('#editMediaURL').val(tempComponents[id].content);
        $('#editMediaWidth').val(tempComponents[id].width);
        $('#editMediaHeight').val(tempComponents[id].height);
        break;

      case 'paragraph':
        editor.setData(tempComponents[id].html);
        $('#editParagraphModal').modal('show');
        break;

      case 'html':
        $('#editHTMLModal').modal('show');
        $('#editHTML').val(tempComponents[id].content);
        break;

      case 'grid':
        $("#editGridModal").modal("show");
        $("#editGridCol").val(tempComponents[id].columns);
        break;

      case 'button':
        $('#editButtonModal').modal('show');
        $('#editButtonURL').val(tempComponents[id].url);
        $('#editButtonText').val(tempComponents[id].content);
        break;

      case 'spacer':
        $('#editSpacerModal').modal('show');
        $('#editSpacerHeight').val(tempComponents[id].height);
        break;

      case 'divider':
        $('#editDividerModal').modal('show');
        $('#editDividerHeight').val(components[id].height);
        break;


    }



    if (componentParent == "editor-user-page") {
      editorComponents = tempComponents;
    }

    if (componentParent == "footer-user-page") {
      footerComponents = tempComponents;
    }


  });
}); //used to make the elements on the page draggable, sortable, droppable, editable

function makeTextComponent() {
  var component = {
    type: "text",
    header: "h3",
    content: "Click to edit text"
  };
  return component;
};

function makeMediaComponent() {
  var component = {
    type: "media",
    height: 315,
    width: 560,
    content: "https://www.youtube.com/embed/8PNO9unyE-I"
  };
  return component;
};

function makeHTMLComponent() {
  var component = {
    type: "html",
    content: "<p> Click to edit code </p>"
  };
  return component;

};

function makeImageComponent() {
  var component = {
    type: "image",
    header: "img",
    content: "https://i.imgflip.com/3trije.jpg"
  };
  return component;
}

function makeParagraphComponent() {
  var component = {
    type: "paragraph",
    html: "<p>Click to edit paragraph<\/p>"
  }
  return component;
}

function makeGridComponent() {
  var component = {
    type: "grid",
    content: "",
    columns: 4,
    gridContent: []
  };
  return component;
}
function makeButtonComponent() {
  var component = {
    type: "button",
    url: "https://youtu.be/8PNO9unyE-I",
    content: "text here",

  };
  return component;
};

function makeSpacerComponent() {
  var component = {
    type: "spacer",
    height: "100"

  };
  return component;
};

function makeDividerComponent() {
  var component = {
    type: "divider",
    height: "100"

  };
  return component;
};




$(document).on('click', '.save-editor-changes', saveEditor);

function saveEditor () { // Save current state of the editor editorComponents
  webpages['webpages'][currentWebpage] = editorComponents;
  webpages['footer'] = footerComponents;

  $(".save-webpage-alert").show();
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      console.log(this.responseText);
    }
  };
  var url = "<?php echo $config['home-file-path']; ?>/controller/controller.php"
  xhttp.open("POST", url, true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  var website_id = "<?php echo $_GET['website']; ?> ";
  if (!isNaN(website_id)) {
    xhttp.send("COMMAND=SAVE-EDITOR&WEBSITE=" + website_id + "&WEBPAGES=" + encodeURI(JSON.stringify(webpages)));
  }
  setTimeout(function () {
    $(".save-webpage-alert").hide();
  }, 5000);
}

$(document).on('click','#publish-button',function () {
  saveEditor();
  var url = "<?php echo $config['home-file-path']; ?>/controller/controller.php";
  var form_data =new FormData();
  form_data.append("COMMAND","TOGGLE_PUBLISH");
  var webpage = "<?php if (isset($_GET['website'])) {echo $_GET['website'];} ?>";
  console.log("Website:" + webpage);
  form_data.append("WEBSITE", webpage);
  $.ajax({
    url: url,
    method: "POST",
    data: form_data,
    contentType: false,
    cache: false,
    processData: false,
    success: function (data, error) {
      console.log(data);
      console.log(error);
      var res = "";
      if (data == 'PUBLISHED') {
        res = 'Unpublish';
      } else if (data =='UNPUBLISHED') {
        res = 'Publish';
      }
      $('#publish-button').text(res);
    }
  });
})

$(document).on('change', '#imageFile', function () {
  $('#imgSpinnerModal').modal('show');
  var url = "<?php echo $config['home-file-path']; ?>/controller/imgupload.php";
  var properties = document.getElementById("imageFile").files[0];
  console.log(properties);
  var form_data = new FormData();
  form_data.append("file", properties);

  $.ajax({
    url: url,
    method: "POST",
    data: form_data,
    contentType: false,
    cache: false,
    processData: false,
    success: function (data, error) {
      $('#imgSpinnerModal').modal('hide');
      console.log(error);
      $('#editImageModal').modal('hide')
      var component = getComponent();
      if (data == "TOOBIG") {
        alert("Image is too big, make it smaller then try again");
      } else if (data == "NOTIMG") {
        alert("Not an image");
      } else if (data == "ERR") {
        alert("Error uploading image");
      } else {
        component.content = "<?php echo $config['home-file-path']; ?>/" + data;
        showChanges();
      }
      //Used to ensure you can upload two of the same photo on firefox
      $('input[type="file"]').val(null);
    }
  });
})

//Gets the component from the index and indexGrid global variables
function getComponent() {
  //indexGrid is -1 if it's not in a grid



  if (componentParent == "editor-user-page") {
    if (indexGrid == -1) {
      return editorComponents[index];
    } else {

      return editorComponents[index].gridContent[indexGrid];
    }

  }

  if (componentParent == "footer-user-page") {

    if (indexGrid == -1) {
      return footerComponents[index];
    } else {

      return footerComponents[index].gridContent[indexGrid];
    }

  }

  console.log("fuck");

}

$(document).on('click', '.text-edit-button', function () {
  let text = $('#editText').val();
  var component = getComponent();
  component.content = text;
  component.header = $("#hType").val();
  $('#editTextModal').modal('hide');




  showChanges();

})

$(document).on('click', '.image-edit-button', function () {
  let text = $('#addImageURL').val();
  $('#editImageModal').modal('hide')
  var component = getComponent();
  component.content = text;

  showChanges();
});


$(document).on('click', '.paragraph-edit-button', function () {
  let res = editor.getData();
  $('#editParagraphModal').modal('hide');
  var component = getComponent();
  component.html = editor.getData();


  showChanges();


});


$(document).on('click', '.media-edit-button', function () {
  let text = $('#editMediaURL').val();
  let height = $('#editMediaHeight').val();
  let width = $('#editMediaWidth').val();

  $('#editMediaModal').modal('hide')
      
  if (height <= 0 || width <= 0) return;
      
  var component = getComponent();

  text = text.replace("youtube.com/watch?v=", "youtube.com/embed/")

  component.content = text;
  component.height = height;
  component.width = width;

  showChanges();
})

$(document).on('click', '.html-edit-button', function () {
  let code = $('#editHTML').val();
  $('#editHTMLModal').modal('hide')
  var component = getComponent();

  component.content = code;

  showChanges();
})

$(document).on("click", ".grid-edit-button", function () {
  let columns = $("#editGridCol").val();
  $("#editGridModal").modal("hide");
  var component = getComponent();


  component.columns = columns;
  component.gridContent = [];

  showChanges();
});

$(document).on('click', '.add-webpage-button', function () {
  $('#addWebpageModal').modal('show');
})

$(document).on('click', '#delete-webpage-button', function () {
  if (currentWebpage == 'homepage') {
    alert('can\'t delete homepage');
  } else {
    $('#deleteWebpageModalBody').text("Are you sure you want to delete webpage " + currentWebpage + "?");
    $('#deleteWebpageModal').modal('show');
  }

})

$(document).on('click', '#deleteWebsiteModalButton', function () {
  var tmpWebpage = currentWebpage;
  changeWebpage('homepage');
  delete webpages['webpages'][tmpWebpage];
  displayWebpages();
  showChanges();
});

$(document).on('click', '.button-edit-button', function () {
  let url = $('#editButtonURL').val();
  let content = $('#editButtonText').val();
  let style = $('#editButtonStyle').val();
  $('#editButtonModal').modal('hide');

  var component = getComponent();

  component.url = url;
  component.content = content;
  component.style = style;

  showChanges();
})

$(document).on('click', '.spacer-edit-button', function () {
  let height = $('#editSpacerHeight').val();
  $('#editSpacerModal').modal('hide');
  
  if (height <= 0) return;
   
  var component = getComponent();

  component.height = height;

  showChanges();
})

$(document).on('click', '.divider-edit-button', function () {
  let height = $('#editDividerHeight').val();
  $('#editDividerModal').modal('hide');
  var component = getComponent();

  component.height = height;


  showChanges();
})

$(document).on('submit', '#save-webpage-form', function (e) {
  console.log("Something happened")
  e.preventDefault();
  changeWebpage($('#webpageText').val());
  $('#addWebpageModal').modal('hide');
})


$(document).on("click", ".text-component-grid", function () {

  componentParent = $(this).closest('.editable-area').attr('id');
  console.log("componentParent" + componentParent);

  preventModal = true; // To prevent parent component click listener from triggering.
  var id = $(this).attr("id");

  var idBoth = id.split("-");

  index = idBoth[0];
  indexGrid = idBoth[1];

  console.log("idBoth[0]: " + idBoth[0]);
  console.log("idBoth[1]: " + idBoth[1]);

  $('#editTextModal').modal('show');

  if (componentParent == "editor-user-page") {
    $('#editText').val(editorComponents[idBoth[0]].gridContent[idBoth[1]].content);
    $("#hType").val(editorComponents[idBoth[0]].gridContent[idBoth[1]].header);
  }

  if (componentParent == "footer-user-page") {
    $('#editText').val(footerComponents[idBoth[0]].gridContent[idBoth[1]].content);
    $("#hType").val(footerComponents[idBoth[0]].gridContent[idBoth[1]].header);
  }

});



$(document).on("click", ".media-component-grid", function () {
  console.log("Media component on the grid clicked.")
  preventModal = true; // To prevent parent component click listener from triggering.
  secGridClicked = true;
  console.log("Prevent modal: " + preventModal)
  event.preventDefault();

  componentParent = $(this).closest('.editable-area').attr('id');
  console.log("componentParent " + componentParent);

  
  var id = $(this).attr("id");
  var idBoth = id.split("-");



  index = idBoth[0];
  indexGrid = idBoth[1];


  $('#editMediaModal').modal('show');



  if (componentParent == "editor-user-page") {

    $('#editMediaURL').val(editorComponents[idBoth[0]].gridContent[idBoth[1]].content);
    $('#editMediaHeight').val(editorComponents[idBoth[0]].gridContent[idBoth[1]].height);

    $('#editMediaWidth').val(editorComponents[idBoth[0]].gridContent[idBoth[1]].width);
  }


  if (componentParent == "footer-user-page") {

    $('#editMediaURL').val(footerComponents[idBoth[0]].gridContent[idBoth[1]].content);
    $('#editMediaHeight').val(footerComponents[idBoth[0]].gridContent[idBoth[1]].height);

    $('#editMediaWidth').val(footerComponents[idBoth[0]].gridContent[idBoth[1]].width);
  }

});

$(document).on("click", ".spacer-component-grid", function () {

  componentParent = $(this).closest('.editable-area').attr('id');
  secGridClicked = true;
  preventModal = true; // To prevent parent component click listener from triggering.
  event.preventDefault();
  var id = $(this).attr("id");
  var idBoth = id.split("-");

  index = idBoth[0];
  indexGrid = idBoth[1];

if (componentParent == "editor-user-page"){
  $('#editSpacerHeight').val(editorComponents[idBoth[0]].gridContent[idBoth[1]].height);
}

if (componentParent == "footer-user-page"){
$('#editSpacerHeight').val(footerComponents[idBoth[0]].gridContent[idBoth[1]].height);
}

$('#editSpacerModal').modal('show');

});





$(document).on("click", ".image-component-grid", function () {

  componentParent = $(this).closest('.editable-area').attr('id');

  preventModal = true; // To prevent parent component click listener from triggering.
  event.preventDefault();
  var id = $(this).attr("id");
  var idBoth = id.split("-");

  index = idBoth[0];
  indexGrid = idBoth[1];

  $('#editImageModal').modal('show');
  $('#addImageURL').val(editorComponents[idBoth[0]].gridContent[idBoth[1]].content);
});





$(document).on("click", ".grid-text-add", function () {
  preventModal = true; // To prevent parent component click listener from triggering.
  event.preventDefault();
  var id = $(this).attr("id");
  var theParent = $(this).closest('.editable-area').attr('id');
  componentParent = theParent;
  var idBoth = id.split("-");

  addTextGrid(idBoth[1], idBoth[0]);




});

$(document).on("click", ".grid-image-add", function () {

  componentParent = $(this).closest('.editable-area').attr('id');

  preventModal = true; // To prevent parent component click listener from triggering.
  event.preventDefault();
  var id = $(this).attr("id");
  var idBoth = id.split("-");
  var theParent = $(this).closest('.editable-area').attr('id');
  componentParent = theParent;

  addImageGrid(idBoth[1], idBoth[0]);


});

$(document).on("click", ".grid-spacer-add", function () {

  componentParent = $(this).closest('.editable-area').attr('id');

  preventModal = true; // To prevent parent component click listener from triggering.
  event.preventDefault();
  var id = $(this).attr("id");
  var idBoth = id.split("-");
  var theParent = $(this).closest('.editable-area').attr('id');
  componentParent = theParent;

  addSpacerGrid(idBoth[1], idBoth[0]);
});

$(document).on("click", ".grid-embed-add", function () {

  componentParent = $(this).closest('.editable-area').attr('id');

  preventModal = true; // To prevent parent component click listener from triggering.
  event.preventDefault();
  var id = $(this).attr("id");
  var idBoth = id.split("-");
  var theParent = $(this).closest('.editable-area').attr('id');
  componentParent = theParent;

  addEmbedGrid(idBoth[1], idBoth[0]);
});




function addTextGrid(gridIndex, componentIndex) {

  if (componentParent == "editor-user-page") {
    var comp = editorComponents[componentIndex]
  }

  if (componentParent == "footer-user-page") {
    var comp = footerComponents[componentIndex]
  }

  comp.gridContent[gridIndex] = makeTextComponent()

  showChanges();
}


function addImageGrid(gridIndex, componentIndex) {

  if (componentParent == "editor-user-page") {
    var comp = editorComponents[componentIndex]
  }

  if (componentParent == "footer-user-page") {
    var comp = footerComponents[componentIndex]
  }

  comp.gridContent[gridIndex] = makeImageComponent()
  showChanges();
}

function addSpacerGrid(gridIndex, componentIndex) {

  if (componentParent == "editor-user-page") {
    var comp = editorComponents[componentIndex]
  }

  if (componentParent == "footer-user-page") {
    var comp = footerComponents[componentIndex]
  }
  comp.gridContent[gridIndex] = makeSpacerComponent()
  showChanges();
}

function addEmbedGrid(gridIndex, componentIndex) {

  if (componentParent == "editor-user-page") {
    var comp = editorComponents[componentIndex]
  }

  if (componentParent == "footer-user-page") {
    var comp = footerComponents[componentIndex]
  }

  comp.gridContent[gridIndex] = makeMediaComponent()
  showChanges();
}



function escapeHtml(unsafe) {
  return unsafe
       .replace(/&/g, "&amp;")
       .replace(/</g, "&lt;")
       .replace(/>/g, "&gt;")
       .replace(/"/g, "&quot;")
       .replace(/'/g, "&#039;");
}



//Function to output text component html code
function textComponentOutput(component, index) {
  return " <div id='" + index + "' class='component mb-4'   ><p class=" + component.header + ">" + escapeHtml(component.content) + "</p></div>";
}

function textComponentOutputGrid(component, gridIndex, compIndex) {
  return " <div id='" + compIndex + "-" + gridIndex + "' class='mb-4 text-component-grid' ><p class=" + component.header + ">" + component.content + "</p></div>";
}

// Function to output image component html code
function imageComponentOutput(component, index) {
  return "<div id='" + index + "' class='component mb-4'   ><img src=\"" + component.content + "\"  height=\"300\"  alt=\"description\" > </div>";
}

function imageComponentOutputGrid(component, gridIndex, compIndex) {
  return "<div  id='" + compIndex + "-" + gridIndex + "' class='mb-4 image-component-grid' ><img src=\"" + component.content + "\"  height=\"300\"  alt=\"description\" > </div>";
}

// Function to output media component html code
function mediaComponentOutput(component, index) {
  return "<div id='" + index + "' class='component mb-4'   style='padding:20px'> <iframe width='" + component.width + "' height='" + component.height + "' src=" + component.content + " frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe> </div>";
}

function mediaComponentOutputGrid(component, gridIndex, compIndex) {
  return "<div id='" + compIndex + "-" + gridIndex + "' class='component mb-4 media-component-grid' style='padding:20px'> <iframe width='" + component.width + "' height='" + component.height + "' src=" + component.content + " frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe> </div>";
}

//Function to output paragraph component html code
function paragraphComponentOutput(component, index) {
  return "<div id='" + index + "' class='component' >" + component.html + "</div>";
}

//Function to output HTML component 
function HTMLComponentOutput(component, index) {
  return "<div id='" + index + "' class='component mb-4' ><iframe id='iframe' srcdoc='" + component.content + "' sandbox></iframe></div>";
}

//Function to output button component 
function buttonComponentOutput(component, index) {
  return "<div id='" + index + "' class='component mb-4' ><a href='" + component.url + "' target='_blank' class='" + component.style + "'>" + component.content + "</a></div>"
}

//Function to output spacer component 
function spacerComponentOutput(component, index) {
  return "<div id='" + index + "' class='component mb-4' style='height:" + component.height + "px'>&nbsp;</div>"
}

function spacerComponentOutputGrid(component, gridIndex, compIndex) {
  return "<div id='" + compIndex + "-" + gridIndex + "' class='component bg-light pr-5 pl-5 mb-4 spacer-component-grid' style='height:" + component.height + "px'>&nbsp;</div>"
}

//Function to output divider component 
function dividerComponentOutput(component, index) {
  return "<div id='" + index + "' class='component mb-4' style='height:" + component.height + "px'><hr></div>"
}

// Function to output grid component html code
function gridComponentOutput(component, index) {
  var res = "";
  res +=
    "<div id='" +
    index +
    "' class='component mb-4' ><div class='row'>";

  for (x = 0; x < component.columns; x++) { // For each column
    res += "<div class='col bd-highlight d-flex align-items-center'>"
    if (component.gridContent[x] == null) {
      res += "<div class=\"dropdown\">" +
        "<button class=\"btn btn-success dropdown-toggle\" type=\"button\" id=\"dropdownMenuButton\" data-toggle=\"dropdown\" aria-haspopup=\"true\" aria-expanded=\"false\">" +
        "Add column item" +
        "</button>" +
        "<div class=\"dropdown-menu\" aria-labelledby=\"dropdownMenuButton\">" +
        "<a id=\"" + index + "-" + x + "\" class=\"dropdown-item grid-text-add\" href=\"#\">Text</a>" +
        "<a id=\"" + index + "-" + x + "\" class=\"dropdown-item grid-image-add\" href=\"#\">Image</a>" +
        "<a id=\"" + index + "-" + x + "\" class=\"dropdown-item grid-spacer-add\" href=\"#\">Spacer</a>" +
        "<a id=\"" + index + "-" + x + "\" class=\"dropdown-item grid-embed-add\" href=\"#\">Media</a>" +
        "</div>" +
        "</div>";
    } else if (component.gridContent[x].type == "text")
      res += textComponentOutputGrid(component.gridContent[x], x, index)
    else if (component.gridContent[x].type == "image")
      res += imageComponentOutputGrid(component.gridContent[x], x, index)
    else if (component.gridContent[x].type == "spacer")
      res += spacerComponentOutputGrid(component.gridContent[x], x, index);
    else if (component.gridContent[x].type == "media")
      res += mediaComponentOutputGrid(component.gridContent[x], x, index);

    res += "</div>";
  }

  res += "</div>";
  return res;
}

function getOutput(component, index) {
  switch (component.type) {
    case 'text':
      return textComponentOutput(component, index);
      break;
    case 'image':
      return imageComponentOutput(component, index);
      break;
    case 'media':
      return mediaComponentOutput(component, index);
      break;
    case 'paragraph':
      return paragraphComponentOutput(component, index);
      break;
    case 'html':
      return HTMLComponentOutput(component, index);
      break;
    case 'grid':
      return gridComponentOutput(component, index);
      break;
    case 'button':
      return buttonComponentOutput(component, index);
      break;
    case 'spacer':
      return spacerComponentOutput(component, index);
      break;
    case 'divider':
      return dividerComponentOutput(component, index);
      break;
  }
}

// Function to render changes
function showChanges() {

  $('.editable-area').empty();
  $('#editor-user-page').empty();
  $('#footer-user-page').empty();

  if (editorComponents.length == 1) {
    $('#editor-user-page').removeClass("invisible").addClass("visible");
  }

  if (footerComponents.length == 1) {
    $('#footer-user-page').removeClass("invisible").addClass("visible");
  }

  for (let i = 0; i < editorComponents.length; i++) {
    switch (editorComponents[i].type) {
      case 'text':
        $('#editor-user-page').append(textComponentOutput(editorComponents[i], i));
        break;
      case 'image':
        $('#editor-user-page').append(imageComponentOutput(editorComponents[i], i));
        break;
      case 'media':
        $('#editor-user-page').append(mediaComponentOutput(editorComponents[i], i));
        break;
      case 'paragraph':
        $('#editor-user-page').append(paragraphComponentOutput(editorComponents[i], i));
        break;
      case 'html':
        $('#editor-user-page').append(HTMLComponentOutput(editorComponents[i], i));
        break;
      case 'grid':
        $('#editor-user-page').append(gridComponentOutput(editorComponents[i], i));
        break;
      case 'button':
        $('#editor-user-page').append(buttonComponentOutput(editorComponents[i], i));
        break;
      case 'spacer':
        $('#editor-user-page').append(spacerComponentOutput(editorComponents[i], i));
        break;
      case 'divider':
        $('#editor-user-page').append(dividerComponentOutput(editorComponents[i], i));
        break;
    }
  }

  for (let i = 0; i < footerComponents.length; i++) {
    switch (footerComponents[i].type) {
      case 'text':
        $('#footer-user-page').append(textComponentOutput(footerComponents[i], i));
        break;
      case 'image':
        $('#footer-user-page').append(imageComponentOutput(footerComponents[i], i));
        break;
      case 'media':
        $('#footer-user-page').append(mediaComponentOutput(footerComponents[i], i));
        break;
      case 'paragraph':
        $('#footer-user-page').append(paragraphComponentOutput(footerComponents[i], i));
        break;
      case 'html':
        $('#footer-user-page').append(HTMLComponentOutput(footerComponents[i], i));
        break;
      case 'grid':
        $('#footer-user-page').append(gridComponentOutput(footerComponents[i], i));
        break;
      case 'button':
        $('#footer-user-page').append(buttonComponentOutput(footerComponents[i], i));
        break;
      case 'spacer':
        $('#footer-user-page').append(spacerComponentOutput(footerComponents[i], i));
        break;
      case 'divider':
        $('#footer-user-page').append(dividerComponentOutput(footerComponents[i], i));
        break;
    }
  }

  componentParent = undefined;

}

function deleteElement() {

  $('.editable-area').empty()
  if (editorComponents.length == 1) {
    $('#editor-user-page').removeClass("invisible").addClass("visible");
  }

  if (footerComponents.length == 1) {
    $('#footer-user-page').removeClass("invisible").addClass("visible");
  }

  if (componentParent == "editor-user-page") {
    if (indexGrid != -1) {
      editorComponents[index].gridContent[indexGrid] = undefined;
    } else {
      editorComponents.splice(index, 1);
    }
  }



  if (componentParent == "footer-user-page") {
    if (indexGrid != -1) {
      footerComponents[index].gridContent[indexGrid] = undefined;
    } else {
      footerComponents.splice(index, 1);
    }
  }
  index = editorComponents.length;
  indexGrid = -1;
  showChanges();

}

function changeWebpage(name) {
  webpages['webpages'][currentWebpage] = editorComponents;
  currentWebpage = name;
  if (typeof webpages['webpages'][currentWebpage] == 'undefined') {
    webpages['webpages'][currentWebpage] = [];
  }
  editorComponents = webpages['webpages'][currentWebpage];
  displayWebpages();
  showChanges();
}

function displayWebpages() {
  $('#webpages-nav-list').empty();
  Object.keys(webpages['webpages']).forEach(function (value, index) {
    var isCurrent = false;
    if (value === currentWebpage) {
      isCurrent = true;
    }
    var htmlText = '<li class="nav-item active"><a onclick="changeWebpage(\''
      + value + '\')" class="nav-link">' + (isCurrent ? '<b>' : '') + value + (isCurrent ? '</b>' : '') + '</a></li>';
    $('#webpages-nav-list').append(htmlText);
  });
  var finalEl = '<li class="nav-item active"><a class="nav-link add-webpage-button">+</a></li>';
  $('#webpages-nav-list').append(finalEl);
}

$('#webpages-nav-list').ready(function () {
  displayWebpages();
})
