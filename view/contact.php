<!-- If there is a message, show message to user -->
<?php
if (!empty($_SESSION['CONTACT_MSG'])) {
  echo "<div class=\"alert alert-success alert-dismissible\" role=\"alert\">";
  echo '<button type="button" class="close" data-dismiss="alert">&times;</button>';
  echo $_SESSION['CONTACT_MSG'];
  echo "</div>";
}
?>

<!-- Contact form -->
    <form class="card" style="border:none;" action="<?php echo $config['home-file-path']; ?>/controller/controller.php" method="POST">
      <div class="card-body">
        <div class="row">
          <div class="col-md-6">
            <div class="md-form mb-0">
              <label for="emailInput" required>Email address</label>
              <input type="email" class="form-control" id="emailInput" placeholder="Enter email" name="EMAIL" required autofocus>
            </div>
          </div>
          <div class="col-md-6">
          <div class="md-form mb-0">
            <label for="nameInput">Name</label>
            <input type="text" class="form-control" id="nameInput" name="FULLNAME" placeholder="Enter your full name" required autofocus>
          </div>
            </div>
        </div>

        <div class = "row">
          <div class="col-md-12 mt-5">

            <div class="md-form">
              <label for="messageInput">Message</label>
              <textarea type="text" class="form-control" id="messageInput" name="MSG" placeholder="Enter message" rows="5"></textarea>
            </div>
            
            <div class="w-100 pt-3 pr-3 text-right">
              <button type="submit" class="btn btn-lg btn-outline-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-lg btn-outline-success" data-dismiss="modal">Send »</button>
            </div>
            <input type="hidden" name="COMMAND" value="CONTACT">

          </div>
        </div>
      </div>
    </form>

<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>



<!-- Avoid form resubmission -->
<script>
if (window.history.replaceState) {
  window.history.replaceState(null, null, window.location.href);
}
</script>