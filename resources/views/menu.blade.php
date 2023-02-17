<nav class="navbar navbar-expand-md navbar-light bg-light shadow-sm" style="font-size: 1.25em">
    <div class="container">
        <a href="/"><img class="navbar-brand" alt="Navbar picture" src="{{asset('assets/icons/edp.svg')}}" height="50"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            @auth
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('site.index')?'active':'' }}" href="{{ route('site.index') }}">Главная</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('tasks.*')?'active':'' }}" href="{{ route('tasks.index') }}">Задачи</a>
                </li>
                @can('viewAny', \App\Models\Documents\Document::class)
                    <li class="nav-item">
                            <ul class="navbar-nav">
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        Документы
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarDarkDropdownMenuLink2">
                                        <li class="nav-item"><a class="dropdown-item {{ request()->routeIs('documents.*')?'active':'' }}" href="{{ route('documents.index') }}">Входящие</a></li>
                                        <li class="nav-item"><a class="dropdown-item {{ request()->routeIs('outgoing_files.*')?'active':'' }}" href="{{ route('outgoing_files.index') }}">Исходящие</a></li>
                                        <li class="nav-item"><a class="dropdown-item {{ request()->routeIs('archive_documents.*')?'active':'' }}" href="{{ route('archive_documents.index') }}">Архив входящие</a></li>
                                        <li class="nav-item"><a class="dropdown-item {{ request()->routeIs('archive_outgoing_documents.*')?'active':'' }}" href="{{ route('archive_outgoing_documents.index') }}">Архив исходящие</a></li>
                                    </ul>
                                </li>
                            </ul>
                    </li>
                @endcan
                @can('viewAny', \App\Models\User::class)
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('users.*')?'active':'' }}" href="{{ route('users.index') }}">Сотрудники</a>
                </li>
                @endcan
                @can('view', \App\Models\Profile\Profile::class)
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('profile.show')?'active':'' }}" href="{{ route('profile.show', Auth::id()) }}">Профиль</a>
                    </li>
                @endcan

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('phonebook.index')?'active':'' }}" href="{{ route('phonebook.index', Auth::id())}}">Телефоны</a>
                </li>

                @can('viewAny', \App\Models\Admin\Admin::class)
                <li class="nav-item">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    Админка
                                </a>
                                <ul class="dropdown-menu dropdown-menu-light" aria-labelledby="navbarDarkDropdownMenuLink">
                                    <li><a class="dropdown-item {{ request()->routeIs('roles.*')?'active':'' }}" href="{{ route('roles.index') }}">Роли</a></li>
                                    <li><a class="dropdown-item  {{ request()->routeIs('user_statuses.*')?'active':'' }}"  href="{{ route('user_statuses.index') }}">Статусы</a></li>
                                    <li><a class="dropdown-item{{ request()->routeIs('logs.index.*')?'active':'' }}" href="{{ route('logs.index')}}">Логи</a></li>
                                </ul>
                            </li>
                        </ul>
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
