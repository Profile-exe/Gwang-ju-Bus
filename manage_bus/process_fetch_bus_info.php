<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/db.class.php';

$api_key = "ZCYf%2FAY9AXU5%2B5M%2BUXfQmkesytz7HGmzIYAB6URM3%2Fz4GKZ9WWLJVGS1omTIb4S5knl7FGmnQOb%2BA%2F%2B6DiFWMw%3D%3D";

$url = "http://api.gwangju.go.kr/json/lineInfo?serviceKey=".$api_key;

// curl에 적용할 옵션들을 저장
$options = array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,  // 반환된 값을 string으로 변환해 저장
    CURLOPT_SSL_VERIFYPEER => false, // true인 경우 https 통신이 불가한 경우 발생
);

// curl 세션 초기화
$ch = curl_init();

// 이것도 유용한 함수 array를 받아서 한번에 옵션을 지정
curl_setopt_array($ch, $options);

// 실행 -> API 서버에서 반환한 데이터를 $response 변수에 저장한다.
$response = json_decode(curl_exec($ch));

// 세션 종료
curl_close($ch);

DB::query('TRUNCATE line'); // 테이블 비우기

foreach ($response->LINE_LIST as $key => $value) {
    $sql = "INSERT INTO line VALUES(:id, :name, :frt, :lrt, :ri, :lk, :un, :dn)";
    DB::query($sql, array(
        ':id'       => $value->LINE_ID,             // 노선 번호
        ':name'     => trim($value->LINE_NAME),     // 노선 이름
        ':frt'      => $value->FIRST_RUN_TIME,      // 첫차 시각
        ':lrt'      => $value->LAST_RUN_TIME,       // 막차 시각
        ':ri'       => $value->RUN_INTERVAL,        // 배차 간격
        ':lk'       => $value->LINE_KIND,           // 노선 종류
        ':un'       => trim($value->DIR_UP_NAME),   // 기점
        ':dn'       => trim($value->DIR_DOWN_NAME)  // 종점
    ));
}

echo $response->ROW_COUNT;