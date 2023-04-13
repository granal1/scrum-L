@extends('main')

@section('title', 'Создание задачи')

    @section('header')
        @include('menu')
    @endsection

    @section('content')
    <div class="container mb-3 mt-3 card shadow-lg">
        <div class="row">
            <div class="col-lg-2 col-md-12 rounded text-white bg-primary pt-3" style="--bs-bg-opacity: .4">
                <div class="row">
                    <div class="col">
                        <h4 class="d-inline-block">Добавление резолюции</h4>
                    </div>
                </div>
            </div>

            <div class="col pt-3">
                @include('message')
                <form action="{{route('tasks.store')}}" method="post">
                    @csrf
                    @method('post')
                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="incoming_at" class="form-label">Дата поступления</label>
                        </div>
                        <div class="col-8">
                            <input disabled readonly type="date" id="incoming_at" name="incoming_at" class="form-control form-select-sm" placeholder="Дата входящего документа" value="{{date('Y-m-d', strtotime($document->incoming_at))}}">
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
                            <input disabled readonly type="text" class="form-control form-control-sm" id="incoming_number" placeholder="Номер" name="incoming_number" value="{{$document->incoming_number}}">
                            @error('incoming_number')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="path">Место хранения документа</label>
                        </div>
                        <div class="col-8">
                            <a href="{{'/storage/' . $document->path}}" target="_blank"><input class="form-control form-control-sm" name="path" id="path" disabled value="{{$document->path}}" style="cursor: pointer;"></a>
                            @error('file')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="incoming_author" class="form-label">Корреспондент (автор)</label>
                        </div>
                        <div class="col-8">
                            <input disabled readonly type="text" class="form-control form-control-sm" id="incoming_author" placeholder="Корреспондент (автор)" name="incoming_author" value="{{$document->incoming_author}}">
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
                            <input disabled readonly type="text" class="form-control form-control-sm" id="number" placeholder="Номер" name="number" value="{{$document->number}}">
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
                            <input disabled readonly type="date" id="date" name="date" class="form-control form-select-sm" placeholder="Дата" value="{{date('Y-m-d', strtotime($document->date))}}">
                            @error('date')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <input hidden value="{{$document->id}}" name="file_uuid">
                            <label for="short_description">Наименование или краткое содержание</label>
                        </div>
                        <div class="col-8">
                            <input disabled readonly class="form-control form-control-sm" name="short_description" id="short_description" value="{{$document->short_description}}">
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
                            <input disabled readonly type="text" class="form-control form-control-sm" id="document_and_application_sheets" placeholder="Количество листов не указано" name="document_and_application_sheets" value="{{$document->document_and_application_sheets}}">
                            @error('document_and_application_sheets')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="description">Резолюция к документу</label>
                        </div>
                        <div class="col-8">
                            <textarea autofocus placeholder="Описание задачи исполнителю документа" class="form-control form-control-sm" name="description" id="description" rows="1"></textarea>
                            @error('description')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="responsible_uuid">Ответственный за исполнение</label>
                        </div>
                        <div class="col-8">
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
                    </div>

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="priority_uuid">Приоритет задачи</label>
                        </div>
                        <div class="col-8">
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
                    </div>

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="deadline_at" class="form-label">Срок исполнения</label>
                        </div>
                        <div class="col-8">
                            <input type="datetime-local" id="deadline_at" name="deadline_at" class="form-control form-select-sm" placeholder="Срок выполнения задачи" required>
                            @error('deadline_at')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-flex justify-content-center my-4">
                        <div class="mx-3">
                            <a type="button" class="btn btn-sm btn-primary" style="width:100px" href="{{route('documents.show', $document->id)}}">Назад</a>
                        </div>
                        <div class="mx-3">
                            <button type="submit" class="btn btn-sm btn-success" style="width:100px">Сохранить</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <script src="{{asset('assets/documents/adaptTextarea.js')}}"></script>
    <script>
        adaptTextarea('description');
    </script>
    @endsection




