@extends('main')

@section('title', 'Создание подзадачи')

    @section('header')
        @include('menu')
    @endsection

    @section('content')
    <div class="container mt-4 card shadow-lg mb-4">
        <div class="row row-cols-1 row-cols-md-2">
            <div class="col">
                <h5 class="mt-3">Новая подзадача</h5>
            </div>
        </div>
        <form action="{{route('tasks.store')}}" method="post">
            @csrf
            <input hidden readonly name="parent_uuid" value="{{$task->id}}">
            <div class="row row-cols-1">
                <div class="col">
                    <a class="btn btn-sm btn-info" href="{{route('tasks.show', $task)}}">Базовая задача родитель</a>
                </div>
                <div class="col mt-3">
                    <textarea class="form-control form-control-sm" disabled readonly>{{$task->description}}</textarea>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-2 mb-3">
                <div class="col mt-3">
                    <label for="priority_uuid">Приоритет</label>
                    <select class="form-select form-select-sm" name="priority_uuid">
                        @forelse($priorities as $priority)
                            <option value="{{$priority->id}}" {{$priority->sort_order === 1 ? 'selected' : ''}}>{{$priority->name}}</option>
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
                    <input type="datetime-local" id="deadline_at" name="deadline_at" class="form-control form-select-sm" placeholder="Срок выполнения задачи" required>
                    @error('deadline_at')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>

            <div class="row row-cols-1">
                <div class="col mt-2">
                    <label for="description">Описание</label>
                    <textarea required placeholder="Описание задачи" class="form-control form-control-sm" name="description" id="description" rows="2"></textarea>
                    @error('description')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-2 mb-3">
                <div class="col mt-3">
                    <label for="files">Приложение</label>
                    <select class="form-select form-select-sm" name="files">
                        <option value="">Выберите ...</option>
                        <option value="1">Файл 1</option>
                        <option value="2">Файл 2</option>
                        <option value="3">Файл 3</option>
                    </select>
                    @error('files')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="col mt-3">
                    <label for="responsible_uuid">Ответственный за выполнение</label>
                    <select class="form-select form-select-sm" name="responsible_uuid">
                        @forelse($users as $user)
                                <option value="{{$user->id}}">{{$user->name}}</option>
                            @empty
                                <option value="">Нет пользователей</option>
                        @endforelse
                    </select>
                    @error('responsible_uuid')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>

            <div class="row mt-5 mb-4">
                <div class="col">
                    <button type="button" class="btn btn-success btn-sm col-12"  onclick="javascript:history.back(); return false;>Назад</button>
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-danger btn-sm col-12">Сохранить</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection



