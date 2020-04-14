var str = <?php echo json_encode($component); ?>;
var webpages = JSON.parse(str);
var currentWebpage = 'homepage';
var editorComponents = webpages['webpages'][currentWebpage];
var footerComponents = webpages['footer'];
var componentParent; //when an element is clicked, we need to know which area it was clicked on in order to edit/delete it
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
//  var startingParent;
  var temp;
  
  //var theParent;


  $(".editable-area").sortable({

    axis: "y",

    start: function (e, ui) {
      startingItem = ui.item.index();
     var startingParent = ui.item.parent().attr('id');
  //    sortedIDs = $("#" + startingParent).sortable("toArray");


      if (startingParent === "editor-user-page"){
       temp = editorComponents.splice(startingItem, 1);
    //  editorComponents.splice(stoppingItem, 0, temp[0]);
      }
      else if (startingParent == "footer-user-page"){
         temp = footerComponents.splice(startingItem, 1);
     // footerComponents.splice(stoppingItem, 0, temp[0]);
      }

// delete from editorComponents array on start
// put it somewhere temporarily
//place it wherever its supposed to go on drop


    },

    stop: function (e, ui) {
      var stoppingParent = ui.item.parent().attr('id');
     console.log("work " +  stoppingParent);

   //   sortedIDs = $("#"+stoppingParent).sortable("toArray");
      var stoppingItem = ui.item.index();

      if (stoppingParent === "editor-user-page"){
     // var temp = editorComponents.splice(startingItem, 1);
      editorComponents.splice(stoppingItem, 0, temp[0]);
      }
      else if (stoppingParent == "footer-user-page"){
     //   var temp = footerComponents.splice(startingItem, 1);
     footerComponents.splice(stoppingItem, 0, temp[0]);
      }


      showChanges();


    }
  }); //when sorting stops, the sortedIDs are updated


  $("#sidebarList > li").draggable({
    revert: true,
    revertDuration: 0


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
      if (component!=null) {
//        editorComponents.push(component);

        if (theParent === "editor-user-page"){
          editorComponents.push(component);

      }
      else if (theParent == "footer-user-page"){
        footerComponents.push(component);

      }


        showChanges();
       // componentParent = undefined;
      }
    }

  }); //make editor droppable



  $(document).on("click", ".component", function () {



    if (preventModal) {
      preventModal = false;
      return;
    }

    componentParent = $(this).parent().attr('id');
  console.log("componentParent " + componentParent);

  var tempComponents;

if (componentParent == "editor-user-page"){
  tempComponents = editorComponents;
}

if (componentParent == "footer-user-page"){
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
        break;

        
    }



    if (componentParent == "editor-user-page"){
  editorComponents = tempComponents;
}

if (componentParent == "footer-user-page"){
  footerComponents = tempComponents;
}
//componentParent = undefined;


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




$(document).on('click', '.save-editor-changes', function () { // Save current state of the editor editorComponents
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
})

$(document).on('change', '#imageFile', function () {
  var url = "<?php echo $config['home-file-path']; ?>/controller/controller.php";
  var properties = document.getElementById("imageFile").files[0];
  var form_data = new FormData();
  form_data.append("file", properties);
  form_data.append("COMMAND", "PIC_UPLOAD");

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
      $('#editImageModal').modal('hide')
      var component = getComponent();
      component.content = "<?php echo $config['home-file-path']; ?>/" + data;
      showChanges();
      $('input[type="file"]').val(null);
    }
  });
})

//Gets the component from the index and indexGrid global variables
function getComponent() {
  console.log(indexGrid);
  //indexGrid is -1 if it's not in a grid

if (componentParent == "editor-user-page"){

  if (indexGrid == -1) {
    return editorComponents[index];
  } else {
    return editorComponents[index].gridContent[indexGrid];
  }

}

if (componentParent == "footer-user-page"){

  if (indexGrid == -1) {
    return footerComponents[index];
  } else {
    return footerComponents[index].gridContent[indexGrid];
  }

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

  if (theParent === "editor-user-page"){
    editorComponents[index].html = editor.getData();

      }
      else if (theParent == "footer-user-page"){
        footerComponents[index].html = editor.getData();

      }

      showChanges();

  
});


