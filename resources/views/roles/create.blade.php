@extends('main')

@section('title', 'Создание роли')

    @section('header')
        @include('menu')
    @endsection

    @section('content')
    <div class="container mt-4 card shadow-lg mb-4">
        <div class="row row-cols-1 row-cols-md-2">
            <div class="col">
                <h5 class="mt-3">Новая роль</h5>
            </div>
        </div>
        @include('message')
        <form action="{{route('roles.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row row-cols-1">
                <div class="col mt-3">
                    <label for="alias" class="form-label">Алиас<span class="text-danger"><b>*</b></span></label>
                    <input required placeholder="Роль" class="form-control form-control-sm" name="alias" id="alias" type="text">
                    @error('alias')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1">
                <div class="col mt-3">
                    <label for="name" class="form-label">Название<span class="text-danger"><b>*</b></span></label>
                    <input required placeholder="Name" class="form-control form-control-sm" name="name" id="name">
                    @error('name')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row mt-4 mb-4">
                <div class="col">
                    <button type="button" class="btn btn-success btn-sm col-12"  onclick="javascript:history.back(); return false;">Назад</button>
                </div>
                <div class="col">
                    <button type="submit" class="btn btn-danger btn-sm col-12">Сохранить</button>
                </div>
            </div>
        </form>
    </div>
</div>
    @endsection



