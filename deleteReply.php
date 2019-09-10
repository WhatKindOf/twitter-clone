<?php
$conn = mysqli_connect("localhost", "root", "abcd1234", "twitter");
$replyID = mysqli_real_escape_string($conn, $_POST['replyID']);

$sql = "DELETE FROM reply WHERE replyID = {$replyID}";
$result = mysqli_query($conn, $sql);

if($result === false){

} else {
    $prevPage = $_SERVER['HTTP_REFERER'];
    // 변수에 이전 페이지 정보 저장.`

    header("Location: ".$prevPage);
}
?>