 <nav class="navbar navbar-expand-lg navbar-light bg-light">
     <div class="container-fluid">
         <a class="navbar-brand" href="#">Navbar</a>
         <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
             aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
             <span class="navbar-toggler-icon"></span>
         </button>


         <div class="collapse navbar-collapse" id="navbarSupportedContent">
             @auth
                 <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                     <li class="nav-item">
                         <a class="nav-link" href="{{ route('tasks.index') }}">Главная</a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link" href="{{ route('tasks.index') }}">Задачи</a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link" href="{{ route('tasks.index') }}">Документы</a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link" href="{{ route('users.index') }}">Сотрудники</a>
                     </li>
                     <li class="nav-item">
                         <a class="nav-link" href="{{ route('tasks.index') }}">Админка</a>
                     </li>
                 </ul>
             @endauth
             <ul class="navbar-nav mb-2 mb-lg-0">
                 @auth
                     <li class="nav-item">
                         <form action="/logout" method="post">
                             @csrf
                             <button class="btn btn-info btn-sm" type="submit">Выход</button>
                         </form>
                     </li>
                 @endauth
                 @guest
                     <li class="nav-item">
                         <a class="nav-link" href="/login">Вход</a>
                     </li>
                 @endguest
             </ul>
         </div>
     </div>
 </nav>
