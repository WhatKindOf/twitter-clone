<?php
session_start();
if(isset($_SESSION['userID'])){
    $user_id = $_SESSION['userID'];
    $user_password = $_SESSION['userPassword'];
}
$conn = mysqli_connect("localhost", "root", "abcd1234", "twitter");

$sql = "SELECT * FROM user WHERE userID = '{$user_id}'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);

$user_img_path = "images/profile_basic_img.png";
if($row['imgPath'] !== NULL){
    $user_img_path = $row['imgPath'];
}
$user_name = $row['userName'];
$signup_date = $row['signupDate'];

function getUserContents($userID){
    $conn = mysqli_connect("localhost", "root", "abcd1234", "twitter");
    $sql = "SELECT DISTINCT boardID, writerID, writeDate, boardText, board.imgPath, user.imgPath userImgPath FROM board, user WHERE writerID = userID and writerID = '{$userID}' ORDER BY writeDate DESC";
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
                                <button class='submitBtns' type='submit'>
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
                <div>
                    <div class='upper'>
                        <div class='btns'>
                            <button class='submitBtns' onclick='showModifyContentModal({$row['boardID']})'>
                                <img class='modifyContentBtn' src='images/edit.png'>
                            </button>
                            <form class='deleteForm' action='deleteContent.php' method='post' onsubmit='return checkDeleteContent()'>
                                <input type='hidden' name='boardID' value='{$row['boardID']}'>
                                <button class='submitBtns' type='submit'>
                                    <img class='clearBtn' src='images/clear.png'>
                                </button>    
                            </form>
                        </div>    
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
                    <div class='btns'>
                        <button class='submitBtns' onclick='showModifyContentModal({$row['boardID']})'>
                            <img class='modifyContentBtn' src='images/edit.png'>
                        </button>
                        <form class='deleteForm' action='deleteContent.php' method='post' onsubmit='return checkDeleteContent()'>
                            <input type='hidden' name='boardID' value='{$row['boardID']}'>
                            <button class='submitBtns' type='submit'>
                                <img class='clearBtn' src='images/clear.png'>
                            </button>    
                        </form>
                    </div>  
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
    <link rel="stylesheet" href="writeStyle.css">
    <link rel="stylesheet" href="mypageStyle.css">
    <link rel="stylesheet" href="modal.css">
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
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

        function deleteUser(){
            const answer = prompt('비밀번호 확인 후 탈퇴를 진행합니다.');
            console.log(answer);
            if(answer === '<?=$user_password?>') {
                document.location = 'deleteUser.php';
            } else {
                alert('올바른 비밀번호를 입력해주세요.');
            }
        }

        function showModifyUserModal(){
            const modal = document.querySelector('#modifyUserModal');

            modal.style.display = "flex";
        }

        function hideModifyUserModal(){
            const modal = document.querySelector('#modifyUserModal');

            modal.style.display = "none";
        }

        function showModifyContentModal(board_id){
            const modal = document.querySelector('#modifyContentModal');
            const boardID = document.querySelector('.boardID');

            modal.style.display = "flex";
            boardID.value = board_id;
        }

        function hideModifyContentModal(){
            const modal = document.querySelector('#modifyContentModal');
            const boardID = document.querySelector('.boardID');

            modal.style.display = "none";
            boardID.value = "";
        }
    </script>

    <title>MYPAGE</title>
</head>
<body>
    <div class="topbar">
        <script>fetchTopbar();</script>
    </div>

    <div class="lowerDiv">
        <div class="left">
            <div class="fix">
                <div class="profile">
                    <img class="profilePic" src="<?=$user_img_path?>" alt="profile_img">
                    <p class="name"><?=$user_name?></p>
                    <p>가입일</p>
                    <p class="signDate"><?=$signup_date?></p>
                </div>  
                <a class="modifyUserBtn" onclick="showModifyUserModal()">정보 수정</a>
                <a class="deleteUserBtn" onclick="deleteUser()">회원 탈퇴</a>
            </div>
        </div>
        <div class="right">
            <?=getUserContents($user_id);?>
        </div>
    </div>

    <div id="modifyUserModal" class="modal">
        <div class="modal-content">
            <div class="closeDiv">
                <span class="modalClose" onclick="hideModifyUserModal()">&times;</span>
            </div>
            <form enctype="multipart/form-data" action="modifyAction.php" method="post">
                <div class="modifyDiv">
                    <div id="imgDiv" class="modifyImgDiv" onmouseover="showModifyBtn()" onmouseout="hideModifyBtn()">
                    <img class="clearModifyImg" src="images/clear.png" alt="clear_img_button" onclick="clearModifyImg()">
                        <input id="raised-button-file" name="imgFile" class="hidden" type="file" accept="image/*">
                        <label for="raised-button-file">
                            <!-- form태그 안에 button태그를 사용하게 되면 form태그는 이를 submit으로 인식하게 된다.
                            이를 방지하기 위해서는 button태그의 type을 button이라고 명시해줘야 한다. -->
                            
                            <img class="modifyAddBtn" src="images/modifyAdd.png" alt="plus_button">
                        
                        </label>
                        <img class="showModifyImg">
                    </div>
                    <div>
                        <input class="modifyName-input" name="modifyName" type="text" placeholder="변경할 이름">
                    </div>
                    <input class="submBtn" type="submit" value="수정하기">
                </div>
            </form>
        </div>
    </div>

    <div id="modifyContentModal" class="modal">
        <div class="modal-contents">
            <div class="closeDiv">
                <span class="modalClose" onclick="hideModifyContentModal()">&times;</span>
            </div>
            <form enctype="multipart/form-data" action="modifyContentAction.php" method="post">
                <input class="boardID" type='hidden' name='boardID'>
                <div class="writeDiv">
                    <div id="imgDiv" class="imgDiv" onmouseover="showAddBtn()" onmouseout="hideAddBtn()">
                    <img class="clearSelImg" src="images/clear.png" alt="clear_img_button" onclick="clearSelectImg()">
                        <input id="raised-button" name="imgFile" class="hidden" type="file" accept="image/*">
                        <label for="raised-button">
                            <!-- form태그 안에 button태그를 사용하게 되면 form태그는 이를 submit으로 인식하게 된다.
                            이를 방지하기 위해서는 button태그의 type을 button이라고 명시해줘야 한다. -->
                            
                            <img class="addBtn" src="images/plus.png" alt="plus_button">
                        
                        </label>
                        <img id="showSelImg">
                    </div>
                    <div class="contentDiv">
                        <div>
                            <textarea class="inputText" name="contentText" placeholder="스토리 작성" onkeyup="handleValueChange(this)"></textarea>
                            <div class="textLength">(<span class="length">0</span>&nbsp;/ 100자)</div>
                        </div>
                        <input class="submitBtn" type="submit" value="수정하기">
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <script>
        var sel_file;

        $(document).ready(function() {
            $("#raised-button-file").on("change", handleImgFileSelect);
        });

        function handleImgFileSelect(e){
            var files = e.target.files;
            var filesArr = Array.prototype.slice.call(files);

            filesArr.forEach(function(f){
                if(!f.type.match("image.*")){
                    alert("확장자는 이미지 확장자만 가능합니다.");
                    return;
                }

                sel_file = f;

                var reader = new FileReader();
                reader.onload = function(e){
                    hideAddBtn();
                    $(".showModifyImg").css("display", "block");
                    $(".showModifyImg").attr("src", e.target.result);
                    $(".clearModifyImg").css("display", "block");
                }
                reader.readAsDataURL(f);
            })
        }

        function clearModifyImg(){
            $(".showModifyImg").removeAttr('src');
            $(".showModifyImg").css("display", "none");
            $(".clearModifyImg").css("display", "none");
        }
    </script>

    <script>
        var img_file;

        $(document).ready(function() {
            $("#raised-button").on("change", handleImgSelect);
        });

        function handleImgSelect(e){
            var files = e.target.files;
            var filesArr = Array.prototype.slice.call(files);

            filesArr.forEach(function(f){
                if(!f.type.match("image.*")){
                    alert("확장자는 이미지 확장자만 가능합니다.");
                    return;
                }

                img_file = f;

                var reader = new FileReader();
                reader.onload = function(e){
                    hideModifyBtn();
                    $("#showSelImg").css("display", "block");
                    $("#showSelImg").attr("src", e.target.result);
                    $(".clearSelImg").css("display", "block");
                }
                reader.readAsDataURL(f);
            })
        }

        function clearSelectImg(){
            $("#showSelImg").removeAttr('src');
            $("#showSelImg").css("display", "none");
            $(".clearSelImg").css("display", "none");
        }
    </script>

    <script src="function.js"></script>
</body>
</html>