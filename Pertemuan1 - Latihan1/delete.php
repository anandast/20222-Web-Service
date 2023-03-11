<?php
include 'conn.php';
if (isset($_POST['delete'])) {
    $id = $_POST['inputID'];
    $conn = new mysqli($servername, $username, $password, $dbname);
    $sql = "DELETE FROM tbltasks WHERE id='$id'";
    if ($conn->query($sql) === TRUE) {
        header('Location:index.php');
    }
}
$conn->close();
