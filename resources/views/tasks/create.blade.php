@extends('main')

@section('title', 'Создание задачи')

@section('header')
    @include('menu')
@endsection

@section('content')
    <div class="container pt-3">
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
        <form action="{{ route('tasks.store') }}" method="post">
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
@endsection
