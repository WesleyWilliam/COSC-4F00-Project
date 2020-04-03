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

function addGridComponent() {
  var component = {
    type: "grid",
    content: "",
    rows: 3,
    columns: 3
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

$(document).on("click", ".grid-edit-button", function() {
  let columns = $("#editGridCol").val();
  $("#editGridModal").modal("hide");
  components[index].columns = columns;
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
    "' class='component text-center mb-4' onclick ='editText(" +
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
    "' class='component mb-4' onclick ='editImage(" +
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

// Function to output grid component html code
function gridComponentOutput(component, index) {
  var res = "";
  res +=
    "<div id='" +
    index +
    "' class='component mb-4' onclick ='editGrid(" +
    index +
    ")' draggable='true' ondragstart='dragGrid(event)'><div class='row'>";

  for (x = 0; x < component.columns; x++) {
    res += "<div class='col bg-info text-white'>column</div>";
  }

  res += "</div>";
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
      case "grid":
        $("#editor-user-page").append(gridComponentOutput(components[i], i));
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

function addGrid(ev) {
  ev.dataTransfer.setData("component", "newgrid");
}

function dragGrid(ev) {
  ev.dataTransfer.setData("grid", ev.target.id);
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
  } else if (component == "newgrid") {
    addGridComponent();
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

function editGrid(i) {
  index = i;
  $("#editGridModal").modal("show");
  $("#editGridCol").val(components[i].columns);
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
