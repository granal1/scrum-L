@extends('main')

@section('title', 'Редактирование пользователя')

@section('header')
    @include('menu')
@endsection

@section('content')
    <div class="container mt-2 card shadow-lg mb-2">
        <div class="row mt-3">
            <div class="col">
                <h4>Сотрудник</h4>
            </div>
        </div>
        @include('message')
        <form action="{{route('users.update', $user)}}" method="post">
            @csrf
            @method('patch')
            <div class="row row-cols-1 row-cols-md-2 mb-3">
                <div class="col">
                    <label for="name" class="form-label">Ф.И.О.</label>
                    <input required type="text" class="form-control form-control-sm" id="name" placeholder="Введите Фамилия Имя Отчество" name="name" value="{{$user->name}}">
                    @error('name')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="col">
                    <label for="login" class="form-label">Логин:</label>
                    <input required type="text" class="form-control form-control-sm" id="login" placeholder="Введите логин" name="login" value="{{$user->login}}">
                    @error('login')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="password" class="form-label">Пароль:</label>
                    <input disabled readonly type="password" class="form-control form-control-sm" id="password" placeholder="Введите пароль или останется существующий" name="password">
                    @error('password')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="col">
                    <label for="phone" class="form-label">Номер телефона в формате xxx-xxx-xx-xx:</label>
                    <input type="tel" id="phone" name="phone" class="form-control form-control-sm" pattern="[0-9]{3}-[0-9]{3}-[0-9]{2}-[0-9]{2}" value="{{$user->phone}}">
                    @error('phone')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-2 mb-3">
                <div class="col">
                    <label for="birthday_at"  class="form-label">Дата рождения:</label>
                    <input type="date" id="birthday_at" name="birthday_at" class="form-control" placeholder="" required="" value="{{$user->birthday_at}}">
                    @error('birthday_at')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="col">
                    <label for="email"  class="form-label">Адрес электронной почты:</label>
                    <input required type="email" id="email" name="email" class="form-control" value="{{$user->email}}">
                    @error('email')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="superior_uuid"  class="form-label">Начальник:</label>
                    <select name="superior_uuid" class="form-select form-select-sm">
                        <option value="">Выберите руководителя ...</option>
                    @forelse($superiors as $superior)
                            <option @if($superior->id === $user->superior_uuid) selected @endif value="{{$superior->id}}">{{$superior->name}}</option>
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
                            <option value="">Выберите подчиненных ...</option>
                        @forelse($subordinates as $subordinate)
                            <option @if($subordinate->superior_uuid === $user->id) selected @endif value="{{$subordinate->id}}">{{$subordinate->name}}</option>
                        @empty
                            <option value="">Нет сотрудников</option>
                        @endforelse
                    </select>
                    @error('subordinate_uuid')
                        <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-3">
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
        <form action="{{route('users.destroy', $user)}}" method="post">
            @csrf
            @method('delete')
            <div class="row mb-4 mt-2">
                <div class="col">
                    <button type="submit" class="btn btn-danger btn-sm col-12">Удалить</button>
                </div>
            </div>
        </form>
    </div>
@endsection


