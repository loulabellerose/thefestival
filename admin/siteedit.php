<?php
session_start();
if (isset($_SESSION['privilegeduser'])) {

    include('../conn.php');

    $id = $_GET['postid'];
    $userid = $_SESSION['userid'];

    $read = "SELECT * FROM fest_sitecontent WHERE postid = '$id'";

    $result = $conn->query($read);

    if (!$result) {
        echo $conn->error;
    }

    while ($row = $result->fetch_assoc()) {
        $posttitle = $row['title'];
        $postbody = $row['body'];
        $postdate = $row['dateposted'];
        $postdate = date("jS F o", strtotime($postdate));
        $postid = $row['postid'];
    }

    $siteadmin = "SELECT * FROM fest_siteadmin WHERE accountid = '$userid'";

    $result = $conn->query($siteadmin);

    while ($row = $result->fetch_assoc()) {
        $adminusername = $row['name'];
    }
} else {
    header("location: ../login.php");
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

            <nav class="breadcrumb" aria-label="breadcrumbs">
                <ul>
                    <li><a href="index.php">Admin Dashboard</a></li>
                    <li><a href="contentindex.php">Site Content</a></li>
                    <li class="is-active"><a href="../">Edit Post</a></li>
                </ul>
            </nav>
            <?php
            echo "<div class='message is-white'>
            <div class='message-header'>
            <a class='delete is-medium' href='sitedelete.php?postid=$postid'></a>
            </div>
                <form action='processsiteedit.php' method='POST' enctype='multipart/form-data'>
                
                    <input type='hidden' value='$postid' name='postid' />

                        <div class='field is-horizontal'>
                            <div class='field-label is-normal'>
                                <label class='label'>Title: </label>
                            </div>
                            <div class='field-body'>
                            <div class='field'>
                            <div class='control'>
                                <input class='input' type='text' value='$posttitle' name='editposttitle'>
                                </div>
                                </div>
                                </div>
                        </div>

                        <div class='field is-horizontal'>
                            <div class='field-label is-normal'>
                                <label class='label'>Post Body: </label>
                            </div>
                            
                            <div class='field-body'>
                                <div class='field'>
                                    <div class='control'>
                                    <textarea class='textarea' name='editpostbody'>$postbody</textarea> 
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class='field is-horizontal'>
                        <div class='field-label is-normal'>

                        </div>

                        <div class='field is-grouped'>
                            <div class='control'>
                                <button class='button is-danger'>Submit</button>
                            </div>
                        <div class='control'>
                            <a class='button is-link is-warning' href='contentindex.php'>Cancel</a>
                        </div>
                        </div>
                </form>
                </div>
            </div>
            </article>
            </div>";
            ?>



</body>

</html>