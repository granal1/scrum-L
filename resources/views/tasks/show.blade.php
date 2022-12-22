@extends('main')

@section('title', 'Задача')

@section('header')
    @include('menu')
@endsection

@section('content')
    <div class="container pt-3">
        <div class="row">
            <div class="col">
                <h4 class="d-inline-block">Задача</h4>
            </div>
        </div>
        <div class="row pt-3">
            <div class="col">
                <label for="uuid">Uuid</label>
                <input class="form-control form-control-sm" name="uuid" id="uuid" disabled value="{{ $task->id }}">
            </div>
        </div>
        <div class="row pt-3">
            <div class="col">
                <label for="description">Описание</label>
                <textarea class="form-control form-control-sm" name="description" id="description" disabled>{{ $task->description }}</textarea>
            </div>
        </div>
        <div class="row pt-3">
            <div class="col">
                <label for="created_at">Создана</label>
                <input class="form-control form-control-sm" name="created_at" id="created_at" disabled
                    value="{{ $task->created_at }}">
            </div>
        </div>
        <div class="row pt-3">
            <div class="col-6">
                <button class="btn btn-sm btn-success col-12" onclick="history.back()">Назад</button>
            </div>
            <div class="col-6">
                <a class="btn btn-sm btn-danger col-12" href="{{ route('tasks.edit', $task) }}">Редактировать</a>
            </div>
        </div>
    </div>
@endsection
