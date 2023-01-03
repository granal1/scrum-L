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
                    <label for="incoming_at">Дата входящего:</label>
                    <input type="datetime-local" id="incoming_at" name="incoming_at" class="form-control form-select-sm" placeholder="Дата входящего документа">
                    @error('incoming_at')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1">
                <div class="col mt-3">
                    <label for="incoming_number" class="form-label">Номер входящего документа</label>
                    <input type="text" class="form-control form-control-sm" id="incoming_number" placeholder="Номер" name="incoming_number">
                    @error('incoming_number')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1">
                <div class="col mt-3">
                    <label for="incoming_author" class="form-label">Корреспондент (автор)</label>
                    <input type="text" class="form-control form-control-sm" id="incoming_author" placeholder="Корреспондент (автор)" name="incoming_author">
                    @error('incoming_author')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1">
                <div class="col mt-3">
                    <label for="number" class="form-label">Номер</label>
                    <input type="text" class="form-control form-control-sm" id="number" placeholder="Номер" name="number">
                    @error('number')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1">
                <div class="col mt-3">
                    <label for="date">Дата</label>
                    <input type="datetime-local" id="date" name="date" class="form-control form-select-sm" placeholder="Дата">
                    @error('date')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1">
                <div class="col mt-3">
                    <label for="short_description" class="form-label">Краткое описание</label>
                    <input type="text" class="form-control form-control-sm" id="short_description" placeholder="Краткое описание" name="short_description">
                    @error('short_description')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1">
                <div class="col mt-3">
                    <label for="document_and_application_sheets" class="form-label">Количество листов документа и приложения (хх+ххх)</label>
                    <input type="text" class="form-control form-control-sm" id="document_and_application_sheets" placeholder="хх+ххх" name="document_and_application_sheets">
                    @error('document_and_application_sheets')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1">
                <div class="col mt-3">
                    <label for="task_description">Описание</label>
                    <textarea placeholder="Описание задачи" class="form-control form-control-sm" name="task_description" id="task_description" rows="2"></textarea>
                    @error('task_description')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1">
                <div class="col mt-3">
                    <label for="executor" class="form-label">Исполнитель</label>
                    <input type="text" class="form-control form-control-sm" id="executor" placeholder="Исполнитель" name="executor">
                    @error('executor')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1">
                <div class="col mt-3">
                    <label for="deadline_at">Срок выполнения:</label>
                    <input type="datetime-local" id="deadline_at" name="deadline_at" class="form-control form-select-sm" placeholder="Срок выполнения задачи">
                    @error('deadline_at')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1">
                <div class="col mt-3">
                    <label for="executed_result">Результат выполнения</label>
                    <textarea placeholder="Описание задачи" class="form-control form-control-sm" name="executed_result" id="executed_result" rows="2"></textarea>
                    @error('executed_result')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1">
                <div class="col mt-3">
                    <label for="executed_at">Срок выполнения:</label>
                    <input type="datetime-local" id="executed_at" name="executed_at" class="form-control form-select-sm">
                    @error('executed_at')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1">
                <div class="col mt-3">
                    <label for="file_mark" class="form-label">Отметка о подшивке документа</label>
                    <input type="text" class="form-control form-control-sm" id="file_mark" placeholder="Отметка" name="file_mark">
                    @error('file_mark')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
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



