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
                    <li class="is-active"><a href="../">Add New User</a></li>
                </ul>
            </nav>

            <div class='box'>

                <form action='addnewuser.php' method='POST' enctype='multipart/form-data'>

                    <div class='field is-horizontal'>
                        <div class='field-label is-normal'>
                            <label class='label'>Name: </label>
                        </div>
                        <div class="field-body">
                            <div class="field">
                                <div class='control'>
                                    <input class='input' type='text' placeholder='Name' name='name' />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class='field is-horizontal'>
                        <div class='field-label is-normal'>
                            <label class='label'>Email Address: </label>
                        </div>
                        <div class='field-body'>
                            <div class='field'>
                                <div class='control'>
                                    <input class='input' name='emailaddress' type='email' placeholder="Email"/>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class='field is-horizontal'>
                        <div class='field-label is-normal'>
                            <label class='label'>Set Password: </label>
                        </div>
                        <div class='field-body'>
                            <div class='field'>
                                <div class='control'>
                                    <input class='input' name='password' type='password' placeholder="Password"/>
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
                                <input type='submit' class='button is-danger' value='Create User' name='create' />
                            </div>
                            <div class='control'>
                                <a class='button is-link is-warning' href='contentindex.php'>Cancel</a>
                            </div>
                        </div>
                </form>
            <?php
            if(isset($_POST['create'])) {

            include('../conn.php');

            $name = $conn->real_escape_string($_POST['name']);
            $name = htmlspecialchars($name);
            $emailaddress = $conn->real_escape_string($_POST['emailaddress']);
            $emailaddress = htmlspecialchars($emailaddress);
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $emailinsert = "INSERT INTO fest_accountemail
                            (emailaddress)
                            VALUES
                            ('$emailaddress')";

            $result = $conn->query($emailinsert);

            $emailid = $conn->insert_id;

            $insert = "INSERT INTO fest_useraccount
                        (emailid, password, usertype)
                        VALUES
                        ('$emailid', '$password', '1')";

            $newaccountresult = $conn->query($insert);

            $accountid = $conn->insert_id;

            $insertnewadmin = "INSERT INTO fest_siteadmin
                                (name, accountid)
                                VALUES
                                ('$name', '$accountid')";

            $insertadmin = $conn->query($insertnewadmin);


            if ($result && $newaccountresult && $insertadmin) {
                echo 
                "<div class='field is-horizontal'>
                        <div class='field-label is-normal'>                      
                        </div>

                        <div class='field is-grouped'>
                            <strong>Admin account created for $emailaddress</strong>
                        </div>
                </div>"; 
            } else {
                echo $conn->error;
            }

        }


?>

            </div>
        </div>
        </article>
        </div>


        </div>
    </section>
</body>

</html>