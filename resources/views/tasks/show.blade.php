@extends('main')

@section('title', 'Задача')

    @section('header')
        @include('menu')
    @endsection

    @section('content')
    <div class="container pt-3 pb-3 mb-3 card mt-3">
        <div class="row">
            <div class="col">
                <h4 class="d-inline-block">Задача</h4>
            </div>
        </div>
        @if(!is_null($task->parent_uuid))
        <div class="row mb-2">
            <div class="col">
                <a class="btn btn-sm btn-info" href="{{route('tasks.show', $task->parent_uuid)}}">Базовая задача</a>
            </div>
        </div>
        @endif
        @include('message')
        <div class="row pt-3 row-cols-1 row-cols-md-3">
            <div class="col mb-3">
                <label for="created_at">Создана</label>
                <input class="form-control form-control-sm" name="created_at" id="created_at" disabled value="{{Timezone::convertToLocal($task->created_at)}}">
            </div>
            <div class="col mb-3">
                <label for="user_uuid">Создал</label>
                <input class="form-control form-control-sm" name="user_uuid" id="user_uuid" disabled value="{{$task->getAuthor()}}">
            </div>
            <div class="col">
                <label for="priority_uuid">Приоритет</label>
                <input class="form-control form-control-sm" name="priority_uuid" id="priority_uuid" disabled value="{{$task->priorities->last()->name}}">
            </div>
        </div>
        <div class="row pt-3 row-cols-1 row-cols-md-3">
            <div class="col mb-3">
                <label for="deadline_at">Выполнить до:</label>
                <input class="form-control form-control-sm" name="deadline_at" id="deadline_at" disabled value="{{Timezone::convertToLocal($task->deadline_at)}}">
            </div>
            <div class="col mb-3">
                <label for="responsible_uuid">Ответственный</label>
                <input class="form-control form-control-sm" name="responsible_uuid" id="responsible_uuid" disabled value="{{$task->getResponsible()}}">
            </div>
            <div class="col">
                <label for="done_progress">Выполнено, %</label>
                <input class="form-control form-control-sm" name="done_progress" id="done_progress" disabled value="{{$task->done_progress}}">
            </div>
        </div>
        <div class="row pt-3 row-cols-1 row-cols-md-2">
            <div class="col mb-3">
                <label for="description">Описание</label>
                <textarea class="form-control form-control-sm" name="description" id="description" disabled>{{$task->description}}</textarea>
            </div>
            @if($task->done_progress > 0)
            <div class="col mb-3">
                <label for="report">Результат выполнения</label>
                <textarea class="form-control form-control-sm" name="report" id="report" disabled>{{$task->report}}</textarea>
            </div>
           @endif
            <div class="col">
                <label for="file_uuid" class="form-label">Приложение</label>
                <ul>
                    @forelse($task->documents as $document)
                        <li class="text-decoration-none"><a href="{{'/storage/' . $document->path}}" target="_blank">{{$document->short_description}}</a></li>
                    @empty
                        <p>Нет приложений</p>
                    @endforelse
                </ul>
            </div>
        </div>
        <div class="row pt-3 row-cols-1 {{$task->author_uuid === Auth::id() || Auth::user()->isAdmin() ? 'row-cols-md-3' : 'row-cols-md-2'}}">
            <div class="col mb-3">
                <button class="btn btn-sm btn-success col-12"  onclick="javascript:history.back(); return false;">Назад</button>
            </div>
            @if($task->responsible_uuid === Auth::id())
            <div class="col mb-3">
                <a class="btn btn-sm btn-warning col-12 {{$task->done_progress < 100 ? '' : 'disabled'}}" href="{{route('tasks.progress', $task)}}">Выполнение</a>
            </div>
            @endif
            @if($task->author_uuid === Auth::id() || Auth::user()->isAdmin())
            <div class="col mb-3">
                <a class="btn btn-sm btn-danger col-12" href="{{route('tasks.edit', $task)}}">Редактировать</a>
            </div>
            @endif
        </div>
        @if($task->done_progress < 100)
        <div class="row row-cols-1">
            <form action="{{route('tasks.create-subtask', $task)}}" method="post">
                @csrf
                <div class="col mb-3">
                    <button type="submit" class="btn btn-danger btn-sm col-12">Создать подзадачу</button>
                </div>
            </form>
        </div>
        @endif
    </div>
    @endsection


