<?php
session_start();
if(isset($_SESSION['userID'])){
    $user_id = $_SESSION['userID'];
    $user_password = $_SESSION['userPassword'];
}
$_SESSION['prevPage'] = $_SERVER['HTTP_REFERER'];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="topbar.css">
    <link rel="stylesheet" href="writeStyle.css">
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
    <script src="fetchBlock.js"></script>
    <title>WRITE <?=$_SESSION['userID']?></title>
</head>
<body>
    <div class="topbar">
        <script>fetchTopbar();</script>
    </div>
    <div class="lowerDiv">
        <!-- 파일 업로드를 위한 인코딩 선언 enctype() -->
        <form enctype="multipart/form-data" action="writeAction.php" method="post">
            <div class="writeDiv">
                <div id="imgDiv" class="imgDiv" onmouseover="showAddBtn()" onmouseout="hideAddBtn()">
                <img class="clearSelImg" src="images/clear.png" alt="clear_img_button" onclick="clearSelectImg()">
                    <input id="raised-button-file" name="imgFile" class="hidden" type="file" accept="image/*">
                    <label for="raised-button-file">
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
                    <input class="submitBtn" type="submit" value="게시하기">
                </div>
            </div>
        </form>
    </div>

    <script src="function.js"></script>
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
</body>
</html>