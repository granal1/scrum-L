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
    <div class="container mt-2 card shadow-lg mb-2">
        <h2 class="rounded-3 mt-2 p-3 text-bg-primary text-center">Карточка задачи</h2>
        <div class="row">
            <div class="col">
                <h4 class="mt-3">Автор задачи: Василий Николаевич</h4>
                <p>
                    Базовая задача: нет </p>
            </div>
            <div class="col">
                <p>Приложение:</p>
                <p>1. <a href="">Сопроводительное письмо.pdf</a></p>
                <p>2. <a href="">Приложение к документу.zip</a></p>
            </div>
        </div>
        <form action="{{route('tasks.store')}}" method="post">
            @csrf
            <div class="row mb-3">
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
                <div class="col">
                    <label for="taskDeadline">Срок выполнения:</label>
                    <input type="datetime-local" id="taskDeadline" name="taskDeadline" class="form-control form-select-sm" placeholder="Срок выполнения задачи" required="" value="">
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <label for="description">Описание</label>
                    <textarea required placeholder="Описание задачи" class="form-control form-control-sm" name="description" id="description" rows="2"></textarea>
                </div>
                <div class="col">
                    <label for="taskDoneDescription">Результат выполнения задачи</label>
                    <textarea class="form-control form-control-sm" rows="2" id="taskDoneDescription" placeholder="" name="taskDoneDescription"></textarea>
                </div>
            </div>
            <div>
                <label for="taskDone" class="mt-3">Выполнено, %:</label>
                <input style="width:100%;" type="range" min="0" max="100" step="5" id="taskDone" name="taskDone" class="" required="" value="0">
            </div>

            <div class="row mt-3">
                <div class="col">
                    <div class="row">
                        <div class="col">
                            <span class="float-end">Исполнитель задачи:</span>
                        </div>
                        <div class="col">
                            <select class="form-select" id="sel1" name="sellist1">
                                <option>не указан</option>
                                <option>Иван Васильевич</option>
                                <option>Ольга Петровна</option>
                                <option>Василий Александрович</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-success">Создать подзадачу</button></p>
                </div>
            </div>

            <div class="d-grid gap-3 d-md-flex justify-content-md-center mb-3">
                <button type="button" class="btn btn-primary">Вернуться</button>
                <button type="submit" class="btn btn-success">Сохранить</button>
                <button type="button" class="btn btn-danger">Удалить</button>
            </div>

        </form>
    </div>
</div>

<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}" async></script>
</body>

</html>



