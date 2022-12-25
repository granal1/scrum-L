@extends('main')

@section('title', 'Главная | Документы')

@section('header')
    @include('menu')
@endsection

@section('content')
    <div class="container pt-3">
        @auth
            <h4>Здравствуйте {{ auth()->user()->name() }}</h4>
        @endauth

                <div class="card">
            <div class="card-header">
                <div class="d-grid gap-2 d-md-flex justify-content-between">
                    <h4 class="d-inline-block">Документы</h4>
                    <a class="btn btn-outline-success" href="{{route('documents.create')}}">Добавить</a>
                </div>
            </div>
        <div class="row pt-3">
            <div class="col">
                <table class="table table-hover">
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

