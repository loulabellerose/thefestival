<?php
session_start();
if (isset($_SESSION['privilegeduser'])) {

    include("../conn.php");

    $userid = $_SESSION['userid'];
    $applicationid = $conn->real_escape_string($_GET['performer']);

    $sitecontent = "SELECT * FROM fest_sitecontent 
                    INNER JOIN
                    fest_siteadmin ON
                    fest_sitecontent.authorid = fest_siteadmin.id";

    $contentresult = $conn->query($sitecontent);

    $siteadmin = "SELECT * FROM fest_siteadmin WHERE accountid = '$userid'";

    $result = $conn->query($siteadmin);

    while ($row = $result->fetch_assoc()) {
        $adminusername = $row['name'];
    }

    $performer = "SELECT * FROM fest_performer
                INNER JOIN
                fest_useraccount
                ON
                fest_performer.userid = fest_useraccount.userid
                WHERE
                performerid = '$applicationid'";

    $performerdata = $conn->query($performer);
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
                            <li><a href="performermanagement.php">Performer Account Admin</a></li>
                            <li class="is-active"><a href="../">Manage Account</a></li>
                        </ul>
                    </nav>

                    <div class='box'>

                    <?php

                    while ($row = $performerdata->fetch_assoc()) {
                        $name = $row['name'];
                        $image = $row['image'];
                        $accountid = $row['userid'];
                        $accountstatus = $row['statusid'];
                        
                        echo
                        
                        "<figure class='media-left'>
                        <article class='media'>
                        <p class='image is-64x64'>
                        <img src='../images/$image' />
                        </p>
                        </figure>

                        <div class='media-content'>
                        <div class='content'>
                        <p>
                        <strong>$name</strong>
                        </p>
                        <form method='POST' action='accountmanage.php?performer=$applicationid'>
                        <div class='field'>
                        <div class='control'>
                        <div class='select'>";
                        
                        if($accountstatus=2) {
                            echo
                            "<select name='accountstatus'>
                            <option selected='selected' value='2'>Account Active</option>
                            <option value='3'>Deactivate Account</option>
                            </select>";
                        }
                        elseif($accountstatus=3) {
                            echo
                            "<select name='accountstatus'>
                            <option value='2'>Activate Account</option>
                            <option selected='selected' value='3'>Account Deactivated</option>
                            </select>";
                        }
                        
                        echo                       
                        "</div>
                        </div>
                        </div>
                        <input type='hidden' name='performerid' value='$applicationid'>
                        <input type='hidden' name='accountid' value='$accountid'>


                        <div class='field'>
                        <p class='control'>
                        <input class='button is-warning' type='submit' value='Save' name='accountedit'>
                        </p>
                        </div>

                        </form>
                        </div>
                        </div>
                        </article>";
                    }


                    if(isset($_POST['accountedit'])) {

                    $accountid = $_POST['accountid'];
                    $performerid = $_POST['performerid'];
                    $accountstatus = $_POST['accountstatus'];

                    $account = "UPDATE fest_useraccount 
                                            SET usertype = '$accountstatus'
                                            WHERE userid = '$accountid' ";

                    $accountupdate = $conn->query($account);

                    if (!$accountupdate) {
                        echo $conn->error;
                    }

                    $performer = "UPDATE fest_performer
                                                SET statusid = '$accountstatus'
                                                WHERE userid = '$accountid'";

                    $performerupdate = $conn->query($performer);


                    if($performerupdate) {
                        echo 
                        "<div class='field is-horizontal'>
                          <div class='field-label'>
                          </div>
                      
                          <div class='field-body'>
                            <div class='field'>
                            <br>
                              <label class = 'label'>Updates saved</label>
                            </div>
                          </div>
                        </div>";
                      }
                      else{
                        echo $conn->error;
                      }
                      
                }

                    ?>
                    </div>


                    </container>
    </section>
</body>

</html>