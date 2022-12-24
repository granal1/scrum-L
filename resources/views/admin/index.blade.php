@extends('main')

@section('title', 'Главная | Админка')

@section('header')
    @include('menu')
@endsection

@section('content')
    <div class="container pt-3">
        @auth
            <h4>Здравствуйте {{ auth()->user()->name() }}</h4>
        @endauth
        <div class="row">
            <div class="col">
                <h4 class="d-inline-block">Админка</h4>
            </div>
        </div>
    </div>
@endsection

