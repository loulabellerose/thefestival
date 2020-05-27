<?php
session_start();
if (isset($_SESSION['privilegeduser'])) {

    include("../conn.php");

    $userid = $_SESSION['userid'];

    $sitecontent = "SELECT * FROM fest_sitecontent 
                    INNER JOIN
                    fest_siteadmin ON
                    fest_sitecontent.authorid = fest_siteadmin.id
                    order by dateposted desc";

    $contentresult = $conn->query($sitecontent);

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
                        <li class="is-active"><a href="../">Site Content</a></li>
                    </ul>
                </nav>

                <div class="columns">
                    <div class="column is-3">
                        <div class="card">
                            <header class="card-header">
                                <p class="card-header-title">
                                    Add New Blog Post
                                </p>
                            </header>
                            <div class="card-content">
                                <div class="content">
                                    <div class="control">     
                                        <span> <a class='navbar-item button is-warning' href='siteadd.php'>Add New Post</a></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="card">
                            <header class="card-header">
                                <p class="card-header-title">
                                    Site Admins
                                </p>
                            </header>
                            <div class="card-content">
                                <div class="content">
                                    <div class="control">     
                                        <span> <a class='navbar-item button is-warning' href='addnewuser.php'>Add New Admin User</a></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                        <div class="column is-9">
                        <div class="card">
                            <header class="card-header">
                                <p class="card-header-title">
                                    Edit Blog Post
                                </p>
                            </header>

                        <div class="card-table">
                                <div class="content">
                                    <table class="table is-fullwidth is-striped">
                                        <tbody>
                                            <?php
                                                while ($row = $contentresult->fetch_assoc()) {
                                                $posttitle = $row['title'];
                                                $postbody = $row['body'];
                                                $postdate = $row['dateposted'];
                                                $postdate = date("jS F o", strtotime($postdate));
                                                $author = $row['name'];
                                                $postid = $row['postid'];            
                                            echo 
                                            "<tr>                                              
                                                <td>
                                                <h4>$posttitle</h4>
                                                <p>$postbody</p>
                                                <strong>$postdate</strong>
                                                </td>
                                                <td>
                                                <span>
                                                <a class='button is-small is-warning' href='siteedit.php?postid=$postid'>Edit Post</a>
                                                </span>
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


                </div>

            </div>

            </div>
        </section>
    </body>
</html>