<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta lang="ru">
    <title>Регистрация</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
</head>

<body>
<div class="container-fluid">
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Navbar</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>


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
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="/login">Вход</a>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <div class="container pt-3">
        <div class="row">
            <div class="col">
                <h4 class="d-inline-block">Регистрация</h4>
            </div>
        </div>
        <form action="/register" method="post">
            @csrf
        <div class="row mb-3 pt-3">
            <div class="col">
                <label for="name">Фамилия И.О.</label>
                <input required class="form-control form-control-sm" name="name"  type="text">
                @error('name')
                    <div>{{$message}}</div>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label for="email">Почта</label>
                <input required class="form-control form-control-sm" name="email"  type="email">
                @error('email')
                    <div>{{$message}}</div>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label for="password">Пароль</label>
                <input required class="form-control form-control-sm" name="password"  type="password">
                @error('password')
                    <div>{{$message}}</div>
                @enderror
            </div>
        </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="password_confirmation">Повторите пароль</label>
                    <input required class="form-control form-control-sm" name="password_confirmation"  type="password">
                    @error('password_confirmation')
                        <div>{{$message}}</div>
                    @enderror
                </div>
            </div>
        <div class="row">
            <div class="col">
                <button class="btn btn-sm btn-danger col-12" type="submit">Сохранить</button>
            </div>
            <div class="col">
                <button class="btn btn-sm btn-success col-12" type="button">Назад</button>
            </div>
        </div>
        </form>
    </div>
</div>

<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}" async></script>
</body>

</html>



