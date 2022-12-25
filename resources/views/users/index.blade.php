@extends('main')

@section('title', 'Главная | Пользователи')

@section('header')
    @include('menu')
@endsection

@section('content')
    <div class="container pt-3">
        @auth
            <h4>Здравствуйте {{ auth()->user()->name() }}</h4>
        @endauth

        <div class="card">
            <div class="card-header">
                <div class="d-grid gap-2 d-md-flex justify-content-between">
                    <h4 class="d-inline-block">Пользователи</h4>
                    <a class="btn btn-outline-success" href="{{route('users.create')}}">Добавить пользователя</a>
                </div>
            </div>
        <div class="row pt-3">
            <div class="col">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <td>Uuid</td>
                            <td>Имя</td>
                            <td>Почта</td>
                        </tr>
                        <tr>
                            <th colspan="4">
                                <a class="btn btn-sm btn-success col-12" href="{{route('users.index')}}">Сброс фильтров</a>
                            </th>
                        </tr>
                        <form action="{{ route('users.index') }}" method="get">
                            <tr>
                                <th>
                                </th>
                                <th>
                                    <input type="search" value="@if(isset($old_filters['name'])) {{ $old_filters['name'] }} @endif"
                                           class="form-control form-control-sm" id="name" name="name"
                                           onchange="this.form.submit()">
                                </th>
                                <th>
                                    <input type="search" value="@if(isset($old_filters['email'])) {{ $old_filters['email'] }} @endif"
                                           class="form-control form-control-sm" id="email" name="email"
                                           onchange="this.form.submit()">
                                </th>
                            </tr>
                        </form>
                    </thead>
                    <tbody style="cursor: pointer;">
                        @forelse($users as $user)
                            <tr  onclick="window.location='{{ route('users.show', $user->id) }}';">
                                <td>{{$user->id}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    Нет пользователей
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{$users->withQueryString()->links()}}
            </div>
        </div>
    </div>
@endsection

