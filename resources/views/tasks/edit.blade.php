<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta lang="ru">
    <title>Создание задачи</title>
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
        <div class="row row-cols-1 row-cols-md-2">
            @if(!is_null($task->currentHistory->parent_uuid))
                    <div class="col">
                        <h5>Создал: {{$task->getAuthor()}}</h5>
                        <a class="btn btn-sm btn-info" href="{{route('tasks.show', $task->currentHistory->parent_uuid)}}">Базовая задача</a>
                    </div>
            @endif
            <div class="col mt-3">
                <p>Приложение:</p>
                <p>1. <a href="">Сопроводительное письмо.pdf</a></p>
                <p>2. <a href="">Приложение к документу.zip</a></p>
            </div>
        </div>
        <form action="{{route('tasks.update', $task)}}" method="post">
            @csrf
            @method('patch')
            <div class="row row-cols-1 row-cols-md-2 mb-3">
                <div class="col mt-3">
                    <label for="priority_uuid">Приоритет</label>
                    <select class="form-select form-select-sm" name="priority_uuid">
                        @forelse($priorities as $priority)
                            <option @if($priority->id === $task->currentHistory->priority_uuid) selected @endif value="{{$priority->id}}">{{$priority->name}}</option>
                        @empty
                            <option value="">Нет приоритетов</option>
                        @endforelse
                    </select>
                    @error('priority_uuid')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="col mt-3">
                    <label for="deadline_at">Срок выполнения:</label>
                    <input type="datetime-local" id="deadline_at" name="deadline_at" class="form-control form-select-sm" placeholder="Срок выполнения задачи" required value="{{$task->currentHistory->deadline_at}}">
                    @error('deadline_at')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>

            <div class="row row-cols-1 row-cols-md-2">
                <div class="col mt-3">
                    <label for="description">Описание</label>
                    <textarea required placeholder="Описание задачи" class="form-control form-control-sm" name="description" id="description" rows="2">{{$task->description}}</textarea>
                    @error('description')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="col mt-3">
                    <label for="comment">Результат выполнения задачи</label>
                    <textarea class="form-control form-control-sm" rows="2" id="comment" name="comment">{{$task->currentHistory->comment}}</textarea>
                    @error('comment')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-2 mt-2">
                <div class="col">
                    <label for="responsible_uuid">Ответственный за выполнение</label>
                    <select class="form-select form-select-sm" name="responsible_uuid">
                        @forelse($users as $user)
                            <option @if($user->id === $task->currentHistory->responsible_uuid) selected @endif value="{{$user->id}}">{{$user->name}}</option>
                        @empty
                            <option value="">Нет пользователей</option>
                        @endforelse
                    </select>
                    @error('responsible_uuid')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="col">
                    <label for="done_progress" class="mt-3">Выполнено, %:</label>
                    <input style="width:100%;" type="range" min="0" max="100" step="5" id="done_progress" name="done_progress" required value="{{$task->currentHistory->done_progress}}">
                    @error('done_progress')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>

            <div class="row row-cols-1 row-cols-md-3">
                <div class="col mt-3">
                    <a class="btn btn-primary btn-sm col-12" href="{{route('tasks.index')}}">Все задачи</a>
                </div>
                <div class="col mt-3">
                    <button type="button" class="btn btn-success btn-sm col-12"  onclick="history.back()">Назад</button>
                </div>
                <div class="col mt-3">
                    <button type="submit" class="btn btn-warning btn-sm col-12">Сохранить</button>
                </div>
            </div>
        </form>
        <form action="{{route('tasks.create-subtask', $task)}}" method="post">
            @csrf
            <div class="row mb-3 mt-3">
                <div class="col">
                    <button type="submit" class="btn btn-warning btn-sm col-12">Создать подзадачу</button>
                </div>
            </div>
        </form>
        <form action="{{route('tasks.destroy', $task)}}" method="post">
            @csrf
            @method('delete')
        <div class="row mb-4 mt-2">
            <div class="col">
                <button type="submit" class="btn btn-danger btn-sm col-12">Удалить</button>
            </div>
        </div>
        </form>
    </div>
</div>

</body>

</html>




