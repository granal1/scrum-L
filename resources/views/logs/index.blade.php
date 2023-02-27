@extends('main')

@section('title', 'Главная | Задачи')

@section('header')
@include('menu')
@endsection

@section('content')
<div class="container-fluid pt-3">

    <div class="card shadow">
        <div class="card-header">
            <div class="d-grid gap-2 d-md-flex align-items-center justify-content-between">
                <h4 class="d-inline-block">Логи</h4>
                        <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Поиск
                        </button>
                    <a class="btn btn-outline-danger btn-sm d-sm-none" type="button" href="{{route('logs.index')}}">Сброс</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row pt-3">
                <div id="successMessage" style="display:none" class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Лог успешно удалён</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <div id="errorMessage" style="display:none" class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Ошибка удаления</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                <div class="col">
                    <table class="table table-sm table-hover table-striped">
                        <thead>
                            <tr>
                                <th class="d-none d-sm-table-cell">id</th>
                                <th class="d-none d-sm-table-cell">task_uuid</th>
                                <th class="d-none d-sm-table-cell">parent_uuid</th>
                                <th class="d-none d-md-table-cell">Автор</th>
                                <th class="d-none d-sm-table-cell">Ответственный</th>
                                <th class="d-none d-sm-table-cell">Описание</th>
                                <th class="d-none d-md-table-cell">Выполнить до</th>
                                <th class="d-none d-sm-table-cell">Исп., %</th>
                                <th class="d-none d-sm-table-cell">Описание</th>
                                <th class="d-none d-md-table-cell">Отчет</th>
                                <th class="d-none d-sm-table-cell">Комментарий</th>
                                <th class="d-none d-md-table-cell">Создана</th>
                                <th class="d-none d-sm-table-cell">Обновлена</th>
                                <th class="d-none d-sm-table-cell">Удалена</th>
                                <th class="d-none d-sm-table-cell">Лог</th>

                            </tr>
                        </thead>
                        <tbody style="cursor: pointer;">
                            @csrf
                            @forelse($logs as $log)
                            <tr id="{{$log->id}}" onclick="window.location='{{ route('logs.show', $log->id) }}';">
                                        <td class="d-none d-sm-table-cell">{{$log->id}}</td>
                                        <td class="d-none d-sm-table-cell">{{$log->task_uuid}}</td>
                                        <td class="d-none d-sm-table-cell">{{$log->parent_uuid}}</td>
                                        <td class="d-none d-md-table-cell">{{$log->author->name}}</td>
                                        <td class="d-none d-sm-table-cell">{{$log->responsible->name}}</td>
                                        <td class="d-none d-sm-table-cell">{{$log->description}}</td>
                                        <td class="d-none d-md-table-cell">{{$log->deadline_at}}</td>
                                        <td class="d-none d-sm-table-cell">@include('graph.progressbar', ['done_progress'=> $log->done_progress])</td>
                                        <td class="d-none d-sm-table-cell">{{$log->report}}</td>
                                        <td class="d-none d-md-table-cell">{{$log->sort_order}}</td>
                                        <td class="d-none d-sm-table-cell">{{$log->comment}}</td>
                                        <td class="d-none d-md-table-cell">{{$log->created_at}}</td>
                                        <td class="d-none d-sm-table-cell">{{$log->updated_at}}</td>
                                        <td class="d-none d-sm-table-cell">{{$log->deleted_at}}</td>
                                        <td class="d-none d-sm-table-cell">
                                            <button data-id="{{$log->id}}" class="btn btn-danger btn-sm"
                                            onclick="deleteLog('{{$log->id}}')">Удалить
                                        </button>
                                        
                                        </td>
                                    </tr>
                            @empty
                            <tr>
                                <td colspan="6">
                                    Логи отсутствуют
                                </td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>
                    {{$logs->withQueryString()->links()}}
                </div>
            </div>
        </div>
    </div>

    <script>
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
        let elem = document.getElementById(id);
        elem.remove();
        let messageElement = document.getElementById('successMessage');
        messageElement.style.display = "block";
        return response.text();
    })
    .then(text => {
        return console.log(text);
    })
    .catch(error => {
        console.error(error);
        let messageElement = document.getElementById('errorMessage');
        messageElement.style.display = "block";
    });;
 }
    </script>
    @endsection
