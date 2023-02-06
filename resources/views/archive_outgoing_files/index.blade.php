@extends('main')

@section('title', 'Архив | Исходящие документы')

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
                    <h4 class="d-inline-block">Архив исходящих документов</h4>
                    <div>
                        <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                            Поиск
                        </button>
                        <a class="btn btn-outline-success btn-sm" type="button"
                            href="{{ route('outgoing_files.index') }}">Текущий год</a>
                    </div>
                    <a class="btn btn-outline-danger btn-sm d-md-none" type="button"
                        href="{{ route('outgoing_files.index') }}">Сброс</a>
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

                                <tr class="collapse @if (!empty($old_filters)) show @endif" id="collapseExample">
                                    <form action="{{ route('archive_outgoing_files.index') }}" method="get">
                                        <td class="d-none d-md-table-cell"><a class="btn btn-outline-danger btn-sm"
                                                type="button" href="{{ route('outgoing_files.index') }}">Сброс</a>
                                        </td>
                                        <td colspan="4"></td>
                                        <td>
                                            <input type="search" placeholder="Поиск по содержимому документов"
                                                value="@if (isset($old_filters['content'])) {{ $old_filters['content'] }} @endif"
                                                class="form-control form-control-sm" id="content" name="content"
                                                onchange="this.form.submit()">
                                        </td>
                                        <td colspan="7"></td>
                                    </form>
                                </tr>
                                @forelse($output_files as $output_file)
                                    <tr
                                        onclick="window.location='{{ route('archive_outgoing_files.show', $output_file->id) }}';">
                                        <td class="d-none d-md-table-cell">
                                            {{ $output_file->outgoing_at ? date('d.m.Y', strtotime($output_file->outgoing_at)) : null }}
                                        </td>
                                        <td class="d-none d-md-table-cell">{{ $output_file->outgoing_number ?? 'Б/Н' }}
                                        </td>
                                        <td class="d-none d-md-table-cell">{{ $output_file->destination ?? 'Нет' }}</td>
                                        <td class="d-none d-md-table-cell">
                                            {{ $output_file->number_of_source_document ?? 'Б/Н' }}</td>
                                        <td class="d-none d-md-table-cell">
                                            {{ $output_file->date_of_source_document ? date('d.m.Y', strtotime($output_file->date_of_source_document)) : 'Нет' }}
                                        </td>
                                        <td>{{ $output_file->short_description ?? 'Отсутствует' }}</td>
                                        <td class="d-none d-md-table-cell">
                                            {{ $output_file->document_and_application_sheets ?? 'Нет' }}</td>
                                        <td class="d-none d-md-table-cell">{{ $output_file->executor->name ?? 'Нет' }}</td>
                                        <td class="d-none d-md-table-cell">{{ $output_file->file_mark ?? 'Нет' }}</td>
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
                        {{ $output_files->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    @endsection
