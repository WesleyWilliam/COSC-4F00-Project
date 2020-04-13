var str = <?php echo json_encode($component); ?>;
var webpages = JSON.parse(str);
var currentWebpage = 'homepage';
var components = webpages[currentWebpage];
var sortedIDs;
var editor = null;
var index; //this index is used to keep track of which element is currently selected on the page
var indexGrid; //this index is used to keep track of which grid element is currently selected on the page
var preventModal = false;

$('#editor-user-page').hide();
$(document).ready(function () {
  showChanges();
  $(".save-webpage-alert").hide();
});

$(function () {
  var startingItem;


  $('#editor-user-page').sortable({

    axis: "y",

    start: function (e, ui) {
      sortedIDs = $("#editor-user-page").sortable("toArray");
      startingItem = ui.item.index();
    },

    stop: function (e, ui) {
      sortedIDs = $("#editor-user-page").sortable("toArray");
      var stoppingItem = ui.item.index();
      var temp = components.splice(startingItem, 1);
      components.splice(stoppingItem, 0, temp[0]);
      showChanges();


    }
  }); //when sorting stops, the sortedIDs are updated


  $("#sidebarList > li").draggable({
    helper: 'clone',
    revert: true,
    revertDuration: 0


  }); //make sidebar draggable


  $("#editor-user-page").droppable({

    drop: function (e, ui) {

      var dropped = ui.draggable.attr("id");

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
        components.push(component);
        showChanges();
      }
    }

  }); //make editor droppable

  $(document).on("click", "#sidebarMinimize", function () {
    $("#sidebar").toggle();

  });




  $(document).on("click", ".component", function () {
    if (preventModal) {
      preventModal = false;
      return;
    }
    console.log("id " + $(this).attr("id"));
    var id = $(this).attr("id");
    var type = components[id].type;

    index = id;
    indexGrid = -1;
    switch (type) {
      case 'text':
        $('#editTextModal').modal('show');
        $('#editText').val(components[id].content);
        break;

      case 'image':
        $('#editImageModal').modal('show');
        $('#addImageURL').val(components[id].content);
        break;

      case 'media':
        $('#editMediaModal').modal('show');
        $('#editMediaURL').val(components[id].content);
        $('#editMediaWidth').val(components[id].width);
        $('#editMediaHeight').val(components[id].height);
        break;

      case 'paragraph':
        editor.setData(components[id].html);
        $('#editParagraphModal').modal('show');
        break;

      case 'html':
        $('#editHTMLModal').modal('show');
        $('#editHTML').val(components[id].content);
        break;

      case 'grid':
        $("#editGridModal").modal("show");
        $("#editGridCol").val(components[id].columns);
        break;

      case 'button':
        $('#editButtonModal').modal('show');
        $('#editButtonURL').val(components[id].url);
        $('#editButtonText').val(components[id].content);
        break;

      case 'spacer':
        $('#editSpacerModal').modal('show');
        $('#editSpacerHeight').val(components[id].height);
        break;

      case 'divider':
        $('#editDividerModal').modal('show');
        break;


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

function makeBlankComponent() { // Used for grid
  var component = {
    type: "blank",
    content: ""
  };
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
    type: "divider"
  };
  return component;
};




$(document).on('click', '.save-editor-changes', function () { // Save current state of the editor components
  webpages[currentWebpage] = components;
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
  console.log(indexGrid);
  //indexGrid is -1 if it's not in a grid
  if (indexGrid == -1) {
    return components[index];
  } else {
    return components[index].gridContent[indexGrid];
  }
}

$(document).on('click', '.text-edit-button', function () {
  let text = $('#editText').val();
  $('#editTextModal').modal('hide');
  var component = getComponent();
  component.content = text;
  component.header = $("#hType").val();
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
  components[index].html = editor.getData();
  showChanges();
});


$(document).on('click', '.media-edit-button', function () {
  let text = $('#editMediaURL').val();
  let height = $('#editMediaHeight').val();
  let width = $('#editMediaWidth').val();

  $('#editMediaModal').modal('hide')
  text = text.replace("youtube.com/watch?v=", "youtube.com/embed/")
  components[index].content = text;
  components[index].height = height;
  components[index].width = width;
  showChanges();
})

$(document).on('click', '.html-edit-button', function () {
  let code = $('#editHTML').val();
  $('#editHTMLModal').modal('hide')
  components[index].content = code;
  showChanges();
})

$(document).on("click", ".grid-edit-button", function () {
  let columns = $("#editGridCol").val();
  $("#editGridModal").modal("hide");
  components[index].columns = columns;
  components[index].gridContent = [];
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
  delete webpages[tmpWebpage];
  displayWebpages();
});

$(document).on('click', '.button-edit-button', function () {
  let url = $('#editButtonURL').val();
  let content = $('#editButtonText').val();
  let style = $('#editButtonStyle').val();
  $('#editButtonModal').modal('hide');
  components[index].url = url;
  components[index].content = content;
  components[index].style = style;

  showChanges();
})

$(document).on('click', '.spacer-edit-button', function () {
  let height = $('#editSpacerHeight').val();
  $('#editSpacerModal').modal('hide');
  components[index].height = height;

  showChanges();
})

$(document).on('click', '.divider-edit-button', function () {
  $('#editDividerModal').modal('hide');
  showChanges();
})

$(document).on('submit', '#save-webpage-form', function (e) {
  e.preventDefault();
  changeWebpage($('#webpageText').val());
  $('#addWebpageModal').modal('hide');
})


$(document).on("click", ".text-component-grid", function () {
  preventModal = true; // To prevent parent component click listener from triggering.
  event.preventDefault();
  var id = $(this).attr("id");
  var idBoth = id.split("-");

  index = idBoth[0];
  indexGrid = idBoth[1];

  $('#editTextModal').modal('show');
  $('#editText').val(components[idBoth[0]].gridContent[idBoth[1]].content);
  $("#hType").val(components[idBoth[0]].gridContent[idBoth[1]].header);

});



$(document).on("click", ".image-component-grid", function () {
  preventModal = true; // To prevent parent component click listener from triggering.
  event.preventDefault();
  var id = $(this).attr("id");
  var idBoth = id.split("-");

  index = idBoth[0];
  indexGrid = idBoth[1];

  $('#editImageModal').modal('show');
  $('#addImageURL').val(components[idBoth[0]].gridContent[idBoth[1]].content);
});

$(document).on("click", ".grid-text-add", function () {
  preventModal = true; // To prevent parent component click listener from triggering.
  event.preventDefault();
  var id = $(this).attr("id");
  var idBoth = id.split("-");

  addTextGrid(idBoth[1], idBoth[0]);




});

$(document).on("click", ".grid-image-add", function () {
  preventModal = true; // To prevent parent component click listener from triggering.
  event.preventDefault();
  var id = $(this).attr("id");
  var idBoth = id.split("-");

  addImageGrid(idBoth[1], idBoth[0]);


});

$(document).on("click", ".grid-blank-add", function () {
  preventModal = true; // To prevent parent component click listener from triggering.
  event.preventDefault();
  var id = $(this).attr("id");
  var idBoth = id.split("-");

  addBlankGrid(idBoth[1], idBoth[0]);
});

$(document).on("click", ".grid-embed-add", function () {
  preventModal = true; // To prevent parent component click listener from triggering.
  event.preventDefault();
  var id = $(this).attr("id");
  var idBoth = id.split("-");

  addEmbedGrid(idBoth[1], idBoth[0]);
});




function addTextGrid(gridIndex, componentIndex) {
  var comp = components[componentIndex]
  comp.gridContent[gridIndex] = makeTextComponent()
  showChanges();
}


function addImageGrid(gridIndex, componentIndex) {
  var comp = components[componentIndex]
  comp.gridContent[gridIndex] = makeImageComponent()
  showChanges();
}

function addBlankGrid(gridIndex, componentIndex) {
  var comp = components[componentIndex]
  comp.gridContent[gridIndex] = makeBlankComponent()
  showChanges();
}

function addEmbedGrid(gridIndex, componentIndex) {
  var comp = components[componentIndex]
  comp.gridContent[gridIndex] = makeMediaComponent()
  showChanges();
}

//Function to output text component html code
function textComponentOutput(component, index) {
  return " <div id='" + index + "' class='component mb-4'   ><p class=" + component.header + ">" + component.content + "</p></div>";
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
  return "<div id='" + index + "' class='component mb-4'   > <iframe width='" + component.width + "' height='" + component.height + "' src=" + component.content + " frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe> </div>";
}

function mediaComponentOutputGrid(component, gridIndex, compIndex) {
  return "<div id='" + compIndex + "-" + gridIndex + "' class='component mb-4'  draggable='true' > <iframe width='" + component.width + "' height='" + component.height + "' src=" + component.content + " frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe> </div>";
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

//Function to output divider component 
function dividerComponentOutput(component, index) {
  return "<div id='" + index + "' class='component mb-4'style='height:100px'><hr></div>"
}

// Function to output grid component html code
function gridComponentOutput(component, index) {
  var res = "";
  res +=
    "<div id='" +
    index +
    "' class='component mb-4' draggable='true' ondragstart='dragGrid(event)'><div class='row'>";

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
        "<a id=\"" + index + "-" + x + "\" class=\"dropdown-item grid-blank-add\" href=\"#\">Blank</a>" +
        "<a id=\"" + index + "-" + x + "\" class=\"dropdown-item grid-embed-add\" href=\"#\">Media</a>" +
        "</div>" +
        "</div>";
    } else if (component.gridContent[x].type == "text")
      res += textComponentOutputGrid(component.gridContent[x], x, index)
    else if (component.gridContent[x].type == "image")
      res += imageComponentOutputGrid(component.gridContent[x], x, index)
    else if (component.gridContent[x].type == "blank")
      res += ""
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

  $('#editor-user-page').empty()
  if (components.length == 1) {
    $('#editor-user-page').removeClass("invisible").addClass("visible");
  }

  for (let i = 0; i < components.length; i++) {
    switch (components[i].type) {
      case 'text':
        $('#editor-user-page').append(textComponentOutput(components[i], i));
        break;
      case 'image':
        $('#editor-user-page').append(imageComponentOutput(components[i], i));
        break;
      case 'media':
        $('#editor-user-page').append(mediaComponentOutput(components[i], i));
        break;
      case 'paragraph':
        $('#editor-user-page').append(paragraphComponentOutput(components[i], i));
        break;
      case 'html':
        $('#editor-user-page').append(HTMLComponentOutput(components[i], i));
        break;
      case 'grid':
        $('#editor-user-page').append(gridComponentOutput(components[i], i));
        break;
      case 'button':
        $('#editor-user-page').append(buttonComponentOutput(components[i], i));
        break;
      case 'spacer':
        $('#editor-user-page').append(spacerComponentOutput(components[i], i));
        break;
      case 'divider':
        $('#editor-user-page').append(dividerComponentOutput(components[i], i));
        break;
    }
  }
}

function deleteElement() {
  $('#editor-user-page').empty()
  if (components.length == 1) {
    $('#editor-user-page').removeClass("invisible").addClass("visible");
  }
  components.splice(index, 1);
  showChanges();
  index = components.length;
  indexGrid = -1;
}

$(document).on('click', '.preview-editor', function () {
  const new_page = $('#editor-user-page').html();
  var strWindowFeatures = "dependent=yes,menubar=yes,location=yes,resizable=yes,scrollbars=yes,status=yes";

  let myWindow = window.open("view-webpage.html", "newWindow", strWindowFeatures);

  myWindow.onload = function () {
    myWindow.document.getElementById('main-body').innerHTML = new_page;
  }

})

function changeWebpage(name) {
  webpages[currentWebpage] = components;
  currentWebpage = name;
  if (typeof webpages[currentWebpage] == 'undefined') {
    webpages[currentWebpage] = [];
  }
  components = webpages[currentWebpage];
  displayWebpages();
  showChanges();
}

function displayWebpages() {
  $('#webpages-nav-list').empty();
  Object.keys(webpages).forEach(function (value, index) {
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