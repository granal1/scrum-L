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
        <div class="row pt-3 row-cols-1 row-cols-md-2">
            <div class="col mb-3">
                <button class="btn btn-sm btn-success col-12"  onclick="javascript:history.back(); return false;>Назад</button>
            </div>
                <div class="col mb-3">
                    <a class="btn btn-sm btn-danger col-12" href="{{route('documents.edit', $document)}}">Редактировать</a>
                </div>
        </div>
    </div>
    @endsection


