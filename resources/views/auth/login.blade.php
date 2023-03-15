@extends('main')

@section('title', 'Вход')

@section('header')
@include('menu')
@endsection

@section('content')
<div class="container">
    <div class="container">
        <div class="row justify-content-center ">
            <div class="col-md-8">

                <!-- The Modal -->
                <div class="modal fade" id="login" style="backdrop-filter: blur(20px)">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h3>Авторизация</h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form method="POST" action="/login">
                            @csrf
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <label for="email" class="col-md-4 col-form-label text-md-end">Email
                                        пользователя:</label>
                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        @error('email')
                                        <div class="text-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="password" class="col-md-4 col-form-label text-md-end">Пароль:</label>
                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control" name="password" value="" required autocomplete="current-password">
                                        @error('password')
                                        <div class="text-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6 offset-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                            <label class="form-check-label" for="remember">
                                                Запомнить
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <input  value="" hidden type="text" id="localTimeZone" name="localTimeZone">
                                </div>
                            </div>
  
                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-secondary">Войти</button>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section id="first" style="
height: 100vh; 
background-image: url('{{asset('assets/images/background(FHD).jpg')}}');
background-position: center;
background-repeat: no-repeat;
background-size: cover;">
<div class="container pt-3">
<div class="row d-flex justify-content-center">
    <div class="col-1 me-5">
    <h1 style="font-size: 4em;">Опять</h1>
    </div>
</div>
<div class="row d-flex justify-content-center">
    <div class="col-1 ms-3">
    <h1 style="font-size: 4em;">нужна</h1>
    </div>
</div>
<div class="row d-flex justify-content-center">
    <div class="col-1 ms-5">
    <h1 style="font-size: 4em;">бумага?!</h1>
    </div>
</div>
<div class="row d-flex justify-content-center">
    <div class="col-2 mt-5 ms-5">
    <a href="#second" class="btn btn-outline-success btn-lg">Выход есть</a>
    </div>
</div>
</div>
</section>

<script>
    document.getElementById('localTimeZone').value = Intl.DateTimeFormat().resolvedOptions().timeZone;
</script>
@endsection
