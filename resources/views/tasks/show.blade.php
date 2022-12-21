<!doctype html>
<html>

<head>
    <title>Задача</title>
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
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="/">Home</a>
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
                <h4 class="d-inline-block">Задача</h4>
            </div>
        </div>
        <div class="row pt-3">
            <div class="col">
                <label for="uuid">Uuid</label>
                <input class="form-control form-control-sm" name="uuid" id="uuid" disabled value="{{$task->id}}">
            </div>
        </div>
        <div class="row pt-3">
            <div class="col">
                <label for="description">Описание</label>
                <textarea class="form-control form-control-sm" name="description" id="description" disabled>{{$task->description}}</textarea>
            </div>
        </div>
        <div class="row pt-3">
            <div class="col">
                <label for="created_at">Создана</label>
                <input class="form-control form-control-sm" name="created_at" id="created_at" disabled value="{{$task->created_at}}">
            </div>
        </div>
        <div class="row pt-3">
            <div class="col-6">
                <button class="btn btn-sm btn-success col-12"  onclick="history.back()">Назад</button>
            </div>
                <div class="col-6">
                    <a class="btn btn-sm btn-danger col-12" href="{{route('tasks.edit', $task)}}">Редактировать</a>
                </div>
        </div>
    </div>
</div>

<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}" async></script>
</body>

</html>


