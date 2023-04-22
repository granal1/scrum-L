@extends('main')

@section('title', 'Главная | Архив Исходящих документов')

@section('header')
    @include('menu')
@endsection

@section('content')
    <div class="container-fluid pt-3">
        <div class="card shadow">
            <div class="card-header">
                <div class="row row-cols-3">
                    <div class="col-1">
                        
                    </div>

                    <div class="col-10 text-center">
                        <div class="col">
                            <form action="{{route('archive_outgoing_documents.index')}}" method="get">
                                <h4 class="d-inline-block">Журнал учета исходящих документов за </h4>
                                @if(!is_null($archive_outgoing_documents))
                                <select class="h5" name="year" id="year" class="form-select form-select-sm" onchange="this.form.submit();">
                                    @forelse($archive_years as $key => $value)
                                        <option value="{{$value}}" @if(Session::get('year') == $value) selected @endif>{{$value}}</option>
                                    @empty
                                        <option value="">____</option>
                                    @endforelse
                                </select>
                                @endif
                                <h4 class="d-inline-block">год</h4>
                            </form>
                        </div>
                        <div class="col">
                            <form action="{{route('archive_outgoing_documents.index')}}" method="get">
                                <input hidden name="year" value="{{Session::get('year')}}">

                                <h5 class="d-inline-block">Период с </h5>
                                <input class="h6" id="dateFrom" type="date" name="from_date"
                                    @if(Session::has('from_date')) 
                                        value="{{Session::get('year') . Session::get('from_date')}}" 
                                    @else 
                                        value="{{Session::get('year')}}-01-01"
                                    @endif 
                                    min="{{Session::get('year')}}-01-01" 
                                    @if(Session::has('to_date')) 
                                        max="{{Session::get('year') . Session::get('to_date')}}" 
                                    @else 
                                        max="{{Session::get('year')}}-12-31" 
                                    @endif>

                                <h5 class="d-inline-block"> по </h5>
                                <input class="h6" id="dateTo" type="date" name="to_date"
                                    @if(Session::has('to_date'))
                                        value="{{Session::get('year') . Session::get('to_date')}}"
                                    @else 
                                        value="{{Session::get('year')}}-12-31"
                                    @endif
                                    @if(Session::has('from_date')) 
                                        min="{{Session::get('year') . Session::get('from_date')}}"
                                    @else 
                                        min="{{Session::get('year')}}-01-01" 
                                    @endif
                                    max="{{Session::get('year')}}-12-31">

                                <button type="submit" class="btn btn-outline-dark mb-1 ms-2"
                                    style="--bs-btn-padding-y: .1rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .85rem;">Выбрать</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-1 text-end">
                            <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Поиск
                            </button>
                        <a class="btn btn-outline-danger btn-sm d-md-none" type="button" href="{{route('archive_outgoing_documents.index')}}">Сброс</a>
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
                                <th class="d-none d-md-table-cell">Наименование или<br>краткое содержание</th>
                                <th class="d-none d-md-table-cell">Кол-во<br>листов</th>
                                <th class="d-none d-md-table-cell">ФИО исполнителя<br>документа</th>
                                <th class="d-none d-sm-table-cell">Место<br>подшивки</th>
                            </tr>
                            </thead>
                            <tbody style="cursor: pointer;">

                            <tr class="collapse @if(!empty($old_filters)) show @endif" id="collapseExample">
                                <form action="{{ route('archive_outgoing_documents.index') }}" method="get">
                                    <td class="d-none d-md-table-cell"><a class="btn btn-outline-danger btn-sm"
                                                                          type="button"
                                                                          href="{{route('archive_outgoing_documents.index')}}">Сброс</a>
                                    </td>
                                    <td colspan="4"></td>
                                    <td>
                                        <input hidden name="year" value="{{Session::get('year')}}">
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
                            @if(!empty($archive_outgoing_documents))
                            @forelse($archive_outgoing_documents as $output_file)
                                <tr onclick="window.open('{{route('archive_outgoing_documents.show', $output_file->id)}}', '_blank')">
                                    <td class="d-none d-md-table-cell">{{$output_file->outgoing_at ? date('d.m.Y', strtotime($output_file->outgoing_at)) : null}}</td>
                                    <td class="d-none d-md-table-cell">{{$output_file->outgoing_number ?? 'Б/Н'}}</td>
                                    <td class="d-none d-md-table-cell">{{$output_file->destination ?? 'Нет'}}</td>
                                    <td class="d-none d-md-table-cell">{{$output_file->number_of_source_document ?? 'Б/Н'}}</td>
                                    <td class="d-none d-md-table-cell">{{$output_file->date_of_source_document ? date('d.m.Y', strtotime($output_file->date_of_source_document)) : 'Нет'}}</td>
                                    <td class="d-none d-md-table-cell">{{$output_file->short_description ?? 'Отсутствует'}}</td>
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
                            @else
                                <tr>
                                    <td colspan="8">
                                        Нет документов
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                        </table>
                        @if(!empty($archive_outgoing_documents))
                        {{$archive_outgoing_documents->withQueryString()->links()}}
                            {{Session::put('page', $archive_outgoing_documents->currentPage())}}
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <script>
            document.getElementById("dateFrom").onchange = function(){
                var input = document.getElementById("dateTo");
                input.setAttribute("min", this.value);
            }
            document.getElementById("dateTo").onchange = function(){
                var input = document.getElementById("dateFrom");
                input.setAttribute("max", this.value);
            }
        </script>
@endsection

