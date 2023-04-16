@extends('main')

@section('title', 'Редактирование документа')

    @section('header')
        @include('menu')
    @endsection

    @section('content')
    <div class="container mb-3 mt-3 card shadow-lg">
        <div class="row">
            <div class="col-lg-2 col-md-12 rounded text-white bg-primary pt-3" style="--bs-bg-opacity: .4">
                <div class="row">
                    <div class="col">
                        <h4 class="d-inline-block">Редактирование роли</h4>
                    </div>
                </div>
            </div>

            <div class="col pt-3">
                @include('message')
                <form action="{{route('roles.update', $role)}}" method="post">
                    @csrf
                    @method('patch')

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="alias" class="form-label">Название<span class="text-danger"></span></label>
                        </div>
                        <div class="col-8">
                            <input required placeholder="Роль" class="form-control form-control-sm" name="alias" id="alias" type="text" value="{{$role->alias}}">
                            @error('alias')
                            <div class="text-danger">{{$message}}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-4 text-end">
                            <label for="name" class="form-label">Алиас</label>
                        </div>
                        <div class="col-8">
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
        </div>
    </div>
    
    @endsection




