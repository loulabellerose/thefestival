<?php
session_start();
if (isset($_SESSION['privilegeduser'])) {

    include("../conn.php");

    //$typeofuser = $_SESSION['usertype'];
    $userid = $_SESSION['userid'];

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

    $performers = "SELECT * FROM fest_performer
                    INNER JOIN
                    fest_useraccount
                    ON
                    fest_performer.userid = fest_useraccount.userid
                    WHERE
                    statusid = '2'";

    $performerdata = $conn->query($performers);


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
                        <li class="is-active"><a href="../">Performer Account Admin</a></li>
                    </ul>
                </nav>

                <div class="columns">
                    <div class="column">

                    </div>
                    <div class="column is-6">
                        <div class="card events-card">
                            <header class="card-header">
                                <p class="card-header-title">
                                    Manage Artist User Accounts
                                </p>
                            </header>

    
                            <div class="card-table">
                                <div class="content">
                                <form>
                                    <table class="table is-fullwidth is-striped">
                                        <tbody>
                                            <?php            
                                            while ($row = $performerdata->fetch_assoc()) {
                                            $name = $row['name'];
                                            $performerid = $row['performerid'];
                                            $accountid = $row['userid'];
                                            echo 
                                            "<tr>                                              
                                                <td>$name</td>
                                                <td>
                                                <a class='button is-small is-warning' href='accountmanage.php?performer=$performerid'>Manage Performer Account</a>  
                                                </td>
                                            </tr>  ";
                                            }         
                                        echo "</tbody>
                                    </table>
                                </form>";

                            
                                ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        
                        </div>


                </div>
            </div>


            </div>
        </section>
    </body>
</html>