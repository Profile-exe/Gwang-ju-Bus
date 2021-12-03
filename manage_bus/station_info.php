<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/db.class.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/lib/delete_parameter.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/arrive_information.php';

if(session_status() == PHP_SESSION_NONE) {
    session_start();
}

// 메시지 전달 시 알림
if (isset($_GET['msg'])) {
    echo '<script>alert("'.$_GET['msg'].'");</script>';
}

$redirect = '/index.php';
if (isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != 'http://localhost/manage_member/register.php') {
    $redirect = delete_parameter($_SERVER['HTTP_REFERER'], 'msg');
}

$station_id = $_GET['id'];
$is_integer = settype($station_id, 'integer');

$result = null;
$article = null;
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
        exit(header('Location: /index.php?msg=Error_occurred_while_reading_board'));
    }
} else {
    exit(header('Location: /index.php?msg=Error_occurred_while_reading_board'));
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
        <header class="my-4">
            <h1>버스 도착 정보</h1>
        </header>
        <article>
            <section class="borard_header">
                <div class="board_id mb-3 d-flex justify-content-between align-items-baseline">
                    <span style="font-size:2em; color:gray;"># <?=$article['station_id']?> - <?=$article['station_name']?></span>
                </div>
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
            <section class="board_body mb-5">
                <div class="board_content" style="font-size:1.2em; color:black;">
                </div>
                <table class="table table-hover">
                    <thead class="table-light">
                    <tr>
                        <th class="col-1 text-center" scope="col">노선</th>
                        <th class="col-2 text-center" scope="col">남은 시간</th>
                        <th class="col-2 text-center" scope="col">남은 정류소</th>
                        <th class="col-3 text-center" scope="col">버스 위치</th>
                    </tr>
                    </thead>
                    <tbody id="station-list" >
                        <?=arrive_info()?>
                    </tbody>
                </table>
            </section>
            <hr>
            <section class="board_footer">
                <div class="d-flex justify-content-between">
                    <div>
                        추가 정보 입력
                    </div>
                    <a href="<?=$redirect?>" class="btn btn-outline-secondary">돌아가기</a>
                </div>
            </section>
        </article>
    </div>
</div>
<!--Bootstrap-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
