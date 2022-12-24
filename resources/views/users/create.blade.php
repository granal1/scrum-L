@extends('main')

@section('title', 'Создание сотрудника')

@section('header')
    @include('menu')
@endsection

@section('content')
    <div class="container mt-2 card shadow-lg mb-2">
        <h4 class="mt-3">Новый сотрудник</h4>
        @include('message')
        <form action="{{route('users.store')}}" method="post">
            @csrf
            @method('post')
            <div class="row row-cols-1 row-cols-md-2 mb-3">
                <div class="col">
                    <label for="name" class="form-label">Ф.И.О.</label>
                    <input required type="text" class="form-control form-control-sm" id="name" placeholder="Введите Фамилия Имя Отчество" name="name">
                    @error('name')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="col">
                    <label for="login" class="form-label">Логин:</label>
                    <input required type="text" class="form-control form-control-sm" id="login" placeholder="Введите логин" name="login">
                    @error('login')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="password" class="form-label">Пароль:</label>
                    <input required type="password" class="form-control form-control-sm" id="password" placeholder="Введите пароль" name="password">
                    @error('password')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="col">
                    <label for="phone" class="form-label">Номер телефона в формате xxx-xxx-xx-xx:</label>
                    <input type="tel" id="phone" name="phone" class="form-control form-control-sm" pattern="[0-9]{3}-[0-9]{3}-[0-9]{2}-[0-9]{2}">
                    @error('phone')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-2 mb-3">
                <div class="col">
                    <label for="birthday_at"  class="form-label">Дата рождения:</label>
                    <input type="date" id="birthday_at" name="birthday_at" class="form-control" placeholder="">
                    @error('birthday_at')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="col">
                    <label for="email"  class="form-label">Адрес электронной почты:</label>
                    <input required type="email" id="email" name="email" class="form-control">
                    @error('email')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="superior_uuid"  class="form-label">Начальник</label>
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
            <div class="row mb-3">
                <div class="col">
                    <label class="form-label form-label-sm">Подчиненные</label>
                    <select name="subordinate_uuid" class="form-select form-select-sm">
                        <option value="">Выберите подчиненного ...</option>
                        @forelse($superiors as $user)
                            <option value="{{$user->id}}">{{$user->name}}</option>
                        @empty
                            <option value="">Нет сотрудников</option>
                        @endforelse
                    </select>
                    @error('subordinate_uuid')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-3 mb-4">
                <div class="col mt-3">
                    <a class="btn btn-primary btn-sm col-12" href="{{route('users.index')}}">Все пользователи</a>
                </div>
                <div class="col mt-3">
                    <button type="button" class="btn btn-success btn-sm col-12"  onclick="history.back()">Назад</button>
                </div>
                <div class="col mt-3">
                    <button type="submit" class="btn btn-warning btn-sm col-12">Сохранить</button>
                </div>
            </div>
        </form>
    </div>
@endsection



