<?php
include 'conn.php';
if (isset($_POST["update"])) {
    $id   = $_POST['inputID'];
    $task = $_POST['inputTask'];
    $desc = $_POST['inputDesc'];
    $date = $_POST['inputDate'];
    $status = $_POST['status'];
    $sql = "UPDATE tbltasks SET title='$task',description='$desc',deadline='$date',complete='$status' WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        header('Location:index.php');
    }
}
$conn->close();
