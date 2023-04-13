@extends('main')

@section('title', 'Создание сотрудника')

@section('header')
    @include('menu')
@endsection

@section('content')
    <div class="container card shadow-lg mx-auto mt-4 mb-4">
        <h4 class="mt-3">Новый сотрудник</h4>
        @include('message')
        <form action="{{route('users.store')}}" method="post">
            @csrf
            @method('post')
            <div class="row row-cols-1 row-cols-md-3 mb-3 mt-2">
                <div class="col mb-3">
                    <label for="name" class="form-label">Фамилия И.О.<span class="text-danger"><b>*</b></span></label>
                    <input required type="text" class="form-control form-control-sm" id="name" placeholder="Введите Фамилия Имя Отчество" name="name">
                    @error('name')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="col">
                    <label class="form-label form-label-sm">Статус<span class="text-danger"><b>*</b></span></label>
                    <select name="user_status_uuid" class="form-select form-select-sm">
                        @forelse($user_statuses as $user_status)
                            <option value="{{$user_status->id}}">{{$user_status->name}}</option>
                        @empty
                            <option value="">Нет статусов</option>
                        @endforelse
                    </select>
                    @error('user_status_uuid')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="col">
                    <label class="form-label form-label-sm">Роли<span class="text-danger"><b>*</b></span></label>
                    <select multiple name="role_uuid[]" class="form-select form-select-sm">
                        @forelse($roles as $role)
                            <option value="{{$role->id}}">{{$role->alias}}</option>
                        @empty
                            <option value="">Нет ролей</option>
                        @endforelse
                    </select>
                    @error('role_uuid')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3 row-cols-1 row-cols-md-3">
                <div class="col mb-3">
                    <label for="password" class="form-label">Пароль:<span class="text-danger"><b>*</b></span></label>
                    <input required type="password" class="form-control form-control-sm" id="password" placeholder="Введите пароль" name="password">
                    @error('password')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="col">
                    <label for="phone" class="form-label">Номер телефона в формате xxx-xxx-xx-xx:</label>
                    <input type="tel" placeholder="904-613-78-62" id="phone" name="phone" class="form-control form-control-sm" pattern="[0-9]{3}-[0-9]{3}-[0-9]{2}-[0-9]{2}">
                    @error('phone')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="col mb-3">
                    <label for="birthday_at"  class="form-label">Дата рождения:</label>
                    <input type="date" id="birthday_at" name="birthday_at" class="form-control form-control-sm" placeholder="">
                    @error('birthday_at')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-3 mb-3">
                <div class="col">
                    <label for="email"  class="form-label">Адрес электронной почты:<span class="text-danger"><b>*</b></span></label>
                    <input required type="email" id="email" name="email" class="form-control form-control-sm" placeholder="mail@mail.ru">
                    @error('email')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="col mb-3">
                    <label for="employment_at"  class="form-label">Дата трудоустройства:</label>
                    <input type="date" id="employment_at" name="employment_at" class="form-control form-control-sm" placeholder="">
                    @error('employment_at')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="col mb-3">
                    <label for="position" class="form-label">Должность</label>
                    <input type="text" class="form-control form-control-sm" id="position" placeholder="Должность" name="position">
                    @error('position')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3 row-cols-1 row-cols-md-3">
                <div class="col mb-3">
                    <label for="superior_uuid"  class="form-label">Начальник<span class="text-danger"><b>*</b></span></label>
                    <select name="superior_uuid" class="form-select form-select-sm">
                        <option value="">Выберите руководителя ...</option>
                        @forelse($superiors as $superior)
                            <option value="{{$superior->id}}">{{$superior->name}}</option>
                        @empty
                            <option value="">Нет сотрудников</option>
                        @endforelse
                    </select>
                    @error('superior_uuid')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-center my-4">
                <div class="mx-3">
                    <button type="button" class="btn btn-primary btn-sm" style="width:150px" onclick="javascript:history.back(); return false;">Назад</button>
                </div>
                <div class="mx-3">
                    <button type="submit" class="btn btn-success btn-sm" style="width:150px">Сохранить</button>
                </div>
            </div>

        </form>
    </div>
@endsection



