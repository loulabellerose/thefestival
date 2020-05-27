<?php
session_start();
include("conn.php");
if (isset($_SESSION['privilegeduser'])) {

    $typeofuser = $_SESSION['usertype'];
    $userid = $_SESSION['userid'];
}

$read = "SELECT * FROM fest_performer

        WHERE statusid = '2' order by name asc";

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

        $name_data = $row["name"];
        $biog_data = $row["biog"];
        $url_data = $row["url"];
        $artist_id = $row["performerid"];
        $artist_img = $row["image"];

        echo "
        <div class='box'>
        <article class='media'>
        <figure class='media-left'>
          <p class='image is-64x64'>
            <img src='images/$artist_img' />
          </p>
        </figure>

        <div class='media-content'>
          <div class='content'>
          <strong> $name_data </strong> 
          <br>
          <br>
          <div class='buttons'>
          <a class='button is-small is-danger is-light' href='artist.php?performer=$artist_id'>More Details</a>
          </div>
          </div>
          </div>


      </article>
      </div>";
      }
      ?>

    </div>
  </section>
</body>

</html>