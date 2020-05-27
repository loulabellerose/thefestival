<?php
session_start();
if (isset($_SESSION['privilegeduser'])) {

    include("../conn.php");

    //$typeofuser = $_SESSION['usertype'];
    $userid = $_SESSION['userid'];

    $artistcontent = "SELECT * FROM fest_performer 
                    WHERE userid='$userid'";

    $result = $conn->query($artistcontent);

    while ($row = $result->fetch_assoc()) {
        $name = $row['name'];
        $biog = $row['biog'];
        $url = $row['url'];
        $image = $row['image'];
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
            include("../static/artistbanner.html")
            ?>

                    <nav class="breadcrumb" aria-label="breadcrumbs">
                        <ul>
                            <li><a href="index.php">Artist Dashboard</a></li>
                            <li class="is-active"><a href="../">Edit Artist Profile</a></li>
                        </ul>
                    </nav>

                    <?php
                    echo
                        "<form action='processedit.php' method='POST' enctype='multipart/form-data'>
                            <input type='hidden' value='$userid' name ='userid' >

                                <div class='columns'>
                                    <div class='column'>
                                        <strong>Your Bio</strong>
                                        <div class='control'>
                                            <textarea class='textarea' name='editbiog' rows='10'>$biog</textarea>
                                        </div>
                                    </div>

                                    <div class='column'>
                                    <strong>Your Website Link</strong>
                                            <input class='input' type='text' value='$url' name='editurl'>
                                    </div>   

                                    <div class='column'>    
                                    <strong>Your Display Image</strong>
                                                <img src='../images/$image' />
                                            <input class='input' type='file' name='editimage'>    
                                        </div>
                                    
                                    <input type='hidden' value='$image' name ='existingimage' >
                                </div>

                            <div class='field is-grouped'>
                                <div class='control'>
                                    <input class='button is-danger is-light' type='submit' value='Save Changes' name='edit'>
                                </div>
                                <div class='control'>
                                    <a class='button is-warning is-light' href='index.php'>Cancel</a>
                                </div>
                            </div>

                        </form>
                        </div>
                    </div>
                </div>";
    ?>


                </div>
    </section>
</body>

</html>