@extends('main')

@section('title', 'Создание подзадачи')

    @section('header')
        @include('menu')
    @endsection

    @section('content')
    <div class="container mb-3 mt-3 card shadow-lg">
        <div class="row">
            <div class="col-lg-2 col-md-12 rounded text-white bg-primary pt-3" style="--bs-bg-opacity: .45">
                <div class="row">
                    <div class="col">
                        <h4 class="d-inline-block">Новая подзадача</h4>
                        <div class="col">
                            <a class="btn btn-sm btn-primary" href="{{route('tasks.show', $task->id)}}">Базовая задача</a>
                        </div>
                        <div class="col">
                            Создал: {{$task->author->name}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col pt-3">
                <form action="{{route('tasks.store')}}" method="post">
                    @csrf
                    <input hidden readonly name="parent_uuid" value="{{$task->id}}">

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="base-description">Описание базовой задачи</label>
                        </div>
                        <div class="col-8">
                            <textarea class="form-control form-control-sm" name="base-description" id="base-description" rows="1" disabled readonly>{{$task->description}}</textarea>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="priority_uuid">Приоритет подзадачи</label>
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
                            <label for="deadline_at">Срок выполнения подзадачи</label>
                        </div>
                        <div class="col-8">
                            <input type="datetime-local" id="deadline_at" name="deadline_at" class="form-control form-select-sm" placeholder="Срок выполнения задачи" required>
                            @error('deadline_at')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="description">Описание подзадачи</label>
                        </div>
                        <div class="col-8">
                            <textarea required placeholder="Напишите, что необходимо сделать" class="form-control form-control-sm" name="description" id="description" rows="1"></textarea>
                            @error('description')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="responsible_uuid">Ответственный за выполнение</label>
                        </div>
                        <div class="col-8">
                            <select class="form-select form-select-sm" name="responsible_uuid">
                                @forelse($users as $user)
                                        <option value="{{$user->id}}">{{$user->name}}</option>
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
                            <label for="period_uuid">Периодичность выполнения</label>
                        </div>
                        <div class="col-8">
                            <select class="form-select form-select-sm" name="period_uuid">
                                <option value="">Не повторять</option>
                                @forelse($periods as $period)
                                    <option value="{{$period->id}}">{{$period->name}}</option>
                                @empty
                                    <option value="">Нет периодов</option>
                                @endforelse
                            </select>
                            @error('periods')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="file_uuid">Приложение к подзадаче</label>
                        </div>
                        <div class="col-8">
                            <select class="form-select form-select-sm" name="file_uuid">
                                <option value="">Выберите документ ...</option>
                                @forelse($documents as $document)
                                    <option value="{{$document->id}}">{{$document->short_description}}</option>
                                @empty
                                    <option value="">Нет документов</option>
                                @endforelse
                            </select>
                            @error('files')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>


                    <div class="d-flex justify-content-center my-4">
                        <div class="mx-3">
                            <button type="button" style="width:100px" class="btn btn-sm btn-success"  onclick="javascript:history.back(); return false;">Назад</button>
                        </div>
                        <div class="mx-3">
                            <button type="submit" style="width:100px" class="btn btn-sm btn-danger">Сохранить</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="{{asset('assets/documents/adaptTextarea.js')}}"></script>
<script>
    adaptTextarea('base-description');
    adaptTextarea('description');
</script>
@endsection



