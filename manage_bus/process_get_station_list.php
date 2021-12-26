<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/db.class.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/pagination.class.php';

// 세션 시작 - $_SESISON['user_id'] 사용을 위해.
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$post_data = json_decode(file_get_contents('php://input')); // JSON 형태로 받은 데이터 객체로 parsing

$filter = $post_data->is_favorite ? "INNER JOIN favorite ON station.station_id = favorite.station_id WHERE favorite.user_id = '{$_SESSION['user_id']}'" : '';

// 정류소 줄 수, 블럭 수
$pagination = new Pagination($post_data->page_count, 5, $post_data->page_num, $filter);

$sql = "SELECT station.station_id, station_name, station_e_name, next_station, station_ars_id 
        FROM station {$filter} 
        ORDER BY station_id LIMIT {$pagination->limit_idx}, {$pagination->page_set}
";

$result = DB::query($sql);

$station_list = '';
if ($result) {  // 정류장이 존재하는 경우 table-row로 생성
    foreach ($result as $index => $row) {
        $station_list .= "
            <tr style='cursor:pointer' onclick='location.href=\"/manage_bus/station_info.php?id={$row['station_id']}\"'>
                <th class='col-1 text-center' scope='row'>{$row['station_id']}</th>
                <td class='col-2 text-center station-name'>{$row['station_name']}</td>
                <td class='col-2 text-center station-e-name'>{$row['station_e_name']}</td>
                <td class='col-3 text-center'>{$row['next_station']}</td>
                <td class='col-2 text-center'>{$row['station_ars_id']}</td>
            </tr>
        ";
    }
}

// table-row랑 pagenation의 nav를 반환할 것임
$response = array(
    'station_list' => $station_list,
    'page_nav'     => $pagination->BottomPageNumber()
);

echo json_encode($response);    // JSON으로 encoding 후 반환