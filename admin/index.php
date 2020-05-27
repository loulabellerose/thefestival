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
                        <li class="is-active">Admin Dashboard</li>
                    </ul>
                </nav>

                <div class="columns">
                    <div class="column is-6">
                        <div class="card events-card">
                            <!--<header class="card-header">
                                <a href="admincontentindex.php" class="card-header-icon" aria-label="more options">
                                <p class="card-header-title">
                                    
                                </p>
                                </a>
                            </header>-->
    
                            <div class="card-content">
                                <div class="content">
                                    Add posts, delete posts
                                </div>
                            </div>

                            <footer class="card-footer">
                                <a href="contentindex.php" aria-label="manage site content" class="card-footer-item">Manage Site Content</a>
                            </footer>
                        </div>
                    </div>

                    <div class="column is-6">
                        <div class="card">
                            <!--<header class="card-header">
                                <a href="adminperformerindex.php" class="card-header-icon" aria-label="more options">
                                <p class="card-header-title">
                                    Manage Performers
                                </p>
                            </a>
                            </header>-->

                            <div class="card-content">
                                <div class="content">
                                    Review applications, manage user accounts
                            </div>
                        </div>

                        <footer class="card-footer">
                                <a href="performerindex.php" aria-label="manage site content" class="card-footer-item">Manage Performers</a>
                        </footer>

                        </div>                     
                    </div>

                </div>
                <a class='button is-warning is-light' href='../logout.php'>logout</a>
            </div>
            
            </div>
</div>
        </section>
    </body>
</html>