@extends('main')

@section('title', 'Статус')

    @section('header')
        @include('menu')
    @endsection

    @section('content')
    <div class="container mb-3 mt-3 card shadow-lg">
        <div class="row">
            <div class="col-lg-2 col-md-12 rounded text-white bg-primary pt-3" style="--bs-bg-opacity: .4">
                <div class="row">
                    <div class="col">
                        <h4 class="d-inline-block">Статус</h4>
                    </div>
                </div>
            </div>

            <div class="col pt-3">
                @include('message')

                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="created_at">Создан</label>
                    </div>
                    <div class="col-8">
                        <input class="form-control form-control-sm" name="created_at" id="created_at" disabled value="{{$user_status->created_at}}">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="path">Название</label>
                    </div>
                    <div class="col-8">
                        <input class="form-control form-control-sm" name="alias" id="alias" disabled value="{{$user_status->alias}}">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="name">Алиас</label>
                    </div>
                    <div class="col-8">
                        <input class="form-control form-control-sm" name="name" id="name" disabled value="{{$user_status->name}}">
                    </div>
                </div>

                <div class="d-flex justify-content-center my-4">
                    <div class="mx-3">
                        <a class="btn btn-sm btn-primary" style="width:150px" href="{{route('user_statuses.index')}}">Все статусы</a>
                    </div>
                    <div class="mx-3">
                        <a class="btn btn-sm btn-primary" style="width:150px" href="{{route('user_statuses.edit', $user_status)}}">Редактировать</a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @endsection


