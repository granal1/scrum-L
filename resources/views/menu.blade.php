
 <nav class="navbar navbar-expand-md navbar-light bg-light shadow-sm">
     <div class="container">
         <img class="navbar-brand" alt="Navbar picture" src="{{asset('assets/icons/navbar_icon.svg')}}" width="45" height="45">
         <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
             aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
             <span class="navbar-toggler-icon"></span>
         </button>


         <div class="collapse navbar-collapse" id="navbarSupportedContent">
             @auth
                 <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                     <li class="nav-item">
                        <a class="nav-link{{ request()->routeIs('tasks.index')?' active':'' }}" href="{{ route('tasks.index') }}">Главная</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link{{ request()->routeIs('tasks.index')?' active':'' }}" href="{{ route('tasks.index') }}">Задачи</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link{{ request()->routeIs('documents.index')?' active':'' }}" href="{{ route('documents.index') }}">Документы</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link{{ request()->routeIs('users.index')?' active':'' }}" href="{{ route('users.index') }}">Сотрудники</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link{{ request()->routeIs('admin.index')?' active':'' }}" href="{{ route('admin.index') }}">Админка</a>
                     </li>
                 </ul>
             @endauth
             <form class="d-flex">
                <ul class="navbar-nav mb-2 mb-lg-0">
                    @auth
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                             Профиль
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="#">Изменить</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="#">Что-то еще</a></li>
                        </ul>
                    </li>
                        <li class="nav-item">
                            <form action="/logout" method="post">
                                @csrf
                                <button class="btn btn-dark btn-sm" type="submit">Выход</button>
                            </form>
                        </li>
                    @endauth
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="/login">Вход</a>
                        </li>
                    @endguest
                </ul>
            </form>
         </div>
     </div>
 </nav>
