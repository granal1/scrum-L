@extends('main')

@section('title', 'Главная | ТЕЛЕФОНЫ')

@section('header')
@include('menu')
@endsection

@section('content')
<div class="container pt-3">
    <div class="card shadow">
        <div class="card-header">
            <div class="d-grid gap-2 d-md-flex align-items-center justify-content-between">
                <h4 class="d-inline-block">Телефонный справочник</h4>
                        <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Поиск
                        </button>
                <a class="btn btn-outline-danger btn-sm d-md-none" type="button" href="{{route('phonebook.index')}}">Сброс</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row pt-3">
                <div class="col">
                    <table class="table table-sm table-hover table-striped">
                        <thead>
                            <tr>
                                <td class="d-none d-sm-table-cell">Должность</td>
                                <td class="d-none d-sm-table-cell">Имя</td>
                                <td class="d-none d-sm-table-cell">Телефон</td>
                                <td class="d-none d-sm-table-cell">Почта</td>
                            </tr>
                        </thead>
                        <tbody style="cursor: pointer;">
                            <tr class="collapse @if(!empty($old_filters)) show @endif" id="collapseExample">
                                <form action="{{ route('phonebook.index') }}" method="get">
                                    <td class="d-none d-sm-table-cell">
                                        <div class="input-group mb-3">
                                                <a class="btn btn-outline-danger btn-sm" type="button" href="{{route('phonebook.index')}}">Сброс</a>
                                              <input type="search" value="@if(isset($old_filters['position'])){{$old_filters['position']}}@endif" class="form-control form-control-sm" id="position" name="position" onchange="this.form.submit()">
                                    </td>
                                    <td class="d-none d-sm-table-cell">
                                        <input type="search" value="@if(isset($old_filters['name'])){{$old_filters['name']}}@endif" class="form-control form-control-sm" id="name" name="name" onchange="this.form.submit()">
                                    </td>
                                    <td class="d-none d-sm-table-cell">
                                        <input type="search" value="@if(isset($old_filters['phone'])){{$old_filters['phone']}}@endif" class="form-control form-control-sm" id="phone" name="phone" onchange="this.form.submit()">
                                    </td>
                                    <td class="d-none d-sm-table-cell">
                                        <input type="search" value="@if(isset($old_filters['email'])){{$old_filters['email']}}@endif" class="form-control form-control-sm" id="email" name="email" onchange="this.form.submit()">
                                    </td>
                                </form>
                            </tr>
                            @forelse($users as $user)
                            <tr onclick="window.location='{{ route('users.show', $user->id) }}';">
                                <td class="d-none d-sm-table-cell">{{$user->position}}</td>
                                <td>{{$user->name}}</td>
                                <td class="d-none d-sm-table-cell">{{$user->phone}}</td>
                                <td class="d-none d-sm-table-cell">{{$user->email}}</td>
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
