@extends('main')

@section('title', 'Главная | Роли')

@section('header')
    @include('menu')
@endsection

@section('content')
    <div class="container pt-3">
        <div class="row">
            <div class="col">
                <h4 class="d-inline-block">Роли</h4>
                @can('create', \App\Models\Roles\Role::class)
                    <a class="btn btn-sm btn-success" href="{{route('roles.create')}}">Добавить</a>
                @endcan
            </div>
        </div>
        <div class="row pt-3">
            <div class="col">
                <table class="table table-sm table-striped table-responsive table-hover table-bordered">
                    <thead>
                        <tr>
                            <td>Алиас</td>
                            <td>Название</td>
                        </tr>
                        <tr>
                            <th colspan="2">
                                <a class="btn btn-sm btn-success col-12" href="{{route('roles.index')}}">Сброс фильтров</a>
                            </th>
                        </tr>
                        <form action="{{ route('roles.index') }}" method="get">
                            <tr>
                                <th>
                                    <input type="search" value="@if(isset($old_filters['alias'])) {{ $old_filters['alias'] }} @endif"
                                           class="form-control form-control-sm" id="alias" name="alias"
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
                        @forelse($roles as $role)
                            <tr  onclick="window.location='{{ route('roles.show', $role->id) }}';">
                                <td>{{$role->alias}}</td>
                                <td>{{$role->name}}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2">
                                    Нет ролей
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{$roles->withQueryString()->links()}}
            </div>
        </div>
    </div>
@endsection

