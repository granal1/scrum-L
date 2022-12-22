<!doctype html>
<html>

<head>
    <title>Создание задачи</title>
    <meta lang="ru">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
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
                <h4 class="d-inline-block">Создание задачи</h4>
            </div>
        </div>
        <form action="{{route('tasks.store')}}" method="post">
            @csrf
        <div class="row pt-3">
            <div class="col">
                <label for="description">Описание</label>
                <textarea required placeholder="Описание задачи" class="form-control form-control-sm" name="description" id="description" rows="2"></textarea>
            </div>
        </div>
        <div class="row pt-3">
            <div class="col">
                <label for="priority_uuid">Приоритет</label>
                <select class="form-select form-select-sm" name="priority_uuid">
                    @forelse($priorities as $priority)
                        <option value="{{$priority->uuid}}">{{$priority->name}}</option>
                    @empty
                        <option value="">Нет приоритетов</option>
                    @endforelse
                </select>
            </div>
        </div>
        <div class="row pt-3">
            <div class="col">
                <label for="responsible_uuid">Ответственный</label>
                <select class="form-select form-select-sm" name="responsible_uuid">
                    @forelse($users as $user)
                        <option value="{{$user->uuid}}">{{$user->name}}</option>
                    @empty
                        <option value="">Нет подчиненных</option>
                    @endforelse
                </select>
            </div>
        </div>
        <div class="row pt-3">
            <div class="col-6">
                <a class="btn btn-sm btn-success col-12"  onclick="javascript:history.back()">Назад</a>
            </div>
            <div class="col-6">
                <button class="btn btn-sm btn-danger col-12" type="submit">Сохранить</button>
            </div>
        </div>
        </form>
    </div>
</div>

<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}" async></script>
</body>

</html>



