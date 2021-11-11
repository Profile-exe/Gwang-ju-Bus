const url = new URL(window.location.href);
const urlParams = url.searchParams;

let page = urlParams.get('page');
if (page === null) page = '1';

const body = {          // AJAX request body
    id: '',
    page_count: 10,     // 한 페이지에 표시할 행의 수
    page_num: page,     // 현재 페이지
    is_favorite: false  // 필터링 on / off 유무
}

function get_station_list(body) { // AJAX 이용
    const init = {
        method: 'POST',
        cache: 'no-cache',
        headers: {
            'Content-Type': 'application/json; charset=utf-8'
        },
        body: JSON.stringify(body)  // JSON 형태로 POST request
    }

    fetch('/manage_bus/process_get_station_list.php', init)
        .then((res) => res.json())    // JSON 형태로 응답받고 parsing 후 사용
        .then((data) => {
            document.getElementById('station-list').innerHTML = data['station_list'];
            document.getElementById('page-list').innerHTML = data['page_nav'];
        });
}

get_station_list(body);