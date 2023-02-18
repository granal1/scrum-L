@extends('main')

@section('title', 'Статус')

    @section('header')
        @include('menu')
    @endsection

    @section('content')
    <div class="container pt-3 pb-3 mb-3 card mt-3">
        <div class="row">
            <div class="col">
                <h4 class="d-inline-block">Статус</h4>
            </div>
        </div>
        @include('message')
        <div class="row pt-3 row-cols-1 row-cols-md-2">
            <div class="col mb-3">
                <label for="uuid">Uuid</label>
                <input class="form-control form-control-sm" name="uuid" id="uuid" disabled value="{{$user_status->id}}">
            </div>
            <div class="col mb-3">
                <label for="created_at">Создан</label>
                <input class="form-control form-control-sm" name="created_at" id="created_at" disabled value="{{$user_status->created_at}}">
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-2">
            <div class="col mb-3">
                <label for="path">Название</label>
                <input class="form-control form-control-sm" name="alias" id="alias" disabled value="{{$user_status->alias}}">
            </div>
            <div class="col">
                <label for="name">Алиас</label>
                <input class="form-control form-control-sm" name="name" id="name" disabled value="{{$user_status->name}}">
            </div>
        </div>
        <div class="row pt-3 row-cols-1 row-cols-md-3">
            <div class="col mb-3">
                <a class="btn btn-primary btn-sm col-12" href="{{route('user_statuses.index')}}">Все роли</a>
            </div>
            <div class="col mb-3">
                <button class="btn btn-sm btn-success col-12"  onclick="javascript:history.back(); return false;">Назад</button>
            </div>
                <div class="col mb-3">
                    <a class="btn btn-sm btn-danger col-12" href="{{route('user_statuses.edit', $user_status)}}">Редактировать</a>
                </div>
        </div>
    </div>
    @endsection


