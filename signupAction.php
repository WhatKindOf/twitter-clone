<?php
$conn = mysqli_connect("localhost", "root", "abcd1234", "twitter");
$filtered_data = array(
    "name"=>mysqli_real_escape_string($conn, $_POST['userName']),
    "id"=>mysqli_real_escape_string($conn, $_POST['userID']),
    "password"=>mysqli_real_escape_string($conn, $_POST['userPassword'])
);
$sql = "INSERT 
            INTO user (userID, userPassword, userName, signupDate)
            VALUES ('{$filtered_data['id']}','{$filtered_data['password']}','{$filtered_data['name']}',NOW())";

$result = mysqli_query($conn, $sql);
if($result === false){
    echo "저장하는 과정에서 문제가 발생하였습니다.";
    error_log(mysqli_error($conn));
} else {
    header("Location: index.php");
}
?>