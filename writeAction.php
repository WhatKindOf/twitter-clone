<?php
session_start();
$user_id = $_SESSION['userID'];
$prevPage = $_SESSION['prevPage'];

$conn = mysqli_connect("localhost", "root", "abcd1234", "twitter");

$contentText = mysqli_real_escape_string($conn, $_POST['contentText']);

$img_name = $_FILES['imgFile']['name'];     // 이미지 이름
$target = 'upload/content/'.$img_name;      // 이미지를 저장할 경로
$img_type = $_FILES['imgFile']['type'];     // 이미지 타입
$img_size = $_FILES['imgFile']['size'];     // 이미지 크기
$tmp_name = $_FILES['imgFile']['tmp_name']; // 이미지 임시 경로
$error_code = $_FILES['imgFile']['error'];  // 파일 에러코드

move_uploaded_file($tmp_name, $target);     // 임시 경로에 있는 파일을 지정한 위치로 이동.

$sql = "INSERT INTO board (writerID, boardText, imgPath, writeDate)
        VALUES ('{$user_id}','{$contentText}','{$target}',NOW())";
if($img_name === ""){
    global $sql;
    $sql = "INSERT INTO board (writerID, boardText, writeDate)
        VALUES ('{$user_id}','{$contentText}',NOW())";
}

$result = mysqli_query($conn, $sql);

if($result === false){
    error_log(mysqli_error($conn));
} else {
    header("Location: ".$prevPage);
}
?>