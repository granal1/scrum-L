<nav class="navbar navbar-expand-md navbar-light bg-light shadow-sm" 
    style=" font-size: 1.25em; 
            --bs-bg-opacity: .1;
            backdrop-filter: blur(40px);
            -webkit-backdrop-filter: blur(40px);">
    <div class="container">
        <a href="/"><img class="navbar-brand" alt="Navbar picture" src="{{asset('assets/icons/edp.svg')}}" height="50"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mb-2 mb-lg-0">
                @guest
                <li class="nav-item">
                    <a class="nav-link" href="#">Документация</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Помощь проекту</a>
                </li>
                @endguest
            </ul>
        </div>
        @guest
        <ul class="navbar-nav mb-2 mb-lg-0">
            <li class="nav-item">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#login">
                    Войти
                </button>
            </li>
        </ul>
        @endguest
    </div>
</nav>
