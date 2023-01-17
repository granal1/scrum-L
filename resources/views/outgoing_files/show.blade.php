@extends('main')

@section('title', 'Исходящий документ')

@section('header')
    @include('menu')
@endsection

@section('content')
    <div class="container pt-3 pb-3 mb-3 mt-3 card shadow-lg">
        <div class="row">
            <div class="col">
                <h4 class="d-inline-block">Исходящий документ</h4>
            </div>
        </div>
        @include('message')
        <div class="row pt-3 row-cols-1 row-cols-md-2">
            <div class="col mb-3">
                <label for="created_at">Создан</label>
                <input class="form-control form-control-sm" name="created_at" id="created_at" disabled
                       value="{{$output_file->created_at}}">
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-2">
            <div class="col mb-3">
                <label for="path">Путь</label>
                <a href="{{'/storage/' . $output_file->path}}" target="_blank"><input
                        class="form-control form-control-sm" name="path" id="path" disabled
                        value="{{$output_file->path}}" style="cursor: pointer;"></a>
            </div>
            <div class="col">
                <label for="name">Название</label>
                <input class="form-control form-control-sm" name="name" id="name" disabled
                       value="{{$output_file->short_description}}">
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-2">
            <div class="col">
                <label for="outgoing_at" class="form-label">Дата входящего:</label>
                <input readonly disabled type="date" id="outgoing_at" name="outgoing_at"
                       class="form-control form-select-sm" placeholder="Дата входящего документа"
                       value="{{date('Y-m-d', strtotime($output_file->outgoing_at))}}">
                @error('outgoing_at')
                <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="col">
                <label for="outgoing_number" class="form-label">Номер входящего документа</label>
                <input readonly disabled type="text" class="form-control form-control-sm" id="outgoing_number"
                       placeholder="Номер" name="outgoing_number" value="{{$output_file->outgoing_number}}">
                @error('outgoing_number')
                <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
        </div>
        <div class="row row-cols-1">
            <div class="col mt-3">
                <label for="destination" class="form-label">Адресат</label>
                <input readonly disabled type="text" class="form-control form-control-sm" id="destination"
                       placeholder="Корреспондент (автор)" name="destination"
                       value="{{$output_file->destination}}">
                @error('destination')
                <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-2">
            <div class="col mt-3">
                <label for="number_of_source_document" class="form-label">Номер</label>
                <input readonly disabled type="text" class="form-control form-control-sm" id="number_of_source_document"
                       placeholder="Номер" name="number_of_source_document" value="{{$output_file->number_of_source_document}}">
                @error('number_of_source_document')
                <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="col mt-3">
                <label for="date_of_source_document" class="form-label">Дата</label>
                <input readonly disabled type="date" id="date_of_source_document" name="date_of_source_document" class="form-control form-select-sm"
                       placeholder="Дата" value="{{date('Y-m-d', strtotime($output_file->date_of_source_document))}}">
                @error('date_of_source_document')
                <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
        </div>
        <div class="row row-cols-1">
            <div class="col mt-3">
                <label for="document_and_application_sheets" class="form-label">Количество листов документа и приложения
                    (хх+ххх)</label>
                <input readonly disabled type="text" class="form-control form-control-sm"
                       id="document_and_application_sheets" placeholder="хх+ххх" name="document_and_application_sheets"
                       value="{{$output_file->document_and_application_sheets}}">
                @error('document_and_application_sheets')
                <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
        </div>
        <div class="row row-cols-1">
            <div class="col mt-3">
                <label for="file_mark" class="form-label">Отметка о подшивке документа</label>
                <input readonly disabled type="text" class="form-control form-control-sm" id="file_mark"
                       placeholder="Отметка" name="file_mark" value="{{$output_file->file_mark}}">
                @error('file_mark')
                <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
        </div>
        <div class="row pt-3 row-cols-1 row-cols-md-3">
            <div class="col mb-3">
                <button class="btn btn-sm btn-success col-12" onclick="javascript:history.back(); return false;">Назад
                </button>
            </div>
            @can('update', \App\Models\OutgoingFiles\OutgoingFile::class)
                <div class="col mb-3">
                    <a class="btn btn-sm btn-danger col-12" href="{{route('outgoing_files.edit', $output_file)}}">Редактировать</a>
                </div>
            @endcan
        </div>
    </div>
@endsection


