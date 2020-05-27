<?php
session_start();
include("conn.php");
if (isset($_SESSION['privilegeduser'])) {

    $typeofuser = $_SESSION['usertype'];
    $userid = $_SESSION['userid'];
}

$performerid = $_GET['performer'];

$read = "SELECT * FROM fest_performer
        JOIN
        fest_sets
        ON
        fest_performer.performerid = fest_sets.performer
        JOIN
        fest_event
        ON
        fest_sets.eventid = fest_event.eventid
        JOIN
        fest_eventday
        ON
        fest_event.eventdayid = fest_eventday.eventdayid 
        WHERE performerid = '$performerid' ";

$result = $conn->query($read);

while ($row = $result->fetch_assoc()) {
    $name_data = $row["name"];
    $biog_data = $row["biog"];
    $url_data = $row["url"];
    $img = $row["image"];
    $event = $row["eventname"];
    $start = $row["starttime"];
    $start = date("H:i", strtotime($start));
    $end = $row["endtime"];
    $end = date("H:i", strtotime($end));
    $day = $row["day"];
}

if (!$result) {
  echo $conn->error;
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

      <?php
        echo 
        "<div class='box'>
            <article class='media'>
                <figure class='media-left'>
                    <p class='image is-64x64'>
                        <img src='images/$img'>
                    </p>
                </figure>

                <div class='media-content'>
                    <div class='content'>
                        <strong> $name_data </strong> 
                    </div>

                    <div class='content'>
                      <p>$biog_data </p>
                    </div>
                    
                    <div class='content'>
                      <strong>Playing at $event on $day from $start til $end</strong>
                    </div>

                    <div class='content'>
                      <div class='buttons'>
                        <a class='button is-small is-danger is-light' target='_blank' href='http://$url_data'>Artist Website</a>
                        <a class='button is-small is-warning is-light' href='artists.php'>Back</a>
                      </div>    
                </div>

        </div>";
      
      ?>

    </div>
  </section>
</body>

</html>