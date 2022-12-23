<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta lang="ru">
    <title>Задача</title>
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
    <div class="container pt-3 pb-3 mb-3">
        <div class="row">
            <div class="col">
                <h4 class="d-inline-block">Задача</h4>
            </div>
        </div>
        @if(!is_null($task->currentHistory->parent_uuid))
        <div class="row mb-2">
            <div class="col">
                <a class="btn btn-sm btn-info" href="{{route('tasks.show', $task->currentHistory->parent_uuid)}}">Базовая задача</a>
            </div>
        </div>
        @endif
        <div class="row">
            <div class="col">
                <label for="uuid">Uuid</label>
                <input class="form-control form-control-sm" name="uuid" id="uuid" disabled value="{{$task->id}}">
            </div>
        </div>
        <div class="row pt-3 row-cols-1 row-cols-md-3">
            <div class="col mb-3">
                <label for="created_at">Создана</label>
                <input class="form-control form-control-sm" name="created_at" id="created_at" disabled value="{{$task->created_at}}">
            </div>
            <div class="col mb-3">
                <label for="user_uuid">Создал</label>
                <input class="form-control form-control-sm" name="user_uuid" id="user_uuid" disabled value="{{$task->getAuthor()}}">
            </div>
            <div class="col">
                <label for="priority_uuid">Приоритет</label>
                <input class="form-control form-control-sm" name="priority_uuid" id="priority_uuid" disabled value="{{$task->getPriority()}}">
            </div>
        </div>
        <div class="row pt-3">
            <div class="col">
                <label for="description">Описание</label>
                <textarea class="form-control form-control-sm" name="description" id="description" disabled>{{$task->description}}</textarea>
            </div>
        </div>
        <div class="row pt-3 row-cols-1 row-cols-md-2">
            <div class="col mb-3">
                <label for="responsible_uuid">Ответственный за выполнение</label>
                <input class="form-control form-control-sm" name="responsible_uuid" id="responsible_uuid" disabled value="{{$task->getResponsible()}}">
            </div>
            <div class="col">
                <label for="deadline_at">Выполнить до:</label>
                <input class="form-control form-control-sm" name="deadline_at" id="deadline_at" disabled value="{{$task->currentHistory->deadline_at}}">
            </div>
        </div>
        <div class="row pt-3">
            <div class="col">
                <label for="done_progress">Выполнено, %</label>
                <input class="form-control form-control-sm" name="done_progress" id="done_progress" disabled value="{{$task->currentHistory->done_progress}}">
            </div>
        </div>
        <div class="row pt-3">
            <div class="col">
                <p>Приложение:</p>
                    <p><a href="#">Файл 1</a></p>
                    <p><a href="#">Файл 2</a></p>
            </div>
        </div>
        <div class="row pt-3 row-cols-1 row-cols-md-3">
            <div class="col">
                <a class="btn btn-primary btn-sm col-12" href="{{route('tasks.index')}}">Все задачи</a>
            </div>
            <div class="col">
                <button class="btn btn-sm btn-success col-12"  onclick="history.back()">Назад</button>
            </div>
                <div class="col">
                    <a class="btn btn-sm btn-danger col-12" href="{{route('tasks.edit', $task)}}">Редактировать</a>
                </div>
        </div>
    </div>
</div>

</body>

</html>


