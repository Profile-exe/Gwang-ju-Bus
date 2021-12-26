<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/db.class.php';

if(session_status() == PHP_SESSION_NONE) {
    session_start();
}

// 로그인 없이 접근한 경우
if (!isset($_SESSION['user_id']) || $_SESSION['user_id'] == '') {
    exit(header('Location: /index.php?msg=Wrong_approach'));
}

$post_data = json_decode(file_get_contents('php://input'));

try {
    $sql = "
        INSERT INTO favorite (station_id, user_id) VALUES (:station_id, :user_id) 
    ";

    $result = DB::query($sql, array(
        ':station_id' => $post_data->station_id,
        ':user_id'    => $_SESSION['user_id']
    ));

    echo 'true';
} catch (Exception $e) {
    echo 'false';
}