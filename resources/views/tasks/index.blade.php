<!doctype html>
<html>

<head>
    <title>Главная | Задачи</title>
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
                        <a class="nav-link" href="{{route('users.create')}}">Профайл</a>
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
        @auth
            <h4>Здравствуйте {{ auth()->user()->name() }}</h4>
        @endauth
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
                            <tr  onclick="window.location='{{ route('tasks.show', $task->id) }}';">
                                <td>{{$task->uuid}}</td>
                                <td>{{$task->description}}</td>
                                <td>{{$task->created_at}}</td>
                                <td>{{$task->created_at}}</td>
                                <td>{{$task->getResponsible()}}</td>
                                <td>{{$task->currentHistory->done_progress}}</td>
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

