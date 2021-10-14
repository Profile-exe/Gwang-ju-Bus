<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/db.class.php';

$api_key = "ZCYf%2FAY9AXU5%2B5M%2BUXfQmkesytz7HGmzIYAB6URM3%2Fz4GKZ9WWLJVGS1omTIb4S5knl7FGmnQOb%2BA%2F%2B6DiFWMw%3D%3D";

$url = "http://api.gwangju.go.kr/json/stationInfo?serviceKey=".$api_key;

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

DB::query('TRUNCATE station'); // 테이블 비우기

foreach ($response->STATION_LIST as $key => $value) {
    $sql = "INSERT INTO station 
            VALUES(:station_id, :busstop_id, :name, :e_name, :longitude, :latitude, :ars_id, :next_station)";
    DB::query($sql, array(
        ':station_id'     => $value->STATION_NUM,           // 정류소 고유 ID
        ':busstop_id'     => $value->BUSSTOP_ID,            // 정류소 번호
        ':name'           => trim($value->BUSSTOP_NAME),    // 정류소 이름
        ':e_name'         => trim($value->NAME_E),          // 정류소 영문 이름
        ':longitude'      => $value->LONGITUDE,             // 위도
        ':latitude'       => $value->LATITUDE,              // 경도
        ':ars_id'         => $value->ARS_ID,                // ARS 번호
        ':next_station'   => trim($value->NEXT_BUSSTOP),    // 정류소 방향
    ));
}

echo $response->ROW_COUNT;