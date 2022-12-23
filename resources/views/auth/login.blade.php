@extends('main')

@section('title', 'Вход')

@section('header')
    @include('menu')
@endsection

@section('content')

    <div class="container mt-3 pt-3 shadow-lg pb-3">
        <div class="row">
            <div class="col">
                <h4 class="d-inline-block">Вход</h4>
            </div>
        </div>
        <form action="/login" method="post">
            @csrf
            <div class="row mb-3 pt-3">
                <div class="col">
                    <label for="email">Почта</label>
                    <input name="email" class="form-control form-control-sm" required type="text">
                    @error('email')
                        <div>{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row mb-3">
                <div class="col">
                    <label for="password">Пароль</label>
                    <input name="password" class="form-control form-control-sm" required type="password">
                    @error('password')
                        <div>{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row mb-4">
                <div class="col">
                    <input type="checkbox" class="form-check-input" name="remember" id="remember">
                    <label for="remember" class="form-check-label">Запомнить меня</label>
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-2">
                <div class="col mb-3">
                    <button class="btn btn-sm btn-danger col-12" type="submit">Войти</button>
                </div>
                <div class="col mb-3">
                    <button class="btn btn-sm btn-success col-12" type="button">Назад</button>
                </div>
            </div>
        </form>
    </div>

@endsection
