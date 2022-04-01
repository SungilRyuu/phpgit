<?php
    include "../connect/connect.php";
    include "../connect/session.php";
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시글 보기</title>
    <?php
        include "../include/style.php";
    ?>
</head>
<body>
    <?php
        include "../include/skip.php";
    ?>
    <!-- //skip -->

    <?php
        include "../include/header.php";
    ?>
    <!-- //header -->
    <?php
    $boardID = $_GET['boardID'];
    $memberID = $_SESSION['memberID'];
    echo $boardID, $memberID;
?>
    <main id="contents">
        <h2 class="ir_so">컨텐츠 영역</h2>
        <section id="board-type" class="section center mb100">
            <div class="container">
                <h3 class="section__title">게시판 보기</h3>
                <p class="section__desc">
                    작성된 게시글을 살펴볼 수 있습니다.
                </p>
                <div class="board__inner">
                    <div class="board__table">
                        <button class="button dark" onclick="location.href='like.php?boardID=<?=$boardID?>&memberID=<?=$memberID?>' ">
                                <div class="hand">
                                    <div class="thumb"></div>
                                </div>
                                <span>Like<span>d</span></span>
                        </button>
                        <table>
                            <colgroup>
                                <col style="width: 30%;">
                                <col style="width: 70%;">
                            </colgroup>
                            <tbody>
<?php
    $boardID = $_GET['boardID'];
    // echo $boardID;
    $sql = "SELECT b.boardTitle, m.youName, b.regTime, b.boardView, b.boardContents, b.liked FROM myBoard b JOIN myMember m ON(m.memberID = b.memberID) WHERE b.boardID = {$boardID}";
    $result = $connect -> query($sql);

    $sql = "UPDATE myBoard SET boardView = boardView + 1 WHERE boardID = {$boardID}";
    $connect -> query($sql);

    if($result){
        $boardInfo = $result -> fetch_array(MYSQLI_ASSOC);
        // echo "<pre>";
        // var_dump($boardInfo);
        // echo "</pre>";
    }

echo "<tr><th>제목</th><td class='left'>".$boardInfo['boardTitle']."</td></tr>";
echo "<tr><th>글쓴이</th><td class='left'>".$boardInfo['youName']."</td></tr>";
echo "<tr><th>등록일</th><td class='left'>".date('Y-m-d H:i', $boardInfo['regTime'])."</td></tr>";
echo "<tr><th>조회수</th><td class='left'>".$boardInfo['boardView']."</td></tr>";
echo "<tr class='height'><th>내용</th><td class='left height'>".$boardInfo['boardContents']."</td></tr>";
echo "<tr><th>좋아요</th><td class='left'>".$boardInfo['liked']."</td></tr>";
?>

                            </tbody>
                        </table>
                    </div>
                    <div class="board__btn">
                        <a href="boardRemove.php?boardID=<?=$boardID?>" onclick="return noticeRemove();">삭제하기</a>
                        <a href="boardModify.php?boardID=<?=$boardID?>">수정하기</a>
                        <a href="board.php">목록보기</a>
                    </div>
                </div>

        </section>

    <main>
        <!-- //main -->
    <?php
        include "../include/footer.php";
    ?>
    <!--//footer -->

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        function likedd(){
            alert('ddd');
        }
        function noticeRemove(){
            let notice = confirm("정말 삭제하시겠습니까?");
            return notice;

        }
        document.querySelectorAll(".button").forEach((button) => {
            button.addEventListener("click", (e) => {
                button.classList.toggle("liked");
                if (button.classList.contains("liked")) {
                    gsap.fromTo(
                        button,
                        {
                            "--hand-rotate": 8
                        },
                        {
                            ease: "none",
                            keyframes: [
                                {
                                    "--hand-rotate": -45,
                                    duration: 0.16,
                                    ease: "none"
                                },
                                {
                                    "--hand-rotate": 15,
                                    duration: 0.12,
                                    ease: "none"
                                },
                                {
                                    "--hand-rotate": 0,
                                    duration: 0.2,
                                    ease: "none",
                                    clearProps: true
                                }
                            ]
                        }
                    );
                }
            });
        });

    </script>

</body>
</html>