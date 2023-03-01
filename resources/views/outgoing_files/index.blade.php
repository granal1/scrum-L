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
                    <div class="col-1">
                        @auth
                            @can('create', \App\Models\OutgoingFiles\OutgoingFile::class)
                                <a class="btn btn-outline-success btn-sm"
                                href="{{route('outgoing_files.create')}}">Добавить</a>
                            @endcan
                        @endauth
                    </div>

                    <div class="d-flex justify-content-center">
                        <div class="pe-1">
                            <h4>Журнал учета исходящих документов за</h4>
                        </div>
                        <div>
                            <form action="{{route('outgoing_files.index')}}" method="get">

                                <select class="h5" name="year" id="year" class="form-select form-select-sm" onchange="this.form.submit();">
                                    @forelse($years as $year)
                                        <option @if(Session::has('year') && Session::get('year') == $year) selected @endif value="{{$year}}">{{$year}}</option>
                                    @empty
                                        <option value="">_____</option>
                                    @endforelse
                                </select>

                            </form>
                        </div>
                        <div class="ps-1 pe-3">
                            <h4>год</h4>
                        </div>
                    </div>

                    <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                        Поиск
                    </button>
                    <a class="btn btn-outline-danger btn-sm d-md-none" type="button"
                       href="{{route('outgoing_files.index')}}">Сброс</a>
                </div>
                <div class="row">
                    <div class="col text-center">
                        <form action="{{route('outgoing_files.index')}}" method="get">
                            <input hidden name="year" value="{{Session::get('year')}}">
                            <h4 class="d-inline-block">Период с: </h4>
                            <select name="from_day" id="day" class="h5">
                                @for($i = 1; $i <= 31; $i++)
                                    <option  @if(Session::has('from_day') && Session::get('from_day') == $i) selected @endif value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                            <select name="from_month" id="month" class="h5">
                                <option @if(Session::has('from_month') && Session::get('from_month') == 1) selected @endif value="01">январь</option>
                                <option @if(Session::has('from_month') && Session::get('from_month') == 2) selected @endif value="02">февраль</option>
                                <option @if(Session::has('from_month') && Session::get('from_month') == 3) selected @endif value="03">март</option>
                                <option @if(Session::has('from_month') && Session::get('from_month') == 4) selected @endif value="04">апрель</option>
                                <option @if(Session::has('from_month') && Session::get('from_month') == 5) selected @endif value="05">май</option>
                                <option @if(Session::has('from_month') && Session::get('from_month') == 6) selected @endif value="06">июнь</option>
                                <option @if(Session::has('from_month') && Session::get('from_month') == 7) selected @endif value="07">июль</option>
                                <option @if(Session::has('from_month') && Session::get('from_month') == 8) selected @endif value="08">август</option>
                                <option @if(Session::has('from_month') && Session::get('from_month') == 9) selected @endif value="09">сентябрь</option>
                                <option @if(Session::has('from_month') && Session::get('from_month') == 10) selected @endif value="10">октябрь</option>
                                <option @if(Session::has('from_month') && Session::get('from_month') == 11) selected @endif value="11">ноябрь</option>
                                <option @if(Session::has('from_month') && Session::get('from_month') == 12) selected @endif value="12">декабрь</option>
                            </select>
                            <h4 class="d-inline-block"> по: </h4>
                            <select name="to_day" id="day" class="h5">
                                @for($i = 1; $i <= 31; $i++)
                                    <option @if(Session::has('to_day') && Session::get('to_day') == $i) selected @endif value="{{$i}}">{{$i}}</option>
                                @endfor
                            </select>
                            <select name="to_month" id="month" class="h5">
                                <option @if(Session::has('to_month') && Session::get('to_month') == 1) selected @endif value="01">январь</option>
                                <option @if(Session::has('to_month') && Session::get('to_month') == 2) selected @endif value="02">февраль</option>
                                <option @if(Session::has('to_month') && Session::get('to_month') == 3) selected @endif value="03">март</option>
                                <option @if(Session::has('to_month') && Session::get('to_month') == 4) selected @endif value="04">апрель</option>
                                <option @if(Session::has('to_month') && Session::get('to_month') == 5) selected @endif value="05">май</option>
                                <option @if(Session::has('to_month') && Session::get('to_month') == 6) selected @endif value="06">июнь</option>
                                <option @if(Session::has('to_month') && Session::get('to_month') == 7) selected @endif value="07">июль</option>
                                <option @if(Session::has('to_month') && Session::get('to_month') == 8) selected @endif value="08">август</option>
                                <option @if(Session::has('to_month') && Session::get('to_month') == 9) selected @endif value="09">сентябрь</option>
                                <option @if(Session::has('to_month') && Session::get('to_month') == 10) selected @endif value="10">октябрь</option>
                                <option @if(Session::has('to_month') && Session::get('to_month') == 11) selected @endif value="11">ноябрь</option>
                                <option @if(Session::has('to_month') && Session::get('to_month') == 12) selected @endif value="12">декабрь</option>
                            </select>
                            <button type="submit" class="btn btn-outline-dark btn-sm mb-2">Найти</button>
                        </form>
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
                        {{Session::put('page', $output_files->currentPage())}}
                    </div>
                </div>
            </div>
        </div>
@endsection

