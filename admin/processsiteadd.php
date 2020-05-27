<?php
session_start();

if(isset($_SESSION['privilegeduser'])) {

    include('../conn.php');

    $userid = $_SESSION['userid'];

    $posttitle = $conn->real_escape_string($_POST['newposttitle']);
    $posttitle = htmlspecialchars($posttitle);
    $postbody = $conn->real_escape_string($_POST['newpostbody']);
    $postbody = htmlspecialchars($postbody);

    $sqlinsert = "INSERT INTO fest_sitecontent
    (title, body, authorid)
    VALUES
    ('$posttitle', '$postbody', $userid)";

    $result = $conn->query($sqlinsert);

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


        <?php
            if(!$result) {
                echo $conn->error;
            } else {
                 echo "                
            <article class='message is-warning is-light'>
            <div class='message-header'>
            <h1>Post Successful</h1>
              <p>$posttitle</p>
            </div>
            <div class='message-body'>
              $postbody
          </div>
          </article>";
            }
          ?>

          <a class="button is-danger is-light" href="contentindex.php">Return</a>
            </div>

        </section>

  </body>
</html>