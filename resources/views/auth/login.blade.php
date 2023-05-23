@extends('main')

@section('title', 'Электронное делопроизводство')

@section('header')
@include('login-menu')
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
background-image: url('{{asset('assets/images/edp(FHD).jpg')}}');
background-position: center;
background-repeat: no-repeat;
background-size: cover;
margin-top: -60px;">
</section>

<section id="first" style="
height: 100vh; 
background-image: url('{{asset('assets/images/background(FHD).jpg')}}');
background-position: center;
background-repeat: no-repeat;
background-size: cover;">
</section>

<section id="first" style="
height: 100vh; 
background-image: url('{{asset('assets/images/third_section_background(FHD).jpg')}}');
background-position: center;
background-repeat: no-repeat;
background-size: cover;">
</section>

<section id="first" style="
height: 100vh; 
background-image: url('{{asset('assets/images/fourth_section_background(FHD).jpg')}}');
background-position: center;
background-repeat: no-repeat;
background-size: cover;">
</section>

<section id="first" style="
height: 100vh; 
background-image: url('{{asset('assets/images/abilities(FHD).jpg')}}');
background-position: center;
background-repeat: no-repeat;
background-size: cover;">
</section>

<script>
    document.getElementById('localTimeZone').value = Intl.DateTimeFormat().resolvedOptions().timeZone;
</script>
@endsection
