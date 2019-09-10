<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="style.css">
    <script src="fetchBlock.js"></script>
    <title>SNS</title>
</head>
<body>
    <div class="container">
        <div class="main">
            <div class="left-side">
                <div class="communicationContent">
                    <div class="delightHeader">새단장한 Twitter.com을 곧 만나보실 수 있습니다.</div>
                    <div class="delightSubheader">트위터에서는 다음과 같이 멋진 기능을 추가했습니다.</div>
                    <div class="delightItem">
                        <img class="icon" src="images/hashtag.png" alt="hashtag">
                        <div>
                            <div class="delightItemTitle">탐색하기</div>
                            <div class="delightItemText">최신 트윗, 뉴스, 동영상을 한 곳에서 확인하세요.</div>
                        </div>
                    </div>
                    <div class="delightItem">
                        <img class="icon" src="images/bookmark.png" alt="hashtag">
                        <div>
                            <div class="delightItemTitle">북마크</div>
                            <div class="delightItemText">흥미로운 트윗은 나중에 또 읽을 수 있도록 저장하세요.</div>
                        </div>
                    </div>
                    <div class="delightItem">
                        <img class="icon" src="images/paint.png" alt="hashtag">
                        <div>
                            <div class="delightItemTitle">맞춤화하기</div>
                            <div class="delightItemText">새로운 테마와 더 추가된 어두운 모드 옵션을 둘러보시고 선택해보세요.</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="right-side">
                <!-- <div class="login">
                    <form class="loginForm" action="">
                        <input class="loginForm-input" type="text" placeholder="아이디">
                        <input class="loginForm-input" type="password" placeholder="비밀번호">
                        <input class="loginForm-submit" type="submit" value="로그인">
                    </form>
                </div> -->
                <div class="signupBlock">
                    <!-- <div class="signupHeader">
                        <img class="logo" src="images/twitter.png" alt="twitter_logo">
                        <div class="signupTitle">
                            지금 세계 곳곳에서 무슨 일이 일어나고 있는지 확인하세요.
                        </div>
                    </div>
                    <div class="signupForm">
                        <div class="signupSubtitle">
                            지금 트위터에 가입하세요.
                        </div>
                        <a class="buttonSignup" href="">가입하기</a>
                        <a class="buttonLogin" href="">로그인</a>
                    </div> -->
                    <script>
                        fetchBlock('default');
                    </script>
                </div>
            </div>
        </div>
        <div class="footer">
            <p>©2019 Twitter</p>
            <p>Made By P.H.S</p>
        </div>
    </div>
</body>
</html>