@extends('main')

@section('title', 'Главная | Задачи')

@section('header')
@include('menu')
@endsection

@section('content')
<div class="container pt-3">
    @auth
    <div class="row mb-3 d-md-flex justify-content-between">
        <div class="col-auto">
            <h4>Здравствуйте {{ auth()->user()->name() }}</h4>
        </div>
        <div class="col-auto"><a class="btn btn-outline-success" href="{{route('tasks.create')}}">Добавить задачу</a></div>
    </div>
    @endauth
    <div class="card shadow">
        <div class="card-header">
            <div class="d-grid gap-2 d-md-flex align-items-center justify-content-between">
                <h4 class="d-inline-block">Задачи</h4>
                <div class="mb-3 d-flex">
                    <div class="input-group-append">

                        <button class="btn btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Поиск
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row pt-3">
                <div class="col">
                    <table class="table table-sm table-hover">
                        <thead>
                            <tr>
                                <td>Uuid</td>
                                <td>Описание</td>
                                <td>Создана</td>
                                <td>Выполнить до</td>
                                <td>Ответственный</td>
                                <td>Выполнено, %</td>
                            </tr>

                        </thead>
                        <tbody style="cursor: pointer;">

                            <tr class="collapse @if(!empty($old_filters)) show @endif" id="collapseExample">
                                <form action="{{ route('tasks.index') }}" method="get">
                                    <td><a class="btn btn-outline-danger" type="button" href="{{route('tasks.index')}}">Сброс фильтров</a></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <input type="search" value="@if(isset($old_filters['description'])) {{ $old_filters['description'] }} @endif" class="form-control me-2" id="description" name="description" onchange="this.form.submit()">
                                    </td>
                                </form>
                            </tr>
                            @forelse($tasks as $task)
                            <tr onclick="window.location='{{ route('tasks.show', $task->id) }}';">
                                <td>{{$task->uuid}}</td>
                                <td>{{$task->description}}</td>
                                <td>{{$task->created_at}}</td>
                                <td>{{$task->created_at}}</td>
                                <td>{{$task->currentResponsible()}}</td>
                                <td>{{$task->currentHistory->done_progress}}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">
                                    Нет задач
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{$tasks->withQueryString()->links()}}
                </div>
            </div>
        </div>
    </div>
    @endsection