@extends('main')

@section('title', 'Главная | Пользователи')

@section('header')
@include('menu')
@endsection

@section('content')
<div class="container pt-3">
    <div class="card shadow">
        <div class="card-header">
            <div class="d-grid gap-2 d-md-flex align-items-center justify-content-between">
                <a class="btn btn-outline-success btn-sm" href="{{route('users.create')}}">Добавить</a>
                <h4 class="d-inline-block">Сотрудники</h4>
                        <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Поиск
                        </button>
            </div>
        </div>
        <div class="card-body">
            <div class="row pt-3">
                <div class="col">
                    <table class="table table-sm table-hover table-striped">
                        <thead>
                            <tr>
                                <td>Uuid</td>
                                <td>Имя</td>
                                <td>Почта</td>
                            </tr>
                        </thead>
                        <tbody style="cursor: pointer;">
                            <tr class="collapse @if(!empty($old_filters)) show @endif" id="collapseExample">
                                <form action="{{ route('users.index') }}" method="get">
                                    <td><a class="btn btn-outline-danger" type="button" href="{{route('users.index')}}">Сброс фильтров</a></td>
                                    <td>
                                        <input type="search" value="@if(isset($old_filters['name'])) {{ $old_filters['name'] }} @endif" class="form-control form-control-sm" id="name" name="name" onchange="this.form.submit()">
                                    </td>
                                    <td>
                                        <input type="search" value="@if(isset($old_filters['email'])) {{ $old_filters['email'] }} @endif" class="form-control form-control-sm" id="email" name="email" onchange="this.form.submit()">
                                    </td>
                                </form>
                            </tr>
                            @forelse($users as $user)
                            <tr onclick="window.location='{{ route('users.show', $user->id) }}';">
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
