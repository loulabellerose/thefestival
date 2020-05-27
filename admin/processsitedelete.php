<?php
session_start();


if(isset($_SESSION['privilegeduser'])) {

    include('../conn.php');

    $id = $_POST['postid'];
    $userid = $_SESSION['userid'];

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

            $update = "DELETE FROM fest_sitecontent WHERE postid = '$id'";

            $result = $conn->query($update);

            if(!$result){
                echo $conn->error;
            }
            else {
                echo         
                "<article class='message is-warning is-light'>
                    <div class='message-header'>
                        <p>Post Deleted</p>
                    </div>
                </article>";
            }
          ?>

          <a class="button is-danger is-light" href="contentindex.php">Return</a>

        </section>

  </body>
</html>