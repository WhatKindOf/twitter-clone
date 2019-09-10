<?php
$conn = mysqli_connect("localhost", "root", "abcd1234", "twitter");
$boardID = mysqli_real_escape_string($conn, $_POST['boardID']);
$sql = "DELETE FROM board WHERE boardID = {$boardID}";
$result = mysqli_query($conn, $sql);

if($result === false){
    error_log(mysqli_error($conn));
    echo "<script>
        if(!alert('삭제에 실패하였습니다.')){
            document.location = 'mypage.php';
        }
      </script>";
} else {
    echo "<script>
        if(!alert('삭제에 성공하였습니다.')){
            document.location = 'mypage.php';
        }
      </script>";
}
?>