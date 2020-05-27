<?php
session_start();
include("conn.php");
?>

<!doctype html>
<html>
<body>

<?php
  include("static/head.html")
  ?>

<?php 
    include("static/nav.html")
    ?>


    <section class="section">
        <div class="container">
            <div class="columns">
                <div class="column">
                </div>
                <div class="column is-four-fifths">
                    <div class="box">
                    <p class="title">
                    Artist & Admin Log In
                    </p>
                    <div class="field">
                    <form method='POST' action='login.php' enctype='multipart/form-data' >
                        <input required class="input" type="text" name="loginemail" placeholder="E-mail Address">
                    </div>
                    <div class="field">
                        <input required class="input" type="password" name="loginpw" placeholder="Password">
                    </div>
                    </div>
                    <div class="field is-grouped">
                        <div class="control">
                            <input class="button is-danger is-light" type="submit" value="login">
                        </div>
                        <!--<div class="control">
                            <a class="button is-link is-light" href="forgotpassword.php">Forgot Password?</a>
                        </div>-->
                    </div>
                </form>
                <?php
        if(isset($_POST['loginemail'])) {
  
        $email = $_POST['loginemail'];
        $pass = $_POST['loginpw'];

        $login = "SELECT * FROM 
                fest_useraccount 
                INNER JOIN
                fest_accountemail
                ON
                fest_useraccount.emailid = fest_accountemail.emailid
                WHERE emailaddress='$email'";

        $result = $conn -> query($login);

        $numberofrows = $result -> num_rows;

        while($row = $result->fetch_assoc()){
            $type = $row['usertype'];
            $id = $row['userid'];
            $storedpass = $row['password'];
        }

        if ($numberofrows > 0){
            $_SESSION['privilegeduser'] = $email;
            $_SESSION['usertype'] = $type;
            $_SESSION['userid'] = $id;

        if (password_verify($pass, $storedpass)) {

            if ($type == '1') {
                header("location: admin/index.php");
            }

            elseif ($type == '2') {
                header("location: artist/index.php");
            }

        } else {
                echo "<strong>Invalid credentials</strong>";
            }
        }  
        else {
            echo "<strong>No user registered</strong>";
        }

        }

        ?>
                <p>Register to perform <a href="register.php">here</a></p>
                </div>
                <div class="column">
                </div>
        </div>
        

    </section>
</body>

</html>