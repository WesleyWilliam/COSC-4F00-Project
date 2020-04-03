var components = JSON.parse(str);
var sortedIDs;
var editor = null;
var index; //this index is used to keep track of which element is currently selected on the page

$("#editor-user-page").hide();
$(document).ready(function() {
  showChanges();
  $(".save-webpage-alert").hide();
});

$(function() {
  var startingItem;

  $("#editor-user-page").sortable({
    start: function(e, ui) {
      sortedIDs = $("#editor-user-page").sortable("toArray");
      startingItem = ui.item.attr("id");
      console.log("start: " + startingItem);
    },

    stop: function(e, ui) {
      sortedIDs = $("#editor-user-page").sortable("toArray");
      var stoppingItem = ui.item.index();
      console.log("stop: " + stoppingItem);
      var temp = components.splice(startingItem, 1);
      components.splice(stoppingItem, 0, temp[0]);
      showChanges();
    }
  }); //when sorting stops, the sortedIDs are updated
}); //used to make the elements on the page draggable/sortable

function addTextComponent() {
  var component = {
    type: "text",
    header: "display-3",
    content: "Click to edit text"
  };
  components.push(component);
  showChanges();
}

function addMediaComponent() {
  var component = {
    type: "media",
    height: 315,
    width: 560,
    content: "https://www.youtube.com/embed/8PNO9unyE-I"
  };
  components.push(component);
  showChanges();
}

function addHTMLComponent() {
  var component = {
    type: "html",
    content: "<p> Click to edit code </p>"
  };
  components.push(component);
  showChanges();
}

function addImageComponent() {
  var component = {
    type: "image",
    header: "img",
    content: "https://i.imgflip.com/3trije.jpg"
  };
  components.push(component);
  showChanges();
}

function addParagraphComponent() {
  var component = {
    type: "paragraph",
    html: "<p>Click to edit paragraph</p>"
  };
  components.push(component);
  showChanges();
}

$(document).on("click", ".save-editor-changes", function() {
  // Save current state of the editor components
  $(".save-webpage-alert").show();
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      console.log(this.responseText);
    }
  };
  var url =
    "<?php echo $config['home-file-path']; ?>/controller/controller.php";
  xhttp.open("POST", url, true);
  xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  var webpage_id = "<?php echo $_GET['website']; ?> ";
  if (!isNaN(webpage_id)) {
    xhttp.send(
      "COMMAND=SAVE-EDITOR&WEBPAGE=" +
        webpage_id +
        "&COMPONENTS=" +
        encodeURI(JSON.stringify(components))
    );
  }
  setTimeout(function() {
    $(".save-webpage-alert").hide();
  }, 5000);
});

$(document).on("change", "#imageFile", function() {
  var url =
    "<?php echo $config['home-file-path']; ?>/controller/controller.php";
  var properties = document.getElementById("imageFile").files[0];
  //  $.post(url,{COMMAND: 'PIC_UPLOAD'},function(data,status) {
  //    console.log(data);
  //  });
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
    success: function(data, error) {
      console.log(data);
      console.log(error);
      $("#editImageModal").modal("hide");
      components[index].content =
        "<?php echo $config['home-file-path']; ?>/" + data;
      showChanges();
      $('input[type="file"]').val(null);
    }
  });
});

$(document).on("click", ".text-edit-button", function() {
  let text = $("#editText").val();
  $("#editTextModal").modal("hide");
  components[index].content = text;
  components[index].header = $("#hType").val();
  showChanges();
});

$(document).on("click", ".image-edit-button", function() {
  let text = $("#addImageURL").val();
  $("#editImageModal").modal("hide");
  components[index].content = text;

  showChanges();
});

$(document).on("click", ".paragraph-edit-button", function() {
  let res = editor.getData();
  $("#editParagraphModal").modal("hide");
  components[index].html = editor.getData();
  showChanges();
});

$(document).on("click", ".media-edit-button", function() {
  let text = $("#editMediaURL").val();
  let height = $("#editMediaHeight").val();
  let width = $("#editMediaWidth").val();

  $("#editMediaModal").modal("hide");
  text = text.replace("youtube.com/watch?v=", "youtube.com/embed/");
  components[index].content = text;
  components[index].height = height;
  components[index].width = width;
  showChanges();
});

$(document).on("click", ".html-edit-button", function() {
  let code = $("#editHTML").val();
  $("#editHTMLModal").modal("hide");
  components[index].content = code;
  showChanges();
});

//Function to output text component html code
function textComponentOutput(component, index) {
  var res = "";
  //component.head1 + component.index + component.head2 + component.content + components.tail
  res +=
    " <div id='" +
    index +
    "' class='component' onclick ='editText(" +
    index +
    ")'  draggable='true' ondragstart='dragText(event)' ><p class=" +
    component.header +
    ">" +
    component.content +
    "</p></div>";
  return res;
}

// Function to output image component html code
function imageComponentOutput(component, index) {
  var res = "";
  res +=
    "<div id='" +
    index +
    "' class='component' onclick ='editImage(" +
    index +
    ")'  draggable='true' ondragstart='dragImage(event)' ><img src=\"" +
    component.content +
    '"  height="300"  alt="description" > </div>';
  return res;
}

