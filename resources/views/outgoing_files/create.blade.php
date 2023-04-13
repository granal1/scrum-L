@extends('main')

@section('title', 'Создание исходящего документа')

    @section('header')
        @include('menu')
    @endsection

    @section('content')
    <div class="container mb-3 mt-3 card shadow-lg">
        <div class="row">
            <div class="col-lg-2 col-md-12 rounded text-white bg-primary pt-3" style="--bs-bg-opacity: .4">
                <div class="row">
                    <div class="col">
                        <h4 class="d-inline-block">Новый исходящий документ</h4>
                    </div>
                </div>
            </div>

            <div class="col pt-3">
                @include('message')
                <form action="{{route('outgoing_files.store')}}" method="post" enctype="multipart/form-data">
                    @csrf

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="outgoing_at" class="form-label">Дата исходящего<span class="text-danger"></span></label>
                        </div>
                        <div class="col-8">
                            <input type="date" id="outgoing_at" name="outgoing_at" class="form-control form-select-sm" value="{{date('Y-m-d')}}">
                            @error('outgoing_at')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="outgoing_number" class="form-label">Номер исходящего документа<span class="text-danger"></span></label>
                        </div>
                        <div class="col-8">
                            <input type="text" class="form-control form-control-sm" id="outgoing_number" placeholder="{{'Предыдущий номер: ' . $last_document_number}}" name="outgoing_number">
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
                            <input type="text" class="form-control form-control-sm" id="destination" placeholder="Укажите получателя документа" name="destination">
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
                            <input type="text" class="form-control form-control-sm" id="number_of_source_document" placeholder="Укажите номер документа, на который отвечаете" name="number_of_source_document">
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
                            <input type="date" id="date_of_source_document" name="date_of_source_document" class="form-control form-select-sm" placeholder="Укажите дату документа, на который отвечаете">
                            @error('date_of_source_document')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="short_description">Наименование или краткое содержание<span class="text-danger"></span></label>
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
                            <label for="document_file" class="form-label">Загрузить документ в формате pdf<span class="text-danger"></span></label>
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
                            <label for="document_and_application_sheets" class="form-label">Количество листов документа, включая приложение</label>
                        </div>
                        <div class="col-8">
                            <input type="text" class="form-control form-control-sm" id="document_and_application_sheets" placeholder="Укажите количество листов" name="document_and_application_sheets">
                            @error('document_and_application_sheets')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="executor_name" class="form-label">Исполнитель<span class="text-danger"></span></label>
                        </div>
                        <div class="col-8">
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
                    </div>

                    <div class="d-flex justify-content-center my-4">
                        <div class="mx-3">
                            <button type="button" class="btn btn-primary btn-sm" style="width:100px" onclick="javascript:history.back(); return false;">Назад</button>
                        </div>
                        <div class="mx-3">
                            <button type="submit" class="btn btn-success btn-sm" style="width:100px">Сохранить</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>
        <script src="{{asset('assets/outgoing_files/create.js')}}"></script>
    @endsection



