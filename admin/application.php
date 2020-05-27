<?php
session_start();
if (isset($_SESSION['privilegeduser'])) {

    include("../conn.php");

    $userid = $_SESSION['userid'];
    $applicationid = $_GET['performer'];


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

    $applications = "SELECT * FROM fest_performer
                    JOIN
                    fest_accountemail
                    ON
                    fest_performer.emailid = fest_accountemail.emailid
                    WHERE
                    performerid = '$applicationid'";
    

    $applicationdata = $conn->query($applications);

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
                        <li class="is-active"><a href="../">Review Performer Application</a></li>
                    </ul>
                </nav>

        <?php

            while ($row = $applicationdata->fetch_assoc()) {
                $applicantname = $row['name'];
                $applicantbiog = $row['biog'];
                $applicantid = $row['performerid'];
                $applicantemailid = $row['emailid'];

                echo 
                "<div class='box'>
                  <article class='media'>
                    <div class='media-content'>
                    <div class='content'>
                    <strong> $applicantname</strong> 
                  </div>

                  <div class='content'>
                    <p>$applicantbiog</p>
                  </div>
                
                <div class='content'>

                  <form method='POST' action='application.php?performer=$applicationid'  enctype='multipart/form-data' >
                
                    <div class='control'>
                    <label class='radio'>
                        <input type='radio' name='applicationstatus' value='2'>
                        Approve Performer Application
                    </label>
                    <label class='radio'>
                        <input type='radio' name='applicationstatus' value='3'>
                        Reject Performer Application
                    </label>
                    </div>

                    <input type='hidden' name='performer' value='$applicantid'>
                    <input type='hidden' name='emailid' value='$applicantemailid'>
                    <input type='hidden' name='performername' value='$applicantname'>


                  </div>


                    <div class='content'>
                      <div class='field-body'>
                        <div class='field'>
                          <div class='control'>
                            <input class='button is-danger' type='submit' value='Submit' name='review'>         
                          </div>
                        </div>
                      </div>
                    </div>

                </form>";
            }
                  if(isset($_POST['review'])) {

                    $applicationstatus = $_POST['applicationstatus'];
                    $applicantid = $_POST['performer'];
                    $applicantname = $_POST['performername'];
                    $emailid = $_POST['emailid'];
      
                    $email = "SELECT emailaddress FROM fest_accountemail
                              WHERE emailid = '$emailid'";
      
                    $accountemail = $conn->query($email);
      
                    if (!$accountemail) {
                      echo $conn->error;
                    }
      
                    $update = "UPDATE fest_performer 
                                SET statusid = '$applicationstatus' 
                                WHERE performerid = '$applicantid'";
      
                    $statusupdate = $conn->query($update);
      
                    if(!$statusupdate) {
                      echo $conn->error;
                    }
                    
                    if ($applicationstatus == 2) {
      
                        $insert = "INSERT INTO fest_useraccount (emailid, usertype)
                              VALUES ('$emailid', 2)";
      
                        $accountinsert = $conn->query($insert); 

                        $userid = $conn->insert_id;
         
                        if (!$accountinsert) {
                          echo $conn->error;
                        }

                        $updateuserid = "UPDATE fest_performer 
                                  SET userid = $userid 
                                  WHERE performerid = $applicantid";

                        $updateuid = $conn->query($updateuserid);

                        if(!$updateuid) {
                          echo $conn->error;
                        }
      
                       // $pass = "SELECT password FROM fest_useraccount
                       // WHERE emailid = '$emailid'";
      
                       // $passgrab = $conn->query($pass);
      
                        //if (!$passgrab) {
                         // echo $conn->error;
                        //}
      
                        echo
                          "<div class='box'>
                            <article class='media'>
                              <div class='media-content'>
                                <div class='content'>
                                  <strong> Application from $applicantname approved</strong> 
                                  <p>An account has been created for them to access the performer dashboard with the following email address:</p>";
                                  while($row = $accountemail->fetch_assoc()) {
                                    $performeremail = $row['emailaddress'];
                                    echo
                                    "<p>$performeremail</p>";
                                  }
                                  ?>
                                  <form method='POST' action='performerindex.php'  enctype='multipart/form-data' >
                                  <div class='control'>
                                          <input type='input' name='pass' placeholder='set a password' required>
                                  </div>
                                  <div class='control'>
                                  <input class='button is-danger' type='submit' value='Set Password' name='set'>         
                                  </div>
                                  </form>
                                  <?php
                                  if(isset($_POST['set'])) {
                                    $hashedpass = password_hash($_POST['pass'], PASSWORD_DEFAULT);

                                    $passupdate = "UPDATE fest_useraccount
                                    SET password = '$hashedpass'
                                    WHERE performerid = '$applicantid'";

                                    $pwupdate = $conn->query($passupdate);

                                    if(!$pwupdate) {
                                      echo $conn->error;
                                    }

                                    else {
                                      echo "User account created successfully.";
                                    }

                                  }


                                  
                          echo        
                                "</div>
                              </div>
                            </article>
                          </div>
                          <a class='button' href='performerindex.php'>Return</a>";
                    }
                    
                    
                    elseif($applicationstatus == 3) {
      
                      $recent = "UPDATE fest_performer 
                      SET statusid = '$applicationstatus' 
                      WHERE performerid = '$applicantid'";
      
                      $applicationdata = $conn->query($applications);
      
                        echo 
                            "<div class='content'>
                              <strong> Application from $applicantname rejected</strong> 
                              </div>
                          <a class='button is-warning is-light' href='performerindex.php'>Return</a>";
      
                      }
                      
      
                    }

            ?>
</div>
                  </div>
                  </article>
            </div>
        
        </container>
    </section>
</body>

</html>