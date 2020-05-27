<?php
session_start();
include("conn.php");
if (isset($_SESSION['privilegeduser'])) {

    $typeofuser = $_SESSION['usertype'];
    $userid = $_SESSION['userid'];
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
      <section class="hero">
          <div class="hero-body">
            <div class="container">
            <h1 class="title has-text-centered">
                Friday
              </h1>
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
              "<div class='pricing-plan is-warning'>

                <div class='plan-header'>$venue_data</div>

                    <div class='plan-price'>
                        <span class='plan-price-amount'>
                            $eventname
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
            </section>

        <section class="hero">
          <div class="hero-body">
            <div class="container">
            <h1 class="title has-text-centered">
                Saturday
              </h1>
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
              "<div class='pricing-plan is-danger'>

                <div class='plan-header'>$venue_data</div>

                    <div class='plan-price'>
                        <span class='plan-price-amount'>
                            $eventname
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

        <section class="hero">
          <div class="hero-body">
            <div class="container">
            <h1 class="title has-text-centered">
                Sunday
              </h1>
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
              "<div class='pricing-plan is-warning'>

                <div class='plan-header'>$venue_data</div>

                    <div class='plan-price'>
                        <span class='plan-price-amount'>
                            $eventname
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
  </section>
</body>

</html>