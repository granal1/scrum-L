@extends('main')

@section('title', 'Главная | Задачи')

@section('header')
    @include('menu')
@endsection

@section('content')
    <div class="container pt-3">
        @auth
            <h4>Здравствуйте {{ auth()->user()->name() }}</h4>
        @endauth
        <div class="row">
            <div class="col">
                <h4 class="d-inline-block">Задачи</h4>
                <a class="btn btn-sm btn-success" href="{{route('tasks.create')}}">Добавить</a>
            </div>
        </div>
        <div class="row pt-3">
            <div class="col">
                <table class="table table-sm table-striped table-responsive table-hover table-bordered">
                    <thead>
                        <tr>
                            <td>Uuid</td>
                            <td>Описание</td>
                            <td>Создана</td>
                            <td>Выполнить до</td>
                            <td>Ответственный</td>
                            <td>Выполнено, %</td>
                        </tr>
                    </thead>
                    <tbody style="cursor: pointer;">
                        @forelse($tasks as $task)
                            <tr  onclick="window.location='{{ route('tasks.show', $task->id) }}';">
                                <td>{{$task->uuid}}</td>
                                <td>{{$task->description}}</td>
                                <td>{{$task->created_at}}</td>
                                <td>{{$task->created_at}}</td>
                                <td>{{$task->getResponsible()}}</td>
                                <td>{{$task->currentHistory->done_progress}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6">
                                    Нет задач
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{$tasks->links()}}
            </div>
        </div>
    </div>
@endsection

