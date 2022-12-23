@extends('main')

@section('title', 'Создание задачи')

@section('header')
    @include('menu')
@endsection

{{--    <div class="container mt-2 card shadow-lg mb-2"> --}}
{{--        <h2 class="rounded-3 mt-2 p-3 text-bg-primary text-center">Карточка задачи</h2> --}}
{{--        <div class="row"> --}}
{{--            <div class="col"> --}}
{{--                <h4 class="mt-3">Автор задачи: Василий Николаевич</h4> --}}
{{--                <p> --}}
{{--                    Базовая задача: нет </p> --}}
{{--            </div> --}}
{{--            <div class="col"> --}}
{{--                <p>Приложение:</p> --}}
{{--                <p>1. <a href="">Сопроводительное письмо.pdf</a></p> --}}
{{--                <p>2. <a href="">Приложение к документу.zip</a></p> --}}
{{--            </div> --}}
{{--        </div> --}}
{{--        <form action="{{route('tasks.store')}}" method="post"> --}}
{{--            @csrf --}}
{{--            <div class="row mb-3"> --}}
{{--                <div class="col"> --}}
{{--                    <label for="priority_uuid">Приоритет</label> --}}
{{--                    <select class="form-select form-select-sm" name="priority_uuid"> --}}
{{--                        @forelse($priorities as $priority) --}}
{{--                            <option value="{{$priority->uuid}}">{{$priority->name}}</option> --}}
{{--                        @empty --}}
{{--                            <option value="">Нет приоритетов</option> --}}
{{--                        @endforelse --}}
{{--                    </select> --}}
{{--                </div> --}}
{{--                <div class="col"> --}}
{{--                    <label for="taskDeadline">Срок выполнения:</label> --}}
{{--                    <input type="datetime-local" id="taskDeadline" name="taskDeadline" class="form-control form-select-sm" placeholder="Срок выполнения задачи" required="" value=""> --}}
{{--                </div> --}}
{{--            </div> --}}

{{--            <div class="row"> --}}
{{--                <div class="col"> --}}
{{--                    <label for="description">Описание</label> --}}
{{--                    <textarea required placeholder="Описание задачи" class="form-control form-control-sm" name="description" id="description" rows="2"></textarea> --}}
{{--                </div> --}}
{{--                <div class="col"> --}}
{{--                    <label for="taskDoneDescription">Результат выполнения задачи</label> --}}
{{--                    <textarea class="form-control form-control-sm" rows="2" id="taskDoneDescription" placeholder="" name="taskDoneDescription"></textarea> --}}
{{--                </div> --}}
{{--            </div> --}}
{{--            <div> --}}
{{--                <label for="taskDone" class="mt-3">Выполнено, %:</label> --}}
{{--                <input style="width:100%;" type="range" min="0" max="100" step="5" id="taskDone" name="taskDone" class="" required="" value="0"> --}}
{{--            </div> --}}

{{--            <div class="row mt-3"> --}}
{{--                <div class="col"> --}}
{{--                    <div class="row"> --}}
{{--                        <div class="col"> --}}
{{--                            <span class="float-end">Исполнитель задачи:</span> --}}
{{--                        </div> --}}
{{--                        <div class="col"> --}}
{{--                            <select class="form-select" id="sel1" name="sellist1"> --}}
{{--                                <option>не указан</option> --}}
{{--                                <option>Иван Васильевич</option> --}}
{{--                                <option>Ольга Петровна</option> --}}
{{--                                <option>Василий Александрович</option> --}}
{{--                            </select> --}}
{{--                        </div> --}}
{{--                    </div> --}}
{{--                </div> --}}
{{--                <div class="col"> --}}
{{--                    <button type="submit" class="btn btn-success">Создать подзадачу</button></p> --}}
{{--                </div> --}}
{{--            </div> --}}

{{--            <div class="d-grid gap-3 d-md-flex justify-content-md-center mb-3"> --}}
{{--                <button type="button" class="btn btn-primary">Вернуться</button> --}}
{{--                <button type="submit" class="btn btn-success">Сохранить</button> --}}
{{--                <button type="button" class="btn btn-danger">Удалить</button> --}}
{{--            </div> --}}

{{--        </form> --}}
{{--    </div> --}}
@section('content')
    <div class="container mt-2 card shadow-lg mb-2">
        <h2 class="rounded-3 mt-2 p-3 text-bg-primary text-center">Карточка сотрудника</h2>
        <form action="/action_page.php">
            <div class="row">
                <div class="col">
                    <div class="mb-3 mt-3">
                        <label for="name" class="form-label">Ф.И.О.</label>
                        <input type="text" class="form-control form-control-lg" id="name" placeholder=""
                            name="name" value="Комаров Анатолий Иванович">
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="login" class="form-label">Логин:</label>
                    <input type="text" class="form-control" id="login" placeholder="" name="login" value="o1">
                </div>
                <div class="col">
                    <label for="pwd" class="form-label">Пароль:</label>
                    <input type="password" class="form-control" id="pwd" placeholder="" name="pswd" value="90-=">
                </div>
            </div>


            <div class="row mb-3">
                <div class="col">
                    <label for="phone" class="mt-3">Номер телефона в формате xxx-xxx-xx-xx:</label>
                    <input type="tel" id="phone" name="phone" class="form-control"
                        pattern="[0-9]{3}-[0-9]{3}-[0-9]{2}-[0-9]{2}" value="111-222-33-44">
                </div>
                <div class="col">
                    <label for="birthday_at" class="mt-3">Дата рождения:</label>
                    <input type="date" id="birthday_at" name="birthday_at" class="form-control" placeholder=""
                        required="" value="1995-08-01">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="email" class="mt-3">Адрес электронной почты:</label>
                    <input type="email" id="email" name="email" class="form-control" value="o1@o1.ru">
                </div>
                <div class="col">
                    <label for="superior_uuid" class="mt-3">Ф.И.О. начальника:</label>
                    <input type="text" id="superior_uuid" name="superior_uuid" class="form-control" placeholder=""
                        required="" value="Герасимов Иван Иванович">
                </div>
            </div>

            <p>
            <h4>Список подчиненных сотрудников:</h4>
            <ol>
                <li>
                    Иванов Артем Анатольевич
                </li>
                <li>
                    Петров Богдан Анатольевич
                </li>
                <li>
                    Сидоров Валерий Анатольевич
                </li>
                <li>
                    Кузнецов Георгий Анатольевич
                </li>
            </ol>
            </p>


            <div class="d-grid gap-3 d-md-flex justify-content-md-center mb-3">
                <button type="submit" class="btn btn-primary">Вернуться</button>
                <button type="submit" class="btn btn-success">Сохранить</button>
                <button type="submit" class="btn btn-danger">Удалить</button>
            </div>

        </form>
    </div>
@endsection
