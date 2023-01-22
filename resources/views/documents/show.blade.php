@extends('main')

@section('title', 'Документ')

    @section('header')
        @include('menu')
    @endsection

    @section('content')
    <div class="container pt-3 pb-3 mb-3 mt-3 card shadow-lg">
        <div class="row">
            <div class="col">
                <h4 class="d-inline-block">Документ</h4>
            </div>
        </div>
        @include('message')
        <div class="row pt-3 row-cols-1 row-cols-md-2">
            <div class="col mb-3">
                <label for="created_at">Создан</label>
                <input class="form-control form-control-sm" name="created_at" id="created_at" disabled value="{{$document->created_at}}">
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-2">
            <div class="col mb-3">
                <label for="path">Путь</label>
                <a href="{{'/storage/' . $document->path}}" target="_blank"><input class="form-control form-control-sm" name="path" id="path" disabled value="{{$document->path}}" style="cursor: pointer;"></a>
            </div>
            <div class="col">
                <label for="name">Название</label>
                <input class="form-control form-control-sm" name="name" id="name" disabled value="{{$document->short_description}}">
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-2">
            <div class="col">
                <label for="incoming_at" class="form-label">Дата входящего:</label>
                <input readonly disabled type="date" id="incoming_at" name="incoming_at" class="form-control form-select-sm" placeholder="Дата входящего документа" value="{{date('Y-m-d', strtotime($document->incoming_at))}}">
                @error('incoming_at')
                <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="col">
                <label for="incoming_number" class="form-label">Номер входящего документа</label>
                <input readonly disabled type="text" class="form-control form-control-sm" id="incoming_number" placeholder="Номер" name="incoming_number" value="{{$document->incoming_number}}">
                @error('incoming_number')
                <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
        </div>
        <div class="row row-cols-1">
            <div class="col mt-3">
                <label for="incoming_author" class="form-label">Корреспондент (автор)</label>
                <input readonly disabled type="text" class="form-control form-control-sm" id="incoming_author" placeholder="Корреспондент (автор)" name="incoming_author" value="{{$document->incoming_author}}">
                @error('incoming_author')
                <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-2">
            <div class="col mt-3">
                <label for="number" class="form-label">Номер</label>
                <input readonly disabled type="text" class="form-control form-control-sm" id="number" placeholder="Номер" name="number" value="{{$document->number}}">
                @error('number')
                <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="col mt-3">
                <label for="date" class="form-label">Дата</label>
                <input readonly disabled type="date" id="date" name="date" class="form-control form-select-sm" placeholder="Дата" value="{{date('Y-m-d', strtotime($document->date))}}">
                @error('date')
                <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
        </div>
        <div class="row row-cols-1">
            <div class="col mt-3">
                <label for="document_and_application_sheets" class="form-label">Количество листов документа и приложения (хх+ххх)</label>
                <input readonly disabled type="text" class="form-control form-control-sm" id="document_and_application_sheets" placeholder="хх+ххх" name="document_and_application_sheets" value="{{$document->document_and_application_sheets}}">
                @error('document_and_application_sheets')
                <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
        </div>
        <div class="row row-cols-1">
            <div class="col mt-3">
                <label for="task_description">Описание</label>
                <textarea readonly disabled placeholder="Описание задачи" class="form-control form-control-sm" name="task_description" id="task_description" rows="2">{{isset($document->tasks[0]) ? $document->tasks[0]->description : null}}</textarea>
                @error('task_description')
                <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
        </div>
        <div class="row row-cols-1 mt-3">
            <div class="col">
                <label for="content" class="form-label">Содержание</label>
                @if(!empty($document->content))
                    <textarea rows="10" class="form-control form-control-sm" name="content" id="content" disabled>{{$document->content}}</textarea>
                @else
                    <input
                        class="form-control form-control-sm" name="content" id="content" disabled
                        value="Отсутствует">
                @endif
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-2">
            <div class="col mt-3">
                <label for="executor" class="form-label">Исполнитель</label>
                <input readonly disabled type="text" class="form-control form-control-sm" id="executor" placeholder="Исполнитель" name="executor" value="{{isset($document->tasks[0]) ? $document->tasks[0]->responsible->name : null}}">
                @error('executor')
                <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
            <div class="col mt-3">
                <label for="deadline_at" class="form-label">Срок выполнения по плану:</label>
                <input readonly disabled type="datetime-local" id="deadline_at" name="deadline_at" class="form-control form-select-sm" placeholder="Срок выполнения задачи" value="{{isset($document->tasks[0]) ? $document->tasks[0]->deadline_at : null}}">
                @error('deadline_at')
                <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
        </div>
        <div class="row row-cols-1">
            <div class="col mt-3">
                <label for="executed_result">Результат выполнения</label>
                <textarea readonly disabled placeholder="Описание задачи" class="form-control form-control-sm" name="executed_result" id="executed_result" rows="2">{{isset($document->tasks[0]) ? $document->tasks[0]->executed_at : null}}</textarea>
                @error('executed_result')
                <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
        </div>
        <div class="row row-cols-1">
            <div class="col mt-3">
                <label for="executed_at">Срок выполнения по факту:</label>
                <input readonly disabled type="date" id="executed_at" name="executed_at" class="form-control form-select-sm" value="{{isset($document->tasks[0]) ? date('Y-m-d', strtotime($document->tasks[0]->created_at)) : null}}">
                @error('executed_at')
                <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
        </div>
        <div class="row row-cols-1">
            <div class="col mt-3">
                <label for="file_mark" class="form-label">Отметка о подшивке документа</label>
                <input readonly disabled type="text" class="form-control form-control-sm" id="file_mark" placeholder="Отметка" name="file_mark" value="{{$document->file_mark}}">
                @error('file_mark')
                <div class="text-danger">{{$message}}</div>
                @enderror
            </div>
        </div>
        <div class="row pt-3 row-cols-1 row-cols-md-3">
            <div class="col mb-3">
                <button class="btn btn-sm btn-success col-12"  onclick="javascript:history.back(); return false;">Назад</button>
            </div>
            <div class="col mb-3">
                <a class="btn btn-sm btn-warning col-12 {{isset($document->tasks[0]) ? 'disabled' : ''}}" href="{{route('documents.create_task', $document)}}">Создать задачу</a>
            </div>
            @can('update', \App\Models\Documents\Document::class)
                <div class="col mb-3">
                    <a class="btn btn-sm btn-danger col-12" href="{{route('documents.edit', $document)}}">Редактировать</a>
                </div>
            @endcan
        </div>
    </div>
    @endsection


