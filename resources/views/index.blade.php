@extends('main')

@section('title', 'Главная')

@section('header')
    @include('menu')
@endsection

@section('content')
    <div class="container pt-3">
            <div class="row mb-3 d-flex justify-content-between">
                <div class="col-auto">
                    <h5>Здравствуйте, {{ $name }}!</h5>
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
                                            <span class="badge bg-danger rounded-pill">{{$outstanding_tasks_count}}</span>
                                        </a>
                                    </div>
                                    <div id="collapseTwo" class="collapse" data-bs-parent="#accordion">
                                        <div class="card-body">
                                            <table class="table table-sm table-hover table-striped">
                                                <thead>
                                                <tr>
                                                    <th class="d-sm-table-cell">Срок</th>
                                                    <th class="d-none d-lg-table-cell">Приоритет</th>
                                                    <th class="d-none d-md-table-cell">Исполнитель</th>
                                                    <th class="d-sm-table-cell">Задача</th>
                                                    <th class="d-none d-md-table-cell">Отчет</th>
                                                    <th class="d-sm-table-cell">Исп.,&nbsp;%</th>
                                                </tr>
                                                </thead>
                                                <tbody style="cursor: pointer;">
                                                <tr class="collapse " id="collapseExample">
                                                    <form action="{{route('site.index')}}" method="get">
                                                        <td class="d-sm-table-cell"></td>
                                                        <td class="d-none d-lg-table-cell">
                                                            <select class="form-select form-select-sm" name="priority_uuid" id="priority_uuid" onchange="this.form.submit()">
                                                                <option value="">Выберите ...</option>
                                                                @forelse($priorities as $priority)
                                                                    <option @if(isset($old_filters['priority_uuid'])) {{$priority->id === $old_filters['priority_uuid'] ? 'selected' : ''}}  @endif value="{{$priority->id}}">{{$priority->name}}</option>
                                                                @empty
                                                                    <option value="">Нет приоритетов</option>
                                                                @endforelse
                                                            </select>
                                                        </td>
                                                        <td class="d-none d-md-table-cell"></td>
                                                        <td class="d-sm-table-cell">
                                                            <input class="form-control form-control-sm" type="search" value="@if(isset($old_filters['description'])){{$old_filters['description']}}@endif" id="description" name="description" onchange="this.form.submit()">
                                                        </td>
                                                        <td class="d-none d-md-table-cell"></td>
                                                        <td class="d-sm-table-cell">
                                                            <a class="btn btn-outline-danger btn-sm" type="button" href="{{route('site.index')}}">Сброс</a>
                                                        </td>
                                                    </form>
                                                </tr>
                                                @forelse($outstanding_tasks as $task)
                                                    <tr onclick="window.location='{{ route('tasks.show', $task->id) }}';">
                                                    <td class="d-sm-table-cell">{{$task->deadline_at}}</td>
                                                    <td class="d-none d-lg-table-cell">{{$task->priority->name}}</td>
                                                    <td class="d-none d-md-table-cell">{{$task->responsible->name}}</td>
                                                    <td class="d-sm-table-cell">{{$task->description}}</td>
                                                    <td class="d-none d-md-table-cell">{{$task->report}}</td>
                                                    <td>@include('graph.progressbar', ['done_progress'=> $task->done_progress])</td>
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
                                                    <th class="d-sm-table-cell">Срок</th>
                                                    <th class="d-none d-lg-table-cell">Приоритет</th>
                                                    <th class="d-none d-md-table-cell">Исполнитель</th>
                                                    <th class="d-sm-table-cell">Задача</th>
                                                    <th class="d-none d-md-table-cell">Отчет</th>
                                                    <th class="d-sm-table-cell">Исп.,&nbsp;%</th>
                                                </tr>
                                                </thead>
                                                <tbody style="cursor: pointer;">
                                                <tr class="collapse @if(!empty($old_filters)) show @endif" id="collapseExample">
                                                    <form action="{{ route('site.index') }}" method="get">
                                                        <td class="d-sm-table-cell"></td>
                                                        <td class="d-none d-lg-table-cell">
                                                            <select class="form-select form-select-sm" name="priority_uuid" id="priority_uuid" onchange="this.form.submit()">
                                                                <option value="">Выберите ...</option>
                                                                @forelse($priorities as $priority)
                                                                    <option @if(isset($old_filters['priority_uuid'])) {{$priority->id === $old_filters['priority_uuid'] ? 'selected' : ''}}  @endif value="{{$priority->id}}">{{$priority->name}}</option>
                                                                @empty
                                                                    <option value="">Нет приоритетов</option>
                                                                @endforelse
                                                            </select>
                                                        </td>
                                                        <td class="d-none d-md-table-cell"></td>
                                                        <td class="d-sm-table-cell">
                                                            <input class="form-control form-control-sm" type="search" value="@if(isset($old_filters['description'])){{$old_filters['description']}}@endif" id="description" name="description" onchange="this.form.submit()">
                                                        </td>
                                                        <td class="d-none d-md-table-cell"></td>
                                                        <td class="d-sm-table-cell">
                                                            <a class="btn btn-outline-danger btn-sm" type="button" href="{{route('site.index')}}">Сброс</a>
                                                        </td>
                                                    </form>
                                                </tr>
                                                @forelse($tasks as $task)
                                                    <tr onclick="window.location='{{ route('tasks.show', $task->id) }}';">
                                                        <td class="d-sm-table-cell">{{$task->deadline_at}}</td>
                                                        <td class="d-none d-lg-table-cell">{{$task->priority->name}}</td>
                                                        <td class="d-none d-md-table-cell">{{$task->responsible->name}}</td>
                                                        <td class="d-sm-table-cell">{{$task->description}}</td>
                                                        <td class="d-none d-md-table-cell">{{$task->report}}</td>
                                                        <td>@include('graph.progressbar', ['done_progress'=> $task->done_progress])</td>
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
<!--local time zone - {{session('localtimezone')}}-->
@endsection
