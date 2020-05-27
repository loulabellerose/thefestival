<?php
session_start();
if (isset($_SESSION['privilegeduser'])) {

    include("../conn.php");

    //$typeofuser = $_SESSION['usertype'];
    $userid = $_SESSION['userid'];

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
                    <li><a href="performerindex.php">Manage Performers</a></li>
                    <li class="is-active"><a href="../">Edit Schedule</a></li>
                </ul>
            </nav>

            <section class="section">
    <div class="container">      
              <div class="pricing-table">
                
              <?php
              
              $eventid = 1;

              while ($eventid <= 3 ) {
                $eventheader = "SELECT * FROM fest_event
                        JOIN
                        fest_venue
                        ON
                        fest_event.venueid = fest_venue.venueid
                        WHERE
                        fest_event.eventid = '$eventid'";

                    $result = $conn->query($eventheader);

                    if (!$result) {
                    echo $conn->error;
                    }

                    while ($row = $result->fetch_assoc()) {
                    $eventname = $row['eventname'];
                    $venue_data = $row["venuename"];
                    }

              echo 
              "<div class='pricing-plan'>

                <div class='plan-header'>$venue_data</div>

                    <div class='plan-price'>
                        <span class='plan-price-amount'>
                            $eventname
                        </span>
                    </div>

                    <div class='plan-price'>
                        <span>
                            <a class='button is-small is-warning' href='eventedit.php?eventid=$eventid'>Edit Event</a>
                        </span>
                    </div>

                <div class='plan-items'>";
                
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

                        $result = $conn->query($event);

                        if (!$result) {
                        echo $conn->error;
                        }

                    while ($row = $result->fetch_assoc()) {
                        //$eventname = $row['eventname'];
                    $performer_data = $row["name"];
                    $start_data = $row["starttime"];
                    $start_data = date('H:i', strtotime($start_data));
                    $end_data = $row["endtime"];
                    $end_data = date('H:i', strtotime($end_data));
                    //$venue_data = $row["venuename"];
                    echo 
                    "<div class='plan-item'>$performer_data $start_data - $end_data</div>";
                    }
 
                    echo 
                    "</div>
                    </div>";
                
                    $eventid++;
            
                    }
                ?>
                
                </div>       
                </div>



              <div class="pricing-table">
                
              <?php
              
              while ($eventid <= 6 ) {
                $eventheader = "SELECT * FROM fest_event
                        JOIN
                        fest_venue
                        ON
                        fest_event.venueid = fest_venue.venueid
                        WHERE
                        fest_event.eventid = '$eventid'";

                    $result = $conn->query($eventheader);

                    if (!$result) {
                    echo $conn->error;
                    }

                    while ($row = $result->fetch_assoc()) {
                    $eventname = $row['eventname'];
                    $venue_data = $row["venuename"];
                    }

              echo 
              "<div class='pricing-plan'>

                <div class='plan-header'>$venue_data</div>

                    <div class='plan-price'>
                        <span class='plan-price-amount'>
                            $eventname
                        </span>
                    </div>

                    <div class='plan-price'>
                    <span>
                        <a class='button is-small is-warning' href='eventedit.php?eventid=$eventid'>Edit Event</a>
                    </span>
                </div>

                <div class='plan-items'>";
                
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

                        $result = $conn->query($event);

                        if (!$result) {
                        echo $conn->error;
                        }

                    while ($row = $result->fetch_assoc()) {
                        //$eventname = $row['eventname'];
                    $performer_data = $row["name"];
                    $start_data = $row["starttime"];
                    $start_data = date('H:i', strtotime($start_data));
                    $end_data = $row["endtime"];
                    $end_data = date('H:i', strtotime($end_data));
                    //$venue_data = $row["venuename"];
                    echo 
                    "<div class='plan-item'>$performer_data $start_data - $end_data</div>";
                    }
 
                    echo 
                    "</div>
                    </div>";
                
                    $eventid++;
            
                    }
                ?>
                </div>


            
              <div class="pricing-table">
                
              <?php

              while ($eventid <= 9 ) {
                $eventheader = "SELECT * FROM fest_event
                        JOIN
                        fest_venue
                        ON
                        fest_event.venueid = fest_venue.venueid
                        WHERE
                        fest_event.eventid = '$eventid'";

                    $result = $conn->query($eventheader);

                    if (!$result) {
                    echo $conn->error;
                    }

                    while ($row = $result->fetch_assoc()) {
                    $eventname = $row['eventname'];
                    $venue_data = $row["venuename"];
                    }

              echo 
              "<div class='pricing-plan'>

                <div class='plan-header'>$venue_data</div>

                    <div class='plan-price'>
                        <span class='plan-price-amount'>
                            $eventname
                        </span>
                    </div>

                    <div class='plan-price'>
                    <span>
                        <a class='button is-small is-warning' href='eventedit.php?eventid=$eventid'>Edit Event</a>
                    </span>
                </div>

                <div class='plan-items'>";
                
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

                        $result = $conn->query($event);

                        if (!$result) {
                        echo $conn->error;
                        }

                    while ($row = $result->fetch_assoc()) {
                        //$eventname = $row['eventname'];
                    $performer_data = $row["name"];
                    $start_data = $row["starttime"];
                    $start_data = date('H:i', strtotime($start_data));
                    $end_data = $row["endtime"];
                    $end_data = date('H:i', strtotime($end_data));
                    //$venue_data = $row["venuename"];
                    echo 
                    "<div class='plan-item'>$performer_data $start_data - $end_data</div>";
                    }
 
                    echo 
                    "</div>
                    </div>";
                
                    $eventid++;
            
                    }
                ?>
                </div>
                </div>



    </div>
  </section>
</body>

</html>