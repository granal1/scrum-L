@extends('main')

@section('title', 'Редактирование документа')

    @section('header')
        @include('menu')
    @endsection

    @section('content')
    <div class="container pt-3 mt-3 mb-3 card shadow-lg">
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
                    <label for="short_description">Название документа</label>
                    <input class="form-control form-control-sm" name="short_description" id="short_description" value="{{$document->short_description}}">
                    @error('short_description')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-2">
                <div class="col mt-3">
                    <label for="incoming_at" class="form-label">Дата входящего:</label>
                    <input type="date" id="incoming_at" name="incoming_at" class="form-control form-select-sm" placeholder="Дата входящего документа" value="{{date('Y-m-d', strtotime($document->incoming_at))}}">
                    @error('incoming_at')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="col mt-3">
                    <label for="incoming_number" class="form-label">Номер входящего документа</label>
                    <input type="text" class="form-control form-control-sm" id="incoming_number" placeholder="Номер" name="incoming_number" value="{{$document->incoming_number}}">
                    @error('incoming_number')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1">
                <div class="col mt-3">
                    <label for="incoming_author" class="form-label">Корреспондент (автор)</label>
                    <input type="text" class="form-control form-control-sm" id="incoming_author" placeholder="Корреспондент (автор)" name="incoming_author" value="{{$document->incoming_author}}">
                    @error('incoming_author')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-2">
                <div class="col mt-3">
                    <label for="number" class="form-label">Номер</label>
                    <input type="text" class="form-control form-control-sm" id="number" placeholder="Номер" name="number" value="{{$document->number}}">
                    @error('number')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="col mt-3">
                    <label for="date" class="form-label">Дата</label>
                    <input type="date" id="date" name="date" class="form-control form-select-sm" placeholder="Дата" value="{{date('Y-m-d', strtotime($document->date))}}">
                    @error('date')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1">
                <div class="col mt-3">
                    <label for="document_and_application_sheets" class="form-label">Количество листов документа и приложения (хх+ххх)</label>
                    <input type="text" class="form-control form-control-sm" id="document_and_application_sheets" placeholder="хх+ххх" name="document_and_application_sheets" value="{{$document->document_and_application_sheets}}">
                    @error('document_and_application_sheets')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1">
                <div class="col mt-3">
                    <label for="task_description">Описание</label>
                    <textarea placeholder="Описание задачи" class="form-control form-control-sm" name="task_description" id="task_description" rows="2">{{$document->task_description}}</textarea>
                    @error('task_description')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-2">
                <div class="col mt-3">
                    <label for="executor" class="form-label">Исполнитель</label>
                    <input type="text" class="form-control form-control-sm" id="executor" placeholder="Исполнитель" name="executor" value="{{$document->executor}}">
                    @error('executor')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="col mt-3">
                    <label for="deadline_at" class="form-label">Срок выполнения по плану:</label>
                    <input type="date" id="deadline_at" name="deadline_at" class="form-control form-select-sm" placeholder="Срок выполнения задачи" value="{{$document->deadline_at ? date('Y-m-d', strtotime($document->deadline_at)) : null}}">
                    @error('deadline_at')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1">
                <div class="col mt-3">
                    <label for="executed_result">Результат выполнения</label>
                    <textarea placeholder="Описание задачи" class="form-control form-control-sm" name="executed_result" id="executed_result" rows="2">{{$document->executed_result}}</textarea>
                    @error('executed_result')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1">
                <div class="col mt-3">
                    <label for="executed_at">Срок выполнения по факту:</label>
                    <input type="date" id="executed_at" name="executed_at" class="form-control form-select-sm" value="{{$document->executed_at ? date('Y-m-d', strtotime($document->executed_at)) : null}}">
                    @error('executed_at')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1">
                <div class="col mt-3">
                    <label for="file_mark" class="form-label">Отметка о подшивке документа</label>
                    <input type="text" class="form-control form-control-sm" id="file_mark" placeholder="Отметка" name="file_mark" value="{{$document->file_mark}}">
                    @error('file_mark')
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




