<?php
function arrive_info() {
    $api_key = "ZCYf%2FAY9AXU5%2B5M%2BUXfQmkesytz7HGmzIYAB6URM3%2Fz4GKZ9WWLJVGS1omTIb4S5knl7FGmnQOb%2BA%2F%2B6DiFWMw%3D%3D";

    $url = "http://api.gwangju.go.kr/json/arriveInfo?serviceKey=".$api_key."&BUSSTOP_ID=".$_GET['id'];

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

    switch($response->RESULT->RESULT_CODE) {
        case 'SUCCESS':     // 도착 정보 있음
            usort($response->BUSSTOP_LIST, function($a, $b) {   // 남은 시간 순으로 정렬
                return $a->REMAIN_MIN > $b->REMAIN_MIN;
            });
            $station_list = '';
            foreach ($response->BUSSTOP_LIST as $index => $row) {
                $station_list .= "
                    <tr>
                        <th class='col-1 text-center' scope='row'>{$row->SHORT_LINE_NAME}</th>
                        <td class='col-2 text-center station-e-name'>{$row->REMAIN_MIN} 분</td>
                        <td class='col-2 text-center station-name'>{$row->REMAIN_STOP} 정류소 전</td>
                        <td class='col-3 text-center'>{$row->BUSSTOP_NAME}</td>
                    </tr>
                ";
            }
            echo trim($station_list);
            break;
        case 'ERROR':       // 도착 정보 없음
            echo '<div class="mb-3" style="font-weight: bold; font-size: 1.3em;">도착 정보 없음</div>';
            break;
    }
}
?>