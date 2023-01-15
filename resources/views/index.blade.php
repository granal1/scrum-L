@extends('main')

@section('title', 'Главная')

@section('header')
    @include('menu')
@endsection

@section('content')
    <div class="container pt-3">
            <div class="row mb-3 d-flex justify-content-between">
                <div class="col-auto">
                    <h5>Здравствуйте {{ auth()->user()->name() }}</h5>
                </div>
            </div>
            <div class="card shadow">
                <div class="card-header">
                    <div class="d-grid gap-2 d-flex align-items-center justify-content-between">
                        <h5 class="d-inline-block">Актуальная информация</h5>
                        <div class="">
                        <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseExample" aria-expanded="false"
                                aria-controls="collapseExample">Поиск
                        </button>
                        <a class="btn btn-outline-danger btn-sm" href="{{route('site.index')}}">Сброс</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">


                            <div id="accordion">
                                @if(Auth::user()->isMainSupervisor())
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <a class="btn" data-bs-toggle="collapse" href="#collapseOne">
                                            Новые документы
                                            <span class="badge bg-primary rounded-pill">{{count($new_documents)}}</span>
                                        </a>
                                    </div>
                                    <div id="collapseOne" class="collapse" data-bs-parent="#accordion">
                                        <div class="card-body">
                                            <table class="table table-sm table-hover table-striped">
                                                <thead>
                                                <tr>
                                                    <th class="d-none d-md-table-cell">Дата</th>
                                                    <th class="d-none d-md-table-cell">Вх.№</th>
                                                    <th class="d-none d-md-table-cell">Корреспондент<br>(автор)</th>
                                                    <th class="d-none d-md-table-cell">Номер<br>док-та</th>
                                                    <th class="d-none d-md-table-cell">Дата<br>док-та</th>
                                                    <th class="d-none d-md-table-cell">Наименование или<br>краткое
                                                        содержание</th>
                                                    <th class="d-none d-md-table-cell">Кол-во<br>листов</th>
                                                </tr>
                                                </thead>
                                                <tbody style="cursor: pointer;">

                                                <tr class="collapse " id="collapseExample">
                                                    <form action="{{route('site.index')}}" method="get">
                                                        <td class="d-none d-md-table-cell"><a
                                                                class="btn btn-outline-danger btn-sm" type="button"
                                                                href="{{route('site.index')}}">Сброс</a></td>
                                                        <td colspan="4"></td>
                                                        <td>
                                                            <input type="search" value=""
                                                                   class="form-control form-control-sm"
                                                                   id="short_description" name="short_description"
                                                                   onchange="this.form.submit()">
                                                        </td>
                                                        <td colspan="7"></td>
                                                    </form>
                                                </tr>
                                                @forelse($new_documents as $document)
                                                <tr
                                                    onclick="window.location='{{route('documents.show', $document->id)}}';">
                                                    <td class="d-none d-md-table-cell">{{$document->incoming_at}}</td>
                                                    <td class="d-none d-md-table-cell">{{$document->incoming_number}}</td>
                                                    <td class="d-none d-md-table-cell">{{$document->incoming_author}}</td>
                                                    <td class="d-none d-md-table-cell">{{$document->number}}</td>
                                                    <td class="d-none d-md-table-cell">{{$document->date}}</td>
                                                    <td class="d-none d-md-table-cell">{{$document->short_description}}</td>
                                                    <td class="d-none d-md-table-cell">{{$document->document_and_application_sheets}}</td>
                                                </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="7">
                                                            Нет новых документов
                                                        </td>
                                                    </tr>
                                                @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <a class="collapsed btn" data-bs-toggle="collapse" href="#collapseTwo">
                                            Невыполненные задачи
                                            <span class="badge bg-danger rounded-pill">{{count($outstanding_tasks)}}</span>
                                        </a>
                                    </div>
                                    <div id="collapseTwo" class="collapse" data-bs-parent="#accordion">
                                        <div class="card-body">
                                            <table class="table table-sm table-hover table-striped">
                                                <thead>
                                                <tr>
                                                    <td class="d-none d-sm-table-cell">Приоритет</td>
                                                    <td>Описание</td>
                                                    <td class="d-none d-sm-table-cell">Ответственный</td>
                                                    <td class="d-none d-md-table-cell">Выполнить до</td>
                                                    <td>Исп.,&nbsp;%</td>
                                                </tr>
                                                </thead>
                                                <tbody style="cursor: pointer;">

                                                <tr class="collapse " id="collapseExample">
                                                    <form action="{{route('site.index')}}" method="get">
                                                        <td class="d-none d-sm-table-cell">
                                                            <select class="form-select form-select-sm"
                                                                    name="priority_uuid" id="priority_uuid"
                                                                    onchange="this.form.submit()">
                                                                <option value="">Выберите ...</option>
                                                                @forelse($priorities as $priority)
                                                                <option {{isset($old_filters['priority_uuid']) && $old_filters['priority_uuid'] === $priority->id ? 'selected' : null}}
                                                                    value="{{$priority->id}}">{{$priority->name}}</option>
                                                                @empty
                                                                    <option value="">Нет приоритетов</option>
                                                                @endforelse
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <input type="search" value="{{isset($old_filters['description']) ? $old_filters['description'] : null}}"
                                                                   class="form-control form-control-sm"
                                                                   id="description" name="description"
                                                                   onchange="this.form.submit()">
                                                        </td>
                                                        <td class="d-none d-sm-table-cell"></td>
                                                        <td>
                                                            <a class="btn btn-outline-danger btn-sm d-sm-none"
                                                               type="button" href="http://scrum-l.local">Сброс</a>
                                                        </td>
                                                        <td colspan="3" class="d-none d-sm-table-cell"><a
                                                                class="btn btn-outline-danger btn-sm" type="button"
                                                                href="http://scrum-l.local">Сброс</a></td>
                                                    </form>
                                                </tr>
                                                @forelse($outstanding_tasks as $task)
                                                    <tr onclick="window.location='{{ route('tasks.show', $task->id) }}';">
                                                    <td class="d-none d-sm-table-cell">{{$task->currentPriority()}}</td>
                                                    <td>{{$task->description}}</td>
                                                    <td class="d-none d-sm-table-cell">{{$task->currentResponsible()}}</td>
                                                    <td class="d-none d-md-table-cell">{{$task->currentHistory->deadline_at}}</td>
                                                    <td>{{$task->currentHistory->done_progress}}</td>
                                                </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5">
                                                            Нет задач
                                                        </td>
                                                    </tr>
                                                @endforelse
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <a class="collapsed btn" data-bs-toggle="collapse" href="#collapseThree">
                                            Текущие задачи
                                            <span class="badge bg-primary rounded-pill">{{$current_tasks_count}}</span>
                                        </a>
                                    </div>
                                    <div id="collapseThree" class="collapse" data-bs-parent="#accordion">
                                        <div class="card-body">
                                            <table class="table table-sm table-hover table-striped">
                                                <thead>
                                                <tr>
                                                    <td class="d-none d-sm-table-cell">Приоритет</td>
                                                    <td>Описание</td>
                                                    <td class="d-none d-sm-table-cell">Ответственный</td>
                                                    <td class="d-none d-md-table-cell">Выполнить до</td>
                                                    <td>Исп.,&nbsp;%</td>
                                                </tr>
                                                </thead>
                                                <tbody style="cursor: pointer;">
                                                <tr class="collapse @if(!empty($old_filters)) show @endif" id="collapseExample">
                                                    <form action="{{ route('site.index') }}" method="get">
                                                        <td class="d-none d-sm-table-cell">
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
                                                            <input type="search" value="@if(isset($old_filters['description'])){{$old_filters['description']}}@endif" class="form-control form-control-sm" id="description" name="description" onchange="this.form.submit()">
                                                        </td>
                                                        <td class="d-none d-sm-table-cell"></td>
                                                        <td>
                                                            <a class="btn btn-outline-danger btn-sm d-sm-none" type="button" href="{{route('site.index')}}">Сброс</a>
                                                        </td>
                                                        <td colspan="3" class="d-none d-sm-table-cell"><a class="btn btn-outline-danger btn-sm" type="button" href="{{route('site.index')}}">Сброс</a></td>
                                                    </form>
                                                </tr>
                                                @forelse($tasks as $task)
                                                    <tr onclick="window.location='{{ route('tasks.show', $task->id) }}';">
                                                        <td class="d-none d-sm-table-cell">{{$task->currentPriority()}}</td>
                                                        <td class="">{{$task->description}}</td>
                                                        <td class="d-none d-sm-table-cell">{{$task->currentResponsible()}}</td>
                                                        <td class="d-none d-md-table-cell">{{$task->currentHistory->deadline_at}}</td>
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
                        </div>
                    </div>
                </div>
            </div>
@endsection
