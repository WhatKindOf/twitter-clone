<?php
$conn = mysqli_connect("localhost", "root", "abcd1234", "twitter");
$filtered_data = array(
    "userID"=>mysqli_real_escape_string($conn, $_POST['writerID']),
    "boardID"=>mysqli_real_escape_string($conn, $_POST['boardID']),
    "replyText"=>mysqli_real_escape_string($conn, $_POST['replyText'])
);

$sql = "INSERT INTO reply (writerID, writeDate, replyText, boardID) VALUES ('{$filtered_data['userID']}',NOW(),'{$filtered_data['replyText']}',{$filtered_data['boardID']})";
$result = mysqli_query($conn, $sql);

if($result === false){

} else {
    $prevPage = $_SERVER['HTTP_REFERER'];
    // 변수에 이전 페이지 정보 저장.`

    header("Location: ".$prevPage);
}
?>