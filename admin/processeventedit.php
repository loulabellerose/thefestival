<?php
session_start();
if (isset($_SESSION['privilegeduser'])) {

    include("../conn.php");

    $userid = $_SESSION['userid'];

    $siteadmin = "SELECT * FROM fest_siteadmin WHERE accountid = '$userid'";

    $result = $conn->query($siteadmin);

    while ($row = $result->fetch_assoc()) {
        $adminusername = $row['name'];
    }

        $seteventid = $_POST['selectevent'];
        $updateeventname = $_POST['eventnameedit'];
        $updatevenue = $_POST['venueid'];
        //$readsetid = $_POST['setid'];
        //$updateperformerid = $_POST['performerid'];

        $eventupdate = "UPDATE fest_event
        SET
        eventname = '$updateeventname',
        venueid = '$updatevenue'
        WHERE
        eventid = '$seteventid'";

        $applyeventupdate = $conn->query($eventupdate);

        if(!$applyeventupdate) {
            echo $conn->error;
        }

        $readsetidarray = unserialize($_POST['setidarray']);

        for($counter = 0; $counter < count($readsetidarray); $counter++) {
            
            $getfield = "field".$counter;

            $updateperformerid = $_POST["$getfield"];

            $setid = $readsetidarray[$counter];

            $setupdate = "UPDATE fest_sets
                            SET
                            performer = '$updateperformerid'
                            WHERE
                            setid = '$setid'";

            $applysetupdate = $conn->query($setupdate);

            if(!$applysetupdate) {
                echo $conn->error;
            }
    }
    }
else {
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
                    <li><a href="performerindex.php">Manage Performers</a></li>
                    <li><a href="scheduling.php">Edit Schedule</a></li>
                    <li class="is-active"><a href="../">Event Update Saved</a></li>
                </ul>
            </nav>

                <div class="container">
                    <div class='box'>    
                        <h1>Event changes saved</h1>
                        <div>
                        <a class='button is-warning' href='scheduling.php'>Return</a>
                        </div>
                    </div>  
                </div>  

            </div>
        </section>
</body>

</html>