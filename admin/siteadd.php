<?php
session_start();
if (isset($_SESSION['privilegeduser'])) {

    include("../conn.php");

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
                    <li><a href="contentindex.php">Site Content</a></li>
                    <li class="is-active"><a href="../">Add New Post</a></li>
                </ul>
            </nav>

            <div class='box'>

                <form action='processsiteadd.php' method='POST' enctype='multipart/form-data'>

                    <div class='field is-horizontal'>
                        <div class='field-label is-normal'>
                            <label class='label'>Title: </label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class='control'>
                                    <input class='input' type='text' value='' name='newposttitle' />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class='field is-horizontal'>
                        <div class='field-label is-normal'>
                            <label class='label'>Post Body: </label>
                        </div>
                        <div class='field-body'>
                            <div class='field'>
                                <div class='control'>
                                    <textarea class='textarea' name='newpostbody'>
                                        </textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="field is-horizontal">
                        <div class="field-label is-normal">
                            <!--Left empty for spacing-->
                        </div>

                        <div class='field is-grouped'>
                            <div class='control'>
                                <input type='submit' class='button is-danger' value='Upload Post' />
                            </div>
                            <div class='control'>
                                <a class='button is-link is-warning' href='contentindex.php'>Cancel</a>
                            </div>
                        </div>
                </form>
            </div>
        </div>
        </article>
        </div>


        </div>
    </section>
</body>

</html>