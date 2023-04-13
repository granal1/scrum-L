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
                    <h4 class="d-inline-block">Новая задача</h4>
                </div>
            </div>
        </div>
        <div class="col pt-3">
            <form action="{{route('tasks.store')}}" method="post">
                @csrf

                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="priority_uuid">Приоритет</label>
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
                        <label for="deadline_at">Срок выполнения:</label>
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
                        <label for="description">Описание</label>
                    </div>
                    <div class="col-8">
                        <textarea required placeholder="Описание задачи" class="form-control form-control-sm" name="description" id="description" rows="1"></textarea>
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
                        <label for="repeat_value">Повторять через</label>
                    </div>
                    <div class="col-1">
                        <select class="form-select form-select-sm" id="repeat_value" name="repeat_value">
                            <option value="">0</option>
                            @for($i = 1; $i <= 31; $i++)
                                <option value="{{$i}}">{{$i}}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="col-2">
                        <select class="form-select form-select-sm" id="repeat_period" name="repeat_period">
                            <option value="days">день</option>
                            <option value="months">месяц</option>
                            <option value="years">год</option>
                        </select>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="file_uuid">Приложение</label>
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
                        <button type="button" class="btn btn-sm btn-primary" style="width:100px" onclick="javascript:history.back(); return false;">Назад</button>
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
