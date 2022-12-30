@extends('main')

@section('title', 'Редактирование документа')

    @section('header')
        @include('menu')
    @endsection

    @section('content')
    <div class="container pt-3">
        @include('message')
        <form action="{{route('roles.update', $role)}}" method="post">
            @csrf
            @method('patch')
            <div class="row">
                <div class="col">
                    <h5>Редактирование документа</h5>
                </div>
            </div>
            <div class="row row-cols-1">
                <div class="col mt-3">
                    <label for="alias">Алиас</label>
                    <input required placeholder="Роль" class="form-control form-control-sm" name="alias" id="alias" type="text" value="{{$role->alias}}">
                    @error('alias')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1">
                <div class="col mt-3">
                    <label for="name">Название</label>
                    <input class="form-control form-control-sm" name="name" id="name" value="{{$role->name}}">
                    @error('name')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>

            <div class="row row-cols-1 row-cols-md-3 mt-2">
                <div class="col mt-3">
                    <a class="btn btn-primary btn-sm col-12" href="{{route('roles.index')}}">Все роли</a>
                </div>
                <div class="col mt-3">
                    <button type="button" class="btn btn-success btn-sm col-12"  onclick="javascript:history.back(); return false;">Назад</button>
                </div>
                <div class="col mt-3">
                    <button type="submit" class="btn btn-warning btn-sm col-12">Сохранить</button>
                </div>
            </div>
        </form>
        <form action="{{route('roles.destroy', $role)}}" method="post">
            @csrf
            @method('delete')
        <div class="row mb-4 mt-3">
            <div class="col">
                <button type="submit" class="btn btn-danger btn-sm col-12">Удалить</button>
            </div>
        </div>
        </form>
    </div>
    @endsection




