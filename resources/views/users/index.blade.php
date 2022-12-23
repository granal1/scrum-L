@extends('main')

@section('title', 'Список сотрудников')

@section('header')
    @include('menu')
@endsection

@section('content')
    <h1>Список сотрудников компании:</h1>
    <a class="btn btn-sm btn-success" href="{{ route('users.create') }}">Добавить сотрудника</a>
    <div class="row pt-3">
        <div class="col">
            <table class="table table-sm table-striped table-responsive table-hover table-bordered">
                <thead>
                    <tr>
                        <td>Uuid</td>
                        <td>Логин</td>
                        <td>Ф.И.О.</td>
                        <td>Адрес электронной почты</td>
                        <td>Номер телефона</td>
                        <td>Дата рождения</td>
                        <td>Комментарий</td>
                    </tr>
                </thead>
                <tbody style="cursor: pointer;">
                    {{-- @forelse($tasks as $task)
                        <tr onclick="window.location='{{ route('tasks.show', $task->id) }}';">
                            <td>{{ $task->uuid }}</td>
                            <td>{{ $task->description }}</td>
                            <td>{{ $task->created_at }}</td>
                            <td>{{ $task->created_at }}</td>
                            <td>Петров П.П.</td>
                            <td>0</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                Нет задач
                            </td>
                        </tr>
                    @endforelse --}}
                </tbody>
            </table>
        </div>

@endsection