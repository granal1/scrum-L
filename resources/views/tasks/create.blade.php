@extends('main')

@section('title', 'Создание задачи')

@section('header')
    @include('menu')
@endsection

@section('content')
    <div class="container pt-3">
        <div class="row">
            <div class="col">
                <h4 class="d-inline-block">Создание задачи</h4>
            </div>
        </div>
        <form action="{{ route('tasks.store') }}" method="post">
            @csrf
            <div class="row pt-3">
                <div class="col">
                    <label for="description">Описание</label>
                    <textarea required placeholder="Описание задачи" class="form-control form-control-sm" name="description" id="description"
                        rows="2"></textarea>
                </div>
            </div>
            <div class="row pt-3">
                <div class="col">
                    <label for="priority_uuid">Приоритет</label>
                    <select class="form-select form-select-sm" name="priority_uuid">
                        @forelse($priorities as $priority)
                            <option value="{{ $priority->uuid }}">{{ $priority->name }}</option>
                        @empty
                            <option value="">Нет приоритетов</option>
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="row pt-3">
                <div class="col">
                    <label for="responsible_uuid">Ответственный</label>
                    <select class="form-select form-select-sm" name="responsible_uuid">
                        @forelse($users as $user)
                            <option value="{{ $user->uuid }}">{{ $user->name }}</option>
                        @empty
                            <option value="">Нет подчиненных</option>
                        @endforelse
                    </select>
                </div>
            </div>
            <div class="row pt-3">
                <div class="col-6">
                    <a class="btn btn-sm btn-success col-12" onclick="javascript:history.back()">Назад</a>
                </div>
                <div class="col-6">
                    <button class="btn btn-sm btn-danger col-12" type="submit">Сохранить</button>
                </div>
            </div>
        </form>
    </div>
@endsection
