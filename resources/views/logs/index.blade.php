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
                <div class="col">
                    <table class="table table-sm table-hover table-striped">
                        <thead>
                            <tr>
                                <th class="d-none d-sm-table-cell">id</th>
                                <th class="d-none d-sm-table-cell">task_uuid</th>
                                <th class="d-none d-sm-table-cell">parent_uuid</th>
                                <th class="d-none d-md-table-cell">author_uuid</th>
                                <th class="d-none d-sm-table-cell">responsible_uuid</th>
                                <th class="d-none d-sm-table-cell">description</th>
                                <th class="d-none d-md-table-cell">deadline_at</th>
                                <th class="d-none d-sm-table-cell">done_progress</th>
                                <th class="d-none d-sm-table-cell">report</th>
                                <th class="d-none d-md-table-cell">sort_order</th>
                                <th class="d-none d-sm-table-cell">comment</th>
                                <th class="d-none d-md-table-cell">created_at</th>
                                <th class="d-none d-sm-table-cell">updated_at</th>
                                <th class="d-none d-sm-table-cell">deleted_at</th>
                                <th class="d-none d-sm-table-cell">Удалить</th>

                            </tr>
                        </thead>
                        <tbody style="cursor: pointer;">
                            @forelse($logs as $log)
                                    <tr onclick="window.location='{{ route('logs.show', $log->id) }}';">
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
                                        <td class="d-none d-sm-table-cell"><form action="{{ url('/logs', ['log' => $log->id]) }}" method="post">
                                                <input class="btn btn-outline-danger btn-sm" type="submit" value="Удалить"/>
                                               
                                                @csrf
                                                @method('delete')
                                            </form></td>
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
    @endsection
