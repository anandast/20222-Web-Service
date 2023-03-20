<?php
include 'conn.php';
if (isset($_POST['insert'])) {
    $task = $_POST['inputTask'];
    $desc = $_POST['inputDesc'];
    $date = $_POST['inputDate'];
    $status = $_POST['status'];
    $sql = "INSERT INTO tbltasks(`title`,`description`,`deadline`,`complete`) VALUES('$task','$desc','$date','$status')";
    if ($conn->query($sql) === TRUE) {
        header('Location:index.php');
    }
}
$conn->close();
