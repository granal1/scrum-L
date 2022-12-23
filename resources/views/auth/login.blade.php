<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta lang="ru">
    <title>Вход</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
<div class="container-fluid">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>
            @auth
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            @endauth

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                @auth
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="/">Главная</a>
                        </li>
                    </ul>
                @endauth
                <ul class="navbar-nav mb-2 mb-lg-0">
                    @auth
                        <li class="nav-item">
                            <form action="/logout" method="post">
                                @csrf
                                <button class="btn btn-info btn-sm" type="submit">Выход</button>
                            </form>
                        </li>
                    @endauth
{{--                    @guest--}}
{{--                        <li class="nav-item">--}}
{{--                            <a class="nav-link" href="/register">Регистрация</a>--}}
{{--                        </li>--}}
{{--                    @endguest--}}
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-3 pt-3 shadow-lg pb-3">
        <div class="row">
            <div class="col">
                <h4 class="d-inline-block">Вход</h4>
            </div>
        </div>
        <form action="/login" method="post">
            @csrf
            <div class="row mb-3 pt-3">
                <div class="col">
                    <label for="email">Почта</label>
                    <input name="email" class="form-control form-control-sm" required type="text">
                    @error('email')
                        <div>{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="password">Пароль</label>
                    <input name="password" class="form-control form-control-sm" required type="password">
                    @error('password')
                        <div>{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row mb-4">
                <div class="col">
                    <input type="checkbox" class="form-check-input" name="remember" id="remember">
                    <label for="remember" class="form-check-label">Запомнить меня</label>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-2">
                <div class="col mb-3">
                    <button class="btn btn-sm btn-danger col-12" type="submit">Войти</button>
                </div>
                <div class="col mb-3">
                    <button class="btn btn-sm btn-success col-12" type="button">Назад</button>
                </div>
            </div>
        </form>
    </div>
</div>

</body>

</html>



