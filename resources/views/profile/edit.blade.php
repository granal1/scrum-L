@extends('main')

@section('title', 'Редактирование пользователя')

@section('header')
    @include('menu')
@endsection

@section('content')
<div class="container mb-3 mt-3 card shadow-lg">
    <div class="row">
        <div class="col-lg-2 col-md-12 rounded text-white bg-primary pt-3" style="--bs-bg-opacity: .4">
            <div class="row">
                <div class="col">
                    <h4 class="d-inline-block">Редактирование профиля сотрудника</h4>
                </div>
            </div>
        </div>

        <div class="col pt-3">
            <form action="{{route('profile.update', $user)}}" method="post">
                @csrf
                @method('patch')

                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="name" class="form-label">Ф.И.О.<span class="text-danger"></span></label>
                    </div>
                    <div class="col-8">
                        <input required type="text" class="form-control form-control-sm" id="name" placeholder="Введите Фамилия Имя Отчество" name="name" value="{{$user->name}}">
                        @error('name')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label class="form-label form-label-sm">Статус<span class="text-danger"><b>*</b></span></label>
                    </div>
                    <div class="col-8">
                        <select disabled name="user_status_uuid" class="form-select form-select-sm">
                            @forelse($user_statuses as $user_status)
                                <option @if($user->status->id === $user_status->id)
                                            selected
                                        @endif
                                        value="{{$user_status->id}}">{{$user_status->name}}</option>
                            @empty
                                <option value="">Нет статусов</option>
                            @endforelse
                        </select>
                        @error('user_status_uuid')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="role_uuid" class="form-label form-label-sm">Роли:<span class="text-danger"></span></label>
                    </div>
                    <div class="col-8">
                        <select disabled name="role_uuid" class="form-select form-select-sm">
                            <option value="">Выберите роль ...</option>
                            @if(isset($user->roles->first()->id))
                            @forelse($roles as $role)
                                <option @if($user->roles->first()->id === $role->id) selected @endif value="{{$role->id}}">{{$role->alias}}</option>
                            @empty
                                <option value="">Нет ролей</option>
                            @endforelse
                            @else
                                @forelse($roles as $role)
                                    <option value="{{$role->id}}">{{$role->alias}}</option>
                                @empty
                                    <option value="">Нет ролей</option>
                                @endforelse
                            @endif
                        </select>
                        @error('role_uuid')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="password" class="form-label">Пароль:</label>
                    </div>
                    <div class="col-8">
                        <input type="password" class="form-control form-control-sm" id="password" placeholder="Введите пароль или останется существующий" name="password">
                        @error('password')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="phone" class="form-label">Номер телефона в формате xxx-xxx-xx-xx:</label>
                    </div>
                    <div class="col-8">
                        <input type="tel" id="phone" name="phone" class="form-control form-control-sm" pattern="[0-9]{3}-[0-9]{3}-[0-9]{2}-[0-9]{2}" value="{{$user->phone}}">
                        @error('phone')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="birthday_at"  class="form-label">Дата рождения:</label>
                    </div>
                    <div class="col-8">
                        <input type="date" id="birthday_at" name="birthday_at" class="form-control form-control-sm" value="{{\Carbon\Carbon::parse($user->birthday_at)->format('Y-m-d')}}">
                        @error('birthday_at')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="email"  class="form-label">Адрес электронной почты:<span class="text-danger"></span></label>
                    </div>
                    <div class="col-8">
                        <input required type="email" id="email" name="email" class="form-control form-control-sm" value="{{$user->email}}">
                        @error('email')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="employment_at"  class="form-label">Дата трудоустройства:</label>
                    </div>
                    <div class="col-8">
                        <input type="date" id="employment_at" name="employment_at" class="form-control form-control-sm" value="{{\Carbon\Carbon::parse($user->employment_at)->format('Y-m-d') ?? 'Нет данных'}}">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="superior_uuid"  class="form-label">Начальник:</label>
                    </div>
                    <div class="col-8">
                        <select name="superior_uuid" class="form-control form-control-sm">
                            <option value="">Выберите руководителя ...</option>
                        @forelse($superiors as $superior)
                                <option @if($superior->id === $user->superior_uuid) selected @endif value="{{$superior->id}}">{{$superior->name}}</option>
                            @empty
                                <option value="">Нет сотрудников</option>
                            @endforelse
                        </select>
                        @error('superior_uuid')
                        <div class="text-danger">{{$message}}</div>
                        @enderror
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label for="position" class="form-label">Должность</label>
                    </div>
                    <div class="col-8">
                        <input type="text" class="form-control form-control-sm" id="position" placeholder="" name="position" value="{{$user->position ?? 'Нет данных'}}">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-4 text-end">
                        <label class="form-label form-label-sm">Подчиненные</label>
                    </div>
                    <div class="col-8">
                        <ol class="list-group list-group-numbered">
                            @forelse($subordinates as $subordinate)
                                <li class="list-group-item">{{$subordinate->name}}</li>
                            @empty
                                <li class="list-group-item">Нет подчиненных</li>
                            @endforelse
                        <ol>
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



