@extends('main')

@section('title', 'Редактирование исходящего документа')

    @section('header')
        @include('menu')
    @endsection

    @section('content')
    <div class="container pt-3 mt-3 mb-3 card shadow-lg">
        @include('message')
        <form action="{{route('output_files.update', $output_file)}}" method="post">
            @csrf
            @method('patch')
            <div class="row">
                <div class="col">
                    <h5>Редактирование исходящего документа</h5>
                </div>
            </div>
            <div class="row row-cols-1">
                <div class="col mt-3">
                    <label for="path">Путь</label>
                    <input disabled readonly class="form-control form-control-sm" name="path" id="path" value="{{$output_file->path}}">
                    @error('file')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1">
                <div class="col mt-3">
                    <label for="short_description">Название документа</label>
                    <input class="form-control form-control-sm" name="short_description" id="short_description" value="{{$output_file->short_description}}">
                    @error('short_description')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-2">
                <div class="col mt-3">
                    <label for="incoming_at" class="form-label">Дата исходящего:</label>
                    <input type="date" id="incoming_at" name="incoming_at" class="form-control form-select-sm" placeholder="Дата входящего документа" value="{{date('Y-m-d', strtotime($output_file->incoming_at))}}">
                    @error('incoming_at')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="col mt-3">
                    <label for="incoming_number" class="form-label">Номер исходящего документа</label>
                    <input type="text" class="form-control form-control-sm" id="incoming_number" placeholder="Номер" name="incoming_number" value="{{$output_file->incoming_number}}">
                    @error('incoming_number')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1">
                <div class="col mt-3">
                    <label for="incoming_author" class="form-label">Адресат</label>
                    <input type="text" class="form-control form-control-sm" id="incoming_author" placeholder="Корреспондент (автор)" name="incoming_author" value="{{$output_file->incoming_author}}">
                    @error('incoming_author')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-2">
                <div class="col mt-3">
                    <label for="number" class="form-label">Номер</label>
                    <input type="text" class="form-control form-control-sm" id="number" placeholder="Номер" name="number" value="{{$output_file->number}}">
                    @error('number')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="col mt-3">
                    <label for="date" class="form-label">Дата</label>
                    <input type="date" id="date" name="date" class="form-control form-select-sm" placeholder="Дата" value="{{date('Y-m-d', strtotime($output_file->date))}}">
                    @error('date')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1">
                <div class="col mt-3">
                    <label for="document_and_application_sheets" class="form-label">Количество листов документа, включая приложение</label>
                    <input type="text" class="form-control form-control-sm" id="document_and_application_sheets" placeholder="укажите количество листов" name="document_and_application_sheets" value="{{$output_file->document_and_application_sheets}}">
                    @error('document_and_application_sheets')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1">
                <div class="col mt-3">
                    <label for="file_mark" class="form-label">Отметка о подшивке документа</label>
                    <input type="text" class="form-control form-control-sm" id="file_mark" placeholder="Отметка" name="file_mark" value="{{$output_file->file_mark}}">
                    @error('file_mark')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-2 mt-2">
                <div class="col mt-3">
                    <a type="button" class="btn btn-success btn-sm col-12"  href="{{route('output_files.show', $output_file->id)}}">Назад</a>
                </div>
                <div class="col mt-3">
                    <button type="submit" class="btn btn-warning btn-sm col-12">Сохранить</button>
                </div>
            </div>
        </form>
        <form action="{{route('output_files.destroy', $output_file)}}" method="post">
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




