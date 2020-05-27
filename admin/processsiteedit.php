<?php
session_start();


if(isset($_SESSION['privilegeduser'])) {

    include('../conn.php');

    $id = $_POST['postid'];
    $userid = $_SESSION['userid'];

    $updateposttitle = $conn->real_escape_string($_POST['editposttitle']);
    $updateposttitle = htmlspecialchars($updateposttitle);
    $updatepostbody = $conn->real_escape_string($_POST['editpostbody']);
    $updatepostbody = htmlspecialchars($updatepostbody);

    $siteadmin = "SELECT * FROM fest_siteadmin WHERE accountid = '$userid'";

    $result = $conn->query($siteadmin);

    while ($row = $result->fetch_assoc()) {
        $adminusername = $row['name'];
    }

} else {
    echo "login error";
}
?>

<!doctype html>
<html>

<?php
    include("../static/head_admin.html")
    ?>

<body>

    <?php
    include("../static/nav_admin.html")
    ?>

  <section class="section">
    <div class="container">

    <?php 
            include("../static/adminbanner.html")
            ?>
            <section class='section'>
            <div class='container'>
        <?php

            $update = "UPDATE fest_sitecontent SET title='$updateposttitle', body='$updatepostbody' WHERE postid = '$id'";

            $result = $conn->query($update);

            if(!$result){
                echo $conn->error;
            }

            $read = "SELECT * FROM fest_sitecontent WHERE postid = '$id'";

            $readresult = $conn->query($read);

            if(!$readresult){
                echo $conn->error;
            }

            while ($row = $readresult->fetch_assoc()){

                $posttitle = $row['title'];
                $postbody = $row['body'];
                $postdate = $row['dateposted'];
                $postdate = date("jS F o", strtotime($postdate));
                $postid = $row['postid'];
            }

            echo "                
            <article class='message is-warning is-light'>
            <div class='message-header'>
            <h1>Update Successful</h1>
              <p>$posttitle</p>
            </div>
            <div class='message-body'>
              $postbody
              $postdate
          </div>
          </article>";
          ?>

          <a class="button is-danger is-light" href="contentindex.php">Return</a>

        </section>

  </body>
</html>