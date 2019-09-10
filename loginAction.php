<?php
$conn = mysqli_connect("localhost", "root", "abcd1234", "twitter");
$filtered_data = array(
    "id"=>mysqli_real_escape_string($conn, $_POST['userID']),
    "password"=>mysqli_real_escape_string($conn, $_POST['userPassword'])
);
$sql = "SELECT * FROM user WHERE userID = '{$filtered_data['id']}' AND userPassword = '{$filtered_data['password']}'";
$result = mysqli_query($conn, $sql);

if($result->num_rows === 0){
    // $prevPage = $_SERVER['HTTP_REFERER'];
    // // 변수에 이전 페이지 정보 저장.`

    // header("Location: ".$prevPage);
    echo "<script>
            if(!alert('아이디 또는 비밀번호가 일치하지 않습니다.')){
                document.location = 'index.php';
            }
          </script>";
} else {
    session_start();
    $_SESSION['userID'] = $filtered_data['id'];
    $_SESSION['userPassword'] = $filtered_data['password'];
    header("Location: home.php");
}
?>