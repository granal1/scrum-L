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
                                <th class="d-none d-sm-table-cell">Должность</th>
                                <th class="d-none d-sm-table-cell">Имя</th>
                                <th class="d-none d-sm-table-cell">Телефон</th>
                                <th class="d-none d-sm-table-cell">Почта</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="collapse @if(!empty($old_filters)) show @endif" id="collapseExample">
                                <form action="{{ route('phonebook.index') }}" method="get">
                                    <td class="d-none d-sm-table-cell">
                                        <div class="input-group mb-3">
                                                <a class="btn btn-outline-danger btn-sm" type="button" href="{{route('phonebook.index')}}">Сброс</a>
                                              <input type="search" value="@if(isset($old_filters['position'])){{$old_filters['position']}}@endif" class="form-control form-control-sm" id="position" name="position" onchange="this.form.submit()">
                                        </div>
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
                            <tr>
                                <td class="d-none d-sm-table-cell">{{$user->position}}</td>
                                <td>{{$user->name}}</td>
                                <td class="d-none d-sm-table-cell">{{$user->phone}} &nbsp;&nbsp;<a href="tel: {{$user->phone}}"><img src="{{asset('./assets/icons/phone.svg')}}" alt="Телефонная трубка" title="Позвонить" style="width: 15px; height: 15px;"></a></td>
                                <td class="d-none d-sm-table-cell">{{$user->email}} &nbsp;&nbsp;<a href="mailto: {{$user->email}}"><img src="{{asset('./assets/icons/send-email.svg')}}" alt="Отправка письма" title="Отправить письмо" style="width: 15px; height: 15px;"></a></td>
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
