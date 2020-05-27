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
                    <li class="is-active"><a href="../">Artist Dashboard</a></li>
                </ul>
            </nav>



            <?php
            echo
                "<div class='box'>

                    <div class='columns'>
                            <div class='column'>
                            <strong>Your Bio</strong>
                                <p>$biog</p>
                            </div>

                            <div class='column'>   
                            <strong>Your Website Link</strong>
                                    <p>$url</p>
                            </div>

                            <div class='column'>   
                            <strong>Your Display Image</strong>
                                <img src='../images/$image' />
                            </div> 
                        </div>
                    
                    <span> <a class='navbar-item button is-danger' href='edit.php?editid=$userid'>Edit Info</a></span>
                    </div>


                    <div>
                    <a class='button is-warning is-light' href='../logout.php'>Logout</a>
                </div>";

            ?>


        </div>
    </section>
</body>

</html>