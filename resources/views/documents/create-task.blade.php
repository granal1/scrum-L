@extends('main')

@section('title', 'Создание задачи')

    @section('header')
        @include('menu')
    @endsection

    @section('content')
    <div class="container pt-3 mt-3 mb-3 card shadow-lg">
        @include('message')
        <form action="{{route('tasks.store')}}" method="post">
            @csrf
            @method('post')
            <div class="row">
                <div class="col">
                    <h5>Создание задачи</h5>
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
                    <input hidden value="{{$document->id}}" name="file_uuid">
                    <label for="short_description">Название документа</label>
                    <input disabled readonly class="form-control form-control-sm" name="short_description" id="short_description" value="{{$document->short_description}}">
                    @error('short_description')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-3">
                <div class="col mt-3">
                    <label for="incoming_at" class="form-label">Дата входящего:</label>
                    <input disabled readonly type="date" id="incoming_at" name="incoming_at" class="form-control form-select-sm" placeholder="Дата входящего документа" value="{{date('Y-m-d', strtotime($document->incoming_at))}}">
                    @error('incoming_at')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="col mt-3">
                    <label for="incoming_number" class="form-label">Номер входящего документа</label>
                    <input disabled readonly type="text" class="form-control form-control-sm" id="incoming_number" placeholder="Номер" name="incoming_number" value="{{$document->incoming_number}}">
                    @error('incoming_number')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="col mt-3">
                    <label for="incoming_author" class="form-label">Корреспондент (автор)</label>
                    <input disabled readonly type="text" class="form-control form-control-sm" id="incoming_author" placeholder="Корреспондент (автор)" name="incoming_author" value="{{$document->incoming_author}}">
                    @error('incoming_author')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-3">
                <div class="col mt-3">
                    <label for="number" class="form-label">Номер</label>
                    <input disabled readonly type="text" class="form-control form-control-sm" id="number" placeholder="Номер" name="number" value="{{$document->number}}">
                    @error('number')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="col mt-3">
                    <label for="date" class="form-label">Дата</label>
                    <input disabled readonly type="date" id="date" name="date" class="form-control form-select-sm" placeholder="Дата" value="{{date('Y-m-d', strtotime($document->date))}}">
                    @error('date')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="col mt-3">
                    <label for="document_and_application_sheets" class="form-label">Количество листов документа и приложения (хх+ххх)</label>
                    <input disabled readonly type="text" class="form-control form-control-sm" id="document_and_application_sheets" placeholder="хх+ххх" name="document_and_application_sheets" value="{{$document->document_and_application_sheets}}">
                    @error('document_and_application_sheets')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1">
                <div class="col mt-3">
                    <label for="description">Описание</label>
                    <textarea autofocus placeholder="Описание задачи" class="form-control form-control-sm" name="description" id="description" rows="1"></textarea>
                    @error('description')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-3">
                <div class="col mt-3">
                    <label for="priority_uuid">Приоритет</label>
                    <select class="form-select form-select-sm" name="priority_uuid">
                        @forelse($priorities as $priority)
                            <option value="{{$priority->id}}" {{$priority->sort_order === 1 ? 'selected' : ''}}>{{$priority->name}}</option>
                        @empty
                            <option value="">Нет приоритетов</option>
                        @endforelse
                    </select>
                    @error('priority_uuid')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="col mt-3">
                    <label for="responsible_uuid">Ответственный за выполнение</label>
                    <select class="form-select form-select-sm" name="responsible_uuid">
                        <option value="">Выберите ответственного ...</option>
                        @forelse($users as $user)
                            <option value="{{$user->id}}" {{$user->id === Auth::id() ? 'selected' : ''}}>{{$user->name}}</option>
                        @empty
                            <option value="">Нет пользователей</option>
                        @endforelse
                    </select>
                    @error('responsible_uuid')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="col mt-3">
                    <label for="deadline_at" class="form-label">Срок выполнения по плану:</label>
                    <input type="datetime-local" id="deadline_at" name="deadline_at" class="form-control form-select-sm" placeholder="Срок выполнения задачи" required>
                    @error('deadline_at')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-2 mt-2 mb-3">
                <div class="col mt-3">
                    <a type="button" class="btn btn-success btn-sm col-12"  href="{{route('documents.show', $document->id)}}">Назад</a>
                </div>
                <div class="col mt-3">
                    <button type="submit" class="btn btn-warning btn-sm col-12">Сохранить</button>
                </div>
            </div>
        </form>
    </div>

    <script src="{{asset('assets/documents/autoHeightTextarea.js')}}"></script>
    <script>
        autoHeightTextarea('description');
    </script>
    @endsection




