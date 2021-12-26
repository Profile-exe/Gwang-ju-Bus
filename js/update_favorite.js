const url = new URL(window.location.href);
const urlParams = url.searchParams;

let station_id = urlParams.get('id');

const body = {
    station_id: station_id
}

const init = {
    method: 'POST',
    headers: {
        'Content-type': 'charset=utf-8',
    },
    body: JSON.stringify(body)
}

document.getElementById('favorite_btn')?.addEventListener('click', (e) => {
    const btn = e.target;
    if (btn.classList.contains('add-favorite')) {
        fetch('/manage_bus/process_add_favorite.php', init)
            .then((res) => Boolean(res.text()))
            .then((is_updated) => {
                if (is_updated) {
                    btn.classList.remove('add-favorite');
                    btn.classList.remove('btn-primary');
                    btn.classList.add('btn-outline-primary');
                    btn.classList.add('delete-favorite');
                    btn.innerText = '즐겨찾기 삭제';
                } else {
                    alert('즐겨찾기 추가 프로세스 도중에 오류가 발생했습니다.');
                }
            });
    } else if (btn.classList.contains('delete-favorite')) {
        fetch('/manage_bus/process_delete_favorite.php', init)
            .then((res) => Boolean(res.text()))
            .then(is_updated => {
                if (is_updated) {
                    btn.classList.remove('delete-favorite');
                    btn.classList.remove('btn-outline-primary');
                    btn.classList.add('btn-primary');
                    btn.classList.add('add-favorite');
                    btn.innerText = '즐겨찾기 추가';
                } else {
                    alert('즐겨찾기 삭제 프로세스 도중에 오류가 발생했습니다.');
                }
            });
    }
});