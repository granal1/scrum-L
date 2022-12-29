<nav class="navbar navbar-expand-md navbar-light bg-light shadow-sm">
    <div class="container">
        <a href="/"><img class="navbar-brand" alt="Navbar picture" src="{{asset('assets/icons/navbar_icon.svg')}}" width="45" height="45"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>


        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            @auth
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('site.index')?'active':'' }}" href="{{ route('site.index') }}">Главная</a>
                </li>
                @can('viewAny', \App\Models\Tasks\Task::class)
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('tasks.*')?'active':'' }}" href="{{ route('tasks.index') }}">Задачи</a>
                </li>
                @endcan
                @can('viewAny', \App\Models\Documents\Document::class)
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('documents.*')?'active':'' }}" href="{{ route('documents.index') }}">Документы</a>
                </li>
                @endcan
                @can('viewAny', \App\Models\User::class)
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('users.*')?'active':'' }}" href="{{ route('users.index') }}">Сотрудники</a>
                </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('profile.show')?'active':'' }}" href="{{ route('profile.show', Auth::id()) }}">Профиль</a>
                    </li>
                @endcan
                @can('viewAny', \App\Models\Roles\Role::class)
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('roles.index')?'active':'' }}" href="{{ route('roles.index') }}">Роли</a>
                    </li>
                @endcan
                @can('viewAny', \App\Models\Admin\Admin::class)
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.*')?'active':'' }}" href="{{ route('admin.index') }}">Админка</a>
                </li>
                @endcan
            </ul>
            @endauth
            <ul class="navbar-nav mb-2 mb-lg-0">
                @auth
                <li class="nav-item">
                    <form action="/logout" method="post">
                        @csrf
                        <button class="btn btn-secondary btn-sm" type="submit">Выход</button>
                    </form>
                </li>
                @endauth
                @guest
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('login')?'active':'' }}" href="/login">Вход</a>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
