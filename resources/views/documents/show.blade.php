@extends('main')

@section('title', 'Документ')

    @section('header')
        @include('menu')
    @endsection

    @section('content')
    <div class="container pt-3 pb-3 mb-3">
        <div class="row">
            <div class="col">
                <h4 class="d-inline-block">Документ</h4>
            </div>
        </div>
        @include('message')
        <div class="row pt-3 row-cols-1 row-cols-md-2">
            <div class="col mb-3">
                <label for="created_at">Создан</label>
                <input class="form-control form-control-sm" name="created_at" id="created_at" disabled value="{{$document->created_at}}">
            </div>
            <div class="col mb-3">
                <label for="">Ссылка</label><br>
                <a href="{{'/storage/' . $document->path}}" target="_blank">{{$document->name}}</a>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-2">
            <div class="col mb-3">
                <label for="path">Путь</label>
                <input class="form-control form-control-sm" name="path" id="path" disabled value="{{$document->path}}">
            </div>
            <div class="col">
                <label for="name">Название</label>
                <input class="form-control form-control-sm" name="name" id="name" disabled value="{{$document->name}}">
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-2">
            <div class="col">
                <label for="incoming_at" class="form-label">Дата входящего:</label>
                <input readonly disabled type="date" id="incoming_at" name="incoming_at" class="form-control form-select-sm" placeholder="Дата входящего документа" value="{{date('Y-m-d', strtotime($document->incoming_at))}}">
                @error('incoming_at')
                <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="col">
                <label for="incoming_number" class="form-label">Номер входящего документа</label>
                <input readonly disabled type="text" class="form-control form-control-sm" id="incoming_number" placeholder="Номер" name="incoming_number" value="{{$document->incoming_number}}">
                @error('incoming_number')
                <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
        </div>
        <div class="row row-cols-1">
            <div class="col mt-3">
                <label for="incoming_author" class="form-label">Корреспондент (автор)</label>
                <input readonly disabled type="text" class="form-control form-control-sm" id="incoming_author" placeholder="Корреспондент (автор)" name="incoming_author" value="{{$document->incoming_author}}">
                @error('incoming_author')
                <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-2">
            <div class="col mt-3">
                <label for="number" class="form-label">Номер</label>
                <input readonly disabled type="text" class="form-control form-control-sm" id="number" placeholder="Номер" name="number" value="{{$document->number}}">
                @error('number')
                <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="col mt-3">
                <label for="date" class="form-label">Дата</label>
                <input readonly disabled type="date" id="date" name="date" class="form-control form-select-sm" placeholder="Дата" value="{{date('Y-m-d', strtotime($document->date))}}">
                @error('date')
                <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
        </div>
        <div class="row row-cols-1">
            <div class="col mt-3">
                <label for="document_and_application_sheets" class="form-label">Количество листов документа и приложения (хх+ххх)</label>
                <input readonly disabled type="text" class="form-control form-control-sm" id="document_and_application_sheets" placeholder="хх+ххх" name="document_and_application_sheets" value="{{$document->document_and_application_sheets}}">
                @error('document_and_application_sheets')
                <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
        </div>
        <div class="row pt-3 row-cols-1 row-cols-md-2">
            <div class="col mb-3">
                <button class="btn btn-sm btn-success col-12"  onclick="javascript:history.back(); return false;">Назад</button>
            </div>
                <div class="col mb-3">
                    <a class="btn btn-sm btn-danger col-12" href="{{route('documents.edit', $document)}}">Редактировать</a>
                </div>
        </div>
    </div>
    @endsection


