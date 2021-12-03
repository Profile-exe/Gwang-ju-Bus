<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/db.class.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/lib/delete_parameter.php';

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
            <h1>헤더</h1>
        </header>
        <article>
            <section class="borard_header">
                <div class="board_id mb-3 d-flex justify-content-between align-items-baseline">
                    <span style="font-size:2em; color:gray;"># <?=$article['station_id']?> - <?=$article['station_name']?></span>
                </div>
            </section>
            <hr>
            <section class="board_body mb-5">
                <div class="board_content" style="font-size:1.2em; color:black;">
                    버스 정보 입력
                </div>
            </section>
            <hr>
            <section class="board_footer">
                <div>
                    추가 정보 입력
                </div>
            </section>
        </article>
    </div>
</div>
<!--Bootstrap-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>