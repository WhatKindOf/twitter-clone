<?php
session_start();
if(isset($_SESSION['userID'])){
    $user_id = $_SESSION['userID'];
    $user_password = $_SESSION['userPassword'];
}

$conn = mysqli_connect("localhost", "root", "abcd1234", "twitter");
$sql = "DELETE FROM user WHERE userID = '{$user_id}'";

$result = mysqli_query($conn, $sql);

if(result === false){
    error_log(mysqli_error($conn));
} else {
    session_destroy();
    header("Location: index.php");
}
?>