// Function to output media component html code
function mediaComponentOutput(component, index) {
  var res = "";
  res +=
    "<div id='" +
    index +
    "' class='component' onclick ='editMedia(" +
    index +
    ")' draggable='true' ondragstart='dragMedia(event)'> <iframe width='" +
    component.width +
    "' height='" +
    component.height +
    "' src=" +
    component.content +
    " frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe> </div>";
  return res;
}

//Function to output paragraph component html code
function paragraphComponentOutput(component, index) {
  return (
    "<div id='" +
    index +
    "' class='component' onclick=\"editParagraph(" +
    index +
    ")\" draggable='true' ondragstart='dragParagraph(event)'>" +
    component.html +
    "</div>"
  );
}

//Function to output HTML component
function HTMLComponentOutput(component, index) {
  return (
    "<div id='" +
    index +
    "' class='component' onclick=\"editHTML(" +
    index +
    ")\" draggable='true' ondragstart='dragHTML(event)'>" +
    component.content +
    "</div>"
  );
}

// Function to render changes
function showChanges() {
  $("#editor-user-page").empty();
  if (components.length == 1) {
    $("#editor-user-page")
      .removeClass("invisible")
      .addClass("visible");
  }

  for (let i = 0; i < components.length; i++) {
    switch (components[i].type) {
      case "text":
        $("#editor-user-page").append(textComponentOutput(components[i], i));
        break;
      case "image":
        $("#editor-user-page").append(imageComponentOutput(components[i], i));
        break;
      case "media":
        $("#editor-user-page").append(mediaComponentOutput(components[i], i));
        break;
      case "paragraph":
        $("#editor-user-page").append(
          paragraphComponentOutput(components[i], i)
        );
        break;
      case "html":
        $("#editor-user-page").append(HTMLComponentOutput(components[i], i));
        break;
    }
  }
}

//drag and drop stuff
function allowDrop(ev) {
  ev.preventDefault();
}

function addText(ev) {
  ev.dataTransfer.setData("component", "newtext");
}

function dragText(ev) {
  ev.dataTransfer.setData("component", ev.target.id);
}

function addImage(ev) {
  ev.dataTransfer.setData("component", "newimage");
}

function dragImage(ev) {
  ev.dataTransfer.setData("component", ev.target.id);
}

function addParagraph(ev) {
  ev.dataTransfer.setData("component", "newparagraph");
}

function dragParagraph(ev) {
  ev.dataTransfer.setData("component", ev.target.id);
}

function addMedia(ev) {
  ev.dataTransfer.setData("component", "newmedia");
}

function dragMedia(ev) {
  ev.dataTransfer.setData("component", ev.target.id);
}

function addHTML(ev) {
  ev.dataTransfer.setData("component", "newhtml");
}

function dragHTML(ev) {
  ev.dataTransfer.setData("component", ev.target.id);
}

function drop(ev, target) {
  ev.preventDefault();
  var component = ev.dataTransfer.getData("component");
  console.log("component " + component);
  if (component == "newtext") {
    addTextComponent();
  } else if (component == "newimage") {
    addImageComponent();
  } else if (component == "newparagraph") {
    addParagraphComponent();
  } else if (component == "newmedia") {
    addMediaComponent();
  } else if (component == "newhtml") {
    addHTMLComponent();
  } else {
    //var data = ev.dataTransfer.getData("component");
    //let temp = JSON.parse(JSON.stringify(components[data]));
    //components.splice(data,1);
    //target.append(document.getElementById(data)); //dont want to append to end of editor, need to append inbetween the child before and after the target area
    //console.log("target: " +JSON.stringify(target));
    //components.splice(target.id,0,temp);
    //console.log("components: " +JSON.stringify(components));
    //showChanges();
  }
}

function editText(i) {
  index = i;
  $("#editTextModal").modal("show");
  $("#editText").val(components[i].content);
}

function editImage(i) {
  index = i;
  $("#editImageModal").modal("show");
  $("#addImageURL").val(components[i].content);
}

function editParagraph(i) {
  index = i;
  editor.setData(components[i].html);
  $("#editParagraphModal").modal("show");
}

function editMedia(i) {
  index = i;
  $("#editMediaModal").modal("show");
  $("#editMediaURL").val(components[i].content);
  $("#editMediaWidth").val(components[i].width);
  $("#editMediaHeight").val(components[i].height);
}

function editHTML(i) {
  index = i;
  $("#editHTMLModal").modal("show");
  $("#editHTML").val(components[i].content);
}

function deleteElement() {
  $("#editor-user-page").empty();
  if (components.length == 1) {
    $("#editor-user-page")
      .removeClass("invisible")
      .addClass("visible");
  }
  components.splice(index, 1);
  showChanges();
  index = components.length;
}

$(document).on("click", ".preview-editor", function() {
  const new_page = $("#editor-user-page").html();
  var strWindowFeatures =
    "dependent=yes,menubar=yes,location=yes,resizable=yes,scrollbars=yes,status=yes";

  let myWindow = window.open(
    "view-webpage.html",
    "newWindow",
    strWindowFeatures
  );

  myWindow.onload = function() {
    myWindow.document.getElementById("main-body").innerHTML = new_page;
  };
});
