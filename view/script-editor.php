var str = <?php echo json_encode($component); ?>;

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
    success: function (data, error) {
      console.log(data);
      console.log(error);
      $('#editImageModal').modal('hide')
      components[index].content = "<?php echo $config['home-file-path']; ?>/" + data;
      showChanges();
      $('input[type="file"]').val(null);
    }
  });
})