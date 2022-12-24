@extends('main')

@section('title', 'Пользователь')

@section('header')
    @include('menu')
@endsection

@section('content')
    <div class="container mt-2 card shadow-lg mb-2">
        <h2 class="rounded-3 mt-2 p-3 text-bg-primary text-center">Карточка сотрудника</h2>
        <form action="">
            <div class="row">
                <div class="col">
                    <div class="mb-3 mt-3">
                        <label for="name" class="form-label">Ф.И.О.</label>
                        <input type="text" class="form-control form-control-lg" id="name" placeholder="" name="name" value="Комаров Анатолий Иванович">
                    </div>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="login" class="form-label">Логин:</label>
                    <input type="text" class="form-control" id="login" placeholder="" name="login" value="o1">
                </div>
                <div class="col">
                    <label for="pwd" class="form-label">Пароль:</label>
                    <input type="password" class="form-control" id="pwd" placeholder="" name="pswd" value="90-=">
                </div>
            </div>


            <div class="row mb-3">
                <div class="col">
                    <label for="phone" class="mt-3">Номер телефона в формате xxx-xxx-xx-xx:</label>
                    <input type="tel" id="phone" name="phone" class="form-control" pattern="[0-9]{3}-[0-9]{3}-[0-9]{2}-[0-9]{2}" value="111-222-33-44">
                </div>
                <div class="col">
                    <label for="birthday_at" class="mt-3">Дата рождения:</label>
                    <input type="date" id="birthday_at" name="birthday_at" class="form-control" placeholder="" required="" value="1995-08-01">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col">
                    <label for="email" class="mt-3">Адрес электронной почты:</label>
                    <input type="email" id="email" name="email" class="form-control" value="o1@o1.ru">
                </div>
                <div class="col">
                    <label for="superior_uuid" class="mt-3">Ф.И.О. начальника:</label>
                    <input type="text" id="superior_uuid" name="superior_uuid" class="form-control" placeholder="" required="" value="Герасимов Иван Иванович">
                </div>
            </div>

            <p>
            <h4>Список подчиненных сотрудников:</h4>
            <ol>
                <li>
                    Иванов Артем Анатольевич
                </li>
                <li>
                    Петров Богдан Анатольевич
                </li>
                <li>
                    Сидоров Валерий Анатольевич
                </li>
                <li>
                    Кузнецов Георгий Анатольевич
                </li>
            </ol>
            </p>


            <div class="row pt-3 row-cols-1 row-cols-md-3">
                <div class="col mb-3">
                    <a class="btn btn-primary btn-sm col-12" href="{{route('users.index')}}">Все пользователи</a>
                </div>
                <div class="col mb-3">
                    <button class="btn btn-sm btn-success col-12"  onclick="history.back()">Назад</button>
                </div>
                <div class="col mb-3">
                    <a class="btn btn-sm btn-danger col-12" href="{{route('users.edit', $user)}}">Редактировать</a>
                </div>
            </div>

        </form>
    </div>
@endsection



