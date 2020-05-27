<?php
    include("conn.php");
    session_start();

?>

<!doctype html>
<html>

<?php
  include("static/head.html")
  ?>

<body>
 
<?php
include("static/nav.html")
?>

  <section class="section">
    <div class="container">
<form method='POST' action='register.php' enctype='multipart/form-data'>
<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label">Artist</label>
  </div>

  <div class="field-body">
    <div class="field">
      <p class="control is-expanded has-icons-left">
        <input class="input" type="text" placeholder="Name" name="performername">
        <span class="icon is-small is-left">
          <i class="fas fa-user"></i>
        </span>
      </p>
    </div>

    <div class="field">
      <p class="control is-expanded has-icons-left has-icons-right">
        <input class="input" type="email" placeholder="Email" name="performeremail">
        <span class="icon is-small is-left">
          <i class="fas fa-envelope"></i>
        </span>
        <span class="icon is-small is-right">
          <i class="fas fa-check"></i>
        </span>
      </p>
    </div>
  </div>

</div>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label">Artist Image</label>
  </div>

  <div class="field-body">
    <div class="field">
        <input class="input" type="file" name="uploadperformerimage">
    </div>
  </div>
</div>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label">Link</label>
  </div>
  <div class="field-body">
    <div class="field">
      <div class="control">
        <input class="input" type="text" placeholder="e.g. Artist Website or SoundCloud" name="url">
      </div>
    </div>
  </div>
</div>

<div class="field is-horizontal">
  <div class="field-label is-normal">
    <label class="label">Biography</label>
  </div>
  <div class="field-body">
    <div class="field">
      <div class="control">
        <textarea class="textarea" placeholder="Tell us a bit about yourself" name="biog"></textarea>
      </div>
    </div>
  </div>
</div>

<div class="field is-horizontal">
  <div class="field-label">
    <!-- Left empty for spacing -->
  </div>

  <div class="field-body">
    <div class="field">
      <div class="control">
        <input class="button is-primary" type="submit" value="Submit Application" name="apply">         
      </div>
    </div>
  </div>
</div>


<?php

if(isset($_POST['apply'])) {
  
  include("conn.php");

  $name = $conn->real_escape_string($_POST['performername']);
  $name = htmlspecialchars($name);
  $email = $conn->real_escape_string($_POST['performeremail']);
  $email = htmlspecialchars($email);
  $biog = $conn->real_escape_string($_POST['biog']);
  $biog = htmlspecialchars($biog);
  $url = $conn->real_escape_string($_POST['url']);
  $url = htmlspecialchars($url);

  $upload = $_FILES['uploadperformerimage']['name'];
  $location = $_FILES['uploadperformerimage']['tmp_name'];

  $move = move_uploaded_file($location,'images/$upload');

  $readexistingaccounts = "SELECT *
                            FROM fest_accountemail
                            WHERE emailaddress = '$email'";
                      
  $existingaccounts = $conn->query($readexistingaccounts);

  if ($existingaccounts->num_rows>0) {
    echo 
    "<div class='field is-horizontal'>
    <div class='field-label'>
      <!-- Left empty for spacing -->
    </div>

    <div class='field-body'>
      <div class='field'>
        <strong>Already an application from that e-mail address</strong>
      </div>
    </div>
    </div>";
  }

  else {
      $performer = "INSERT INTO fest_performer (name, biog, url, image)
      VALUES ('$name', '$biog', '$url', '$upload');";
    
      $newperformer = $conn->query($performer);
    
      $performerid = $conn->insert_id;
      $_SESSION['performerid'] = $performerid;
    
      $application = "INSERT INTO fest_accountemail (emailaddress)
      VALUES ('$email')";
    
      $newapplication = $conn->query($application);
    
      $applicationid = $conn->insert_id;
      
      if ($newperformer && $newapplication) {
        
        $update = "UPDATE fest_performer 
        SET emailid = $applicationid 
        WHERE performerid = $performerid";
    
        $emailupdate = $conn->query($update);
    
        if($emailupdate){
          echo "
          <div class='field is-horizontal'>
          <div class='field-label'>
            <!-- Left empty for spacing -->
          </div>
    
          <div class='field-body'>
            <div class='field'>
              <strong>Your application has been successful - you will hear from us shortly! </strong>
            </div>
          </div>
          </div>";
      } else {
        echo $conn->error;
      } 

    } 
  }

}
?>
</div>
</form>
</div>
</section>

</body>

</html>