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
        <form action="{{route('outgoing_files.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row row-cols-1 row-cols-md-2">
                <div class="col mt-3">
                    <label for="date_of_source_document" class="form-label">Дата документа входящего</label>
                    <input type="date" id="date_of_source_document" name="date_of_source_document" class="form-control form-select-sm" placeholder="Дата">
                    @error('date_of_source_document')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="col mt-3">
                    <label for="number_of_source_document" class="form-label">Номер документа входящего</label>
                    <input type="text" class="form-control form-control-sm" id="number_of_source_document" placeholder="Номер" name="number_of_source_document">
                    @error('number_of_source_document')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-2">
                <div class="col mt-3">
                    <label for="outgoing_at" class="form-label">Дата исходящего:<span class="text-danger"><b>*</b></span></label>
                    <input type="date" id="outgoing_at" name="outgoing_at" class="form-control form-select-sm" value="{{date('Y-m-d')}}">
                    @error('outgoing_at')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="col mt-3">
                    <label for="outgoing_number" class="form-label">Номер исходящего документа<span class="text-danger"><b>*</b></span></label>
                    <input type="text" class="form-control form-control-sm" id="outgoing_number" placeholder="Номер" name="outgoing_number">
                    @error('outgoing_number')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1">
                <div class="col mt-3">
                    <label for="document_file" class="form-label">Загрузить PDF документ<span class="text-danger"><b>*</b></span></label>
                    <input accept=".pdf" required class="form-control form-control-sm" name="file" id="document_file" type="file">
                    @error('file')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1">
                <div class="col mt-3">
                    <label for="archive_file" class="form-label">Загрузить архив приложение к документу</label>
                    <input accept=".zip, .rar" class="form-control form-control-sm" name="archive_file" id="archive_file" type="file">
                    @error('archive_file')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1">
                <div class="col mt-3">
                    <label for="short_description">Наименование или краткое содержание<span class="text-danger"><b>*</b></span></label>
                    <input placeholder="Наименование" class="form-control form-control-sm" name="short_description" id="document_name">
                    @error('short_description')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1">
                <div class="col mt-3">
                    <label for="executor_name" class="form-label">Исполнитель задачи<span class="text-danger"><b>*</b></span></label>
                    <input  required list="executors_list" class="form-control form-control-sm" id="executor_name" name="executor_name">
                    <datalist id="executors_list">
                        @forelse($users as $user)
                            <option value="{{$user->name}}"></option>
                        @empty
                            <option value="Нет исполнителей"></option>
                        @endforelse
                    </datalist>
                    @error('executor_name')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="col mt-3">
                    <label for="destination" class="form-label">Адресат</label>
                    <input type="text" class="form-control form-control-sm" id="destination" placeholder="Адресат" name="destination">
                    @error('destination')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1">
                <div class="col mt-3">
                    <label for="document_and_application_sheets" class="form-label">Количество листов исходящего документа, включая приложение</label>
                    <input type="text" class="form-control form-control-sm" id="document_and_application_sheets" placeholder="Укажите количество листов" name="document_and_application_sheets">
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
        <script src="{{asset('assets/outgoing_files/create.js')}}"></script>
    @endsection



