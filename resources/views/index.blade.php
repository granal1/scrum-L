@extends('main')

@section('title', 'Главная')

@section('header')
    @include('menu')
@endsection

@section('content')
    <div class="container pt-3">
            <div class="row mb-3 d-md-flex justify-content-between">
                <div class="col-auto">
                    <h5>Здравствуйте {{ auth()->user()->name() }}</h5>
                </div>
            </div>
        <div class="card shadow">
            <div class="card-header">
                <div class="d-grid gap-2 d-md-flex align-items-center justify-content-between">
                    <h5 class="d-inline-block">Ваши задачи</h5>
                            <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Поиск
                            </button>
                </div>
            </div>
            <div class="card-body">
                <div class="row pt-3">
                    <div class="col">
                        <table class="table table-sm table-hover table-striped">
                            <thead>
                            <tr>
                                <td class="d-none d-sm-table-cell">Приоритет</td>
                                <td>Описание</td>
                                <td class="d-none d-sm-table-cell">Ответственный</td>
                                <td class="d-none d-sm-table-cell">Выполнить до</td>
                                <td>Выполнено, %</td>
                            </tr>
                            </thead>
                            <tbody style="cursor: pointer;">

                            <tr class="collapse @if(!empty($old_filters)) show @endif" id="collapseExample">
                                <form action="{{ route('site.index') }}" method="get">
                                    <td>
                                        <select class="form-select form-select-sm" name="priority_uuid" id="priority_uuid" onchange="this.form.submit()">
                                            <option value="">Выберите ...</option>
                                            @forelse($priorities as $priority)
                                                <option @if(isset($old_filters['priority_uuid'])) {{$priority->id === $old_filters['priority_uuid'] ? 'selected' : ''}}  @endif value="{{$priority->id}}">{{$priority->name}}</option>
                                            @empty
                                                <option value="">Нет приоритетов</option>
                                            @endforelse
                                        </select>
                                    </td>
                                    <td>
                                        <input type="search" value="@if(isset($old_filters['description'])) {{ $old_filters['description'] }} @endif" class="form-control form-control-sm" id="description" name="description" onchange="this.form.submit()">
                                    </td>
                                    <td></td>
                                    <td></td>
                                    <td colspan="3"><a class="btn btn-danger btn-sm" type="button" href="{{route('site.index')}}">Сброс фильтров</a></td>
                                </form>
                            </tr>
                            @forelse($tasks as $task)
                                <tr onclick="window.location='{{ route('tasks.show', $task->id) }}';">
                                    <td class="d-none d-sm-table-cell">{{$task->currentPriority()}}</td>
                                    <td class="">{{$task->description}}</td>
                                    <td class="d-none d-sm-table-cell">{{$task->currentResponsible()}}</td>
                                    <td class="d-none d-sm-table-cell">{{$task->currentHistory->deadline_at}}</td>
                                    <td>@include('graph.progressbar')</td>
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
