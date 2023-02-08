@extends('main')

@section('title', 'Выполнение задачи')

    @section('header')
        @include('menu')
    @endsection

    @section('content')
    <div class="container mb-3 mt-3 card shadow-lg">
        <div class="row">

            <div class="col-lg-2 col-md-12 rounded text-white bg-primary pt-3" style="--bs-bg-opacity: .45">
                <div class="col">
                    <h4>Исполнение задачи</h4>
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

            <div class="col pt-3">
                @include('message')

                <form action="{{route('tasks.progress_update', $task)}}" method="post">
                    @csrf
                    @method('patch')

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="created_at">Задача создана</label>
                        </div>
                        <div class="col-8">
                            <input class="form-control form-control-sm" name="created_at" id="created_at" disabled value="{{$task->created_at}}">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="user_uuid">Автор задачи</label>
                        </div>
                        <div class="col-8">
                            <input class="form-control form-control-sm" name="user_uuid" id="user_uuid" disabled value="{{$task->author->name}}">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="priority_uuid">Приоритет</label>
                        </div>
                        <div class="col-8">
                            <input class="form-control form-control-sm" name="priority_uuid" id="priority_uuid" disabled value="{{$task->priority->name}}">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="deadline_at">Срок исполнения задачи</label>
                        </div>
                        <div class="col-8">
                            <input class="form-control form-control-sm" name="deadline_at" id="deadline_at" disabled value="{{$task->deadline_at}}">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="description">Описание задачи</label>
                        </div>
                        <div class="col-8">
                            <textarea class="form-control form-control-sm" name="description" id="description" rows="1" disabled>{{$task->description}}</textarea>
                        </div>
                    </div>

                    @if(!empty($task->documents) && count($task->documents) > 0)
                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="file_uuid" class="form-label">Входящие документы</label>
                        </div>
                        <div class="col-8">
                            <ul>
                                @forelse($task->documents as $document)
                                    <li class="text-decoration-none"><a href="{{'/storage/' . $document->path}}" target="_blank">{{$document->short_description}}</a></li>
                                @empty
                                    <p>Нет приложений</p>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                    @endif

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="responsible_uuid">Исполнитель задачи</label>
                        </div>
                        <div class="col-8">
                            <input class="form-control form-control-sm" name="responsible_uuid" id="responsible_uuid" disabled value="{{$task->responsible->name}}">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="period_uuid">Периодичность выполнения</label>
                        </div>
                        <div class="col-8">
                            <input class="form-control form-control-sm" name="period_uuid" id="period_uuid" disabled value="{{$task->repeat_value}} {{translate_repeat_period($task->repeat_period)}}">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="responsible_uuid">Процент исполнения задачи</label>
                        </div>
                        <div class="col-8">
                            <label for="done_progress" class="mt-3">Исполнено, <output id="progress_bar_value"></output>%:</label>
                            <input style="width:100%;" type="range" min="0" max="100" step="5" id="done_progress" name="done_progress" required value="{{$task->done_progress}}">
                            @error('done_progress')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="comment">Результат выполнения задачи</label>
                        </div>
                        <div class="col-8">
                            <textarea class="form-control form-control-sm" rows="1" id="comment" name="comment">{{$task->report}}</textarea>
                            @error('executed_result')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div id="outgoing_files_block" class="row mt-3">
                            <div class="col-4 text-end">
                                <label for="create_new_task"><span class="text-danger"><b>*</b></span> Повторить эту задачу</label>
                            </div>
                            <div class="col-8 mb-3">
                                <input class="form-check-input" type="checkbox" value="1" id="create_new_task" name="create_new_task" checked>
                            </div>
                        <div class="col-4 text-end">
                            <label for="outgoing_file_uuid">Приложение исходящее</label>
                        </div>
                        <div class="col-8">
                            <select class="form-select form-select-sm" name="outgoing_file_uuid">
                                <option value="">Выберите документ ...</option>
                                @forelse($outgoing_documents as $outgoing_document)
                                    <option value="{{$outgoing_document->id}}">{{$outgoing_document->short_description}}</option>
                                @empty
                                    <option value="">Нет документов</option>
                                @endforelse
                            </select>
                            @error('outgoing_file_uuid')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-center my-4">
                        <div class="mx-3">
                            <button type="button" style="width:100px" class="btn btn-sm btn-success"  onclick="history.back()">Назад</button>
                        </div>
                        <div class="mx-3">
                            <button type="submit" style="width:100px" class="btn btn-sm btn-warning">Сохранить</button>
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
            adaptTextarea('comment');
        </script>
    @endsection




