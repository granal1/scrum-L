<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta lang="ru">
    <title>Создание задачи</title>
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
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/">Главная</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Link</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Dropdown
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">Action</a></li>
                            <li><a class="dropdown-item" href="#">Another action</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
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



