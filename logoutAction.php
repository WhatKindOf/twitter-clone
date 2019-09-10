<?php
session_start();
session_destroy();
echo "<script>
        if(!alert('로그아웃 되었습니다.')){
            document.location = 'index.php';
        }
      </script>";
?>