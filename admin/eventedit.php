<?php
session_start();
if (isset($_SESSION['privilegeduser'])) {

    include("../conn.php");

    $eventid = $_GET['eventid'];
    $userid = $_SESSION['userid'];

    $siteadmin = "SELECT * FROM fest_siteadmin WHERE accountid = '$userid'";

    $result = $conn->query($siteadmin);

    while ($row = $result->fetch_assoc()) {
        $adminusername = $row['name'];
    }

    $event = "SELECT * FROM fest_performer 
    JOIN fest_sets
    ON
    fest_sets.performer = fest_performer.performerid
    JOIN
    fest_event
    ON 
    fest_sets.eventid = fest_event.eventid
    JOIN
    fest_venue
    ON
    fest_event.venueid = fest_venue.venueid
    WHERE
    fest_event.eventid = '$eventid'";

    $eventdata = $conn->query($event);

    if (!$eventdata) {
    echo $conn->error;
    }

    $basic = "SELECT * FROM fest_event
                WHERE
                eventid = '$eventid'"; 


    
    $basicinfo = $conn->query($basic);

    if (!$basicinfo){
        echo $conn->error;
    }

    while ($row = $basicinfo->fetch_assoc()) {
        $eventname = $row['eventname'];
        $setvenueid = $row['venueid'];
    }

    
    $getnumsets = "SELECT * FROM fest_sets
              WHERE
            eventid = '$eventid'"; 

    $numsets = $conn->query($getnumsets);

$setcount = mysqli_num_rows($numsets);

    echo $setcount;

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
                    <li><a href="performerindex.php">Manage Performers</a></li>
                    <li><a href="scheduling.php">Edit Schedule</a></li>
                    <li class="is-active"><a href="../">Edit Event</a></li>
                </ul>
            </nav>

                <div class="container"> 
                    <div class='box'>
                
              <?php
              echo
                "<form action='processeventedit.php' method='POST' enctype='multipart/form-data'>
                <input type='hidden' value='$eventid' name ='selectevent' >
                <div class='field is-horizontal'>
                    <div class='field-label is-normal'>
                        <label class='label'>Event Name</label>
                    </div>                   
                    <input class='input' type='text' value='$eventname' name='eventnameedit'>                
                </div>
                
                <div class='field is-horizontal'>
                    <div class='field-label is-normal'>
                        <label class='label'>Venue</label>
                    </div>    
                        <div class='select'>
                            <select name='venueid'>";

                            $venue = "SELECT * FROM fest_venue";

                            $venuelist = $conn->query($venue);

                            if(!$venuelist) {
                                echo $conn->error;
                            }

                            while ($row = $venuelist->fetch_assoc()) {
                                $venuename = $row['venuename'];
                                $venueid = $row['venueid'];

                                if ($venueid == $setvenueid) {
                                echo
                                "<option selected value='$venueid'>$venuename</option>";
                                }
                                else {
                                echo
                                "<option value='$venueid'>$venuename</option>";
                                }
                            }
                            echo        
                            "</select>
                        </div>           
                </div>";

                $setidarray = array();
                $performeridarray = array();

                $counter = 0;

                while ($row = $eventdata->fetch_assoc()) {

                    $performer_data = $row["name"];
                    $setperformerid = $row["performerid"];
                    $setid = $row["setid"];
                    $start_data = $row["starttime"];
                    $start_data = date('H:i', strtotime($start_data));
                    $end_data = $row["endtime"];
                    $end_data = date('H:i', strtotime($end_data));

                    array_push($setidarray, $setid);
                    $field = "field$counter";

                        echo
                        "<div class='field is-horizontal'>
                            <div class='field-label is-normal'>
                                <label class='label'>$start_data - $end_data</label>
                            </div>    
                            <div class='select'>
                                <select name='$field' id='performerid'>";

                                $performer = "SELECT * FROM fest_performer
                                                WHERE
                                                statusid=2";
                                    
                                $readperformer = $conn->query($performer);

                                if(!$readperformer) {
                                    echo $conn->error;
                                }
                                

                                while ($row = $readperformer->fetch_assoc()) {
                                    $name = $row['name'];
                                    $performerid = $row['performerid'];
                                    
                                    

                                    if ($performerid == $setperformerid) {
                                        
                                        echo
                                        "<option selected value='$performerid'>$name</option>";
                                    }

                                    else {
                                        echo
                                        "<option value='$performerid'>$name</option>";
                                    }
                                    
                                }
                                    echo
                                    "</select>";

                                    
                                    echo
                                 "</div>";
                                 $counter++;
                                 
                                 echo 
                                 "</div>"; 
                                 
                        }
                        $postsetdata = serialize($setidarray);

                        echo "<input type='hidden' value='$postsetdata' name ='setidarray' >"

                ?>

                    <div class='field is-grouped'>
                    <div class='control'>
                        <input class='button is-danger' type='submit' value='Save Changes' name='edit'>
                    </div>
                    <div class='control'>
                        <a class='button is-link is-warning' href='scheduling.php'>Cancel</a>
                    </div>
                </div>
                </form>
                

               <!--$postperformerdata = serialize($performeridarray);

                //echo "<input type='hidden' value='$postperformerdata' name='performeridarray'>";


;

                ?>-->

                
                </div>       
                </div>
                </div>    

                

    </div>
  </section>
</body>

</html>