$(document).on('click', '.media-edit-button', function () {
  let text = $('#editMediaURL').val();
  let height = $('#editMediaHeight').val();
  let width = $('#editMediaWidth').val();

  $('#editMediaModal').modal('hide')
  text = text.replace("youtube.com/watch?v=", "youtube.com/embed/")


  if (theParent === "editor-user-page"){
    editorComponents[index].content = text;
  editorComponents[index].height = height;
  editorComponents[index].width = width;
      }
      else if (theParent == "footer-user-page"){
        footerComponents[index].content = text;
  footerComponents[index].height = height;
  footerComponents[index].width = width;
      }



  showChanges();
})

$(document).on('click', '.html-edit-button', function () {
  let code = $('#editHTML').val();
  $('#editHTMLModal').modal('hide')

  if (theParent === "editor-user-page"){
    editorComponents[index].content = code;

      }
      else if (theParent == "footer-user-page"){
        footerComponents[index].content = code;

      }

  showChanges();
})

$(document).on("click", ".grid-edit-button", function () {
  let columns = $("#editGridCol").val();
  $("#editGridModal").modal("hide");


  if (theParent === "editor-user-page"){
    editorComponents[index].columns = columns;
  editorComponents[index].gridContent = [];
      }
      else if (theParent == "footer-user-page"){
        footerComponents[index].columns = columns;
  footerComponents[index].gridContent = [];
      }


  showChanges();
});

$(document).on('click', '.add-webpage-button', function () {
  $('#addWebpageModal').modal('show');
})

$(document).on('click', '.button-edit-button', function () {
  let url = $('#editButtonURL').val();
  let content = $('#editButtonText').val();
  let style = $('#editButtonStyle').val();
  $('#editButtonModal').modal('hide');


  if (theParent === "editor-user-page"){
    editorComponents[index].url = url;
  editorComponents[index].content = content;
  editorComponents[index].style = style;
      }
      else if (theParent == "footer-user-page"){
        footerComponents[index].url = url;
  footerComponents[index].content = content;
  footerComponents[index].style = style;
      }


  showChanges();
})

$(document).on('click', '.spacer-edit-button', function () {
  let height = $('#editSpacerHeight').val();
  $('#editSpacerModal').modal('hide');
  editorComponents[index].height = height;

  showChanges();
})

$(document).on('click', '.divider-edit-button', function () {
  $('#editDividerModal').modal('hide');

  if (theParent === "editor-user-page"){

      }
      else if (theParent == "footer-user-page"){

      }

  showChanges();
})

$(document).on('click', '#save-webpage-button', function () {
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
  $('#editText').val(editorComponents[idBoth[0]].gridContent[idBoth[1]].content);
  $("#hType").val(editorComponents[idBoth[0]].gridContent[idBoth[1]].header);

});



$(document).on("click", ".image-component-grid", function () {
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
  var comp = editorComponents[componentIndex]
  comp.gridContent[gridIndex] = makeTextComponent()
  showChanges();
}


function addImageGrid(gridIndex, componentIndex) {
  var comp = editorComponents[componentIndex]
  comp.gridContent[gridIndex] = makeImageComponent()
  showChanges();
}

function addBlankGrid(gridIndex, componentIndex) {
  var comp = editorComponents[componentIndex]
  comp.gridContent[gridIndex] = makeBlankComponent()
  showChanges();
}

function addEmbedGrid(gridIndex, componentIndex) {
  var comp = editorComponents[componentIndex]
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
  return "<div id='"  + index + "' class='component mb-4'   ><img src=\"" + component.content + "\"  height=\"300\"  alt=\"description\" > </div>";
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
  return "<div id='" + index + "' class='component mb-4' ><a href='"+component.url+"' target='_blank' class='"+component.style+"'>"+component.content+"</a></div>"
}

//Function to output spacer component 
function spacerComponentOutput(component, index) {
  return "<div id='" + index + "' class='component mb-4' style='height:"+component.height+"px'>&nbsp;</div>"
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
      res += mediaComponentOutputGrid(component.gridContent[x],x,index);

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

  $('.editable-area').empty()

//  $('#editor-user-page').empty()
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

  $('#editable-area').empty()
  if (editorComponents.length == 1) {
    $('#editor-user-page').removeClass("invisible").addClass("visible");
  }

  if (footerComponents.length == 1) {
    $('#footer-user-page').removeClass("invisible").addClass("visible");
  }

  if (componentParent == "editor-user-page"){
  editorComponents.splice(index, 1);
  showChanges();
  index = editorComponents.length;
  indexGrid = -1;
  }

  if (componentParent == "footer-user-page"){
    footerComponents.splice(index, 1);
  showChanges();
  index = footerComponents.length;
  indexGrid = -1;
  }

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