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
            <header class="col-6">
                <form class="mb-3 input-group form-floating d-flex justify-content-center" action="/manage_bus/search_bus.php">
                    <div class="col-10 form-floating">
                        <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                        <label for="floatingInput">노선 이름 입력</label>
                    </div>
                    <button class="btn btn-outline-primary" type="button">검색</button>
                </form>
            </header>
        </section>
        <section class="row mb-5 d-flex justify-content-evenly">
            <div class="col-md-6 card" style="width: 18rem;">
                <a href="/manage_bus/favorites.php" class="text-decoration-none">
                    <img class="mt-3 card-img-top" src="/img/favorite.png" alt="...">
                    <div class="card-body">
                        <p class="card-text text-center">즐겨찾기</p>
                    </div>
                </a>
            </div>
            <div class="col-md-6 card" style="width: 18rem;">
                <a href="/manage_bus/search_bus.php" class="text-decoration-none">
                    <img class="mt-3 card-img-top" src="/img/bus-stop.png" alt="...">
                    <div class="card-body">
                        <p class="card-text text-center">정류소</p>
                    </div>
                </a>
            </div>
        </section>
    </article>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>