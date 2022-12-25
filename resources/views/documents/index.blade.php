@extends('main')

@section('title', 'Главная | Документы')

@section('header')
    @include('menu')
@endsection

@section('content')
    <div class="container pt-3">
{{--        @auth--}}
{{--            <h4>Здравствуйте {{ auth()->user()->name() }}</h4>--}}
{{--        @endauth--}}
        <div class="row">
            <div class="col">
                <h4 class="d-inline-block">Документы</h4>
                <a class="btn btn-sm btn-success" href="{{route('documents.create')}}">Добавить</a>
            </div>
        </div>
        <div class="row pt-3">
            <div class="col">
                <table class="table table-sm table-striped table-responsive table-hover table-bordered">
                    <thead>
                        <tr>
                            <td>Uuid</td>
                            <td>Создан</td>
                            <td>Путь</td>
                            <td>Название</td>
                        </tr>
                        <tr>
                            <th colspan="4">
                                <a class="btn btn-sm btn-success col-12" href="{{route('documents.index')}}">Сброс фильтров</a>
                            </th>
                        </tr>
                        <form action="{{ route('documents.index') }}" method="get">
                            <tr>
                                <th>
                                </th>
                                <th></th>
                                <th>
                                    <input type="search" value="@if(isset($old_filters['path'])) {{ $old_filters['path'] }} @endif"
                                           class="form-control form-control-sm" id="path" name="path"
                                           onchange="this.form.submit()">
                                </th>
                                <th>
                                    <input type="search" value="@if(isset($old_filters['name'])) {{ $old_filters['name'] }} @endif"
                                           class="form-control form-control-sm" id="name" name="name"
                                           onchange="this.form.submit()">
                                </th>
                            </tr>
                        </form>
                    </thead>
                    <tbody style="cursor: pointer;">
                        @forelse($documents as $document)
                            <tr  onclick="window.location='{{ route('documents.show', $document->id) }}';">
                                <td>{{$document->uuid}}</td>
                                <td>{{$document->created_at}}</td>
                                <td>{{$document->path}}</td>
                                <td>{{$document->name}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    Нет документов
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{$documents->withQueryString()->links()}}
            </div>
        </div>
    </div>
@endsection

