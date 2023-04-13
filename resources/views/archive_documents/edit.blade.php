@extends('main')

@section('title', 'Редактирование документа')

    @section('header')
        @include('menu')
    @endsection

    @section('content')
    <div class="container mb-3 mt-3 card shadow-lg">
        <div class="row">
            <div class="col-lg-2 col-md-12 rounded text-white bg-primary pt-3" style="--bs-bg-opacity: .4">
                <div class="row">
                    <div class="col">
                        <h4 class="d-inline-block">Редактирование документа</h4>
                    </div>
                </div>
            </div>

            <div class="col pt-3">
                @include('message')
                <form action="{{route('archive_documents.update', $archive_document['id'])}}" method="post">
                    @csrf
                    @method('patch')

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="incoming_at" class="form-label">Дата поступления</label>
                        </div>
                        <div class="col-8">
                            <input type="date" id="incoming_at" name="incoming_at" class="form-control form-select-sm" placeholder="Дата входящего документа" value="{{date('Y-m-d', strtotime($archive_document['incoming_at']))}}">
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
                            <input type="text" class="form-control form-control-sm" id="incoming_number" placeholder="Номер" name="incoming_number" value="{{$archive_document['incoming_number']}}">
                            @error('incoming_number')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="incoming_author" class="form-label">Корреспондент (автор)</label>
                        </div>
                        <div class="col-8">
                            <input type="text" class="form-control form-control-sm" id="incoming_author" placeholder="Корреспондент (автор)" name="incoming_author" value="{{$archive_document['incoming_author']}}">
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
                            <input type="text" class="form-control form-control-sm" id="number" placeholder="Номер" name="number" value="{{$archive_document['number']}}">
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
                            <input type="date" id="date" name="date" class="form-control form-select-sm" placeholder="Дата" value="{{date('Y-m-d', strtotime($archive_document['date']))}}">
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
                            <input class="form-control form-control-sm" name="short_description" id="short_description" value="{{$archive_document['short_description']}}">
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
                            <input disabled readonly class="form-control form-control-sm" name="path" id="path" value="{{$archive_document['path']}}">
                            @error('file')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="path">Приложение к документу</label>
                        </div>
                        <div class="col-8">
                            @if(!empty($archive_document['archive_path']))
                                    <input
                                        class="form-control form-control-sm" name="archive_path" id="archive_path" disabled
                                        value="{{$archive_document['archive_path']}}">
                            @else
                                <input
                                    class="form-control form-control-sm" name="archive_path" id="archive_path" disabled
                                    value="Отсутствует">
                            @endif
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="document_and_application_sheets" class="form-label">Количество листов документа, включая приложение</label>
                        </div>
                        <div class="col-8">
                            <input type="text" class="form-control form-control-sm" id="document_and_application_sheets" placeholder="укажите количество листов" name="document_and_application_sheets" value="{{$archive_document['document_and_application_sheets']}}">
                            @error('document_and_application_sheets')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="task_description">Резолюция руководителя</label>
                        </div>
                        <div class="col-8">
                            <textarea disabled readonly placeholder="Резолюция руководителя отсутствует" class="form-control form-control-sm" name="task_description" id="task_description" rows="1">{{isset($archive_document->tasks[0]) ? $archive_document->tasks[0]->description : null}}</textarea>
                            @error('task_description')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="executor" class="form-label">Исполнитель документа</label>
                        </div>
                        <div class="col-8">
                            <input disabled readonly type="text" class="form-control form-control-sm" id="executor" placeholder="Исполнитель" name="executor" value="{{isset($archive_document->tasks[0]) ? $archive_document->tasks[0]->responsible->name : null}}">
                            @error('executor')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="deadline_at" class="form-label">Срок выполнения по плану</label>
                        </div>
                        <div class="col-8">
                            <input disabled readonly type="date" id="deadline_at" name="deadline_at" class="form-control form-select-sm" placeholder="Срок выполнения задачи" value="{{isset($archive_document->tasks[0]) ? date('Y-m-d', strtotime($archive_document->tasks[0]->deadline_at)) : null}}">
                            @error('deadline_at')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="executed_result">Результат исполнения</label>
                        </div>
                        <div class="col-8">
                            <textarea disabled readonly placeholder="Сведений об исполнении нет" class="form-control form-control-sm" name="executed_result" id="executed_result" rows="1">{{isset($archive_document->tasks[0]) ? $archive_document->tasks[0]->executed_at : null}}</textarea>
                            @error('executed_result')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="executed_at">Дата исполнения</label>
                        </div>
                        <div class="col-8">
                            <input readonly disabled type="date" id="executed_at" name="executed_at" class="form-control form-select-sm" value="{{isset($archive_document->tasks[0]) ? date('Y-m-d', strtotime($archive_document->tasks[0]->created_at)) : null}}">
                            @error('executed_at')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="file_mark" class="form-label">Отметка о подшивке документа</label>
                        </div>
                        <div class="col-8">
                            <input type="text" class="form-control form-control-sm" id="file_mark" placeholder="Документ в дело не подшит" name="file_mark" value="{{$archive_document['file_mark']}}">
                            @error('file_mark')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-center my-4">
                        <div class="mx-3">
                            <a type="button" class="btn btn-primary btn-sm" style="width:100px" href="{{route('archive_documents.show', $archive_document['id'])}}">Назад</a>
                        </div>
                        <div class="mx-3">
                            <button type="submit" class="btn btn-success btn-sm" style="width:100px">Сохранить</button>
                        </div>

                </form>
                        <form action="{{route('archive_documents.destroy', $archive_document['id'])}}" method="post">
                            @csrf
                            @method('delete')
                            <div class="mx-3">
                                <button type="submit" style="width:100px" class="btn btn-danger btn-sm">Удалить</button>
                            </div>
                        </form>
                    </div>
            </div>
        </div>
    </div>
    <script src="{{asset('assets/documents/adaptTextarea.js')}}"></script>
    <script>
        adaptTextarea('task_description');
        adaptTextarea('executed_result');
    </script>
    @endsection




