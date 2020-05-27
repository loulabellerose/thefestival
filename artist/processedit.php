<?php
session_start();
$userid = $_SESSION['userid'];

if (isset($_POST['edit'])) {

include('../conn.php');

$id = $_POST['userid'];

$url = $conn->real_escape_string($_POST['editurl']);
$url = htmlspecialchars($url);
$biog = $conn->real_escape_string($_POST['editbiog']);
$biog = htmlspecialchars($biog);

$filename = $_FILES['editimage']['name'];
$filetemp = $_FILES['editimage']['tmp_name'];

if (!empty($filename)) {

    move_uploaded_file($filetemp, '../images/' . $filename);

    $update = "UPDATE fest_performer
    SET 
    url = '$url',
    biog = '$biog',
    image = '$filename'
    
    WHERE userid='$id'";

    $performerupdate = $conn->query($update);

    if (!$performerupdate) {
        echo $conn->error;
    }

    else {
        header("location: index.php");
    }
} else {

    $update = "UPDATE fest_performer
    SET 
    url = '$url',
    biog = '$biog'
    WHERE userid='$id'";

    $performerupdate = $conn->query($update);

    if (!$performerupdate) {
        echo $conn->error;
    }

    else {
        header("location: index.php");
    }
}
}
?>