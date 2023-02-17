@extends('main')

@section('title', 'Главная | Исходящие документы')

@section('header')
    @include('menu')
@endsection

@section('content')
    <div class="container-fluid pt-3">
        <div class="card shadow">
            <div class="card-header">
                <div class="d-grid gap-2 d-md-flex align-items-center justify-content-between">
                    @auth
                        @can('create', \App\Models\OutgoingFiles\OutgoingFile::class)
                            <a class="btn btn-outline-success btn-sm"
                               href="{{route('outgoing_files.create')}}">Добавить</a>
                        @endcan
                    @endauth
                        <div class="col-10 text-center">
                            <form action="{{route('outgoing_files.index')}}" method="get">
                                <h4 class="d-inline-block">Журнал учета исходящих документов за </h4>
                                <select onchange="this.form.submit();" class="form-select form-select-sm d-inline-block" name="year" style="width: 6rem;">
                                    @forelse($years as $year)
                                        <option @if(isset($old_filters['year']) && $old_filters['year']  == $year) selected @endif value="{{$year}}">{{$year}}</option>
                                    @empty
                                        <option value="">Нет данных ...</option>
                                    @endforelse
                                </select>
                                <h4 class="d-inline-block">год</h4>
                            </form>
                        </div>
                    <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        Поиск
                    </button>
                    <a class="btn btn-outline-danger btn-sm d-md-none" type="button"
                       href="{{route('outgoing_files.index')}}">Сброс</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <table class="table table-sm table-hover table-striped">
                            <thead>
                            <tr>
                                <th class="d-none d-md-table-cell">Дата</th>
                                <th class="d-none d-md-table-cell">Исх.№</th>
                                <th class="d-none d-md-table-cell">Адресат</th>
                                <th class="d-none d-md-table-cell">Ответ на исх.,<br>№</th>
                                <th class="d-none d-md-table-cell">Ответ на исх.,<br>дата</th>
                                <th>Наименование или<br>краткое содержание</th>
                                <th class="d-none d-md-table-cell">Кол-во<br>листов</th>
                                <th class="d-none d-md-table-cell">ФИО исполнителя<br>документа</th>
                                <th class="d-none d-sm-table-cell">Место<br>подшивки</th>
                            </tr>
                            </thead>
                            <tbody style="cursor: pointer;">

                            <tr class="collapse @if(!empty($old_filters)) show @endif" id="collapseExample">
                                <form action="{{ route('outgoing_files.index') }}" method="get">
                                    <td class="d-none d-md-table-cell"><a class="btn btn-outline-danger btn-sm"
                                                                          type="button"
                                                                          href="{{route('outgoing_files.index')}}">Сброс</a>
                                    </td>
                                    <td colspan="4"></td>
                                    <td>
                                        <input type="search"
                                               placeholder="Поиск по содержимому документов"
                                               value="@if(isset($old_filters['content'])){{$old_filters['content']}}@endif"
                                               class="form-control form-control-sm" id="content"
                                               name="content"
                                               onchange="this.form.submit()">
                                    </td>
                                    <td colspan="7"></td>
                                </form>
                            </tr>
                            @forelse($output_files as $output_file)
                                <tr onclick="window.location='{{ route('outgoing_files.show', $output_file->id) }}';">
                                    <td class="d-none d-md-table-cell">{{$output_file->outgoing_at ? date('d.m.Y', strtotime($output_file->outgoing_at)) : null}}</td>
                                    <td class="d-none d-md-table-cell">{{$output_file->outgoing_number ?? 'Б/Н'}}</td>
                                    <td class="d-none d-md-table-cell">{{$output_file->destination ?? 'Нет'}}</td>
                                    <td class="d-none d-md-table-cell">{{$output_file->number_of_source_document ?? 'Б/Н'}}</td>
                                    <td class="d-none d-md-table-cell">{{$output_file->date_of_source_document ? date('d.m.Y', strtotime($output_file->date_of_source_document)) : 'Нет'}}</td>
                                    <td>{{$output_file->short_description ?? 'Отсутствует'}}</td>
                                    <td class="d-none d-md-table-cell">{{$output_file->document_and_application_sheets ?? 'Нет'}}</td>
                                    <td class="d-none d-md-table-cell">{{$output_file->executor->name ?? 'Нет'}}</td>
                                    <td class="d-none d-md-table-cell">{{$output_file->file_mark ?? 'Нет'}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">
                                        Нет документов
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        {{$output_files->withQueryString()->links()}}
                    </div>
                </div>
            </div>
        </div>
@endsection

