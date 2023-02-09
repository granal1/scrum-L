@extends('main')

@section('title', 'Редактирование задачи')

@section('header')
    @include('menu')
@endsection

@section('content')
<div class="container mb-3 mt-3 card shadow-lg">
    <div class="row">
        <div class="col-lg-2 col-md-12 rounded text-white bg-primary pt-3" style="--bs-bg-opacity: .4">
            <div class="row">
                <div class="col">
                    <h4 class="d-inline-block">Редактирование задачи</h4>

                    @if(!is_null($task->parent_uuid))
                    <div class="col">
                        <a class="btn btn-sm btn-primary" href="{{route('tasks.show', $task->parent_uuid)}}">Базовая задача</a>
                    </div>

                    <div class="col">
                        Создал: {{$task->author->name}}
                    </div>
                    @endif

                </div>
            </div>
        </div>
        <div class="col pt-3">
            @include('message')
            <div class="row mt-3">
                <div class="col-4 text-end">
                    <label class="form-label">Приложение</label>
                </div>
                <div class="col-8">
                    <ul>
                        @forelse($task->documents as $document)
                            <form action="{{route('tasks.task-file-destroy', [$task, $document])}}" method="post">
                                @csrf
                                @method('delete')
                                <li>
                                    <a href="{{'/storage/' . $document->path}}" target="_blank">{{$document->short_description}}</a>
                                    <button class="ms-2 btn btn-sm btn-danger" type="submit">x</button>
                                </li>
                            </form>
                        @empty
                            <span>Нет приложений</span>
                        @endforelse
                    </ul>
                </div>
            </div>

            <form action="{{route('tasks.update', $task)}}" method="post">
                @csrf
                @method('patch')

                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="priority_uuid">Приоритет</label>
                    </div>
                    <div class="col-8">
                        <select class="form-select form-select-sm" name="priority_uuid">
                            @forelse($priorities as $priority)
                                <option @if($priority->id === $task->priority_uuid) selected @endif value="{{$priority->id}}">{{$priority->name}}</option>
                            @empty
                                <option value="">Нет приоритетов</option>
                            @endforelse
                        </select>
                        @error('priority_uuid')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="deadline_at">Срок выполнения:</label>
                    </div>
                    <div class="col-8">
                        <input type="datetime-local" id="deadline_at" name="deadline_at" class="form-control form-select-sm" placeholder="Срок выполнения задачи" required value="{{$task->deadline_at}}">
                        @error('deadline_at')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="description">Описание</label>
                    </div>
                    <div class="col-8">
                        <textarea required placeholder="Описание задачи" class="form-control form-control-sm" name="description" id="description" rows="1">{{$task->description}}</textarea>
                        @error('description')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="file_uuid" class="form-label">Прикрепить документ</label>
                    </div>
                    <div class="col-8">
                        <select class="form-select form-select-sm" name="file_uuid">
                            <option value="">Выберите документ ...</option>
                        @forelse($documents as $document)
                                <option value="{{$document->id}}">{{$document->short_description}}</option>
                            @empty
                                <option value="">Нет документов</option>
                            @endforelse
                        </select>
                        @error('file_uuid')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="responsible_uuid">Ответственный за выполнение</label>
                    </div>
                    <div class="col-8">
                        <select class="form-select form-select-sm" name="responsible_uuid">
                            @forelse($users as $user)
                                <option @if($user->id === $task->responsible_uuid) selected @endif value="{{$user->id}}">{{$user->name}}</option>
                            @empty
                                <option value="">Нет пользователей</option>
                            @endforelse
                        </select>
                        @error('responsible_uuid')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>

                @if($task->done_progress > 0)
                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="done_progress">Исполнено</label>
                    </div>
                    <div class="col-8">
                        <label for="done_progress" class="mt-3"><output id="progress_bar_value"></output>%:</label>
                        <input  @if($task->responsible_uuid !== Auth::id()) disabled @endif style="width:100%;" type="range" min="0" max="100" step="5" id="done_progress" name="done_progress" required value="{{$task->done_progress}}">
                        @error('done_progress')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                @endif

                @if($task->done_progress > 0)
                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="report">Результат выполнения задачи</label>
                    </div>
                    <div class="col-8">
                        <textarea @if($task->responsible_uuid !== Auth::id()) disabled @endif class="form-control form-control-sm" rows="1" id="report" name="report">{{$task->report}}</textarea>
                        @error('report')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>
                @endif

                <div class="d-flex justify-content-center my-4">
                    <div class="mx-3">
                        <button type="button" style="width:100px" class="btn btn-sm btn-success"  onclick="javascript:history.back(); return false;">Назад</button>
                    </div>
                    <div class="mx-3">
                        <button type="submit" style="width:100px" class="btn btn-sm btn-danger">Сохранить</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="{{asset('assets/tasks/progress_bar_value_display.js')}}" defer></script>
<script src="{{asset('assets/documents/adaptTextarea.js')}}"></script>
<script>
    adaptTextarea('description');
    adaptTextarea('report');
</script>
@endsection




