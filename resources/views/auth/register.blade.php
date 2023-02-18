@extends('main')

@section('title', 'Регистрация')

@section('header')
    @include('menu')
@endsection

@section('content')
    <div class="container pt-3">
        <div class="row">
            <div class="col">
                <h4 class="d-inline-block">Регистрация</h4>
            </div>
        </div>
        <form action="/register" method="post">
            @csrf
        <div class="row mb-3 pt-3">
            <div class="col">
                <label for="name">Фамилия И.О.</label>
                <input required class="form-control form-control-sm" name="name"  type="text">
                @error('name')
                    <div>{{$message}}</div>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label for="email">Почта</label>
                <input required class="form-control form-control-sm" name="email"  type="email">
                @error('email')
                    <div>{{$message}}</div>
                @enderror
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label for="password">Пароль</label>
                <input required class="form-control form-control-sm" name="password"  type="password">
                @error('password')
                    <div>{{$message}}</div>
                @enderror
            </div>
        </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="password_confirmation">Повторите пароль</label>
                    <input required class="form-control form-control-sm" name="password_confirmation"  type="password">
                    @error('password_confirmation')
                        <div>{{$message}}</div>
                    @enderror
                </div>
            </div>
        <div class="row">
            <div class="col">
                <button class="btn btn-sm btn-danger col-12" type="submit">Сохранить</button>
            </div>
            <div class="col">
                <button class="btn btn-sm btn-success col-12" type="button">Назад</button>
            </div>
        </div>
        </form>
    </div>
@endsection



