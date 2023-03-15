@extends('main')

@section('title', 'Вход')

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
<div class="container pt-5">

</div>
</section>

<section id="first" style="
height: 100vh; 
background-image: url('{{asset('assets/images/background(FHD).jpg')}}');
background-position: center;
background-repeat: no-repeat;
background-size: cover;">
<div class="container pt-5">
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

<section id="second" style="
height: 100vh; 
background-image: url('{{asset('assets/images/second_section_background(FHD).jpg')}}');
background-position: center;
background-repeat: no-repeat;
background-size: cover;">
<div class="container">
  <div class="row pt-2">
    <div class="col  d-flex justify-content-center">
      <image src="{{asset('assets/images/document_flow.jpg')}}" style="width: 40vw;" class="my-auto"></image>
    </div>
  </div>
  <div class="row mt-2">
    <div class="col d-flex justify-content-center">
      <a href="#third" class="btn btn-warning btn-lg">Зачем все это?</a>
    </div>
  </div>
</div>
</section>

<section id="third"  
style="
height: 100vh; 
background-image: url('{{asset('assets/images/third_section_background(FHD).jpg')}}');
background-position: center;
background-repeat: no-repeat;
background-size: cover;">
<div class="container">
  <div class="row">
    <div class="col mt-5  d-flex justify-content-center">
      <h1 style="color: white;">Не выполнена задача?</h1>
    </div>
  </div>
</div>
</section>

<section id="fourth"style="
height: 100vh;">
<div class="container">
  <div class="row row-cols-1 row-cols-md-3 pt-5 d-flex justify-content-around">
    <div class="col-6 col-sm-3 col-md-3 card text-center shadow-lg">
      <img style="height: 15vh;" src="{{asset('assets/images/keeping.svg')}}" class="card-img-top rounded mx-auto" alt="Keeping image">
      <div class="card-body">
        <p class="card-text">Хранение документов и файлов</p>
      </div>
    </div>
    <div class="col-6  col-sm-3 col-md-3 card text-center shadow-lg">
      <img style="height: 15vh;" src="{{asset('assets/images/searching.svg')}}" class="card-img-top rounded mx-auto" alt="Searching image">
      <div class="card-body">
        <p class="card-text">Полнотекстовый поиск</p>
      </div>
    </div>
    <div class="col-6  col-sm-3 col-md-3 card text-center shadow-lg">
      <img style="height: 15vh;" src="{{asset('assets/images/control.svg')}}" class="card-img-top rounded mx-auto" alt="Control image">
      <div class="card-body">
        <p class="card-text">Учет и контроль исполнения задач</p>
      </div>
    </div>
  </div>
  <div class="row row-cols-1 row-cols-md-3 pt-5">
    <div class="col card text-center shadow-lg">
      <img style="height: 15vh;" src="{{asset('assets/images/keeping.svg')}}" class="card-img-top rounded mx-auto" alt="Keeping image">
      <div class="card-body">
        <p class="card-text">Хранение документов и файлов</p>
      </div>
    </div>
    <div class="col card text-center shadow-lg">
      <img style="height: 15vh;" src="{{asset('assets/images/searching.svg')}}" class="card-img-top rounded mx-auto" alt="Searching image">
      <div class="card-body">
        <p class="card-text">Полнотекстовый поиск</p>
      </div>
    </div>
    <div class="col card text-center shadow-lg">
      <img style="height: 15vh;" src="{{asset('assets/images/control.svg')}}" class="card-img-top rounded mx-auto" alt="Control image">
      <div class="card-body">
        <p class="card-text">Учет и контроль исполнения задач</p>
      </div>
    </div>
  </div>
</div>
</section>

<script>
    document.getElementById('localTimeZone').value = Intl.DateTimeFormat().resolvedOptions().timeZone;
</script>
@endsection
