@extends('main')

@section('title', 'Архив | Документы')

@section('header')
    @include('menu')
@endsection

@section('content')
    <div class="container-fluid pt-3">
        <div class="card shadow">
            <div class="card-header">
                <div class="d-grid gap-2 d-md-flex align-items-center justify-content-between">                    
                    <div class="btn-group">
                        <button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">
                            {{ substr($archive, -4) }} год
                        </button>
                        <div class="dropdown-menu">
                            @forelse ($archive_list as $key => $value)
                                <a class="dropdown-item"
                                    href="{{ route('archive_documents.index') }}?archive={{ $value }}">{{ $key }}
                                    год</a>
                            @empty
                                <div>нет сохранённых архивов</div>
                            @endforelse
                        </div>
                    </div>
                    <h4 class="d-inline-block">Архив входящих документов</h4>
                    <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Поиск
                    </button>
                    <a class="btn btn-outline-danger btn-sm d-md-none" type="button"
                        href="{{ route('documents.index') }}">Сброс</a>
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

                                <tr class="collapse @if (!empty($old_filters)) show @endif" id="collapseExample">
                                    <form action="{{ route('archive_documents.index') }}" method="get">
                                        <td class="d-none d-md-table-cell"><a class="btn btn-outline-danger btn-sm"
                                                type="button" href="{{ route('archive_documents.index') }}">Сброс</a></td>
                                        <td colspan="4"></td>
                                        <td>
                                            <input type="search"
                                                value="@if (isset($old_filters['content'])) {{ $old_filters['content'] }} @endif"
                                                class="form-control form-control-sm" id="content" name="content"
                                                onchange="this.form.submit()">
                                        </td>
                                        <td colspan="8"></td>
                                    </form>
                                </tr>
                                @forelse($documents as $document)
                                    <tr onclick="window.location='{{ route('archive_documents.show', $document->id) }}';">
                                        <td class="d-none d-md-table-cell">
                                            {{ $document->incoming_at ? date('d.m.Y', strtotime($document->incoming_at)) : null }}
                                        </td>
                                        <td class="d-none d-md-table-cell">{{ $document->incoming_number }}</td>
                                        <td class="d-none d-md-table-cell">{{ $document->incoming_author }}</td>
                                        <td class="d-none d-md-table-cell">{{ $document->number }}</td>
                                        <td class="d-none d-md-table-cell">
                                            {{ $document->date ? date('d.m.Y', strtotime($document->date)) : null }}</td>
                                        <td>{{ $document->short_description }}</td>
                                        <td class="d-none d-md-table-cell">{{ $document->document_and_application_sheets }}
                                        </td>
                                        <td class="d-none d-md-table-cell">
                                            {{ isset($document->tasks[0]) ? $document->tasks[0]->description : null }}</td>
                                        <td class="d-none d-md-table-cell">
                                            {{ isset($document->tasks[0]) ? $document->tasks[0]->responsible->name : null }}
                                        </td>
                                        <td class="d-none d-md-table-cell">
                                            {{ isset($document->tasks[0]) ? date('d.m.Y', strtotime($document->tasks[0]->deadline_at)) : null }}
                                        </td>
                                        <td class="d-none d-md-table-cell">
                                            {{ isset($document->tasks[0]) ? $document->tasks[0]->executed_result : null }}
                                        </td>
                                        <td class="d-none d-md-table-cell">{{ $document->executed_at ?? null }}</td>
                                        <td class="d-none d-md-table-cell">{{ $document->file_mark }}
                                            <input hidden name="arcnive_name" value="{{$archive}}">
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="13">
                                            Нет документов
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $documents->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    @endsection