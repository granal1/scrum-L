@extends('main')

@section('title', 'Пользователь')

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
        <form action="">
            <div class="row row-cols-1 row-cols-md-2 mb-3">
                <div class="col">
                        <label for="name" class="form-label">Ф.И.О.</label>
                        <input disabled readonly type="text" class="form-control form-control-sm" id="name" placeholder="" name="name" value="{{$user->name}}">
                </div>
                <div class="col">
                    <label for="role_uuid" class="form-label">Роль:</label>
                    <input  disabled readonly type="text" class="form-control form-control-sm" id="role_uuid" placeholder="" name="role_uuid" value="@if(isset($user->roles->first()->id)) {{$user->roles->first()->alias}} @else {{'Не определено'}} @endif">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="birthday_at"  class="form-label">Дата рождения:</label>
                        <input  disabled readonly type="date" id="birthday_at" name="birthday_at" class="form-control form-control-sm" value="{{\Carbon\Carbon::parse($user->birthday_at)->format('Y-m-d') ?? 'Нет данных'}}">
                </div>
                <div class="col">
                    <label for="phone" class="form-label">Номер телефона в формате xxx-xxx-xx-xx:</label>
                    <input  disabled readonly type="tel" id="phone" name="phone" class="form-control form-control-sm" pattern="[0-9]{3}-[0-9]{3}-[0-9]{2}-[0-9]{2}" value="{{$user->phone ?? 'Нет данных'}}">
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-2 mb-3">
                <div class="col">
                    <label for="email"  class="form-label">Адрес электронной почты:</label>
                    <input  disabled readonly type="email" id="email" name="email" class="form-control form-control-sm" value="{{$user->email}}">
                </div>
                <div class="col">
                    <label for="superior_uuid"  class="form-label">Начальник:</label>
                    @if(isset($user->superior->name))
                    <input  disabled readonly type="text" id="superior_uuid" name="superior_uuid" class="form-control form-control-sm" placeholder="" required="" value="{{$user->superior->name}}">
                    @else
                        <input  disabled readonly type="text" id="superior_uuid" name="superior_uuid" class="form-control form-control-sm" placeholder="" required="" value="Отсутствует">
                    @endif
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label class="form-label form-label-sm">Подчиненные</label>
                    <select disabled name="subordinate_uuid" class="form-select form-select-sm">
                        @forelse($subordinates as $subordinate)
                            <option value="{{$subordinate->id}}">{{$subordinate->name}}</option>
                        @empty
                            <option value="">Нет подчиненных</option>
                        @endforelse
                    </select>
                    @error('subordinate_uuid')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row pt-3 row-cols-1 row-cols-md-2 mb-3">
                <div class="col mb-3">
                    <button class="btn btn-sm btn-success col-12"  onclick="history.back()">Назад</button>
                </div>
                <div class="col mb-3">
                    <a class="btn btn-sm btn-danger col-12" href="{{route('profile.edit', $user)}}">Редактировать</a>
                </div>
            </div>

        </form>
    </div>
@endsection



