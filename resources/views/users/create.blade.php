@extends('main')

@section('title', 'Создание сотрудника')

@section('header')
    @include('menu')
@endsection

@section('content')
<div class="container mb-3 mt-3 card shadow-lg">
    <div class="row">
        <div class="col-lg-2 col-md-12 rounded text-white bg-primary pt-3" style="--bs-bg-opacity: .4">
            <div class="row">
                <div class="col">
                    <h4 class="d-inline-block">Новый сотрудник</h4>
                </div>
            </div>
        </div>

        <div class="col pt-3">
            @include('message')
            <form action="{{route('users.store')}}" method="post">
                @csrf

                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="name" class="form-label">Фамилия Имя Отчество сотрудника<span class="text-danger"></span></label>
                    </div>
                    <div class="col-8">
                        <input required type="text" class="form-control form-control-sm" id="name" placeholder="Введите Фамилию Имя Отчество сотрудника" name="name">
                        @error('name')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label class="form-label form-label-sm">Статус<span class="text-danger"></span></label>
                    </div>
                    <div class="col-8">
                        <select name="user_status_uuid" class="form-select form-select-sm">
                            <option value="">Выберите статус ...</option>
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
                </div>

                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label class="form-label form-label-sm">Роли<br>(возможен выбор нескольких пунктов)<span class="text-danger"></span></label>
                    </div>
                    <div class="col-8">
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

                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="password" class="form-label">Пароль<span class="text-danger"></span></label>
                    </div>
                    <div class="col-8">
                        <input required type="password" class="form-control form-control-sm" id="password" placeholder="Введите пароль" name="password">
                        @error('password')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="phone" class="form-label">Номер телефона в формате xxx-xxx-xx-xx</label>
                    </div>
                    <div class="col-8">
                        <input type="tel" placeholder="Например: 999-999-99-99" id="phone" name="phone" class="form-control form-control-sm" pattern="[0-9]{3}-[0-9]{3}-[0-9]{2}-[0-9]{2}">
                        @error('phone')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="birthday_at"  class="form-label">Дата рождения</label>
                    </div>
                    <div class="col-8">
                        <input type="date" id="birthday_at" name="birthday_at" class="form-control form-control-sm" placeholder="">
                        @error('birthday_at')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="email"  class="form-label">Адрес электронной почты<span class="text-danger"></span></label>
                    </div>
                    <div class="col-8">
                        <input required type="email" id="email" name="email" class="form-control form-control-sm" placeholder="Укажите адрес электронной почты">
                        @error('email')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="employment_at"  class="form-label">Дата трудоустройства</label>
                    </div>
                    <div class="col-8">
                        <input type="date" id="employment_at" name="employment_at" class="form-control form-control-sm" placeholder="">
                        @error('employment_at')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="position" class="form-label">Должность</label>
                    </div>
                    <div class="col-8">
                        <input type="text" class="form-control form-control-sm" id="position" placeholder="Укажите должность сотрудника" name="position">
                        @error('position')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="superior_uuid" class="form-label">Начальник<span class="text-danger"></span></label>
                    </div>
                    <div class="col-8">
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
    </div>
</div>

@endsection



