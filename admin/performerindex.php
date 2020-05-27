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

    $applications = "SELECT * FROM fest_performer
                        WHERE
                        statusid = '1'";

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
                        <!--<li><a href="../">Bulma</a></li>
                        <li><a href="../">Templates</a></li>
                        <li><a href="../">Examples</a></li>-->
                        <li><a href="index.php">Admin Dashboard</a></li>
                        <li class="is-active"><a href="../">Manage Performers</a></li>
                    </ul>
                </nav>

                <div class="columns">
                    <div class="column is-6">
                        <div class="card events-card">
                            <header class="card-header">
                                <p class="card-header-title">
                                    Review Artist Applications
                                </p>
                            </header>
    
                            <div class="card-table">
                                <div class="content">
                                    <table class="table is-fullwidth is-striped">
                                        <tbody>
                                            <?php            
                                            while ($row = $applicationdata->fetch_assoc()) {
                                            $applicantname = $row['name'];
                                            $applicantbiog = $row['biog'];
                                            $applicantid = $row['performerid'];
                                            echo 
                                            "<tr>                                              
                                                <td>$applicantname</td>
                                                <td>
                                                <a class='button is-small is-warning' href='application.php?performer=$applicantid'>Review Application</a>
                                                </td>
                                            </tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                        </div>
                    </div>

                    <div class="column is-6">
                        <div class="card events-card">    
                                <div class="card-content">
                                    <div class="content">
                                        Manage set times
                                    </div>
                                </div>

                                <footer class="card-footer">
                                    <a href="scheduling.php" aria-label="manage site content" class="card-footer-item">
                                        Scheduling</a>
                                </footer>
                            </div>

                            <div class="card events-card">
        
                                <div class="card-content">
                                    <div class="content">
                                        Manage user accounts for performers
                                    </div>
                                </div>

                                <footer class="card-footer">
                                    <a href="performermanagement.php" aria-label="manage site content" class="card-footer-item">
                                        Performer Account Admin</a>
                                </footer>
                            </div>
                    </div>

                </div>
            </div>
            </div>

            </div>
        </section>
    </body>
</html>