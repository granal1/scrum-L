@extends('main')

@section('title', 'Редактирование документа')

    @section('header')
        @include('menu')
    @endsection

    @section('content')
    <div class="container pt-3 mt-3 card">
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
                    <label for="alias" class="form-label">Название<span class="text-danger"><b>*</b></span></label>
                    <input required placeholder="Роль" class="form-control form-control-sm" name="alias" id="alias" type="text" value="{{$role->alias}}">
                    @error('alias')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1">
                <div class="col mt-3">
                    <label for="name" class="form-label">Алиас</label>
                    <input readonly class="form-control form-control-sm" name="name" id="name" value="{{$role->name}}">
                    @error('name')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-center my-4">
                <div class="mx-3">
                    <button type="button" class="btn btn-primary btn-sm" style="width:150px" onclick="javascript:history.back(); return false;">Назад</button>
                </div>
                <div class="mx-3">
                    <button type="submit" class="btn btn-success btn-sm" style="width:150px">Сохранить</button>
                </div>
            </div>

        </form>
    </div>
    @endsection




