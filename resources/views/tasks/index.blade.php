<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta lang="ru">
    <title>Главная | Задачи</title>
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
                        <a class="nav-link active" aria-current="page" href="{{route('tasks.index')}}">Home</a>
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
                <h4 class="d-inline-block">Задачи</h4>
                <a class="btn btn-sm btn-success" href="{{route('tasks.create')}}">Добавить</a>
            </div>
        </div>
        <div class="row pt-3">
            <div class="col">
                <table class="table table-sm table-striped table-responsive table-hover table-bordered">
                    <thead>
                        <tr>
                            <td>Uuid</td>
                            <td>Описание</td>
                            <td>Создана</td>
                            <td>Выполнить до</td>
                            <td>Ответственный</td>
                            <td>Выполнено, %</td>
                        </tr>
                    </thead>
                    <tbody style="cursor: pointer;">
                        @forelse($tasks as $task)
                            <tr  onclick="window.location='{{ route('tasks.show', $task->uuid) }}';">
                                <td>{{$task->uuid}}</td>
                                <td>{{$task->description}}</td>
                                <td>{{$task->created_at}}</td>
                                <td>{{$task->created_at}}</td>
                                <td>Петров П.П.</td>
                                <td>0</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    Нет задач
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{$tasks->links()}}
            </div>
        </div>
    </div>
</div>

<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}" async></script>
</body>

</html>

