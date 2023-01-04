@extends('main')

@section('title', 'Главная | Документы')

@section('header')
    @include('menu')
@endsection

@section('content')
        <div class="container-fluid pt-3">
            <div class="card shadow">
                <div class="card-header">
                    <div class="d-grid gap-2 d-md-flex align-items-center justify-content-between">
                        @auth
                            <a class="btn btn-outline-success btn-sm" href="{{route('documents.create')}}">Добавить</a>
                        @endauth
                        <h4 class="d-inline-block">Журнал учета входящих документов</h4>
                                <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Поиск
                                </button>
                            <a class="btn btn-outline-danger btn-sm d-md-none" type="button" href="{{route('documents.index')}}">Сброс</a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <table class="table table-sm table-hover table-striped">
                                <thead>
                                <tr>
                                    <th class="d-none d-md-table-cell text-center" style="width:11ch">Дата</th>
                                    <th class="d-none d-md-table-cell text-center">Вх.№</th>
                                    <th class="d-none d-md-table-cell text-center">Корреспондент<br>(автор)</th>
                                    <th class="d-none d-md-table-cell text-center">Номер<br>док-та</th>
                                    <th class="d-none d-md-table-cell text-center" style="width:11ch">Дата<br>док-та</th>
                                    <th class="d-none d-md-table-cell text-center">Наименование или<br>краткое содержание</th>
                                    <th class="d-none d-md-table-cell text-center">Кол-во<br>листов</th>
                                    <th class="d-none d-sm-table-cell text-center">Задание (Резолюция)</th>
                                    <th class="d-none d-sm-table-cell text-center">Исполнитель<br>(Исполнители)</th>
                                    <th class="d-none d-sm-table-cell text-center">Срок<br>исполнения</th>
                                    <th class="d-none d-sm-table-cell text-center">Результат<br>исполнения</th>
                                    <th class="d-none d-sm-table-cell text-center">Дата<br>исполнения</th>
                                    <th class="d-none d-sm-table-cell text-center">Место<br>подшивки</th>
                                </tr>
                                </thead>
                                <tbody style="cursor: pointer;">

                                <tr class="collapse @if(!empty($old_filters)) show @endif" id="collapseExample">
                                    <form action="{{ route('documents.index') }}" method="get">
                                        <td class="d-none d-md-table-cell"><a class="btn btn-outline-danger btn-sm" type="button" href="{{route('documents.index')}}">Сброс</a></td>
                                        <td class="d-none d-sm-table-cell">
                                            <input type="search" value="@if(isset($old_filters['path'])) {{ $old_filters['path'] }} @endif"
                                                   class="form-control form-control-sm" id="path" name="path"
                                                   onchange="this.form.submit()">
                                        </td>
                                        <td>
                                            <input type="search" value="@if(isset($old_filters['name'])) {{ $old_filters['name'] }} @endif"
                                                   class="form-control form-control-sm" id="name" name="name"
                                                   onchange="this.form.submit()">
                                        </td>
                                    </form>
                                </tr>
                                @forelse($documents as $document)
                                    <tr  onclick="window.location='{{ route('documents.show', $document->id) }}';">
                                        <td class="d-none d-md-table-cell">{{$document->incoming_at}}</td>
                                        <td class="d-none d-md-table-cell">{{$document->incoming_number}}</td>
                                        <td class="d-none d-md-table-cell">{{$document->incoming_author}}</td>
                                        <td class="d-none d-md-table-cell">{{$document->number}}</td>
                                        <td class="d-none d-md-table-cell">{{$document->date}}</td>
                                        <td class="d-none d-md-table-cell">{{$document->short_description}}</td>
                                        <td class="d-none d-md-table-cell">{{$document->document_and_application_sheets}}</td>
                                        <td class="d-none d-md-table-cell">{{$document->task_description}}</td>
                                        <td class="d-none d-md-table-cell">{{$document->executor}}</td>
                                        <td class="d-none d-md-table-cell">{{$document->deadline_at}}</td>
                                        <td class="d-none d-md-table-cell">{{$document->executed_result}}</td>
                                        <td class="d-none d-md-table-cell">{{$document->executed_at}}</td>
                                        <td class="d-none d-md-table-cell">{{$document->file_mark}}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">
                                            Нет документов
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                            {{$documents->withQueryString()->links()}}
                        </div>
                    </div>
                </div>
            </div>
@endsection

