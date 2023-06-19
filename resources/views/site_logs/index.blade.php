@extends('main')

@section('title', 'Главная | Логи сайта')

@section('header')
@include('menu')
@endsection

@section('content')
<div class="container-fluid pt-3">

    <div class="card shadow">
        <div class="card-header">
            <div class="d-grid gap-2 d-md-flex align-items-center justify-content-between">
                <h4 class="d-inline-block">Логи сайта</h4>
                        <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Поиск
                        </button>
                    <a class="btn btn-outline-danger btn-sm d-sm-none" type="button" href="{{route('site_logs.index')}}">Сброс</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row pt-3">
                <div class="col">
                    <table class="table table-sm table-hover table-striped">
                        <thead>
                            <tr>
                                <th class="d-none d-sm-table-cell">Дата</th>
                                <th class="d-none d-sm-table-cell">Ссылка</th>
                                <th class="d-none d-sm-table-cell">Удалить</th>

                            </tr>
                        </thead>
                        <tbody style="cursor: pointer;">
                        @forelse($dates as $date)
                            <tr>
                            <td class="d-none d-sm-table-cell">{{$date}}</td>
                                <td class="d-none d-sm-table-cell"><a href="{{$logs_storage_link  . '/' . $date . '/laravel.log'}}">{{$logs_storage_link  . '/' . $date . '/laravel.log'}}</a></td>
                                <td class="d-none d-sm-table-cell"></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    Даты отсутствуют
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
{{--                    {{$logs->withQueryString()->links()}}--}}
                </div>
            </div>
        </div>
    </div>
    @endsection
