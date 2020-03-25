var str = <?php echo json_encode($component); ?>;
    var components = JSON.parse(str);
    var editor = null;
    var index; //this index is used to keep track of which element is currently selected on the page

    $('#editor-user-page').hide();
    $(document).ready(function() {
      showChanges();
      $(".save-webpage-alert").hide();
    });

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
        header: "media",
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
      $('#editMediaModal').modal('hide')
      text = text.replace("youtube.com/watch?v=", "youtube.com/embed/")
      components[index].content = text;
      showChanges();
    })

    $(document).on('click', '.html-edit-button', function() {
      let code = $('#editHTML').val();
      $('#editHTMLModal').modal('hide')
      components[index].content = code;
      showChanges();
    })

    //Function to output text component html code
    function textComponentOutput(component, index) {
      var res = "";
      //component.head1 + component.index + component.head2 + component.content + components.tail
      res += "<p class=" + component.header + " " + "onclick ='editText(" + index + ")'  draggable='true' ondragstart='dragText(event)'  >" + component.content + "</p>";
      return res;
    }

    // Function to output image component html code
    function imageComponentOutput(component, index) {
      var res = "";
      res += "<img src=\"" + component.content + "\" onclick =\"editImage(" + index + ")\" height=\"300\"  alt=\"description\" >";
      return res;
    }

    // Function to output media component html code
    function mediaComponentOutput(component, index) {
      var res = "";
      res += "<div onclick ='editMedia(" + index + ")'> <iframe width='560' height='315' src=" + component.content + " frameborder='0' allow='accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture' allowfullscreen></iframe> </div>";
      return res;
    }

    //Function to output paragraph component html code
    function paragraphComponentOutput(component, index) {
      return "<div onclick=\"editParagraph(" + index + ")\">" + component.html + "</div>";
    }

    //Function to output HTML component 
    function HTMLComponentOutput(component, index) {
      return "<div onclick=\"editHTML(" + index + ")\">" + component.content + "</div>";
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

    function dragParagraph(ev) {
      ev.dataTransfer.setData("component", "paragraph");
    }

    function dragMedia(ev) {
      ev.dataTransfer.setData("component", "media");
    }

    function dragHTML(ev) {
      ev.dataTransfer.setData("component", "html");
    }

    function drop(ev) {
      ev.preventDefault();
      var component = ev.dataTransfer.getData("component");
      if (component == "text") {
        addTextComponent();
      } else if (component == "image") {
        addImageComponent();
      } else if (component == "paragraph") {
        addParagraphComponent();
      } else if (component == "media") {
        addMediaComponent();
      } else if (component == "html") {
        addHTMLComponent();
      }
    }

    function editText(i) {
      index = i;
      $('#editTextModal').modal('show');
      $('#editText').val(components[i].content);
    }

    function editImage(i) {
      index = i;
      $('#editImageModal').modal('show');

    }

    function editParagraph(i) {
      index = i;
      editor.setData(components[i].html);
      $('#editParagraphModal').modal('show');
    }

    function editMedia(i) {
      index = i;
      $('#editMediaModal').modal('show');

    }

    function editHTML(i) {
      index = i;
      $('#editHTMLModal').modal('show');

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