@extends('main')

@section('title', 'Редактирование задачи')

    @section('header')
        @include('menu')
    @endsection

    @section('content')
    <div class="container pt-3 card shadow-lg my-3 mx-auto">
        <div class="row row-cols-1 row-cols-md-2">
            @if(!is_null($task->currentHistory->parent_uuid))
                    <div class="col">
                        <h5>Создал: {{$task->getAuthor()}}</h5>
                        <a class="btn btn-sm btn-info" href="{{route('tasks.show', $task->currentHistory->parent_uuid)}}">Базовая задача</a>
                    </div>
            @endif
                    <div class="col">
                        <label class="form-label">Приложение</label>
                        <ul>
                            @forelse($task->documents as $document)
                                <form action="{{route('tasks.task-file-destroy', [$task, $document])}}" method="post">
                                    @csrf
                                    @method('delete')
                                    <li>
                                        <a href="{{'/storage/' . $document->path}}" target="_blank">{{$document->name}}</a>
                                        <button class="ms-2 btn btn-sm btn-danger" type="submit">x</button>
                                    </li>
                                </form>
                            @empty
                                <span>Нет приложений</span>
                            @endforelse
                        </ul>
                    </div>
        </div>
        @include('message')
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
            <div class="row row-cols-1 row-cols-md-2 mt-3">
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
            <div class="col mt-3 mb-2">
                <label for="file_uuid" class="form-label">Прикрепить документ</label>
                <select class="form-select form-select-sm" name="file_uuid">
                    <option value="">Выберите документ ...</option>
                @forelse($documents as $document)
                        <option value="{{$document->id}}">{{$document->name}}</option>
                    @empty
                        <option value="">Нет документов</option>
                    @endforelse
                </select>
                @error('file_uuid')
                <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="row row-cols-1 row-cols-md-2 mb-4 mt-3">
                <div class="col mt-3">
                    <button type="button" class="btn btn-success btn-sm col-12"  onclick="javascript:history.back(); return false;">Назад</button>
                </div>
                <div class="col mt-3">
                    <button type="submit" class="btn btn-warning btn-sm col-12">Сохранить</button>
                </div>
            </div>
        </form>
        <div class="row row-cols-1">
            <form action="{{route('tasks.create-subtask', $task)}}" method="post">
                @csrf
                <div class="col mb-3">
                    <button type="submit" class="btn btn-danger btn-sm col-12">Создать подзадачу</button>
                </div>
            </form>
        </div>
    </div>
    @endsection




