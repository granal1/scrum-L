@extends('main')

@section('title', 'Создание документа')

    @section('header')
        @include('menu')
    @endsection

    @section('content')
    <div class="container mb-3 mt-3 card shadow-lg">
        <div class="row">
            <div class="col-lg-2 col-md-12 rounded text-white bg-primary pt-3" style="--bs-bg-opacity: .4">
                <div class="row">
                    <div class="col">
                        <h4 class="d-inline-block">Новый документ</h4>
                    </div>
                </div>
            </div>

            <div class="col pt-3">
                @include('message')
                <form action="{{route('documents.store')}}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="incoming_at" class="form-label">Дата поступления</label>
                        </div>
                        <div class="col-8">
                            <input type="date" id="incoming_at" name="incoming_at" class="form-control form-select-sm" value="{{date('Y-m-d')}}">
                            @error('incoming_at')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="incoming_number" class="form-label">Регистрационный номер документа</label>
                        </div>
                        <div class="col-8">
                            <input type="text" class="form-control form-control-sm" id="incoming_number" placeholder="{{'Предыдущий номер: ' . $last_document_number}}" name="incoming_number">
                            @error('incoming_number')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="document_file" class="form-label">Загрузить документ в формате pdf</label>
                        </div>
                        <div class="col-8">
                            <input accept=".pdf" required class="form-control form-control-sm" name="file" id="document_file" type="file">
                            @error('file')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="archive_file" class="form-label">Загрузить zip-архив с приложениями к документу</label>
                        </div>
                        <div class="col-8">
                            <input accept=".zip" class="form-control form-control-sm" name="archive_file" id="archive_file" type="file">
                            @error('archive_file')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="incoming_author" class="form-label">Корреспондент (автор)</label>
                        </div>
                        <div class="col-8">
                            <input type="text" class="form-control form-control-sm" id="incoming_author" placeholder="От кого поступил документ" name="incoming_author">
                            @error('incoming_author')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="number" class="form-label">Номер документа</label>
                        </div>
                        <div class="col-8">
                            <input type="text" class="form-control form-control-sm" id="number" placeholder="Номер поступившего документа" name="number">
                            @error('number')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="date" class="form-label">Дата документа</label>
                        </div>
                        <div class="col-8">
                            <input type="date" id="date" name="date" class="form-control form-select-sm" placeholder="Дата">
                            @error('date')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="short_description">Наименование или краткое содержание</label>
                        </div>
                        <div class="col-8">
                            <input placeholder="Укажите тип и наименование документа" class="form-control form-control-sm" name="short_description" id="document_name">
                            @error('short_description')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="document_and_application_sheets" class="form-label">Количество листов документа, включая приложение</label>
                        </div>
                        <div class="col-8">
                            <input type="text" class="form-control form-control-sm" id="document_and_application_sheets" placeholder="укажите количество листов" name="document_and_application_sheets">
                            @error('document_and_application_sheets')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-center my-4">
                        <div class="mx-3">
                            <button type="button" style="width:100px" class="btn btn-success btn-sm"  onclick="javascript:history.back(); return false;">Назад</button>
                        </div>
                        <div class="mx-3">
                            <button type="submit" style="width:100px" class="btn btn-danger btn-sm">Сохранить</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
        <script src="{{asset('assets/documents/create.js')}}"></script>
    @endsection



