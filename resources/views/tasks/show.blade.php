@extends('main')

@section('title', 'Задача')

    @section('header')
        @include('menu')
    @endsection

    @section('content')
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
        @include('message')
        <div class="row pt-3 row-cols-1 row-cols-md-4">
            <div class="col">
                <label for="uuid">Uuid</label>
                <input class="form-control form-control-sm" name="uuid" id="uuid" disabled value="{{$task->id}}">
            </div>
            <div class="col mb-3">
                <label for="created_at">Создана</label>
                <input class="form-control form-control-sm" name="created_at" id="created_at" disabled value="{{$task->created_at}}">
            </div>
            <div class="col mb-3">
                <label for="user_uuid">Создал</label>
                <input class="form-control form-control-sm" name="user_uuid" id="user_uuid" disabled value="{{$task->currentAuthor()}}">
            </div>
            <div class="col">
                <label for="priority_uuid">Приоритет</label>
                <input class="form-control form-control-sm" name="priority_uuid" id="priority_uuid" disabled value="{{$task->priorities->last()->name}}">
            </div>
        </div>
        <div class="row pt-3">
            <div class="col">
                <label for="description">Описание</label>
                <textarea class="form-control form-control-sm" name="description" id="description" disabled>{{$task->description}}</textarea>
            </div>
        </div>
        <div class="row pt-3 row-cols-1 row-cols-md-3">
            <div class="col mb-3">
                <label for="responsible_uuid">Ответственный</label>
                <input class="form-control form-control-sm" name="responsible_uuid" id="responsible_uuid" disabled value="{{$task->currentResponsible()}}">
            </div>
            <div class="col mb-3">
                <label for="deadline_at">Выполнить до:</label>
                <input class="form-control form-control-sm" name="deadline_at" id="deadline_at" disabled value="{{$task->currentHistory->deadline_at}}">
            </div>
            <div class="col">
                <label for="done_progress">Выполнено, %</label>
                <input class="form-control form-control-sm" name="done_progress" id="done_progress" disabled value="{{$task->currentHistory->done_progress}}">
            </div>
        </div>
        <div class="row pt-3">
            <div class="col">
                <label for="file_uuid" class="form-label">Приложение</label>
                <ul>
                @forelse($task->documents as $document)
                    <li class="text-decoration-none"><a href="{{'/storage/' . $document->path}}" target="_blank">{{$document->name}}</a></li>
                @empty
                    <p>Нет приложений</p>
                @endforelse
                </ul>
            </div>
        </div>
        <div class="row pt-3 row-cols-1 row-cols-md-3">
            <div class="col mb-3">
                <a class="btn btn-primary btn-sm col-12" href="{{route('tasks.index')}}">Все задачи</a>
            </div>
            <div class="col mb-3">
                <button class="btn btn-sm btn-success col-12"  onclick="history.back()">Назад</button>
            </div>
                <div class="col mb-3">
                    <a class="btn btn-sm btn-danger col-12" href="{{route('tasks.edit', $task)}}">Редактировать</a>
                </div>
        </div>
    </div>
    @endsection


