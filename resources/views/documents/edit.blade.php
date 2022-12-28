@extends('main')

@section('title', 'Редактирование документа')

    @section('header')
        @include('menu')
    @endsection

    @section('content')
    <div class="container pt-3">
        @include('message')
        <form action="{{route('documents.update', $document)}}" method="post">
            @csrf
            @method('patch')
            <div class="row">
                <div class="col">
                    <h5>Редактирование документа</h5>
                </div>
            </div>
            <div class="row row-cols-1">
                <div class="col mt-3">
                    <label for="path">Путь</label>
                    <input disabled readonly class="form-control form-control-sm" name="path" id="path" value="{{$document->path}}">
                    @error('file')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1">
                <div class="col mt-3">
                    <label for="name">Название документа</label>
                    <input class="form-control form-control-sm" name="name" id="name" value="{{$document->name}}">
                    @error('name')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>

            <div class="row row-cols-1 row-cols-md-2 mt-2">
                <div class="col mt-3">
                    <a type="button" class="btn btn-success btn-sm col-12"  href="{{route('documents.show', $document->id)}}">Назад</a>
                </div>
                <div class="col mt-3">
                    <button type="submit" class="btn btn-warning btn-sm col-12">Сохранить</button>
                </div>
            </div>
        </form>
        <form action="{{route('documents.destroy', $document)}}" method="post">
            @csrf
            @method('delete')
        <div class="row mb-4 mt-3">
            <div class="col">
                <button type="submit" class="btn btn-danger btn-sm col-12">Удалить</button>
            </div>
        </div>
        </form>
    </div>
    @endsection




