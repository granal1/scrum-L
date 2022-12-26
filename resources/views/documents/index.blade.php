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
                @if(Auth::user()->roles->first()->name === Auth::user()::ROLE_DELO)
                    <a class="btn btn-sm btn-success" href="{{route('documents.create')}}">Добавить</a>
                @endif
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
                {{$documents->links()}}
            </div>
        </div>
    </div>
@endsection

