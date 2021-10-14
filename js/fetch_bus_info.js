const init = {
    method: 'GET',
    headers: {
        'Content-type': 'charset=utf-8',
    }
}

document.getElementById('fetch_bus_info').addEventListener('click', (e) => {
    fetch('/manage_bus/process_fetch_bus_info.php', init)
        .then((res) => res.text())
        .then(row_count => {
            alert(`${row_count}개의 버스 노선이 업데이트 되었습니다.`);
        });
})
