@extends('main')

@section('title', 'Пользователь')

@section('header')
    @include('menu')
@endsection

@section('content')
<div class="container mb-3 mt-3 card shadow-lg">
    <div class="row">
        <div class="col-lg-2 col-md-12 rounded text-white bg-primary pt-3" style="--bs-bg-opacity: .4">
            <div class="row">
                <div class="col">
                    <h4 class="d-inline-block">Профиль сотрудника</h4>
                </div>
            </div>
        </div>

        <div class="col pt-3">
            <form action="">
            <div class="row mt-3">
                <div class="col-4 text-end">
                    <label for="name" class="form-label">Ф.И.О.</label>
                </div>
                <div class="col-8">
                    <input disabled readonly type="text" class="form-control form-control-sm" id="name" placeholder="" name="name" value="{{$user->name}}">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-4 text-end">
                    <label for="user_status_uuid" class="form-label">Статус</label>
                </div>
                <div class="col-8">
                    <input disabled readonly type="text" class="form-control form-control-sm" id="user_status_uuid" placeholder="" name="user_status_uuid" value="{{$user->status->name}}">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-4 text-end">
                    <label for="role_uuid" class="form-label">Роль</label>
                </div>
                <div class="col-8">
                    <input disabled readonly type="text" class="form-control form-control-sm" id="role_uuid" placeholder="" name="role_uuid" value="@if(isset($user->roles->first()->id)) {{$user->roles->first()->alias}} @else {{'Не определено'}} @endif">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-4 text-end">
                    <label for="birthday_at"  class="form-label">Дата рождения</label>
                </div>
                <div class="col-8">
                    <input disabled readonly type="date" id="birthday_at" name="birthday_at" class="form-control form-control-sm" value="{{$user->birthday_at ? \Carbon\Carbon::parse($user->birthday_at)->format('Y-m-d') : 'Нет данных'}}">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-4 text-end">
                    <label for="phone" class="form-label">Номер телефона в формате xxx-xxx-xx-xx</label>
                </div>
                <div class="col-8">
                    <input disabled readonly type="tel" id="phone" name="phone" class="form-control form-control-sm" pattern="[0-9]{3}-[0-9]{3}-[0-9]{2}-[0-9]{2}" value="{{$user->phone ?? 'Нет данных'}}">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-4 text-end">
                    <label for="employment_at"  class="form-label">Дата трудоустройства</label>
                </div>
                <div class="col-8">
                    <input disabled readonly type="date" id="employment_at" name="employment_at" class="form-control form-control-sm" value="{{\Carbon\Carbon::parse($user->employment_at)->format('Y-m-d') ?? 'Нет данных'}}">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-4 text-end">
                    <label for="email"  class="form-label">Адрес электронной почты</label>
                </div>
                <div class="col-8">
                    <input  disabled readonly type="email" id="email" name="email" class="form-control form-control-sm" value="{{$user->email}}">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-4 text-end">
                    <label for="position" class="form-label">Должность</label>
                </div>
                <div class="col-8">
                    <input disabled readonly type="text" class="form-control form-control-sm" id="position" placeholder="" name="position" value="{{$user->position ?? 'Нет данных'}}">
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-4 text-end">
                    <label for="superior_uuid"  class="form-label">Начальник</label>
                </div>
                <div class="col-8">
                    @if(isset($user->superior->name))
                    <input  disabled readonly type="text" id="superior_uuid" name="superior_uuid" class="form-control form-control-sm" placeholder="" required="" value="{{$user->superior->name}}">
                    @else
                        <input  disabled readonly type="text" id="superior_uuid" name="superior_uuid" class="form-control form-control-sm" placeholder="" required="" value="Отсутствует">
                    @endif
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-4 text-end">
                    <label class="form-label form-label-sm">Подчиненные</label>
                </div>
                <div class="col-8">
                    <ol class="list-group list-group-numbered">
                        @forelse($subordinates as $subordinate)
                            <li class="list-group-item">{{$subordinate->name}}</li>
                        @empty
                            <li class="list-group-item">Нет подчиненных</li>
                        @endforelse
                    </ol>
                </div>
            </div>


            <div class="d-flex justify-content-center my-4">
                <div class="mx-3">
                    <button class="btn btn-sm btn-primary" style="width:150px" onclick="javascript:history.back(); return false;">Назад</button>
                </div>
                @can('update', \App\Models\Profile\Profile::class)
                <div class="mx-3">
                    <a class="btn btn-sm btn-primary" style="width:150px" href="{{route('profile.edit', $user)}}">Редактировать</a>
                </div>
                @endcan
            </div>

            </form>
        </div>
    </div>
</div>

@endsection



