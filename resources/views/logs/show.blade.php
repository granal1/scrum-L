@extends('main')

@section('title', 'Задача')

    @section('header')
        @include('menu')
    @endsection

    @section('content')
    <div class="container mb-3 mt-3 card shadow-lg">
        <div class="row">
            <div class="col-lg-2 col-md-12 rounded text-white bg-primary pt-3" style="--bs-bg-opacity: .4">
                <div class="row">
                    <div class="col">
                        @csrf
                        <h4 class="d-inline-block">Лог задачи</h4>
                        @if(!is_null($log->parent_uuid))
                        <div class="col">
                            <a class="btn btn-sm btn-primary" href="{{route('tasks.show', $log->parent_uuid)}}">Базовая задача</a>
                        </div>
                        <div class="col">
                            Создал: {{$log->author->name}}
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
                        <input class="form-control form-control-sm" name="created_at" id="created_at" disabled value="{{$log->created_at}}">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="user_uuid">Автор задачи</label>
                    </div>
                    <div class="col-8">
                        <input class="form-control form-control-sm" name="user_uuid" id="user_uuid" disabled value="{{$log->author->name}}">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="priority_uuid">Отчет</label>
                    </div>
                    <div class="col-8">
                        <input class="form-control form-control-sm" name="priority_uuid" id="priority_uuid" disabled value="{{$log->report}}">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="deadline_at">Срок исполнения задачи</label>
                    </div>
                    <div class="col-8">
                        <input class="form-control form-control-sm" name="deadline_at" id="deadline_at" disabled value="{{$log->deadline_at}}">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="description">Описание задачи</label>
                    </div>
                    <div class="col-8">
                        <textarea class="form-control form-control-sm" name="description" id="description" rows="1" disabled>{{$log->description}}</textarea>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="responsible_uuid">Исполнитель задачи</label>
                    </div>
                    <div class="col-8">
                        <input class="form-control form-control-sm" name="responsible_uuid" id="responsible_uuid" disabled value="{{$log->responsible->name}}">
                    </div>
                </div>

                @if($log->done_progress > 0)
                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="done_progress">Исполнено, %</label>
                    </div>
                    <div class="col-8">
                        <input class="form-control form-control-sm" name="done_progress" id="done_progress" disabled value="{{$log->done_progress}}">
                    </div>
                </div>
                @endif

                @if($log->done_progress > 0)
                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="report">Результат исполнения задачи</label>
                    </div>
                    <div class="col-8">
                        <textarea class="form-control form-control-sm" name="report" id="report" rows="1" disabled>{{$log->report}}</textarea>
                    </div>
                </div>
                @endif

                <div class="d-flex justify-content-center my-4">
                    <div class="mx-3">
                        <a style="width:170px" class="btn btn-sm btn-success"  href="{{route('logs.index')}}">Назад</a>
                    </div>
                    <button style="width:170px" data-id="{{$log->id}}" class="btn btn-danger btn-sm"
                        onclick="deleteLog('{{$log->id}}')">Удалить
                    </button>

                   
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('assets/documents/adaptTextarea.js')}}"></script>
    <script>
        adaptTextarea('description');
        adaptTextarea('report');
async function deleteLog(id)
{
const csrfToken = document.querySelector("[name~=_token]").value;

let response = await fetch('/logs/' + id,
{
    method: 'DELETE',
    headers: {
            "X-CSRF-Token": csrfToken
        }
}).then(response => {
        window.location.replace('{{route('logs.index')}}');
        return response.text();
    })
    .then(text => {
        return console.log(text);
    })
    .catch(error => {
        allert(error);
    });;
 }
    </script>
    @endsection


