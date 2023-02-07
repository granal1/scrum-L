@extends('main')

@section('title', 'Задача')

    @section('header')
        @include('menu')
    @endsection

    @section('content')
    <div class="container mb-3 mt-3 card shadow-lg">
        <div class="row">
            <div class="col-lg-2 col-md-12 rounded text-white bg-primary pt-3" style="--bs-bg-opacity: .45">
                <div class="row">
                    <div class="col">
                        <h4 class="d-inline-block">Задача</h4>
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
                        <label for="period_uuid">Периодичность выполнения</label>
                    </div>
                    <div class="col-8">
                        <input class="form-control form-control-sm" name="period_uuid" id="period_uuid" disabled value="{{$task->period->name}}">
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

                @if($task->done_progress > 0)
                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="done_progress">Исполнено, %</label>
                    </div>
                    <div class="col-8">
                        <input class="form-control form-control-sm" name="done_progress" id="done_progress" disabled value="{{$task->done_progress}}">
                    </div>
                </div>
                @endif

                @if($task->done_progress > 0)
                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="report">Результат исполнения задачи</label>
                    </div>
                    <div class="col-8">
                        <textarea class="form-control form-control-sm" name="report" id="report" rows="1" disabled>{{$task->report}}</textarea>
                    </div>
                </div>
                @endif

                @if(!empty($task->outgoing_documents) && count($task->outgoing_documents) > 0)
                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="file_uuid" class="form-label">Исходящие документы</label>
                    </div>
                    <div class="col-8">
                        <ul>
                            @forelse($task->outgoing_documents as $outgoing_document)
                                <li class="text-decoration-none"><a href="{{'/storage/' . $outgoing_document->path}}" target="_blank">{{$outgoing_document->short_description}}</a></li>
                            @empty
                                <p>Нет приложений</p>
                            @endforelse
                        </ul>
                    </div>
                </div>
                @endif


                <div class="d-flex justify-content-center my-4">
                    <div class="mx-3">
                        <a style="width:170px" class="btn btn-sm btn-success"  href="{{route('tasks.index')}}">Назад</a>
                    </div>

                    @if($task->responsible_uuid === Auth::id())
                    <div class="mx-3">
                        <a style="width:170px" class="btn btn-sm btn-warning {{$task->done_progress < 100 ? '' : 'disabled'}}" href="{{route('tasks.progress', $task)}}">Выполнение</a>
                    </div>
                    @endif

                    @if($task->author_uuid === Auth::id() || Auth::user()->isAdmin())
                    <div class="mx-3">
                        <a style="width:170px" class="btn btn-sm btn-danger" href="{{route('tasks.edit', $task)}}">Редактировать</a>
                    </div>
                    @endif

                    @if($task->done_progress < 100)
                    <div class="mx-3">
                        <form action="{{route('tasks.create-subtask', $task)}}" method="post">
                            @csrf
                            <div>
                                <button type="submit" style="width:170px" class="btn btn-danger btn-sm">Создать подзадачу</button>
                            </div>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('assets/documents/adaptTextarea.js')}}"></script>
    <script>
        adaptTextarea('description');
        adaptTextarea('report');
    </script>
    @endsection


