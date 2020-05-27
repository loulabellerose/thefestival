<?php
//add PHP code from external conn.php
include("conn.php");

$read = "SELECT * FROM fest_sitecontent order by dateposted desc";

$result = $conn->query($read);

if (!$result) {
  echo $conn->error;
}
 
?>

<!doctype html>
<html>

<?php
  include("static/head.html")
  ?>

    <body>
    <?php 
    if (isset($_SESSION['privilegeduser'])) {

      if($typeofuser == '1') {
        include("static/nav_adminloggedin.html");
      }
    
      elseif($typeofuser == '2') {
        include("static/nav_artistloggedin.html");
      }
    
      else{
        include("static/nav.html");
      }
    }
    
    else{
      include("static/nav.html");
    }
    ?>

  <section class="section">
    <div class="container">
      

    <?php
    while ($row = $result->fetch_assoc()) {
      $title = $row['title'];
      $body = $row['body'];

      echo 
      "<article class='message is-warning'>
        <div class='message-header'>
          <p>$title</p>
        </div>
        <div class='message-body'>
          $body
      </div>
      </article>";
    }


        ?>
        </div>

    </div>
  </section>
  </body>
</html>