<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/db.class.php';
require_once $_SERVER['DOCUMENT_ROOT'].'/classes/pagination.class.php';

// 세션 시작
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// 메시지 전달 시 알림
if (isset($_GET['msg'])) {
    echo '<script>alert("'.$_GET['msg'].'");</script>';
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

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<main class="container">
    <article class="my-5 row d-flex justify-content-center">
        <section class="row mb-5 d-flex justify-content-center">
            <header class="col-12 d-flex justify-content-between">
                <div class="col-3 ms-4 text-center align-self-center">
                    <span style="font-size:2em; color:black;">🚏 <span style="font-weight:bold;">정류소 검색</span></span>
                </div>
                <form class="input-group form-floating d-flex justify-content-center w-100" action="/manage_bus/search_bus.php">
                    <div id="input-line-num" class="form-floating w-75">
                        <input type="text" class="form-control" id="floatingInput" placeholder="노선 이름 입력">
                        <label for="floatingInput">정류소 이름 입력</label>
                    </div>
                    <button id="search-btn" class="btn btn-outline-primary" type="submit">검색</button>
                </form>
            </header>
        </section>
        <section>
            <table class="table table-hover">
                <thead class="table-light">
                <tr>
                    <th class="col-1 text-center" scope="col">#</th>
                    <th class="col-2 text-center" scope="col">정류소 명(한글)</th>
                    <th class="col-2 text-center" scope="col">정류소 명(영문)</th>
                    <th class="col-3 text-center" scope="col">정류소 방향</th>
                    <th class="col-2 text-center" scope="col">ARS 번호</th>
                </tr>
                </thead>
                <tbody id="station-list" >
                </tbody>
            </table>
        </section>
        <section class="row d-flex justify-content-center">
            <div class="row d-flex justify-content-center">
                <a href="/index.php" class="col-6 mb-3 btn btn-outline-secondary">홈으로</a>
            </div>
        </section>
        <footer class="mt-5">
            <nav id="nav-pagination" class="position-absolute bottom-0 start-50 translate-middle">
                <ul id="page-list" class="pagination d-flex justify-content-center">
                </ul>
            </nav>
        </footer>
    </article>
</main>

<script src="/js/fetch_station_list.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>