@extends('main')

@section('title', 'Редактирование исходящего документа')

    @section('header')
        @include('menu')
    @endsection

    @section('content')
    <div class="container mb-3 mt-3 card shadow-lg">
        <div class="row">
            <div class="col-lg-2 col-md-12 rounded text-white bg-primary pt-3" style="--bs-bg-opacity: .4">
                <div class="row">
                    <div class="col">
                        <h4 class="d-inline-block">Редактирование исходящего документа</h4>
                    </div>
                </div>
            </div>

            <div class="col pt-3">
                @include('message')
                <form action="{{route('outgoing_files.update', $output_file)}}" method="post">
                    @csrf
                    @method('patch')

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="outgoing_at" class="form-label">Дата исходящего:</label>
                        </div>
                        <div class="col-8">
                            <input type="date" id="outgoing_at" name="outgoing_at" class="form-control form-select-sm" placeholder="Дата исходящего документа" value="{{date('Y-m-d', strtotime($output_file->outgoing_at))}}">
                            @error('outgoing_at')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="outgoing_number" class="form-label">Номер исходящего документа</label>
                        </div>
                        <div class="col-8">
                            <input type="text" class="form-control form-control-sm" id="outgoing_number" placeholder="Номер исходящего документа" name="outgoing_number" value="{{$output_file->outgoing_number}}">
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
                            <input type="text" class="form-control form-control-sm" id="destination" placeholder="Укажите получателя документа" name="destination" value="{{$output_file->destination}}">
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
                            <input type="text" class="form-control form-control-sm" id="number_of_source_document" placeholder="Укажите номер документа, на который отвечаете" name="number_of_source_document" value="{{$output_file->number_of_source_document}}">
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
                            <input type="date" id="date_of_source_document" name="date_of_source_document" class="form-control form-select-sm" placeholder="Укажите дату документа, на который отвечаете" value="{{date('Y-m-d', strtotime($output_file->date_of_source_document))}}">
                            @error('date_of_source_document')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="short_description">Наименование или краткое содержание</label>
                        </div>
                        <div class="col-8">
                            <input placeholder="Укажите тип и наименование документа" class="form-control form-control-sm" name="short_description" id="short_description" value="{{$output_file->short_description}}">
                            @error('short_description')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="path">Место хранения документа</label>
                        </div>
                        <div class="col-8">
                            <input disabled readonly class="form-control form-control-sm" name="path" id="path" value="{{$output_file->path}}">
                            @error('file')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="archive_path">Приложение к документу</label>
                        </div>
                        <div class="col-8">
                            @if(!empty($output_file->archive_path))
                                <input disabled readonly class="form-control form-control-sm" name="archive_path" id="archive_path" value="{{$output_file->archive_path}}">
                            @else
                                <input disabled readonly class="form-control form-control-sm" name="archive_path" id="archive_path" value="Отсутствует">
                            @endif
                                @error('archive_path')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="document_and_application_sheets" class="form-label">Количество листов документа, включая приложение</label>
                        </div>
                        <div class="col-8">
                            <input type="text" class="form-control form-control-sm" id="document_and_application_sheets" placeholder="укажите количество листов" name="document_and_application_sheets" value="{{$output_file->document_and_application_sheets}}">
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
                            <input  type="text" required readonly list="executors_list" class="form-control form-control-sm" id="executor_name" name="executor_name" value="{{$output_file->executor->name}}">
                            @error('executor_name')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>


                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="file_mark" class="form-label">Отметка о подшивке документа</label>
                        </div>
                        <div class="col-8">
                            <input type="text" class="form-control form-control-sm" id="file_mark" placeholder="Документ в дело не подшит" name="file_mark" value="{{$output_file->file_mark}}">
                            @error('file_mark')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-center my-4">
                        <div class="mx-3">
                            <a type="button" style="width:150px" class="btn btn-success btn-sm"  href="{{route('outgoing_files.show', $output_file->id)}}">Назад</a>
                        </div>
                        <div class="mx-3">
                            <button type="submit" style="width:150px" class="btn btn-warning btn-sm">Сохранить</button>
                        </div>
                </form>
                        <form action="{{route('outgoing_files.destroy', $output_file)}}" method="post">
                            @csrf
                            @method('delete')
                            <div class="mx-3">
                                <button type="submit" style="width:150px" class="btn btn-danger btn-sm">Удалить</button>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
    @endsection




