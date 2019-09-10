<?php
session_start();
$user_id = $_SESSION['userID'];

$conn = mysqli_connect("localhost", "root", "abcd1234", "twitter");

$modifyName = mysqli_real_escape_string($conn, $_POST['modifyName']);

$img_name = $_FILES['imgFile']['name'];     // 이미지 이름
$target = 'upload/profile/'.$img_name;      // 이미지를 저장할 경로
$img_type = $_FILES['imgFile']['type'];     // 이미지 타입
$img_size = $_FILES['imgFile']['size'];     // 이미지 크기
$tmp_name = $_FILES['imgFile']['tmp_name']; // 이미지 임시 경로
$error_code = $_FILES['imgFile']['error'];  // 파일 에러코드

move_uploaded_file($tmp_name, $target);     // 임시 경로에 있는 파일을 지정한 위치로 이동.

if($modifyName === "" && $img_name === ""){
    echo "<script>
        if(!alert('수정할 사항이 없습니다.')){
            document.location = 'mypage.php';
        }
      </script>";
} else {
    
    $sql = '';
    if($modifyName === ""){                   // 사진만 변경할 때
        $sql = "UPDATE user SET imgPath = '{$target}' WHERE userID =  '{$user_id}'";
    } else if ($img_name === "") {              // 이름만 변경할 때
        $sql = "UPDATE user SET userName = '{$modifyName}' WHERE userID =  '{$user_id}'";
    } else {                                    // 사진, 이름 둘 다 변경할 때
        $sql = "UPDATE user SET imgPath = '{$target}', userName = '{$modifyName}' WHERE userID =  '{$user_id}'";
    }

    $result = mysqli_query($conn, $sql);

    if($result === false){
        error_log(mysqli_error($conn));
    } else {
        echo 
            "<script>
                if(!alert('수정이 성공적으로 수행되었습니다.')){
                    document.location = 'mypage.php';
                }
            </script>";
    }
}

?>