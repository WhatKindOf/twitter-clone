<?php
session_start();
if(isset($_SESSION['userID'])){
    $user_id = $_SESSION['userID'];
    $user_password = $_SESSION['userPassword'];
}

function getAllContents($userID){
    $conn = mysqli_connect("localhost", "root", "abcd1234", "twitter");
    $sql = "SELECT DISTINCT boardID, writerID, writeDate, boardText, board.imgPath, user.imgPath userImgPath FROM board, user WHERE writerID = userID ORDER BY writeDate DESC";
    $result = mysqli_query($conn, $sql);
    
    $content_list = "";
    while($row = mysqli_fetch_array($result)){
        $sql = "SELECT DISTINCT replyID, reply.writerID, reply.writeDate, replyText, reply.boardID, user.imgPath FROM board, reply, user WHERE reply.boardID = {$row['boardID']} and reply.writerID = user.userID";
        $res = mysqli_query($conn, $sql);
        $reply = "";
        while($r = mysqli_fetch_array($res)){
            $usr_img_path = "images/profile_basic_img.png";
            if($r['imgPath'] !== NULL){
                $usr_img_path = $r['imgPath'];
            }
            $reply .=   "<div class='reply'>
                            <div>
                                <img class='replyProfileImg' src='{$usr_img_path}' alt='profile_img'>
                            </div>
                            <div class='replyContent'>
                                <div class='replyName'>{$r['writerID']}</div>
                                <div class='replyText'>
                                    {$r['replyText']}
                                </div>
                                <div class='dateDelete'>
                                    <div class='replyDate'>{$r['writeDate']}</div>";
            if($userID === $r['writerID']) {
                $reply .=   "<form action='deleteReply.php' method='post' onsubmit='return checkDeleteReply()'>
                                <input type='hidden' name='replyID' value='{$r['replyID']}'>
                                <button class='submitBtn' type='submit'>
                                    <span class='deleteText'>삭제</span>
                                </button>    
                            </form>";
            }
                $reply .= "</div>
                        </div>
                    </div>";
            }

            $user_img_path = "images/profile_basic_img.png";
            if($row['userImgPath'] !== NULL){
                $user_img_path = $row['userImgPath'];
            }

            if($row['imgPath'] !== NULL){
                $content_list .= "<div class='contentWithPicDiv'>
                    <div class='picDiv'>
                        <img class='pic' src='{$row['imgPath']}' alt='content_pic'>
                    </div>
                    <div class='contentDiv'>
                        <div class='upper'>
                            <span class='profileDiv'>
                                <img class='profileImg' src='{$user_img_path}' alt='profile_img'>
                                <span class='profileName'>{$row['writerID']}</span>
                            </span>
                            <span class='uploadDate'>
                                {$row['writeDate']}
                            </span>
                        </div>
                        <div class='mid'>
                            <div class='summary'>
                                {$row['boardText']}
                            </div>
                            <div class='showReply'>
                                {$reply}
                            </div>
                        </div>
                        <div class='lower'>
                            <form action='inputReply.php' method='post'>
                                <input type='hidden' name='writerID' value='{$userID}'>
                                <input type='hidden' name='boardID' value='{$row['boardID']}'>
                                <input class='inputReply' type='text' name='replyText' placeholder='댓글 입력'>
                            </form>    
                        </div>
                    </div>
                </div>";
            } else {
                $content_list .= "<div class='contentWithoutPicDiv'>
                    <div class='upper'>
                        <span class='profileDiv'>
                            <img class='profileImg' src='{$user_img_path}' alt='profile_img'>
                            <span class='profileName'>{$row['writerID']}</span>
                        </span>
                        <span class='uploadDate'>
                            {$row['writeDate']}
                        </span>
                    </div>
                    <div class='mid'>
                        <div class='summary'>
                            {$row['boardText']}
                        </div>
                        <div class='showReply'>
                            {$reply}
                        </div>
                    </div>
                    <div class='lower'>
                        <form action='inputReply.php' method='post'>
                            <input type='hidden' name='writerID' value='{$userID}'>
                            <input type='hidden' name='boardID' value='{$row['boardID']}'>
                            <input class='inputReply' type='text' name='replyText' placeholder='댓글 입력'>
                        </form> 
                    </div>
                </div>";
            }
        }
    return $content_list;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="topbar.css">
    <link rel="stylesheet" href="homeStyle.css">
    <script src="fetchBlock.js"></script>
    <script>
        function checkDeleteContent(){
            if(confirm('정말 해당 게시물을 삭제하시겠습니까?')){
                return true;
            }
            else{
                return false;
            }
        }

        function checkDeleteReply(){
            if(confirm('정말 해당 댓글을 삭제하시겠습니까?')){
                return true;
            }
            else{
                return false;
            }
        }
    </script>
    <title>HOME</title>
</head>
<body>
    <div class="topbar">
        <script>fetchTopbar();</script>
    </div>

    <div class="lowerDiv">
        <?=getAllContents($user_id);?>
    </div>
    
</body>
</html>