@extends('main')

@section('title', 'Создание документа')

    @section('header')
        @include('menu')
    @endsection

    @section('content')
    <div class="container mt-4 card shadow-lg mb-4">
        <div class="row row-cols-1 row-cols-md-2">
            <div class="col">
                <h5 class="mt-3">Новый документ</h5>
            </div>
        </div>
        @include('message')
        <form action="{{route('documents.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row row-cols-1">
                <div class="col mt-3">
                    <input accept=".pdf" required class="form-control form-control-sm" name="file" id="document_file" type="file">
                    @error('file')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1">
                <div class="col mt-3">
                    <label for="name">Название</label>
                    <input placeholder="Название" class="form-control form-control-sm" name="name" id="document_name">
                    @error('name')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row mt-4 mb-4">
                <div class="col">
                    <button type="button" class="btn btn-success btn-sm col-12"  onclick="javascript:history.back(); return false;">Назад</button>
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-danger btn-sm col-12">Сохранить</button>
                </div>
            </div>
        </form>
    </div>
</div>
    <script src="{{ asset('assets/documents/create.js') }}"></script>
    @endsection



