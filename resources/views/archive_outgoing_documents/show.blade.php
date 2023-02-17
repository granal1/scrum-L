@extends('main')

@section('title', 'Исходящий документ')

@section('header')
    @include('menu')
@endsection

@section('content')
    <div class="container mb-3 mt-3 card shadow-lg">
        <div class="row">
            <div class="col-lg-2 col-md-12 rounded text-white bg-primary pt-3" style="--bs-bg-opacity: .4">
                <div class="row">
                    <div class="col">
                        <h4 class="d-inline-block">Исходящий документ</h4>
                    </div>
                </div>
            </div>

            <div class="col pt-3">
                @include('message')

                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="outgoing_at" class="form-label">Дата исходящего:</label>
                    </div>
                    <div class="col-8">
                        <input readonly disabled type="date" id="outgoing_at" name="outgoing_at"
                            class="form-control form-select-sm" placeholder="Дата исходящего документа"
                            value="{{date('Y-m-d', strtotime($archive_document['outgoing_at']))}}">
                        @error('outgoing_at')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="outgoing_number" class="form-label">Номер исходящего:</label>
                    </div>
                    <div class="col-8">
                        <input readonly disabled type="text" class="form-control form-control-sm" id="outgoing_number"
                            placeholder="Номер исходящего документа" name="outgoing_number" value="{{$archive_document['outgoing_number']}}">
                        @error('outgoing_number')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="destination" class="form-label">Адресат</label>
                    </div>
                    <div class="col-8">
                        <input readonly disabled type="text" class="form-control form-control-sm" id="destination"
                            placeholder="Получатель документа не указан" name="destination"
                            value="{{$archive_document['destination']}}">
                        @error('destination')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="number_of_source_document" class="form-label">Ответ на исходящий №</label>
                    </div>
                    <div class="col-8">
                        <input readonly disabled type="text" class="form-control form-control-sm" id="number_of_source_document"
                            placeholder="Номер документа не указан" name="number_of_source_document" value="{{$archive_document['number_of_source_document']}}">
                        @error('number_of_source_document')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="date_of_source_document" class="form-label">Ответ на исходящий от</label>
                    </div>
                    <div class="col-8">
                        <input readonly disabled type="date" id="date_of_source_document" name="date_of_source_document" class="form-control form-select-sm"
                            placeholder="Дата документа не указана" value="{{date('Y-m-d', strtotime($archive_document['date_of_source_document']))}}">
                        @error('date_of_source_document')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="name">Наименование или краткое содержание</label>
                    </div>
                    <div class="col-8">
                        <input class="form-control form-control-sm" name="name" id="name" disabled
                        placeholder="Сведения не указаны" value="{{$archive_document['short_description']}}">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="path">Место хранения документа</label>
                    </div>
                    <div class="col-8">
                        <a href="{{'/storage/' . $archive_document['path']}}" target="_blank"><input
                            class="form-control form-control-sm" name="path" id="path" disabled
                            value="{{$archive_document['path']}}" style="cursor: pointer;"></a>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="path">Приложение к документу</label>
                    </div>
                    <div class="col-8">
                        @if(!empty($archive_document['archive_path']))
                        <a href="{{'/storage/' . $archive_document['archive_path']}}" target="_blank">
                            <input
                                class="form-control form-control-sm" name="archive_path" id="archive_path" disabled
                                value="{{$archive_document['archive_path']}}" style="cursor: pointer;">
                        </a>
                        @else
                            <input
                                class="form-control form-control-sm" name="archive_path" id="archive_path" disabled
                                value="Отсутствует">
                        @endif
                    </div>
                </div>

                <div class="row mt-3 mx-1">
                    <div class="card">
                        <div class="card-header text-center">
                            <a class="btn btn-outline-primary btn-sm" data-bs-toggle="collapse" href="#collapseOne">
                            Показать текст документа
                            </a>
                        </div>
                        <div id="collapseOne" class="collapse" data-bs-parent="#accordion">
                            <div class="card-body">
                                @if(!empty($archive_document->content))
                                    <textarea rows="20" class="form-control form-control-sm" name="content" id="content" disabled>{{$archive_document['content']}}</textarea>
                                @else
                                    <input
                                        class="form-control form-control-sm" name="content" id="content" disabled
                                        placeholder="Текстовая часть отсутствует">
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="document_and_application_sheets" class="form-label">Количество листов документа, включая приложение</label>
                        </div>
                    <div class="col-8">
                        <input readonly disabled type="text" class="form-control form-control-sm"
                            id="document_and_application_sheets" placeholder="хх+ххх" name="document_and_application_sheets"
                            value="{{$archive_document['document_and_application_sheets']}}">
                        @error('document_and_application_sheets')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>

{{--                <div class="row mt-3">--}}
{{--                    <div class="col-4 text-end">--}}
{{--                        <label for="executor_uuid" class="form-label">Исполнитель</label>--}}
{{--                    </div>--}}
{{--                    <div class="col-8">--}}
{{--                        <input readonly disabled type="text" class="form-control form-control-sm" id="executor_uuid"--}}
{{--                            placeholder="Исполнитель" name="executor_uuid"--}}
{{--                            value="{{$archive_document->executor->name}}">--}}
{{--                        @error('executor_uuid')--}}
{{--                        <div class="text-danger">{{$message}}</div>--}}
{{--                        @enderror--}}
{{--                    </div>--}}
{{--                </div>--}}

                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="file_mark" class="form-label">Отметка о подшивке документа</label>
                    </div>
                    <div class="col-8">
                        <input readonly disabled type="text" class="form-control form-control-sm" id="file_mark"
                            placeholder="Документ в дело не подшит" name="file_mark" value="{{$archive_document['file_mark']}}">
                        @error('file_mark')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-center my-4">
                    <div class="mx-3">
                        <a style="width:150px" class="btn btn-sm btn-success"  href="{{route('archive_outgoing_documents.index', ['year' => Session::get('year')])}}">Назад
                        </a>
                    </div>
                    @can('update', \App\Models\OutgoingFiles\OutgoingFile::class)
                        <div class="mx-3">
                            <a style="width:150px" class="btn btn-sm btn-danger" href="{{route('archive_outgoing_documents.edit', $archive_document['id'])}}">Редактировать</a>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection


