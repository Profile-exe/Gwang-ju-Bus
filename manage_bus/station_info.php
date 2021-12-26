<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/db.class.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/lib/delete_parameter.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/arrive_information.php';

if(session_status() == PHP_SESSION_NONE) {
    session_start();
}

$station_id = $_GET['id'];

$favorite_btn = '<button class="btn btn-primary disabled">즐겨찾기</button>';
$loginout = '<a id="loginout_btn" href="/manage_member/login.php" class="btn btn-secondary">로그인</a>';
if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != '') {
    $favorite_btn = '<button id="favorite_btn" class="btn btn-primary add-favorite">즐겨찾기 추가</button>';
    $loginout = '<a id="loginout_btn" href="/manage_member/process_logout.php" class="btn btn-secondary">로그아웃</a>';

    $result = null;
    try {
        $sql = "
            SELECT EXISTS(SELECT * FROM favorite WHERE user_id = :user_id AND station_id = :station_id) AS success
        ";

        $result = DB::query($sql, array(
            ':user_id'    => $_SESSION['user_id'],
            ':station_id' => $station_id
        ))[0]['success'];

        settype($result, 'integer');
        if ($result) {     // 해당 정류소가 이미 즐겨찾기 되어있음
            $favorite_btn = '<button id="favorite_btn" class="btn btn-primary delete-favorite">즐겨찾기 삭제</button>';
        }
    } catch (Exception $e) {
        exit(header('Location: /index.php?msg=Error_occurred_while_reading_favorite'));
    }
}

// 메시지 전달 시 알림
if (isset($_GET['msg'])) {
    echo '<script>alert("'.$_GET['msg'].'");</script>';
}

$redirect = '/index.php';
if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != 'http://localhost/manage_member/register.php') {
    $redirect = delete_parameter($_SERVER['HTTP_REFERER'], 'msg');
}

$result = null;
$article = null;
$is_integer = settype($station_id, 'integer');
if ($is_integer) {  // 정수는 true 반환됨
    try {
        $sql = "
            SELECT * FROM station
            WHERE station_id = :station_id;
        ";

        $result = DB::query($sql, array(
            ':station_id' => $station_id
        ));

        if ($result == array()) {
            exit(header('Location: /index.php?msg=Wrong_station_ID'));
        }

        $article = $result[0];
    } catch (Exception $e) {
        exit(header('Location: /index.php?msg=Error_occurred_while_reading_station'));
    }
} else {
    exit(header('Location: /index.php?msg=Error_occurred_while_reading_station'));
}
?>

<!doctype html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Gwang-ju-Bus</title>

    <!--Bootstrap-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<div class="container my-3 d-flex justify-content-center">
    <div class="col-10">
        <header class="my-4 d-flex justify-content-between">
            <span style="font-size:2.5em; color:gray;"># <?=$article['station_id']?> - <?=$article['station_name']?></span>
            <?=$favorite_btn?>
        </header>
        <article>
            <section class="borard_header">
                <div class="board_info d-flex justify-content-between align-items-center">
                    <div>
                        <span style="font-size: 1.3em; font-weight: bold;"><?=$article['next_station'].' 방면'?></span>
                    </div>
                    <div class="author_name">
                        <span style="font-size: 1.3em; font-weight: bold;">ARS |</span>
                        <span style="font-size: 1.3em;"><?=$article['station_ars_id']?></span>
                    </div>
                </div>
            </section>
            <hr>
            <section class="board_body mb-5 h">
                <div class="board_content" style="font-size:1.2em; color:black;">
                </div>
                <table class="table table-hover table-fix-head">
                    <thead class="table-light">
                    <tr>
                        <th class="col-1 text-center" scope="col">노선</th>
                        <th class="col-2 text-center" scope="col">남은 시간</th>
                        <th class="col-2 text-center" scope="col">남은 정류소</th>
                        <th class="col-3 text-center" scope="col">버스 위치</th>
                    </tr>
                    </thead>
                    <tbody id="bus-list">
                        <?=arrive_info()?>
                    </tbody>
                </table>
            </section>
            <hr>
            <section class="board_footer">
                <div class="d-flex justify-content-between">
                    <?=$loginout?>
                    <a href="<?=$redirect?>" class="btn btn-outline-secondary">돌아가기</a>
                </div>
            </section>
            <footer class="mt-5">
                <nav id="nav-pagination" class="position-absolute bottom-0 start-50 translate-middle">
                    <ul id="page-list" class="pagination d-flex justify-content-center">
                    </ul>
                </nav>
            </footer>
        </article>
    </div>
</div>
<script src="/js/update_favorite.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
