@extends('layout')

@section('title', 'Редактирование задачи')

@section('content')
    <div class="container pt-3">
        <div class="row">
            <div class="col">
                <h4 class="d-inline-block">Редактирование задачи</h4>
            </div>
        </div>
        <form action="{{ route('tasks.update', $task) }}" method="post">
            @csrf
            @method('patch')
            <div class="row pt-3">
                <div class="col">
                    <label for="description">Описание</label>
                    <textarea required placeholder="Описание задачи" class="form-control form-control-sm" name="description" id="description"
                        rows="2">{{ $task->description }}</textarea>
                </div>
            </div>
            <div class="row pt-3">
                <div class="col-6">
                    <button class="btn btn-sm btn-success col-12" onclick="history.back()">Назад</button>
                </div>
                <div class="col-6">
                    <button class="btn btn-sm btn-danger col-12" type="submit">Сохранить</button>
                </div>
            </div>
        </form>
    </div>
@endsection
