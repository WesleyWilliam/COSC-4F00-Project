var str = <?php echo json_encode($component); ?>;
    var components = JSON.parse(str);
    var sortedIDs;
    var editor = null;
    var index; //this index is used to keep track of which element is currently selected on the page

    $('#editor-user-page').hide();
    $(document).ready(function() {
      showChanges();
      $(".save-webpage-alert").hide();
    });

$(function(){
  var startingItem;


    $('#editor-user-page').sortable({

      axis : "y",
  
      start: function(e,ui){
    sortedIDs = $( "#editor-user-page").sortable( "toArray" );
    startingItem = ui.item.index();
  },
  
  stop: function(e,ui){
    sortedIDs = $( "#editor-user-page").sortable( "toArray" );
    var stoppingItem = ui.item.index();
    var temp = components.splice(startingItem,1);
    components.splice(stoppingItem, 0, temp[0]);
showChanges();


  }
}); //when sorting stops, the sortedIDs are updated


$("#sidebarList > li").draggable({
revert :true,
revertDuration: 0


}); //make sidebar draggable


$("#editor-user-page").droppable({

drop: function (e, ui) {
  var dropped = ui.draggable.attr("id");


  switch (dropped) {
          case 'text-sidebar-button':
            addTextComponent();
            break;
          case 'image-sidebar-button':
            addImageComponent();
            break;
          case 'embeddedcontent-sidebar-button':
            addMediaComponent();
            break;
          case 'paragraph-sidebar-button':
            addParagraphComponent();
            break;
            case 'html-sidebar-button':
              addHTMLComponent();
            break;
            case 'grid-sidebar-button':
              addGridComponent();
            break;
        } 



}

}); //make editor droppable



  $(document).on("click", ".component" , function() {
console.log("id " + $(this).attr("id"));
        var id = $(this).attr("id");
        var type = components[id].type;

index = id;
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
              $('#editGridModal').modal('show');
      $('#gridColumns').val(components[id].columns);
                  break;
        } 


        
        });




}); //used to make the elements on the page draggable, sortable, droppable, editable





    function addTextComponent() {
      var component = {
        type: "text",
        header: "display-3",
        content: "Click to edit text"
      };
      components.push(component);
      showChanges();
    };

    function addMediaComponent() {
      var component = {
        type: "media",
        height: 315,
        width: 560,
        content: "https://www.youtube.com/embed/8PNO9unyE-I"
      };
      components.push(component);
      showChanges();
    };

    function addHTMLComponent() {
        var component = {
        type: "html",
        content: "<p> Click to edit code </p>"
      };
      components.push(component);
      showChanges();

    };

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
        html: "<p>Click to edit paragraph<\/p>"
      }
      components.push(component);
      showChanges();
    }

    function addGridComponent() {
      var component = {
        type: "grid",
        columns: 2,
        gridComponents: [makeTextComponent(), makeTextComponent()]
      }



      components.push(component);

      for (var i=0; i<component.columns; i++){
  components[components.length-1].gridComponents[i].id = components.length+" gridComponent: " + i;
}

      showChanges();
    }


    function makeTextComponent() {
      var component = {
        type: "text",
        header: "display-3",
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
        columns: 2,
        gridComponents: [makeTextComponent(), makeTextComponent()]
      }
      return component;
    }




    $(document).on('click', '.save-editor-changes', function() { // Save current state of the editor components
      $(".save-webpage-alert").show();
      var xhttp = new XMLHttpRequest();
      xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
          console.log(this.responseText);
        }
      };
      var url = "<?php echo $config['home-file-path']; ?>/controller/controller.php"
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



    $(document).on('change', '#imageFile', function() {
      var url = "<?php echo $config['home-file-path']; ?>/controller/controller.php";
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
        success: function(data,error) {
          console.log(data);
          console.log(error);
          $('#editImageModal').modal('hide')
          components[index].content = "<?php echo $config['home-file-path']; ?>/" + data;
          showChanges();
          $('input[type="file"]').val(null);
        }
      });
    })

    $(document).on('click', '.text-edit-button', function() {
      let text = $('#editText').val();
      $('#editTextModal').modal('hide')
      components[index].content = text;
      components[index].header = $("#hType").val();
      showChanges();
    })

    $(document).on('click', '.image-edit-button', function() {
      let text = $('#addImageURL').val();
      $('#editImageModal').modal('hide')
      components[index].content = text;

      showChanges();
    });

    $(document).on('click', '.paragraph-edit-button', function() {
      let res = editor.getData();
      $('#editParagraphModal').modal('hide');
      components[index].html = editor.getData();
      showChanges();
    });


    $(document).on('click', '.media-edit-button', function() {
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

    $(document).on('click', '.html-edit-button', function() {
      let code = $('#editHTML').val();
      $('#editHTMLModal').modal('hide')
      components[index].content = code;
      showChanges();
    })

    $(document).on('click', '.grid-edit-button', function() {
      let code = $('#gridColumns').val();
      $('#editGridModal').modal('hide')
      components[index].grids = code;
      showChanges();
    })

    //Function to output text component html code
    function textComponentOutput(component, index) {
      var res = "";
      //component.head1 + component.index + component.head2 + component.content + components.tail
      res += " <div id='"+index+"' class='component'  draggable='true' ><p class=" + component.header +   ">" + component.content + "</p></div>";
      return res;
    }

    // Function to output image component html code
    function imageComponentOutput(component, index) {
      var res = "";
      res += "<div id='"+index+"' class='component'  draggable='true' ><img src=\"" + component.content + "\"  height=\"300\"  alt=\"description\" > </div>";
      return res;
    }

    // Function to output media component html code
    function mediaComponentOutput(component, index) {
      var res = "";
      res += "<div id='"+index+"' class='component'  draggable='true' > <iframe width='"+component.width+"' height='"+component.height+"' src=" + component.content + " frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe> </div>";
      return res;
    }

    //Function to output paragraph component html code
    function paragraphComponentOutput(component, index) {
      return "<div id='"+index+"' class='component' draggable='true'>" + component.html + "</div>";
    }

    //Function to output HTML component 
    function HTMLComponentOutput(component, index) {
      return "<div id='"+index+"' class='component' draggable='true'>" + component.content + "</div>";
    }

    //Function to output grid component 
    function gridComponentOutput(component, index) {
      var res = "";
      res += "<div id='"+index+"' class='component'   draggable='true'>";

for (var i=0; i<component.columns; i++){
  res+="<div class='column' ondrop='drop(event, this)' ondragover='allowDrop(event)'>" ;
      res += getOutput(component.gridComponents[i], i);
      res+="</div>";
}

 res +=   "</div>";
      return res;
       }

       function getOutput(component, index){
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
              return  gridComponentOutput(component, index);
;
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
    }

    $(document).on('click', '.preview-editor', function() {
      const new_page = $('#editor-user-page').html();
      var strWindowFeatures = "dependent=yes,menubar=yes,location=yes,resizable=yes,scrollbars=yes,status=yes";

      let myWindow = window.open("view-webpage.html", "newWindow", strWindowFeatures);

      myWindow.onload = function() {
        myWindow.document.getElementById('main-body').innerHTML = new_page;
      }

    })