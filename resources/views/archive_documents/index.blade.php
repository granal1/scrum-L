@extends('main')

@section('title', 'Главная | Архивные документы')

@section('header')
    @include('menu')
@endsection

@section('content')
        <div class="container-fluid pt-3">
            <div class="card shadow">
                <div class="card-header">
                    <div class="row row-cols-1 row-cols-md-3">
                        <div class="col-1">
                        </div>
                        <div class="col-10 text-center">
                        <form action="{{route('archive_documents.index')}}" method="get">
                            <h4 class="d-inline-block">Архив входящих документов за</h4>
                        @if(!is_null($archive_documents))
                                <select name="year" id="year" class="form-select form-select-sm d-inline-block" onchange="this.form.submit();" style="width: 6rem;">
                                    @forelse($archive_years as $key => $value)
                                        <option value="{{$value}}" @if(Session::get('year') == $value) selected @endif>{{$value}}</option>
                                    @empty
                                        <option value="">пусто</option>
                                    @endforelse
                                </select>
                            @endif
                            <h4 class="d-inline-block">год</h4>
                        </form>
                        </div>
                        <div class="col-1 text-end">
                                <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Поиск
                                </button>
                            <a class="btn btn-outline-danger btn-sm d-md-none" type="button" href="{{route('archive_documents.index')}}">Сброс</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <table class="table table-sm table-hover table-striped">
                                <thead>
                                <tr>
                                    <th class="d-none d-md-table-cell">Дата</th>
                                    <th class="d-none d-md-table-cell">Вх.№</th>
                                    <th class="d-none d-md-table-cell">Корреспондент<br>(автор)</th>
                                    <th class="d-none d-md-table-cell">Номер<br>док-та</th>
                                    <th class="d-none d-md-table-cell">Дата<br>док-та</th>
                                    <th>Наименование или<br>краткое содержание</th>
                                    <th class="d-none d-md-table-cell">Кол-во<br>листов</th>
                                    <th class="d-none d-sm-table-cell">Задание (Резолюция)</th>
                                    <th class="d-none d-sm-table-cell">Исполнитель<br>(Исполнители)</th>
                                    <th class="d-none d-sm-table-cell">Срок<br>исполнения</th>
                                    <th class="d-none d-sm-table-cell">Результат<br>исполнения</th>
                                    <th class="d-none d-sm-table-cell">Дата<br>исполнения</th>
                                    <th class="d-none d-sm-table-cell">Место<br>подшивки</th>
                                </tr>
                                </thead>
                                <tbody style="cursor: pointer;">

                                <tr class="collapse @if(!empty($old_filters)) show @endif" id="collapseExample">
                                    <form action="{{ route('archive_documents.index') }}" method="get">
                                        <td class="d-none d-md-table-cell"><a class="btn btn-outline-danger btn-sm" type="button" href="{{route('archive_documents.index')}}">Сброс</a></td>
                                      <td colspan="4"></td>
                                        <td>
                                            <input hidden name="year" id="year" value="{{Session::get('year')}}">
                                            <input type="search"
                                                   value="@if(isset($old_filters['content'])){{$old_filters['content']}}@endif"
                                                   class="form-control form-control-sm" id="content"
                                                   name="content"
                                                   onchange="this.form.submit()">
                                        </td>
                                        <td colspan="8"></td>
                                    </form>
                                </tr>
                                @if(!is_null($archive_documents))
                                @forelse($archive_documents as $archive_document)
                                    <tr  onclick="window.location='{{ route('archive_documents.show', $archive_document->id) }}';">
                                        <td class="d-none d-md-table-cell">{{$archive_document->incoming_at ? date('d.m.Y', strtotime($archive_document->incoming_at)) : null}}</td>
                                        <td class="d-none d-md-table-cell">{{$archive_document->incoming_number}}</td>
                                        <td class="d-none d-md-table-cell">{{$archive_document->incoming_author}}</td>
                                        <td class="d-none d-md-table-cell">{{$archive_document->number}}</td>
                                        <td class="d-none d-md-table-cell">{{$archive_document->date ? date('d.m.Y', strtotime($archive_document->date)) : null}}</td>
                                        <td>{{$archive_document->short_description}}</td>
                                        <td class="d-none d-md-table-cell">{{$archive_document->document_and_application_sheets}}</td>
                                        <td class="d-none d-md-table-cell">{{isset($archive_document->tasks[0]) ? $archive_document->tasks[0]->description : null}}</td>
                                        <td class="d-none d-md-table-cell">{{isset($archive_document->tasks[0]) ? $archive_document->tasks[0]->responsible->name : null}}</td>
                                        <td class="d-none d-md-table-cell">{{isset($archive_document->tasks[0]) ? date('d.m.Y', strtotime($archive_document->tasks[0]->deadline_at)) : null}}</td>
                                        <td class="d-none d-md-table-cell">{{isset($archive_document->tasks[0]) ? $archive_document->tasks[0]->executed_result : null}}</td>
                                        <td class="d-none d-md-table-cell">{{$archive_document->executed_at ?? null}}</td>
                                        <td class="d-none d-md-table-cell">{{$archive_document->file_mark}}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="13">
                                            Нет документов
                                        </td>
                                    </tr>
                                @endforelse
                                @else
                                    <tr>
                                        <td colspan="13">
                                            Нет документов
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                            @if(!is_null($archive_documents))
                                {{$archive_documents->withQueryString()->links()}}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
@endsection

