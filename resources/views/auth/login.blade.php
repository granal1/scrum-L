@extends('main')

@section('title', 'Вход')

@section('header')
@include('menu')
@endsection

@section('content')
<div class="container pt-3">
    <div class="container">
        <div class="row justify-content-center ">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header">
                        <h3>Авторизация</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="/login">
                            @csrf
                            <div class="row mb-3">
                                <label for="email" class="col-md-4 col-form-label text-md-end">Email
                                    пользователя:</label>
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="admin@admin.ru" required autocomplete="email" autofocus>
                                    @error('email')
                                    <div>{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="password" class="col-md-4 col-form-label text-md-end">Пароль:</label>
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" value="+1234567" required autocomplete="current-password">
                                    @error('password')
                                    <div>{{$message}}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                        <label class="form-check-label" for="remember">
                                            Запомнить
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-md-8 offset-md-4">
                                    <button type="submit" class="btn btn-secondary">
                                        Войти
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
