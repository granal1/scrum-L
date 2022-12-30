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
        <form action="{{route('profile.update', $user)}}" method="post">
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
                    <label for="role_uuid" class="form-label form-label-sm">Роли:</label>
                    <select disabled name="role_uuid" class="form-select form-select-sm">
                        <option value="">Выберите роль ...</option>
                        @if(isset($user->roles->first()->id))
                        @forelse($roles as $role)
                            <option @if($user->roles->first()->id === $role->id) selected @endif value="{{$role->id}}">{{$role->alias}}</option>
                        @empty
                            <option value="">Нет ролей</option>
                        @endforelse
                        @else
                            @forelse($roles as $role)
                                <option value="{{$role->id}}">{{$role->alias}}</option>
                            @empty
                                <option value="">Нет ролей</option>
                            @endforelse
                        @endif
                    </select>
                    @error('role_uuid')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="password" class="form-label">Пароль:</label>
                    <input type="password" class="form-control form-control-sm" id="password" placeholder="Введите пароль или останется существующий" name="password">
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
                    <input type="date" id="birthday_at" name="birthday_at" class="form-control" value="{{\Carbon\Carbon::parse($user->birthday_at)->format('Y-m-d')}}">
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
                    <ol class="list-group list-group-numbered">
                    @forelse($subordinates as $subordinate)
                        <li class="list-group-item">{{$subordinate->name}}</li>
                    @empty
                        <li class="list-group-item">Нет подчиненных</li>
                    @endforelse
                    <ol>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-2 mb-3">
                <div class="col mt-3">
                    <button type="button" class="btn btn-success btn-sm col-12"  onclick="javascript:history.back(); return false;">Назад</button>
                </div>
                <div class="col mt-3">
                    <button type="submit" class="btn btn-warning btn-sm col-12">Сохранить</button>
                </div>
            </div>
        </form>
    </div>
@endsection



