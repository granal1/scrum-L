@extends('main')

@section('title', 'Создание исходящего документа')

    @section('header')
        @include('menu')
    @endsection

    @section('content')
    <div class="container mt-4 card shadow-lg mb-4">
        <div class="row row-cols-1 row-cols-md-2">
            <div class="col">
                <h5 class="mt-3">Новый исходящий документ</h5>
            </div>
        </div>
        @include('message')
        <form action="{{route('output_files.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row row-cols-1 row-cols-md-2">
                <div class="col mt-3">
                    <label for="incoming_at" class="form-label">Дата исходящего:</label>
                    <input type="date" id="incoming_at" name="incoming_at" class="form-control form-select-sm" value="{{date('Y-m-d')}}">
                    @error('incoming_at')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="col mt-3">
                    <label for="incoming_number" class="form-label">Номер исходящего документа</label>
                    <input type="text" class="form-control form-control-sm" id="incoming_number" placeholder="Номер" name="incoming_number">
                    @error('incoming_number')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1">
                <div class="col mt-3">
                    <label for="document_file" class="form-label">Загрузить документ</label>
                    <input accept=".pdf" required class="form-control form-control-sm" name="file" id="document_file" type="file">
                    @error('file')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1">
                <div class="col mt-3">
                    <label for="short_description">Наименование или краткое содержание</label>
                    <input placeholder="Наименование" class="form-control form-control-sm" name="short_description" id="document_name">
                    @error('short_description')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>

            <div class="row row-cols-1">
                <div class="col mt-3">
                    <label for="incoming_author" class="form-label">Адресат</label>
                    <input type="text" class="form-control form-control-sm" id="incoming_author" placeholder="Корреспондент (автор)" name="incoming_author">
                    @error('incoming_author')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-2">
                <div class="col mt-3">
                    <label for="number" class="form-label">Номер</label>
                    <input type="text" class="form-control form-control-sm" id="number" placeholder="Номер" name="number">
                    @error('number')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="col mt-3">
                    <label for="date" class="form-label">Дата</label>
                    <input type="date" id="date" name="date" class="form-control form-select-sm" placeholder="Дата">
                    @error('date')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1">
                <div class="col mt-3">
                    <label for="document_and_application_sheets" class="form-label">Количество листов документа, включая приложение</label>
                    <input type="text" class="form-control form-control-sm" id="document_and_application_sheets" placeholder="укажите количество листов" name="document_and_application_sheets">
                    @error('document_and_application_sheets')
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
        <script src="{{asset('assets/output_files/create.js')}}"></script>
    @endsection



